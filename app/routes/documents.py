import os
from flask import Blueprint, render_template, redirect, url_for, flash, request, send_file
from flask_login import login_required, current_user
from werkzeug.utils import secure_filename
from app.models import Document
from app import db
from app.utils.helpers import allowed_file, generate_unique_filename, log_activity

bp = Blueprint('documents', __name__, url_prefix='/documents')

@bp.route('/')
@login_required
def list_documents():
    """List all user documents"""
    page = request.args.get('page', 1, type=int)
    per_page = 20
    
    documents = Document.query.filter_by(user_id=current_user.id).order_by(
        Document.uploaded_at.desc()
    ).paginate(page=page, per_page=per_page, error_out=False)
    
    return render_template('documents/list.html', documents=documents)

@bp.route('/upload', methods=['GET', 'POST'])
@login_required
def upload():
    """Upload document"""
    if request.method == 'POST':
        if 'file' not in request.files:
            flash('No file selected.', 'error')
            return redirect(url_for('documents.upload'))
        
        file = request.files['file']
        if file.filename == '':
            flash('No file selected.', 'error')
            return redirect(url_for('documents.upload'))
        
        if file and allowed_file(file.filename):
            # Generate unique filename
            original_filename = secure_filename(file.filename)
            filename = generate_unique_filename(original_filename)
            
            # Save file
            from flask import current_app
            file_path = os.path.join(current_app.config['UPLOAD_FOLDER'], filename)
            file.save(file_path)
            
            # Get file info
            file_size = os.path.getsize(file_path)
            file_type = original_filename.rsplit('.', 1)[1].lower()
            
            # Get form data
            title = request.form.get('title', original_filename)
            description = request.form.get('description', '')
            category = request.form.get('category', 'General')
            tags = request.form.get('tags', '')
            access_level = request.form.get('access_level', 'private')
            
            # Create document record
            document = Document(
                filename=filename,
                original_filename=original_filename,
                file_path=file_path,
                file_size=file_size,
                file_type=file_type,
                title=title,
                description=description,
                category=category,
                tags=tags,
                access_level=access_level,
                user_id=current_user.id
            )
            
            db.session.add(document)
            db.session.commit()
            
            log_activity(current_user.id, 'upload_document', 'document', document.id, 
                        f"Uploaded: {original_filename}", request.remote_addr)
            
            flash('Document uploaded successfully!', 'success')
            return redirect(url_for('documents.view', doc_id=document.id))
        else:
            flash('File type not allowed.', 'error')
    
    return render_template('documents/upload.html')

@bp.route('/<int:doc_id>')
@login_required
def view(doc_id):
    """View document details"""
    document = Document.query.get_or_404(doc_id)
    
    # Check access permissions
    if document.user_id != current_user.id and document.access_level == 'private':
        flash('You do not have permission to view this document.', 'error')
        return redirect(url_for('documents.list_documents'))
    
    log_activity(current_user.id, 'view_document', 'document', doc_id, 
                f"Viewed: {document.title}", request.remote_addr)
    
    return render_template('documents/view.html', document=document)

@bp.route('/<int:doc_id>/download')
@login_required
def download(doc_id):
    """Download document"""
    document = Document.query.get_or_404(doc_id)
    
    # Check access permissions
    if document.user_id != current_user.id and document.access_level == 'private':
        flash('You do not have permission to download this document.', 'error')
        return redirect(url_for('documents.list_documents'))
    
    log_activity(current_user.id, 'download_document', 'document', doc_id, 
                f"Downloaded: {document.title}", request.remote_addr)
    
    return send_file(document.file_path, as_attachment=True, 
                    download_name=document.original_filename)

@bp.route('/<int:doc_id>/edit', methods=['GET', 'POST'])
@login_required
def edit(doc_id):
    """Edit document metadata"""
    document = Document.query.get_or_404(doc_id)
    
    # Only owner can edit
    if document.user_id != current_user.id:
        flash('You do not have permission to edit this document.', 'error')
        return redirect(url_for('documents.list_documents'))
    
    if request.method == 'POST':
        document.title = request.form.get('title', document.title)
        document.description = request.form.get('description', '')
        document.category = request.form.get('category', 'General')
        document.tags = request.form.get('tags', '')
        document.access_level = request.form.get('access_level', 'private')
        
        db.session.commit()
        
        log_activity(current_user.id, 'edit_document', 'document', doc_id, 
                    f"Edited: {document.title}", request.remote_addr)
        
        flash('Document updated successfully!', 'success')
        return redirect(url_for('documents.view', doc_id=doc_id))
    
    return render_template('documents/edit.html', document=document)

@bp.route('/<int:doc_id>/delete', methods=['POST'])
@login_required
def delete(doc_id):
    """Delete document"""
    document = Document.query.get_or_404(doc_id)
    
    # Only owner can delete
    if document.user_id != current_user.id:
        flash('You do not have permission to delete this document.', 'error')
        return redirect(url_for('documents.list_documents'))
    
    # Delete file from filesystem
    try:
        if os.path.exists(document.file_path):
            os.remove(document.file_path)
    except Exception as e:
        print(f"Error deleting file: {e}")
    
    log_activity(current_user.id, 'delete_document', 'document', doc_id, 
                f"Deleted: {document.title}", request.remote_addr)
    
    db.session.delete(document)
    db.session.commit()
    
    flash('Document deleted successfully!', 'success')
    return redirect(url_for('documents.list_documents'))

@bp.route('/<int:doc_id>/archive', methods=['POST'])
@login_required
def archive(doc_id):
    """Archive/unarchive document"""
    document = Document.query.get_or_404(doc_id)
    
    # Only owner can archive
    if document.user_id != current_user.id:
        flash('You do not have permission to archive this document.', 'error')
        return redirect(url_for('documents.list_documents'))
    
    document.is_archived = not document.is_archived
    db.session.commit()
    
    action = 'archived' if document.is_archived else 'unarchived'
    log_activity(current_user.id, f'{action}_document', 'document', doc_id, 
                f"{action.capitalize()}: {document.title}", request.remote_addr)
    
    flash(f'Document {action} successfully!', 'success')
    return redirect(url_for('documents.view', doc_id=doc_id))
