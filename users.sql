-- Create database
CREATE DATABASE IF NOT EXISTS school_management;
USE school_management;

-- Create users table for login
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('teacher', 'student') NOT NULL
);

-- Create grades table
CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grade_name VARCHAR(50) NOT NULL
);

-- Create subjects table
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL,
    grade_id INT,
    FOREIGN KEY (grade_id) REFERENCES grades(id) ON DELETE CASCADE
);

-- Insert grades (from 1st grade to 13th grade)
INSERT INTO grades (grade_name) VALUES 
('1st Grade'), ('2nd Grade'), ('3rd Grade'), ('4th Grade'), 
('5th Grade'), ('6th Grade'), ('7th Grade'), ('8th Grade'), 
('9th Grade'), ('10th Grade'), ('11th Grade'), ('12th Grade'), ('13th Grade');

-- Create topics table
CREATE TABLE IF NOT EXISTS topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Create videos table
CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT,
    filename VARCHAR(255) NOT NULL,
    FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
);

-- Create pdfs table
CREATE TABLE IF NOT EXISTS pdfs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
);

-- Create assignments table
CREATE TABLE IF NOT EXISTS assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
);

-- Insert sample data into subjects table
INSERT INTO subjects (subject_name, grade_id) VALUES 
('Mathematics', 1),
('Science', 2),
('History', 3),
('Geography', 4),
('English', 5),
('Physics', 6),
('Chemistry', 7),
('Biology', 8),
('Computer Science', 9),
('Art', 10),
('Music', 11),
('Physical Education', 12),
('Economics', 13);

-- Insert sample data into users table
INSERT INTO users (user_id, password, role) VALUES 
('T001', 'password123', 'teacher'),
('S001', 'password123', 'student');
