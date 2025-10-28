# Installation Guide

## Prerequisites

Before installing the Smart Archival Information Security System, ensure you have:

- **Python 3.8 or higher** installed on your system
- **pip** (Python package manager)
- **Git** (for cloning the repository)
- At least **500MB of free disk space**

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone https://github.com/karthikeyanmathie-arch/SMART-ARCHIVAL-INFORMATION-SECURITY.git
cd SMART-ARCHIVAL-INFORMATION-SECURITY
```

### 2. Create a Virtual Environment (Recommended)

**On Linux/macOS:**
```bash
python3 -m venv venv
source venv/bin/activate
```

**On Windows:**
```bash
python -m venv venv
venv\Scripts\activate
```

### 3. Install Dependencies

```bash
pip install -r requirements.txt
```

This will install:
- Flask (web framework)
- Flask-SQLAlchemy (database ORM)
- Flask-Login (authentication)
- Werkzeug (security utilities)
- cryptography (encryption)
- PyPDF2 (PDF processing)
- python-magic (file type detection)
- Pillow (image processing)
- python-dotenv (environment variables)
- gunicorn (production server)

### 4. Configure Environment Variables

```bash
cp .env.example .env
```

Edit the `.env` file with your preferred text editor and update:

```
SECRET_KEY=your-random-secret-key-here
DATABASE_URI=sqlite:///archival_system.db
UPLOAD_FOLDER=uploads
MAX_CONTENT_LENGTH=16777216
ALLOWED_EXTENSIONS=pdf,txt,doc,docx,xls,xlsx,jpg,jpeg,png,gif
```

**Important:** Generate a strong secret key:
```bash
python -c "import secrets; print(secrets.token_hex(32))"
```

### 5. Initialize the Database

```bash
flask --app run init-db
```

You should see: `Database initialized successfully!`

### 6. Create an Administrator Account

```bash
flask --app run create-admin
```

Follow the prompts to create your admin account:
- Enter admin username
- Enter admin email
- Enter admin password

### 7. Run the Application

**Development Mode:**
```bash
python run.py
```

The application will be available at: `http://localhost:5000`

**Production Mode (using Gunicorn):**
```bash
gunicorn -w 4 -b 0.0.0.0:8000 run:app
```

## Verification

1. Open your web browser and navigate to `http://localhost:5000`
2. You should see the Smart Archival System homepage
3. Click "Login" and use your admin credentials
4. You should be redirected to the dashboard

## Troubleshooting

### Issue: "Module not found" errors
**Solution:** Make sure you activated the virtual environment and installed all dependencies:
```bash
source venv/bin/activate  # On Windows: venv\Scripts\activate
pip install -r requirements.txt
```

### Issue: "Database not found" error
**Solution:** Initialize the database:
```bash
flask --app run init-db
```

### Issue: "Permission denied" errors
**Solution:** Check that the `uploads` and `logs` directories have write permissions:
```bash
chmod 755 uploads logs
```

### Issue: Port 5000 already in use
**Solution:** Use a different port:
```bash
export PORT=8080
python run.py
```

## Next Steps

After successful installation:

1. **Read the User Guide** for detailed usage instructions
2. **Review Security Best Practices** in the README
3. **Configure production settings** if deploying to a server
4. **Set up regular backups** for your database and uploaded files

## Updating the System

To update to the latest version:

```bash
git pull origin main
pip install -r requirements.txt --upgrade
flask --app run init-db  # Updates database schema if needed
```

## Uninstallation

To completely remove the system:

```bash
# Deactivate virtual environment
deactivate

# Remove application files
cd ..
rm -rf SMART-ARCHIVAL-INFORMATION-SECURITY

# Delete database and uploads (if desired)
# Note: This will permanently delete all your data
```

## Support

If you encounter any issues during installation, please:
1. Check the troubleshooting section above
2. Review the README.md file
3. Open an issue on GitHub with:
   - Your operating system and version
   - Python version
   - Error messages (if any)
   - Steps to reproduce the issue
