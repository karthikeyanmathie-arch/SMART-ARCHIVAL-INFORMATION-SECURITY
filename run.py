#!/usr/bin/env python3
"""
Smart Archival Information Security System
Main application entry point
"""

from app import create_app, db
from app.models import User, Document, AuditLog
import os

app = create_app()

@app.shell_context_processor
def make_shell_context():
    """Make database models available in shell"""
    return {'db': db, 'User': User, 'Document': Document, 'AuditLog': AuditLog}

@app.cli.command()
def init_db():
    """Initialize the database"""
    db.create_all()
    print("Database initialized successfully!")

@app.cli.command()
def create_admin():
    """Create an admin user"""
    username = input("Enter admin username: ")
    email = input("Enter admin email: ")
    password = input("Enter admin password: ")
    
    if User.query.filter_by(username=username).first():
        print("User already exists!")
        return
    
    admin = User(username=username, email=email, role='admin')
    admin.set_password(password)
    db.session.add(admin)
    db.session.commit()
    print(f"Admin user '{username}' created successfully!")

if __name__ == '__main__':
    # Run development server
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port, debug=True)
