import os
import secrets
from werkzeug.utils import secure_filename
from flask import current_app
from datetime import datetime
from app.models import AuditLog
from app import db

def allowed_file(filename):
    """Check if file extension is allowed"""
    return '.' in filename and \
           filename.rsplit('.', 1)[1].lower() in current_app.config['ALLOWED_EXTENSIONS']

def generate_unique_filename(original_filename):
    """Generate a unique filename to prevent conflicts"""
    timestamp = datetime.utcnow().strftime('%Y%m%d_%H%M%S')
    random_string = secrets.token_hex(8)
    name, ext = os.path.splitext(secure_filename(original_filename))
    return f"{name}_{timestamp}_{random_string}{ext}"

def get_file_size_readable(size_bytes):
    """Convert bytes to human readable format"""
    for unit in ['B', 'KB', 'MB', 'GB']:
        if size_bytes < 1024.0:
            return f"{size_bytes:.2f} {unit}"
        size_bytes /= 1024.0
    return f"{size_bytes:.2f} TB"

def log_activity(user_id, action, resource_type, resource_id=None, details=None, ip_address=None):
    """Log user activity to audit log"""
    try:
        log_entry = AuditLog(
            user_id=user_id,
            action=action,
            resource_type=resource_type,
            resource_id=resource_id,
            details=details,
            ip_address=ip_address
        )
        db.session.add(log_entry)
        db.session.commit()
    except Exception as e:
        db.session.rollback()
        print(f"Error logging activity: {e}")

def search_documents(query, user_id, filters=None):
    """Search documents with optional filters"""
    from app.models import Document
    
    # Base query
    documents = Document.query.filter(
        (Document.user_id == user_id) | (Document.access_level.in_(['shared', 'public']))
    )
    
    # Text search in title, description, and tags
    if query:
        search_pattern = f"%{query}%"
        documents = documents.filter(
            db.or_(
                Document.title.ilike(search_pattern),
                Document.description.ilike(search_pattern),
                Document.tags.ilike(search_pattern),
                Document.original_filename.ilike(search_pattern)
            )
        )
    
    # Apply filters
    if filters:
        if filters.get('category'):
            documents = documents.filter(Document.category == filters['category'])
        if filters.get('file_type'):
            documents = documents.filter(Document.file_type == filters['file_type'])
        if filters.get('date_from'):
            documents = documents.filter(Document.uploaded_at >= filters['date_from'])
        if filters.get('date_to'):
            documents = documents.filter(Document.uploaded_at <= filters['date_to'])
    
    return documents.order_by(Document.uploaded_at.desc()).all()
