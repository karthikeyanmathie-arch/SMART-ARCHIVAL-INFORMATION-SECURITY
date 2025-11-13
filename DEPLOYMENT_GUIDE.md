# 🚀 Deployment Guide - Smart Archival & Information System

**SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002**

This comprehensive guide will help you deploy the Smart Archival & Information System on your server.

## Adding the logo

Place your logo file at `assets/images/ssm_logo.png`. The site header references `/test_dfm/assets/images/ssm_logo.png` and will display the image automatically. If the image is missing, the layout will fall back to text only.

## 📋 Prerequisites

### Server Requirements

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: Version 7.4 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Storage**: Minimum 500MB free space
- **Memory**: 256MB RAM minimum

### Required PHP Extensions

- PDO
- PDO_MySQL
- Fileinfo
- GD
- Session
- JSON
- MBString

## 🛠️ Step-by-Step Deployment

### Step 1: Download and Extract Files

1. **Download the project files** to your local machine
2. **Extract** the files to a temporary directory
3. **Upload** all files to your web server's document root (usually `public_html` or `www`)

```bash
# If using command line
cd /path/to/your/webroot
# Upload files here
```

### Step 2: Set Directory Permissions

Set appropriate permissions for directories:

```bash
# Make uploads directory writable
chmod 755 uploads/
chmod 755 config/
chmod 755 assets/

# Create subdirectories for uploads
mkdir -p uploads/{academic_calendar,student_admission,research_publications,syllabus,placement,alumni,student_projects}
chmod 755 uploads/*/
```

### Step 3: Check System Requirements

1. Navigate to `http://yourdomain.com/setup/check_requirements.php`
2. Review all requirements
3. Fix any issues highlighted in red
4. Refresh until all requirements show green checkmarks

### Step 4: Run Installation Wizard

1. **Navigate to**: `http://yourdomain.com/setup/install.php`
2. **Follow the 3-step installation process**:

#### Step 1: Database Configuration

- Enter your database host (usually `localhost`)
- Enter database username and password
- Enter database name (will be created if it doesn't exist)
- Click "Test Connection & Continue"

#### Step 2: Database Setup

- Click "Create Database Tables" to import the schema
- Wait for completion message

#### Step 3: Admin Account Setup

- Create your admin username and password
- Enter admin email address
- Click "Complete Installation"

### Step 5: Security Configuration

1. **Delete setup files** after installation:

```bash
rm -rf setup/
```

2. **Verify .htaccess** is working (Apache users)
3. **Check file permissions** are secure
4. **Change default passwords** if any

## 🔧 Server-Specific Configuration

### Apache Configuration

The included `.htaccess` file provides:

- Security headers
- File upload restrictions
- Compression
- Caching rules
- Error handling

### Nginx Configuration

If using Nginx, add this to your server block:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/webroot;
    index index.php index.html;

    # Security headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Protect sensitive directories
    location ~ ^/(config|database|setup)/ {
        deny all;
    }

    # File upload security
    location ~* ^/uploads/.*\.(php|phtml|php3|php4|php5)$ {
        deny all;
    }

    # Static file caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## 🗄️ Database Configuration

### Manual Database Setup (Alternative)

If the automatic installer doesn't work:

1. **Create database**:

```sql
CREATE DATABASE dept_file_management;
```

2. **Import schema**:

```bash
mysql -u username -p dept_file_management < database/schema.sql
```

3. **Create admin user**:

```sql
INSERT INTO users (username, password, email, role, department)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@yourdomain.com', 'admin', 'Administration');
```

### Database Optimization

Add these to your MySQL configuration:

```ini
[mysqld]
innodb_buffer_pool_size = 256M
max_connections = 100
query_cache_size = 32M
tmp_table_size = 64M
max_heap_table_size = 64M
```

## 🔐 Security Hardening

### 1. File Permissions

```bash
# Set secure permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 600 config/database.php
```

### 2. Hide Sensitive Information

- Remove or restrict access to `database/` directory
- Ensure `.htaccess` is working
- Hide PHP version in headers

### 3. SSL Certificate

- Install SSL certificate for HTTPS
- Redirect HTTP to HTTPS
- Update any hardcoded HTTP URLs

### 4. Regular Updates

- Keep PHP updated
- Update MySQL/MariaDB
- Monitor security advisories

## 📊 Performance Optimization

### 1. PHP Configuration

```ini
; php.ini optimizations
memory_limit = 256M
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
opcache.enable = 1
opcache.memory_consumption = 128
```

### 2. Database Optimization

- Regular OPTIMIZE TABLE commands
- Monitor slow query log
- Add indexes for frequently searched columns

### 3. File Storage

- Consider CDN for file uploads
- Implement file compression
- Regular cleanup of old files

## 🔄 Backup Strategy

### 1. Database Backup

```bash
# Daily database backup
mysqldump -u username -p dept_file_management > backup_$(date +%Y%m%d).sql
```

### 2. File Backup

```bash
# Backup uploads directory
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz uploads/
```

### 3. Automated Backup Script

```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u username -p dept_file_management > /backups/db_$DATE.sql
tar -czf /backups/files_$DATE.tar.gz uploads/
# Keep only last 30 days
find /backups -name "*.sql" -mtime +30 -delete
find /backups -name "*.tar.gz" -mtime +30 -delete
```

## 🐛 Troubleshooting

### Common Issues

#### 1. Database Connection Error

```
Solution: Check database credentials in config/database.php
Verify MySQL service is running
Check firewall settings
```

#### 2. File Upload Issues

```
Solution: Check directory permissions (755)
Verify PHP upload settings
Check available disk space
```

#### 3. Session Issues

```
Solution: Check PHP session configuration
Verify session directory permissions
Clear browser cookies
```

#### 4. Permission Denied Errors

```
Solution: Check file/directory permissions
Verify web server user ownership
Check SELinux settings (if applicable)
```

### Error Logs

Monitor these log files:

- PHP error log: `/var/log/php_errors.log`
- Apache error log: `/var/log/apache2/error.log`
- MySQL error log: `/var/log/mysql/error.log`

## 📞 Support and Maintenance

### Regular Maintenance Tasks

1. **Weekly**:

   - Check error logs
   - Monitor disk space
   - Verify backups

2. **Monthly**:

   - Update system packages
   - Review user accounts
   - Clean old uploaded files

3. **Quarterly**:
   - Security audit
   - Performance review
   - Database optimization

### Getting Help

1. Check error logs first
2. Verify all requirements are met
3. Test with minimal configuration
4. Document exact error messages

## 🎉 Post-Deployment Checklist

- [ ] System requirements verified
- [ ] Database installed and configured
- [ ] Admin account created
- [ ] File permissions set correctly
- [ ] Security measures implemented
- [ ] SSL certificate installed
- [ ] Backup strategy implemented
- [ ] Error monitoring configured
- [ ] User training completed
- [ ] Documentation updated

## 🔗 Quick Access URLs

After deployment, access these URLs:

- **Main Application**: `http://yourdomain.com/`
- **Login Page**: `http://yourdomain.com/login.php`
- **Admin Panel**: `http://yourdomain.com/admin/users.php`

---

**Congratulations!** Your Smart Archival & Information System is now deployed and ready for use. Remember to change default passwords and implement regular backups.
