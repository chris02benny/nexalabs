-- Programs Table for NEXA Labs
-- Run this SQL in MySQL Workbench to create the programs table

USE nexalabs_db;

-- Create programs table
CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    program_name VARCHAR(255) NOT NULL,
    focus_areas TEXT NULL COMMENT 'Programmes / Focus Areas - can contain newlines',
    applications TEXT NULL COMMENT 'Applications - can contain newlines',
    outcome TEXT NULL COMMENT 'Outcome - can contain newlines',
    isactive TINYINT(1) DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
    reg_start_date DATE NULL COMMENT 'Registration start date',
    reg_end_date DATE NULL COMMENT 'Registration end date',
    program_start_date DATE NULL COMMENT 'Program start date',
    program_end_date DATE NULL COMMENT 'Program end date',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_program_name (program_name),
    INDEX idx_isactive (isactive),
    INDEX idx_reg_dates (reg_start_date, reg_end_date),
    INDEX idx_program_dates (program_start_date, program_end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data (optional - for testing)
INSERT INTO programs (
    program_name,
    focus_areas,
    applications,
    outcome,
    isactive,
    reg_start_date,
    reg_end_date,
    program_start_date,
    program_end_date
) VALUES
(
    'Extended Reality (XR): AR & VR',
    'Augmented Reality (AR) Development
Virtual Reality (VR) Development
Immersive Simulations & Interactive Experiences',
    'Education & Training
Industrial Visualization
Smart Maintenance & Field Services
Cultural & Heritage Experiences
Engineering & Scientific Simulations
Skill Training & Safety Drills
Healthcare & Rehabilitation
Design Visualization & Gaming',
    'Develops immersive application design skills, spatial thinking, and the ability to build interactive XR-based learning, training, and visualization solutions.',
    1,
    '2024-01-01',
    '2024-01-31',
    '2024-02-01',
    '2024-04-30'
),
(
    'Robotics & Intelligent Systems',
    'Industrial Robotics
Humanoid Robots
Drones & Autonomous Systems
AI-Enabled Robotics
Robot Operating System (ROS & ROS2)',
    'Industrial Automation
Smart Manufacturing
Autonomous Navigation
Human–Robot Interaction
Research & Development',
    'Builds hands-on expertise in robotics systems, automation, autonomy, and intelligent machine control using industry-grade platforms.',
    1,
    '2024-01-15',
    '2024-02-15',
    '2024-03-01',
    '2024-05-31'
),
(
    'Programming Foundations',
    'C Programming Essentials
Python for Beginners
MySQL Mastery Bootcamp',
    'Software Development Foundations
Data Processing & Automation
Backend and Database Systems',
    'Develops strong algorithmic thinking, problem-solving ability, and database fundamentals essential for advanced technology domains.',
    1,
    '2024-02-01',
    '2024-02-28',
    '2024-03-15',
    '2024-06-15'
);

-- View to get active programs
CREATE OR REPLACE VIEW vw_active_programs AS
SELECT 
    id,
    program_name,
    focus_areas,
    applications,
    outcome,
    reg_start_date,
    reg_end_date,
    program_start_date,
    program_end_date,
    created_at
FROM programs
WHERE isactive = 1
ORDER BY created_at DESC;

-- View to get programs with registration open
CREATE OR REPLACE VIEW vw_programs_registration_open AS
SELECT 
    id,
    program_name,
    focus_areas,
    applications,
    outcome,
    reg_start_date,
    reg_end_date,
    program_start_date,
    program_end_date,
    created_at
FROM programs
WHERE isactive = 1
    AND reg_start_date <= CURDATE()
    AND reg_end_date >= CURDATE()
ORDER BY reg_end_date ASC;

-- Notes:
-- 1. TEXT fields can store up to 65,535 characters and preserve newlines
-- 2. If you need longer content, change TEXT to LONGTEXT (up to 4GB)
-- 3. Newlines are preserved when storing and retrieving data
-- 4. Use nl2br() in PHP to convert newlines to <br> tags for display
-- 5. Use PHP_EOL or "\n" when inserting data with newlines

