#!/usr/bin/env python3
"""
Test script to verify the Smart Archival System is working correctly
"""

from app import create_app, db
from app.models import User, Document, AuditLog
import sys

def test_basic_functionality():
    """Test basic application functionality"""
    print("Testing Smart Archival Information Security System...")
    print("-" * 60)
    
    # Create app
    print("1. Creating application...")
    app = create_app()
    
    with app.app_context():
        # Check database tables
        print("2. Checking database tables...")
        inspector = db.inspect(db.engine)
        tables = inspector.get_table_names()
        required_tables = ['user', 'document', 'audit_log']
        
        for table in required_tables:
            if table in tables:
                print(f"   ✓ Table '{table}' exists")
            else:
                print(f"   ✗ Table '{table}' missing")
                return False
        
        # Test creating a user
        print("3. Testing user creation...")
        test_user = User.query.filter_by(username='testuser').first()
        if test_user:
            db.session.delete(test_user)
            db.session.commit()
        
        user = User(username='testuser', email='test@example.com', role='user')
        user.set_password('testpass123')
        db.session.add(user)
        db.session.commit()
        print(f"   ✓ User created with ID: {user.id}")
        
        # Test password verification
        print("4. Testing password verification...")
        if user.check_password('testpass123'):
            print("   ✓ Password verification works")
        else:
            print("   ✗ Password verification failed")
            return False
        
        # Test user roles
        print("5. Testing user roles...")
        if not user.is_admin():
            print("   ✓ User role check works")
        else:
            print("   ✗ User role check failed")
            return False
        
        # Test admin user
        print("6. Testing admin user...")
        admin = User(username='admin', email='admin@example.com', role='admin')
        admin.set_password('admin123')
        db.session.add(admin)
        db.session.commit()
        if admin.is_admin():
            print(f"   ✓ Admin user created with ID: {admin.id}")
        else:
            print("   ✗ Admin role check failed")
            return False
        
        # Test audit log
        print("7. Testing audit logging...")
        log = AuditLog(
            user_id=user.id,
            action='test_action',
            resource_type='system',
            details='Test log entry'
        )
        db.session.add(log)
        db.session.commit()
        print(f"   ✓ Audit log created with ID: {log.id}")
        
        # Count records
        print("8. Checking record counts...")
        user_count = User.query.count()
        log_count = AuditLog.query.count()
        print(f"   ✓ Users in database: {user_count}")
        print(f"   ✓ Audit logs in database: {log_count}")
        
        # Clean up test data
        print("9. Cleaning up test data...")
        db.session.delete(user)
        db.session.delete(admin)
        db.session.delete(log)
        db.session.commit()
        print("   ✓ Test data cleaned up")
    
    print("-" * 60)
    print("✓ All tests passed successfully!")
    return True

if __name__ == '__main__':
    try:
        success = test_basic_functionality()
        sys.exit(0 if success else 1)
    except Exception as e:
        print(f"\n✗ Error during testing: {e}")
        import traceback
        traceback.print_exc()
        sys.exit(1)
