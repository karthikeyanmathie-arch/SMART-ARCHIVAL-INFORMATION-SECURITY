from flask import Blueprint, render_template, redirect, url_for, flash, request
from flask_login import login_user, logout_user, current_user
from app.models import User
from app import db
from app.utils.helpers import log_activity

bp = Blueprint('auth', __name__, url_prefix='/auth')

@bp.route('/login', methods=['GET', 'POST'])
def login():
    """User login route"""
    if current_user.is_authenticated:
        return redirect(url_for('main.dashboard'))
    
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        remember = request.form.get('remember', False)
        
        user = User.query.filter_by(username=username).first()
        
        if user and user.check_password(password) and user.is_active:
            login_user(user, remember=remember)
            log_activity(user.id, 'login', 'system', ip_address=request.remote_addr)
            flash('Login successful!', 'success')
            next_page = request.args.get('next')
            # Validate redirect URL to prevent open redirect vulnerability
            if next_page and next_page.startswith('/'):
                return redirect(next_page)
            return redirect(url_for('main.dashboard'))
        else:
            flash('Invalid username or password.', 'error')
    
    return render_template('auth/login.html')

@bp.route('/register', methods=['GET', 'POST'])
def register():
    """User registration route"""
    if current_user.is_authenticated:
        return redirect(url_for('main.dashboard'))
    
    if request.method == 'POST':
        username = request.form.get('username')
        email = request.form.get('email')
        password = request.form.get('password')
        confirm_password = request.form.get('confirm_password')
        
        # Validation
        if not username or not email or not password:
            flash('All fields are required.', 'error')
        elif password != confirm_password:
            flash('Passwords do not match.', 'error')
        elif User.query.filter_by(username=username).first():
            flash('Username already exists.', 'error')
        elif User.query.filter_by(email=email).first():
            flash('Email already registered.', 'error')
        else:
            # Create new user
            user = User(username=username, email=email, role='user')
            user.set_password(password)
            db.session.add(user)
            db.session.commit()
            
            log_activity(user.id, 'register', 'user', user.id, ip_address=request.remote_addr)
            flash('Registration successful! Please log in.', 'success')
            return redirect(url_for('auth.login'))
    
    return render_template('auth/register.html')

@bp.route('/logout')
def logout():
    """User logout route"""
    if current_user.is_authenticated:
        log_activity(current_user.id, 'logout', 'system', ip_address=request.remote_addr)
        logout_user()
        flash('You have been logged out.', 'info')
    return redirect(url_for('auth.login'))
