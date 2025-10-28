from flask import Blueprint, render_template
from flask_login import login_required, current_user
from app.models import Document

bp = Blueprint('main', __name__)

@bp.route('/')
def index():
    """Landing page"""
    return render_template('index.html')

@bp.route('/dashboard')
@login_required
def dashboard():
    """User dashboard"""
    # Get user's recent documents
    recent_docs = Document.query.filter_by(user_id=current_user.id).order_by(
        Document.uploaded_at.desc()
    ).limit(10).all()
    
    # Get statistics
    total_docs = Document.query.filter_by(user_id=current_user.id).count()
    archived_docs = Document.query.filter_by(user_id=current_user.id, is_archived=True).count()
    
    return render_template('dashboard.html', 
                         recent_docs=recent_docs,
                         total_docs=total_docs,
                         archived_docs=archived_docs)

@bp.route('/about')
def about():
    """About page"""
    return render_template('about.html')
