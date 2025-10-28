# Smart Archival Information Security System

A comprehensive digital platform designed to simplify and streamline the process of managing, storing, and retrieving organizational documents and information. This system enables users to efficiently archive records, perform intelligent searches, control access, and maintain data security through a user-friendly interface.

## Features

### Core Functionality
- **Secure Document Storage**: Upload and store documents with encryption and secure file handling
- **User Authentication**: Role-based access control with admin, user, and viewer roles
- **Intelligent Search**: Full-text search across document titles, descriptions, tags, and filenames
- **Document Management**: Upload, view, edit, download, archive, and delete documents
- **Access Control**: Set documents as private, shared, or public
- **Audit Logging**: Comprehensive tracking of all system activities
- **Metadata Management**: Organize documents with categories, tags, and descriptions
- **Admin Dashboard**: Manage users, documents, and view system logs

### Security Features
- Password hashing using industry-standard Werkzeug security utilities
- Session management with Flask-Login
- Role-based access control (RBAC)
- Comprehensive audit logging for accountability
- Secure file upload with type validation
- Protection against common web vulnerabilities

## Technology Stack

- **Backend**: Python Flask 3.0
- **Database**: SQLite with SQLAlchemy ORM
- **Authentication**: Flask-Login
- **Security**: Werkzeug security utilities, cryptography
- **Frontend**: HTML5, CSS3, JavaScript
- **File Processing**: PyPDF2, Pillow, python-magic

## Installation

### Prerequisites
- Python 3.8 or higher
- pip (Python package manager)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/karthikeyanmathie-arch/SMART-ARCHIVAL-INFORMATION-SECURITY.git
   cd SMART-ARCHIVAL-INFORMATION-SECURITY
   ```

2. **Create a virtual environment**
   ```bash
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   ```

3. **Install dependencies**
   ```bash
   pip install -r requirements.txt
   ```

4. **Configure environment variables**
   ```bash
   cp .env.example .env
   # Edit .env file with your configuration
   ```

5. **Initialize the database**
   ```bash
   python run.py init_db
   ```

6. **Create an admin user**
   ```bash
   python run.py create_admin
   ```

7. **Run the application**
   ```bash
   python run.py
   ```

The application will be available at `http://localhost:5000`

## Usage Guide

### For Users

1. **Registration**: Create a new account at `/auth/register`
2. **Login**: Sign in at `/auth/login`
3. **Upload Documents**: Navigate to "Upload" to add new documents
4. **Search**: Use the search feature to find documents by title, description, tags, or filename
5. **Manage Documents**: View, edit, download, archive, or delete your documents
6. **Access Control**: Set document visibility (private, shared, public)

### For Administrators

1. **Admin Dashboard**: Access at `/admin` to view system statistics
2. **User Management**: Manage user accounts, activate/deactivate users
3. **Document Overview**: View all documents in the system
4. **Audit Logs**: Monitor all system activities and user actions

## Project Structure

```
SMART-ARCHIVAL-INFORMATION-SECURITY/
├── app/
│   ├── __init__.py           # Application factory
│   ├── models.py             # Database models
│   ├── routes/               # Route blueprints
│   │   ├── auth.py          # Authentication routes
│   │   ├── main.py          # Main routes
│   │   ├── documents.py     # Document management routes
│   │   ├── search.py        # Search functionality
│   │   └── admin.py         # Admin routes
│   ├── templates/            # HTML templates
│   │   ├── base.html
│   │   ├── index.html
│   │   ├── dashboard.html
│   │   ├── auth/
│   │   ├── documents/
│   │   ├── search/
│   │   └── admin/
│   ├── static/               # Static files
│   │   ├── css/
│   │   └── js/
│   └── utils/                # Utility functions
│       ├── helpers.py
│       └── decorators.py
├── uploads/                  # Document storage (excluded from git)
├── logs/                     # Application logs (excluded from git)
├── config.py                 # Configuration settings
├── run.py                    # Application entry point
├── requirements.txt          # Python dependencies
└── README.md                # This file
```

## API Endpoints

### Authentication
- `GET/POST /auth/login` - User login
- `GET/POST /auth/register` - User registration
- `GET /auth/logout` - User logout

### Documents
- `GET /documents` - List user documents
- `GET/POST /documents/upload` - Upload new document
- `GET /documents/<id>` - View document details
- `GET /documents/<id>/download` - Download document
- `GET/POST /documents/<id>/edit` - Edit document metadata
- `POST /documents/<id>/delete` - Delete document
- `POST /documents/<id>/archive` - Archive/unarchive document

### Search
- `GET /search?q=query` - Search documents

### Admin
- `GET /admin` - Admin dashboard
- `GET /admin/users` - Manage users
- `GET /admin/documents` - View all documents
- `GET /admin/logs` - View audit logs
- `POST /admin/users/<id>/toggle-active` - Activate/deactivate user

## Security Best Practices

1. **Change default secret key**: Update `SECRET_KEY` in `.env` file
2. **Use strong passwords**: Enforce password policies
3. **Regular backups**: Backup database and uploaded files regularly
4. **HTTPS in production**: Use SSL/TLS certificates
5. **Monitor audit logs**: Regularly review system activities
6. **Update dependencies**: Keep all packages up to date
7. **File type validation**: Only allow approved file types
8. **Rate limiting**: Implement rate limiting in production
9. **Input validation**: Always validate and sanitize user input

## Production Deployment

For production deployment:

1. **Use a production WSGI server** (e.g., Gunicorn)
   ```bash
   gunicorn -w 4 -b 0.0.0.0:8000 run:app
   ```

2. **Use a production database** (e.g., PostgreSQL, MySQL)
   - Update `DATABASE_URI` in `.env`

3. **Set up reverse proxy** (e.g., Nginx)

4. **Enable HTTPS** with SSL certificates

5. **Configure file storage** (consider cloud storage for scalability)

6. **Set up monitoring and logging**

7. **Implement backup strategy**

## License

This project is licensed under the MIT License.

## Support

For issues, questions, or contributions, please open an issue on GitHub.

## Contributors

- Karthikeyan Mathie

---

**Note**: This is a comprehensive archival and information security system designed for organizational use. Ensure proper security measures are in place before deploying to production.
