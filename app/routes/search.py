from flask import Blueprint, render_template, request
from flask_login import login_required, current_user
from app.utils.helpers import search_documents, log_activity

bp = Blueprint('search', __name__, url_prefix='/search')

@bp.route('/')
@login_required
def search():
    """Search documents"""
    query = request.args.get('q', '')
    category = request.args.get('category', '')
    file_type = request.args.get('file_type', '')
    
    filters = {}
    if category:
        filters['category'] = category
    if file_type:
        filters['file_type'] = file_type
    
    results = []
    if query or filters:
        results = search_documents(query, current_user.id, filters)
        log_activity(current_user.id, 'search', 'system', 
                    details=f"Search query: {query}", ip_address=request.remote_addr)
    
    return render_template('search/results.html', 
                         query=query, 
                         results=results,
                         category=category,
                         file_type=file_type)
