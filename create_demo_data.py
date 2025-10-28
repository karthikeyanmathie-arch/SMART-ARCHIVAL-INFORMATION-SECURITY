#!/usr/bin/env python3
"""
Demo script to create sample data for the Smart Archival System
"""

from app import create_app, db
from app.models import User, Document, AuditLog
import os
from datetime import datetime, timedelta

def create_demo_data():
    """Create sample users and documents for demonstration"""
    print("Creating demo data for Smart Archival Information Security System...")
    print("-" * 60)
    
    app = create_app()
    
    with app.app_context():
        # Check if demo data already exists
        if User.query.filter_by(username='demo_admin').first():
            print("Demo data already exists. Skipping...")
            return
        
        # Create demo admin user
        print("1. Creating demo admin user...")
        admin = User(
            username='demo_admin',
            email='admin@demo.com',
            role='admin'
        )
        admin.set_password('admin123')
        db.session.add(admin)
        db.session.commit()
        print(f"   ✓ Admin user created (username: demo_admin, password: admin123)")
        
        # Create demo regular users
        print("2. Creating demo regular users...")
        users = []
        for i in range(3):
            user = User(
                username=f'demo_user{i+1}',
                email=f'user{i+1}@demo.com',
                role='user'
            )
            user.set_password(f'user{i+1}pass')
            users.append(user)
            db.session.add(user)
        db.session.commit()
        print(f"   ✓ Created 3 regular users (demo_user1, demo_user2, demo_user3)")
        
        # Create sample documents (metadata only, no actual files)
        print("3. Creating sample document metadata...")
        sample_docs = [
            {
                'title': 'Q4 Financial Report 2023',
                'description': 'Quarterly financial report including revenue, expenses, and profit analysis',
                'category': 'Financial',
                'tags': 'finance, report, quarterly, 2023',
                'file_type': 'pdf'
            },
            {
                'title': 'Employee Handbook 2024',
                'description': 'Updated employee policies and procedures for the new year',
                'category': 'HR',
                'tags': 'hr, policies, employees, handbook',
                'file_type': 'pdf'
            },
            {
                'title': 'Project Proposal - Website Redesign',
                'description': 'Detailed proposal for company website modernization',
                'category': 'Projects',
                'tags': 'project, website, proposal, design',
                'file_type': 'docx'
            },
            {
                'title': 'Meeting Minutes - January 2024',
                'description': 'Notes from monthly team meeting discussing Q1 goals',
                'category': 'Meetings',
                'tags': 'meeting, minutes, team, january',
                'file_type': 'docx'
            },
            {
                'title': 'Security Guidelines',
                'description': 'Information security policies and best practices',
                'category': 'IT',
                'tags': 'security, it, policies, guidelines',
                'file_type': 'pdf'
            },
        ]
        
        # Create dummy file paths for demo
        upload_folder = app.config['UPLOAD_FOLDER']
        
        for i, doc_data in enumerate(sample_docs):
            # Alternate between users
            owner = users[i % len(users)]
            
            # Create dummy filename
            filename = f"demo_file_{i+1}.{doc_data['file_type']}"
            
            document = Document(
                filename=filename,
                original_filename=f"{doc_data['title'].replace(' ', '_')}.{doc_data['file_type']}",
                file_path=os.path.join(upload_folder, filename),
                file_size=1024 * (100 + i * 50),  # Dummy sizes
                file_type=doc_data['file_type'],
                title=doc_data['title'],
                description=doc_data['description'],
                category=doc_data['category'],
                tags=doc_data['tags'],
                access_level='shared',  # Make them shared for demo
                user_id=owner.id,
                uploaded_at=datetime.utcnow() - timedelta(days=len(sample_docs)-i)
            )
            db.session.add(document)
        
        db.session.commit()
        print(f"   ✓ Created {len(sample_docs)} sample documents")
        
        # Create some audit log entries
        print("4. Creating sample audit logs...")
        log_entries = [
            (admin.id, 'login', 'system', None, 'Admin logged in'),
            (users[0].id, 'upload_document', 'document', 1, 'Uploaded Q4 Financial Report'),
            (users[1].id, 'upload_document', 'document', 2, 'Uploaded Employee Handbook'),
            (admin.id, 'view_document', 'document', 1, 'Viewed Q4 Financial Report'),
            (users[2].id, 'search', 'system', None, 'Search query: financial'),
        ]
        
        for user_id, action, resource_type, resource_id, details in log_entries:
            log = AuditLog(
                user_id=user_id,
                action=action,
                resource_type=resource_type,
                resource_id=resource_id,
                details=details,
                ip_address='127.0.0.1'
            )
            db.session.add(log)
        
        db.session.commit()
        print(f"   ✓ Created {len(log_entries)} audit log entries")
        
        print("-" * 60)
        print("✓ Demo data created successfully!")
        print("\nDemo Users:")
        print("  Admin: username=demo_admin, password=admin123")
        print("  User1: username=demo_user1, password=user1pass")
        print("  User2: username=demo_user2, password=user2pass")
        print("  User3: username=demo_user3, password=user3pass")
        print("\nNote: Sample documents are metadata only (no actual files)")
        print("Login at http://localhost:5000/auth/login")

if __name__ == '__main__':
    try:
        create_demo_data()
    except Exception as e:
        print(f"\n✗ Error creating demo data: {e}")
        import traceback
        traceback.print_exc()
