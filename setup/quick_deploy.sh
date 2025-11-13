#!/bin/bash

# Quick Deployment Script for Smart Archival & Information System
# This script automates the basic deployment process

echo "=================================================="
echo "Smart Archival & Information System"
echo "Quick Deployment Script"
echo "=================================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_step() {
    echo -e "${BLUE}[STEP]${NC} $1"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    print_warning "Running as root. Consider using a non-root user for security."
fi

# Step 1: Check system requirements
print_step "1. Checking system requirements..."

# Check PHP
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -n1 | cut -d' ' -f2 | cut -d'-' -f1)
    print_status "PHP version: $PHP_VERSION"
    
    # Check if PHP version is 7.4 or higher
    if php -r "exit(version_compare(PHP_VERSION, '7.4.0', '<') ? 1 : 0);"; then
        print_error "PHP 7.4 or higher is required. Current version: $PHP_VERSION"
        exit 1
    fi
else
    print_error "PHP is not installed or not in PATH"
    exit 1
fi

# Check MySQL/MariaDB
if command -v mysql &> /dev/null; then
    MYSQL_VERSION=$(mysql --version | cut -d' ' -f6 | cut -d',' -f1)
    print_status "MySQL version: $MYSQL_VERSION"
elif command -v mariadb &> /dev/null; then
    MARIADB_VERSION=$(mariadb --version | cut -d' ' -f6 | cut -d',' -f1)
    print_status "MariaDB version: $MARIADB_VERSION"
else
    print_error "MySQL or MariaDB is not installed or not in PATH"
    exit 1
fi

# Check web server
if command -v apache2 &> /dev/null || command -v httpd &> /dev/null; then
    print_status "Apache web server detected"
elif command -v nginx &> /dev/null; then
    print_status "Nginx web server detected"
else
    print_warning "No common web server detected. Make sure you have a web server installed."
fi

# Step 2: Set up directories and permissions
print_step "2. Setting up directories and permissions..."

# Create upload directories
UPLOAD_DIRS=(
    "uploads"
    "uploads/academic_calendar"
    "uploads/student_admission"
    "uploads/research_publications"
    "uploads/syllabus"
    "uploads/placement"
    "uploads/alumni"
    "uploads/student_projects"
    "uploads/scholarship"
    "uploads/meeting_minutes"
    "uploads/faculty_appraisal"
    "uploads/value_added_courses"
    "uploads/extension_outreach"
    "uploads/student_participation"
    "uploads/mou_collaboration"
    "uploads/higher_study"
    "uploads/remedial_classes"
    "uploads/bridge_course"
    "uploads/timetable"
    "uploads/internal_assessment"
    "uploads/result_analysis"
)

for dir in "${UPLOAD_DIRS[@]}"; do
    if [ ! -d "$dir" ]; then
        mkdir -p "$dir"
        print_status "Created directory: $dir"
    fi
    chmod 755 "$dir"
done

# Set permissions for config directory
if [ -d "config" ]; then
    chmod 755 config
    print_status "Set permissions for config directory"
fi

# Step 3: Check PHP extensions
print_step "3. Checking PHP extensions..."

REQUIRED_EXTENSIONS=("pdo" "pdo_mysql" "fileinfo" "gd" "session" "json")

for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if php -m | grep -q "^$ext$"; then
        print_status "PHP extension '$ext' is installed"
    else
        print_error "Required PHP extension '$ext' is not installed"
        exit 1
    fi
done

# Step 4: Database setup prompt
print_step "4. Database configuration..."

echo ""
echo "Please provide database configuration details:"
read -p "Database host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Database name [dept_file_management]: " DB_NAME
DB_NAME=${DB_NAME:-dept_file_management}

read -p "Database username: " DB_USER
if [ -z "$DB_USER" ]; then
    print_error "Database username is required"
    exit 1
fi

read -s -p "Database password: " DB_PASS
echo ""

# Test database connection
print_status "Testing database connection..."
if mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1;" &> /dev/null; then
    print_status "Database connection successful"
else
    print_error "Database connection failed. Please check your credentials."
    exit 1
fi

