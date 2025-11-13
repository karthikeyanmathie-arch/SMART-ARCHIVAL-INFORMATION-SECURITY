# Smart Archival & Information System

**SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002**

A comprehensive web application for managing academic department documents and records across three main areas: Department, Faculty, and Student.

## Features

### Department

- **Academic Calendar**: Manage academic year events and schedules
- **Timetable**: Class schedules and faculty assignments
- **Student Admission**: Student admission records and documents
- **Remedial Classes**: Remedial class schedules and records
- **Bridge Course Sessions**: Bridge course programs and sessions
- **Research Publications**: Faculty research publications and papers
- **MOU & Collaboration**: Memorandums of understanding and partnerships
- **Higher Study Data**: Passed out students pursuing higher studies

### Faculty

- **Syllabus**: Course syllabus and curriculum management
- **Result Analysis**: Student results and performance analysis
- **Internal Assessment**: Internal assessment records and marks
- **Scholarship Files**: Student scholarship applications and records
- **Placement Files**: Student placement records and company details
- **Meeting Minutes**: Department meeting minutes and decisions
- **Faculty Appraisal**: Faculty performance appraisal reports

### Student

- **Alumni Details**: Alumni information and contact details
- **Value Added Courses**: Additional courses and skill development programs
- **Extension & Outreach**: Community service and outreach programs
- **Student Projects**: Student project activities and records
- **Student Participation**: Student participation in other college events

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **File Upload**: Support for PDF, DOC, DOCX, JPG, PNG files

## Installation & Setup

### Prerequisites

- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Installation Steps

1. **Clone/Download the project**

   ```bash
   git clone <repository-url>
   # or download and extract the ZIP file
   ```

2. **Database Setup**

   - Create a new MySQL database named `dept_file_management`
   - Import the database schema:

   ```bash
   mysql -u root -p dept_file_management < database/schema.sql
   ```

3. **Configure Database Connection**

   - Edit `config/database.php`
   - Update database credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'dept_file_management');
   ```

4. **Set File Permissions**

   ```bash
   chmod 755 uploads/
   chmod 755 uploads/*/
   ```

5. **Web Server Configuration**
   - Point your web server document root to the project directory
   - Ensure PHP is enabled
   - Enable required PHP extensions: PDO, PDO_MySQL, fileinfo

### Default Login Credentials

- **Username**: admin
- **Password**: password

**Important**: Change the default password after first login!

## Directory Structure

```
├── admin/                  # Admin panel files
├── assets/                 # CSS, JS, and other assets
│   ├── css/
│   └── js/
├── config/                 # Configuration files
├── database/               # Database schema and migrations
├── includes/               # Common PHP includes
├── modules/                # Application modules
│   ├── department/         # Department modules
│   ├── faculty/           # Faculty modules
│   └── student/           # Student modules
├── uploads/               # File upload directory
├── index.php              # Main dashboard
├── login.php              # Login page
└── README.md              # This file
```

## Usage

1. **Login**: Access the application through your web browser and login with admin credentials
2. **Navigation**: Use the top navigation menu to access different areas
3. **Add Records**: Click on any module to add new records and upload documents
4. **Search & Filter**: Use the search functionality to find specific records
5. **File Management**: Upload and view documents associated with each record

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention using prepared statements
- File upload validation and security
- Session management and authentication
- Role-based access control

## File Upload Guidelines

- **Supported Formats**: PDF, DOC, DOCX, JPG, PNG
- **Maximum File Size**: Configure in PHP settings (`upload_max_filesize`)
- **Storage**: Files are stored in organized directories under `uploads/`

## Backup Recommendations

1. **Database Backup**: Regular MySQL dumps
2. **File Backup**: Backup the entire `uploads/` directory
3. **Code Backup**: Version control with Git

## Troubleshooting

### Common Issues

1. **Database Connection Error**

   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **File Upload Issues**

   - Check directory permissions (755 for uploads/)
   - Verify PHP upload settings
   - Ensure sufficient disk space

3. **Login Problems**
   - Verify default credentials
   - Check session configuration
   - Clear browser cache/cookies

### Error Logs

- Check PHP error logs
- Enable error reporting during development
- Monitor web server error logs

## Customization

### Adding New Modules

1. Create new PHP files in appropriate module directory
2. Follow existing code structure and patterns
3. Update navigation menu in `includes/navigation.php`
4. Add database tables if needed

### Styling

- Modify `assets/css/style.css` for visual changes
- Responsive design included for mobile devices
- Print-friendly styles available

## Support

For technical support or questions:

1. Check the troubleshooting section
2. Review PHP and MySQL error logs
3. Ensure all prerequisites are met

## License

This project is developed for educational and institutional use. Please ensure compliance with your organization's policies when deploying.

## Version History

- **v1.0**: Initial release with all core modules
- Complete CRUD operations for all sectors
- File upload and management
- User authentication and role management
- Responsive design and modern UI
