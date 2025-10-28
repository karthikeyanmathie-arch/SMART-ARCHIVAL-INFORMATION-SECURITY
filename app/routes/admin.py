from flask import Blueprint, render_template, redirect, url_for, flash, request
from flask_login import login_required
from app.models import User, Document, AuditLog
from app import db
from app.utils.decorators import admin_required
from app.utils.helpers import log_activity

bp = Blueprint('admin', __name__, url_prefix='/admin')

@bp.route('/')
@admin_required
def dashboard():
    """Admin dashboard"""
    total_users = User.query.count()
    total_documents = Document.query.count()
    recent_logs = AuditLog.query.order_by(AuditLog.timestamp.desc()).limit(20).all()
    
    return render_template('admin/dashboard.html', 
                         total_users=total_users,
                         total_documents=total_documents,
                         recent_logs=recent_logs)

@bp.route('/users')
@admin_required
def users():
    """List all users"""
    page = request.args.get('page', 1, type=int)
    per_page = 20
    
    users = User.query.order_by(User.created_at.desc()).paginate(
        page=page, per_page=per_page, error_out=False
    )
    
    return render_template('admin/users.html', users=users)

@bp.route('/users/<int:user_id>/toggle-active', methods=['POST'])
@admin_required
def toggle_user_active(user_id):
    """Activate or deactivate a user"""
    from flask_login import current_user
    
    user = User.query.get_or_404(user_id)
    
    if user.id == current_user.id:
        flash('You cannot deactivate your own account.', 'error')
        return redirect(url_for('admin.users'))
    
    user.is_active = not user.is_active
    db.session.commit()
    
    status = 'activated' if user.is_active else 'deactivated'
    log_activity(current_user.id, f'{status}_user', 'user', user_id, 
                f"{status.capitalize()} user: {user.username}", request.remote_addr)
    
    flash(f'User {status} successfully!', 'success')
    return redirect(url_for('admin.users'))

@bp.route('/documents')
@admin_required
def documents():
    """List all documents"""
    page = request.args.get('page', 1, type=int)
    per_page = 20
    
    documents = Document.query.order_by(Document.uploaded_at.desc()).paginate(
        page=page, per_page=per_page, error_out=False
    )
    
    return render_template('admin/documents.html', documents=documents)

@bp.route('/logs')
@admin_required
def logs():
    """View audit logs"""
    page = request.args.get('page', 1, type=int)
    per_page = 50
    
    logs = AuditLog.query.order_by(AuditLog.timestamp.desc()).paginate(
        page=page, per_page=per_page, error_out=False
    )
    
    return render_template('admin/logs.html', logs=logs)
