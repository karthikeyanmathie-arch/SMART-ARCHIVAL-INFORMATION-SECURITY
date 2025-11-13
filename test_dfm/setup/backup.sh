#!/bin/bash

# Backup Script for Smart Archival & Information System
# This script creates backups of database and uploaded files

# Configuration
BACKUP_DIR="/var/backups/dept_management"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Load database configuration
if [ -f "../config/database.php" ]; then
    DB_HOST=$(grep "define('DB_HOST'" ../config/database.php | cut -d"'" -f4)
    DB_USER=$(grep "define('DB_USER'" ../config/database.php | cut -d"'" -f4)
    DB_PASS=$(grep "define('DB_PASS'" ../config/database.php | cut -d"'" -f4)
    DB_NAME=$(grep "define('DB_NAME'" ../config/database.php | cut -d"'" -f4)
else
    print_error "Database configuration file not found"
    exit 1
fi

# Create backup directory
mkdir -p "$BACKUP_DIR"

print_status "Starting backup process..."

# Database backup
print_status "Creating database backup..."
DB_BACKUP_FILE="$BACKUP_DIR/database_$DATE.sql"

if mysqldump -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$DB_BACKUP_FILE" 2>/dev/null; then
    print_status "Database backup created: $DB_BACKUP_FILE"
    gzip "$DB_BACKUP_FILE"
    print_status "Database backup compressed: ${DB_BACKUP_FILE}.gz"
else
    print_error "Database backup failed"
    exit 1
fi

# Files backup
print_status "Creating files backup..."
FILES_BACKUP_FILE="$BACKUP_DIR/files_$DATE.tar.gz"

if [ -d "../uploads" ]; then
    tar -czf "$FILES_BACKUP_FILE" -C .. uploads/ 2>/dev/null
    if [ $? -eq 0 ]; then
        print_status "Files backup created: $FILES_BACKUP_FILE"
    else
        print_error "Files backup failed"
        exit 1
    fi
else
    print_warning "Uploads directory not found, skipping files backup"
fi

# Configuration backup
print_status "Creating configuration backup..."
CONFIG_BACKUP_FILE="$BACKUP_DIR/config_$DATE.tar.gz"

if [ -d "../config" ]; then
    tar -czf "$CONFIG_BACKUP_FILE" -C .. config/ 2>/dev/null
    if [ $? -eq 0 ]; then
        print_status "Configuration backup created: $CONFIG_BACKUP_FILE"
    else
        print_warning "Configuration backup failed"
    fi
fi

# Cleanup old backups
print_status "Cleaning up old backups (older than $RETENTION_DAYS days)..."

find "$BACKUP_DIR" -name "database_*.sql.gz" -mtime +$RETENTION_DAYS -delete 2>/dev/null
find "$BACKUP_DIR" -name "files_*.tar.gz" -mtime +$RETENTION_DAYS -delete 2>/dev/null
find "$BACKUP_DIR" -name "config_*.tar.gz" -mtime +$RETENTION_DAYS -delete 2>/dev/null

print_status "Old backups cleaned up"

# Generate backup report
BACKUP_SIZE=$(du -sh "$BACKUP_DIR" | cut -f1)
BACKUP_COUNT=$(ls -1 "$BACKUP_DIR" | wc -l)

echo ""
echo "Backup Summary:"
echo "- Backup Directory: $BACKUP_DIR"
echo "- Total Size: $BACKUP_SIZE"
echo "- Total Files: $BACKUP_COUNT"
echo "- Latest Database Backup: database_$DATE.sql.gz"
echo "- Latest Files Backup: files_$DATE.tar.gz"
echo "- Latest Config Backup: config_$DATE.tar.gz"

print_status "Backup process completed successfully!"

# Optional: Send notification (uncomment and configure as needed)
# echo "Backup completed at $(date)" | mail -s "Backup Report - Dept Management" admin@yourdomain.com