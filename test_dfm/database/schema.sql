-- Smart Archival & Information System Database Schema
-- Created for Academic Institution

CREATE DATABASE IF NOT EXISTS if0_40331495_dept_file_management;
USE if0_40331495_dept_file_management;

-- Users table for authentication
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'faculty', 'staff') NOT NULL,
    department VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- DEPARTMENT SECTOR TABLES

-- Academic Calendar
CREATE TABLE academic_calendar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    event_name VARCHAR(200) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    description TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Timetable
CREATE TABLE timetable (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    class_name VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    faculty_name VARCHAR(100) NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room_number VARCHAR(50),
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Student Admission
CREATE TABLE student_admission (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admission_year VARCHAR(20) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) UNIQUE NOT NULL,
    course VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    admission_date DATE NOT NULL,
    documents_path VARCHAR(500),
    status ENUM('admitted', 'pending', 'rejected') DEFAULT 'pending',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Remedial Classes
CREATE TABLE remedial_classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    faculty_name VARCHAR(100) NOT NULL,
    student_count INT NOT NULL,
    schedule_details TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Bridge Course Sessions
CREATE TABLE bridge_course_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    duration_hours INT NOT NULL,
    faculty_name VARCHAR(100) NOT NULL,
    student_count INT NOT NULL,
    session_details TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Research Publications
CREATE TABLE research_publications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(500) NOT NULL,
    authors TEXT NOT NULL,
    journal_name VARCHAR(200),
    publication_date DATE,
    volume VARCHAR(50),
    issue VARCHAR(50),
    pages VARCHAR(50),
    doi VARCHAR(100),
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- MOU and Collaboration
CREATE TABLE mou_collaboration (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_name VARCHAR(200) NOT NULL,
    mou_type ENUM('academic', 'research', 'industry', 'international') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    purpose TEXT,
    document_path VARCHAR(500),
    status ENUM('active', 'expired', 'terminated') DEFAULT 'active',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Higher Study Data (Passed Out Students)
CREATE TABLE higher_study_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    graduation_year VARCHAR(20) NOT NULL,
    course_completed VARCHAR(100) NOT NULL,
    higher_study_institution VARCHAR(200),
    higher_study_course VARCHAR(100),
    admission_year VARCHAR(20),
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- FACULTY SECTOR TABLES

-- Syllabus
CREATE TABLE syllabus (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    syllabus_content TEXT,
    document_path VARCHAR(500),
    approved_by VARCHAR(100),
    approval_date DATE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Result Analysis
CREATE TABLE result_analysis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    total_students INT NOT NULL,
    passed_students INT NOT NULL,
    failed_students INT NOT NULL,
    pass_percentage DECIMAL(5,2),
    analysis_details TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Internal Assessment Records
CREATE TABLE internal_assessment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    assessment_type ENUM('test1', 'test2', 'assignment', 'project') NOT NULL,
    max_marks INT NOT NULL,
    conducted_date DATE NOT NULL,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Scholarship Files
CREATE TABLE scholarship_files (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    scholarship_type VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2),
    academic_year VARCHAR(20) NOT NULL,
    application_date DATE NOT NULL,
    status ENUM('applied', 'approved', 'rejected', 'disbursed') DEFAULT 'applied',
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Placement Files
CREATE TABLE placement_files (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    company_name VARCHAR(200) NOT NULL,
    position VARCHAR(100) NOT NULL,
    package_offered DECIMAL(10,2),
    placement_date DATE NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Department Meeting Minutes
CREATE TABLE meeting_minutes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    meeting_date DATE NOT NULL,
    meeting_type ENUM('department', 'faculty', 'academic', 'administrative') NOT NULL,
    agenda TEXT NOT NULL,
    attendees TEXT,
    decisions TEXT,
    action_items TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Faculty Appraisal Reports
CREATE TABLE faculty_appraisal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    faculty_name VARCHAR(100) NOT NULL,
    employee_id VARCHAR(50) NOT NULL,
    appraisal_year VARCHAR(20) NOT NULL,
    teaching_score DECIMAL(5,2),
    research_score DECIMAL(5,2),
    service_score DECIMAL(5,2),
    overall_score DECIMAL(5,2),
    comments TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- STUDENT SECTOR TABLES

-- Alumni Details
CREATE TABLE alumni_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    graduation_year VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    current_organization VARCHAR(200),
    current_position VARCHAR(100),
    contact_email VARCHAR(100),
    contact_phone VARCHAR(20),
    address TEXT,
    achievements TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Value Added Course Details
CREATE TABLE value_added_courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(200) NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    duration_hours INT NOT NULL,
    instructor_name VARCHAR(100) NOT NULL,
    enrolled_students INT NOT NULL,
    course_description TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Extension and Outreach Programs
CREATE TABLE extension_outreach (
    id INT PRIMARY KEY AUTO_INCREMENT,
    program_name VARCHAR(200) NOT NULL,
    program_type ENUM('extension', 'outreach', 'community_service') NOT NULL,
    target_audience VARCHAR(100),
    program_date DATE NOT NULL,
    duration_days INT NOT NULL,
    participants_count INT NOT NULL,
    program_description TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Student Project Activities
CREATE TABLE student_projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_title VARCHAR(300) NOT NULL,
    student_names TEXT NOT NULL,
    guide_name VARCHAR(100) NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    project_type ENUM('minor', 'major', 'research') NOT NULL,
    project_description TEXT,
    document_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Student Participation in Other Colleges
CREATE TABLE student_participation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    event_name VARCHAR(200) NOT NULL,
    organizing_college VARCHAR(200) NOT NULL,
    event_type ENUM('technical', 'cultural', 'sports', 'academic') NOT NULL,
    participation_date DATE NOT NULL,
    achievement VARCHAR(100),
    certificate_path VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert default admin user
INSERT INTO users (username, password, email, role, department) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@college.edu', 'admin', 'Administration');