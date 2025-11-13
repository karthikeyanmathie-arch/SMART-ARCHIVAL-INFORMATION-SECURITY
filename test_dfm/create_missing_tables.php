<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

echo "Creating missing database tables...\n";

$missing_tables = [
    'placement_data' => "CREATE TABLE IF NOT EXISTS placement_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(255) NOT NULL,
        company_name VARCHAR(255) NOT NULL,
        position VARCHAR(255),
        package DECIMAL(10,2),
        placement_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'alumni_data' => "CREATE TABLE IF NOT EXISTS alumni_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        graduation_year YEAR,
        department VARCHAR(100),
        current_position VARCHAR(255),
        company VARCHAR(255),
        contact_email VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'timetable' => "CREATE TABLE IF NOT EXISTS timetable (
        id INT AUTO_INCREMENT PRIMARY KEY,
        class_name VARCHAR(100) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        time_slot VARCHAR(50),
        day_of_week VARCHAR(20),
        faculty_name VARCHAR(100),
        room_number VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'exam_schedule' => "CREATE TABLE IF NOT EXISTS exam_schedule (
        id INT AUTO_INCREMENT PRIMARY KEY,
        exam_name VARCHAR(255) NOT NULL,
        subject VARCHAR(100),
        exam_date DATE,
        start_time TIME,
        end_time TIME,
        room_number VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'announcements' => "CREATE TABLE IF NOT EXISTS announcements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        announcement_date DATE,
        target_audience ENUM('students', 'faculty', 'all'),
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'notices' => "CREATE TABLE IF NOT EXISTS notices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        notice_date DATE,
        expiry_date DATE,
        priority ENUM('low', 'medium', 'high'),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'faculty_profiles' => "CREATE TABLE IF NOT EXISTS faculty_profiles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        designation VARCHAR(100),
        department VARCHAR(100),
        email VARCHAR(255),
        phone VARCHAR(20),
        specialization TEXT,
        experience INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'course_materials' => "CREATE TABLE IF NOT EXISTS course_materials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_name VARCHAR(255) NOT NULL,
        material_type ENUM('lecture', 'assignment', 'reference'),
        title VARCHAR(255),
        file_path VARCHAR(500),
        uploaded_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'attendance' => "CREATE TABLE IF NOT EXISTS attendance (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50),
        subject VARCHAR(100),
        date DATE,
        status ENUM('present', 'absent'),
        recorded_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'grades' => "CREATE TABLE IF NOT EXISTS grades (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50),
        subject VARCHAR(100),
        exam_type VARCHAR(50),
        marks DECIMAL(5,2),
        max_marks DECIMAL(5,2),
        grade VARCHAR(10),
        recorded_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'events' => "CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_name VARCHAR(255) NOT NULL,
        event_date DATE,
        start_time TIME,
        end_time TIME,
        location VARCHAR(255),
        description TEXT,
        organizer VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach($missing_tables as $table_name => $sql) {
    try {
        $conn->exec($sql);
        echo "✅ Table '$table_name' created successfully\n";
    } catch (Exception $e) {
        echo "❌ Failed to create table '$table_name': " . $e->getMessage() . "\n";
    }
}

echo "\nAll missing tables creation completed!\n";
?>