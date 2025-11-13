# 🚀 Quick Start Guide

Get your Smart Archival & Information System up and running in minutes!

## 🎯 For Beginners (Web Interface Setup)

### Step 1: Upload Files

1. Download all project files
2. Upload to your web hosting account (usually in `public_html` folder)
3. Extract if uploaded as ZIP

### Step 2: Check Requirements

1. Open your browser
2. Go to: `http://yourdomain.com/setup/check_requirements.php`
3. Ensure all items show ✓ PASS
4. Fix any issues before proceeding

### Step 3: Install System

1. Go to: `http://yourdomain.com/setup/install.php`
2. Follow the 3-step wizard:
   - **Step 1**: Enter database details
   - **Step 2**: Create database tables
   - **Step 3**: Create admin account

### Step 4: Login & Start Using

1. Go to: `http://yourdomain.com/login.php`
2. Login with your admin credentials
3. Start managing your documents!

---

## ⚡ For Advanced Users (Command Line Setup)

### One-Command Deployment

```bash
# Make script executable and run
chmod +x setup/quick_deploy.sh
./setup/quick_deploy.sh
```

This script will:

- ✅ Check system requirements
- ✅ Set up directories and permissions
- ✅ Configure database
- ✅ Import database schema
- ✅ Create admin user
- ✅ Secure the installation

---

## 🔧 Manual Setup (If Automated Setup Fails)

### 1. Database Setup

```sql
-- Create database
CREATE DATABASE dept_file_management;

-- Import schema
mysql -u username -p dept_file_management < database/schema.sql

-- Create admin user (password: 'password')
INSERT INTO users (username, password, email, role, department)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@college.edu', 'admin', 'Administration');
```

### 2. Configure Database Connection

Edit `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'dept_file_management');
```

### 3. Set Permissions

```bash
chmod 755 uploads/
chmod 755 config/
mkdir -p uploads/{academic_calendar,student_admission,research_publications,syllabus,placement,alumni,student_projects}
```

---

## 🎯 Default Login Credentials

**Username:** admin  
**Password:** password

⚠️ **Important:** Change the default password immediately after first login!

---

## 📁 Key Directories

```
├── modules/
│   ├── department/     # Academic calendar, admissions, research
│   ├── faculty/        # Syllabus, results, placements
│   └── student/        # Alumni, projects, activities
├── uploads/            # File storage (must be writable)
├── config/             # Configuration files
├── assets/             # CSS, JS, images
└── setup/              # Installation scripts
```

---

## 🔍 Troubleshooting

### Common Issues & Solutions

**❌ Database Connection Error**

```
✅ Check database credentials in config/database.php
✅ Ensure MySQL service is running
✅ Verify database exists
```

**❌ File Upload Not Working**

```
✅ Check uploads/ directory permissions (755)
✅ Verify PHP upload settings
✅ Check available disk space
```

**❌ Permission Denied**

```
✅ Set correct file permissions: chmod 644 files, chmod 755 directories
✅ Ensure web server can write to uploads/
```

**❌ Page Not Found (404)**

```
✅ Check .htaccess file exists
✅ Verify mod_rewrite is enabled (Apache)
✅ Check file paths are correct
```

---

## 🚀 Next Steps After Installation

### 1. Security Setup

- [ ] Change default admin password
- [ ] Remove setup/ directory
- [ ] Configure SSL certificate
- [ ] Set up regular backups

### 2. User Management

- [ ] Create faculty user accounts
- [ ] Set appropriate roles and permissions
- [ ] Train users on system usage

### 3. Data Entry

- [ ] Start with Academic Calendar
- [ ] Add Student Admission records
- [ ] Upload existing documents
- [ ] Configure department-specific settings

### 4. Maintenance

- [ ] Set up automated backups
- [ ] Monitor error logs
- [ ] Plan regular updates

---

## 📞 Need Help?

### Self-Help Resources

1. **Check Error Logs**: Look in `logs/` directory
2. **Requirements**: Ensure all system requirements are met
3. **Documentation**: Read the full DEPLOYMENT_GUIDE.md

### System Requirements Reminder

- PHP 7.4+
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx)
- 500MB+ free space

---

## 🎉 You're All Set!

Your Smart Archival & Information System is ready to use. The system includes:

✅ **Department**: Academic calendar, admissions, research publications  
✅ **Faculty**: Syllabus, results, placements, appraisals  
✅ **Student**: Alumni, projects, activities  
✅ **Admin Panel**: User management and system configuration  
✅ **File Management**: Secure document upload and storage  
✅ **Responsive Design**: Works on desktop, tablet, and mobile

**Happy Document Managing! 📚**