# Create database if it doesn't exist
mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\`;" 2>/dev/null
if [ $? -eq 0 ]; then
    print_status "Database '$DB_NAME' is ready"
else
    print_error "Failed to create database '$DB_NAME'"
    exit 1
fi

# Step 5: Update database configuration
print_step "5. Updating database configuration..."

# Backup original config file
if [ -f "config/database.php" ]; then
    cp config/database.php config/database.php.backup
    print_status "Backed up original database configuration"
fi

# Update database configuration
cat > config/database.php << EOF
<?php
// Database configuration
define('DB_HOST', '$DB_HOST');
define('DB_USER', '$DB_USER');
define('DB_PASS', '$DB_PASS');
define('DB_NAME', '$DB_NAME');

class Database {
    private \$host = DB_HOST;
    private \$user = DB_USER;
    private \$pass = DB_PASS;
    private \$dbname = DB_NAME;
    private \$dbh;
    private \$error;

    public function __construct() {
        // Set DSN
        \$dsn = 'mysql:host=' . \$this->host . ';dbname=' . \$this->dbname;
        
        // Set options
        \$options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instance
        try {
            \$this->dbh = new PDO(\$dsn, \$this->user, \$this->pass, \$options);
        } catch(PDOException \$e) {
            \$this->error = \$e->getMessage();
        }
    }

    public function getConnection() {
        return \$this->dbh;
    }
}
?>
EOF

print_status "Database configuration updated"

# Step 6: Import database schema
print_step "6. Importing database schema..."

if [ -f "database/schema.sql" ]; then
    mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < database/schema.sql
    if [ $? -eq 0 ]; then
        print_status "Database schema imported successfully"
    else
        print_error "Failed to import database schema"
        exit 1
    fi
else
    print_error "Database schema file not found: database/schema.sql"
    exit 1
fi

# Step 7: Create admin user
print_step "7. Creating admin user..."

echo ""
read -p "Admin username [admin]: " ADMIN_USER
ADMIN_USER=${ADMIN_USER:-admin}

read -s -p "Admin password: " ADMIN_PASS
echo ""
if [ -z "$ADMIN_PASS" ]; then
    print_error "Admin password is required"
    exit 1
fi

read -p "Admin email: " ADMIN_EMAIL
if [ -z "$ADMIN_EMAIL" ]; then
    print_error "Admin email is required"
    exit 1
fi

# Hash the password using PHP
HASHED_PASS=$(php -r "echo password_hash('$ADMIN_PASS', PASSWORD_DEFAULT);")

# Insert admin user
mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "
DELETE FROM users WHERE username = 'admin';
INSERT INTO users (username, password, email, role, department) 
VALUES ('$ADMIN_USER', '$HASHED_PASS', '$ADMIN_EMAIL', 'admin', 'Administration');
"

if [ $? -eq 0 ]; then
    print_status "Admin user created successfully"
else
    print_error "Failed to create admin user"
    exit 1
fi

# Step 8: Set final permissions
print_step "8. Setting final permissions..."

# Set secure permissions
find . -type f -exec chmod 644 {} \; 2>/dev/null
find . -type d -exec chmod 755 {} \; 2>/dev/null

# Make config file more secure
chmod 600 config/database.php

print_status "Permissions set successfully"

# Step 9: Create installation lock
print_step "9. Finalizing installation..."

echo "$(date '+%Y-%m-%d %H:%M:%S')" > config/installed.lock
print_status "Installation lock file created"

# Step 10: Cleanup
print_step "10. Cleaning up..."

# Remove setup directory for security
if [ -d "setup" ]; then
    read -p "Remove setup directory for security? (y/N): " REMOVE_SETUP
    if [[ $REMOVE_SETUP =~ ^[Yy]$ ]]; then
        rm -rf setup/
        print_status "Setup directory removed"
    else
        print_warning "Setup directory kept. Consider removing it manually for security."
    fi
fi

# Final summary
echo ""
echo "=================================================="
print_status "Deployment completed successfully!"
echo "=================================================="
echo ""
echo "System Information:"
echo "- Database Host: $DB_HOST"
echo "- Database Name: $DB_NAME"
echo "- Admin Username: $ADMIN_USER"
echo "- Admin Email: $ADMIN_EMAIL"
echo ""
echo "Next Steps:"
echo "1. Access your application through a web browser"
echo "2. Login with the admin credentials you created"
echo "3. Configure additional users as needed"
echo "4. Start using the document management system"
echo ""
echo "Security Recommendations:"
echo "- Change default passwords regularly"
echo "- Keep the system updated"
echo "- Monitor access logs"
echo "- Implement regular backups"
echo ""
print_status "Enjoy your Smart Archival & Information System!"