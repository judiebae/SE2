-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS fur_a_paw_intments;

-- Switch to the newly created database
USE fur_a_paw_intments;

-- Drop tables if they exist (in reverse order of dependencies)
DROP TABLE IF EXISTS admin_activities_reminders;
DROP TABLE IF EXISTS payment_membership_status;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS payment;
DROP TABLE IF EXISTS pet;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS admin;

-- Create Admin table
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(100) UNIQUE NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    admin_position VARCHAR(50) NOT NULL
);

-- Create Customer table
CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_first_name VARCHAR(50) NOT NULL,
    customer_last_name VARCHAR(50) NOT NULL,
    customer_email VARCHAR(100) UNIQUE NOT NULL,
    customer_contact_number VARCHAR(15) NOT NULL,
    customer_password VARCHAR(255) NOT NULL,
    customer_membership_status ENUM('Regular', 'Premium') DEFAULT 'Regular'
);

-- Create Service table
CREATE TABLE service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(50) NOT NULL,
    service_rate DECIMAL(10,2) NOT NULL
);

CREATE TABLE pet ( 
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NULL,
    pet_name VARCHAR(50) NOT NULL,
    pet_size ENUM('Small Dog', 'Regular Dog', 'Large Dog', 'Regular Cat') NOT NULL,
    pet_breed VARCHAR(50) NOT NULL, -- ✅ Ensure breed is always recorded
    pet_age INT CHECK (pet_age >= 0), -- ✅ Prevent negative age values
    pet_gender ENUM('Male', 'Female') NOT NULL, -- ✅ Add gender field
    pet_description TEXT NULL,
    pet_profile_photo TEXT NULL,
    pet_vaccination_status ENUM('Vaccinated', 'Not Vaccinated') NOT NULL DEFAULT 'Not Vaccinated',
    pet_vaccination_card TEXT NULL,
    pet_vaccination_date DATE NULL,
    pet_vaccination_expiry DATE NULL,
    pet_special_instruction TEXT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
);



-- Create Payment table 
-- ALTER TABLE payment MODIFY payment_reference_number VARCHAR(50) UNIQUE NULL;  CHANGE TO NULL TO SEE WHATS UP BUTT IF ERROR CHANGE BACK TO NOT NULL
CREATE TABLE payment ( 
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    payment_reference_number VARCHAR(50) UNIQUE NULL,
    payment_category ENUM('Full', 'Downpayment'),
    payment_amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('GCash', 'Maya', 'Credit Card', 'Cash') NOT NULL,
    payment_status ENUM('Pending', 'Completed', 'Failed') NOT NULL,
    payment_date DATE NOT NULL,
    proof_of_payment TEXT,
    customer_id INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
);

-- Create Booking table
-- ALTER TABLE booking MODIFY admin_id INT NULL; CHANGE TO NULL TO SEE WHATS UP BUTT IF ERROR CHANGE BACK TO NOT NULL
CREATE TABLE booking (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    service_id INT NOT NULL,
    payment_id INT NOT NULL,
    payment_status ENUM('Pending', 'Paid', 'Cancelled') NOT NULL,
    admin_id INT NULL,
    booking_date DATE NOT NULL,
    booking_status ENUM('Confirmed', 'Cancelled', 'Completed') NOT NULL,
    booking_check_in TIME,
    booking_check_out TIME,
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES service(service_id) ON DELETE CASCADE,
    FOREIGN KEY (payment_id) REFERENCES payment(payment_id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Create Payment Membership Status table
CREATE TABLE payment_membership_status (
    payment_membership_id INT AUTO_INCREMENT PRIMARY KEY,
    payment_id INT NOT NULL,
    admin_id INT NOT NULL,
    FOREIGN KEY (payment_id) REFERENCES payment(payment_id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Create Admin Activities Reminders table
CREATE TABLE admin_activities_reminders (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    activity_date DATE NOT NULL,
    activity_time TIME NOT NULL,
    activity_description TEXT,
    activity_type ENUM('Reminder', 'Task'),
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Insert sample data into Admin table
INSERT INTO admin (admin_name, admin_email, admin_password, admin_position) VALUES
('John Doe', 'john@example.com', 'hashedpassword1', 'Manager'),
('Jane Smith', 'jane@example.com', 'hashedpassword2', 'Supervisor'),
('Mike Johnson', 'mike@example.com', 'hashedpassword3', 'Staff'),
('Emily Davis', 'emily@example.com', 'hashedpassword4', 'Coordinator'),
('David Wilson', 'david@example.com', 'hashedpassword5', 'HR');

-- Insert sample data into Customer table
INSERT INTO customer (customer_first_name, customer_last_name, customer_email, customer_contact_number, customer_password, customer_membership_status) VALUES
('Alice', 'Brown', 'alice@example.com', '09123456789', 'hashedpassword6', 'Regular'),
('Bob', 'Green', 'bob@example.com', '09234567890', 'hashedpassword7', 'Premium'),
('Charlie', 'White', 'charlie@example.com', '09345678901', 'hashedpassword8', 'Regular'),
('Diana', 'Black', 'diana@example.com', '09456789012', 'hashedpassword9', 'Premium'),
('Ethan', 'Gray', 'ethan@example.com', '09567890123', 'hashedpassword10', 'Regular');


INSERT INTO payment (payment_reference_number, payment_category, payment_amount, payment_method, payment_status, payment_date, proof_of_payment, customer_id) VALUES
('REF12345', 'Full', 1000.00, 'GCash', 'Completed', '2025-02-25', 'proof1.jpg', 1),
('REF67890', 'Downpayment', 500.00, 'Maya', 'Pending', '2025-02-26', 'proof2.jpg', 2),
('REF11223', 'Full', 1500.00, 'Credit Card', 'Completed', '2025-02-27', 'proof3.jpg', 3),
('REF44556', 'Full', 750.00, 'Cash', 'Completed', '2025-02-28', 'proof4.jpg', 4),
('REF77889', 'Downpayment', 1200.00, 'Maya', 'Pending', '2025-03-01', 'proof5.jpg', 5);

-- Insert sample data into Payment Membership Status Table
INSERT INTO payment_membership_status (payment_id, admin_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insert sample data into Admin Activities Reminders Table
INSERT INTO admin_activities_reminders (admin_id, activity_date, activity_time, activity_description, activity_type) VALUES
(1, '2025-02-25', '10:00:00', 'Team Meeting', 'Reminder'),
(2, '2025-02-26', '14:00:00', 'Client Follow-up', 'Reminder'),
(3, '2025-02-27', '09:00:00', 'System Maintenance', 'Task'),
(4, '2025-02-28', '11:30:00', 'Budget Review', 'Reminder'),
(5, '2025-03-01', '13:45:00', 'HR Briefing', 'Reminder');


-- Insert sample data into Pet Table
INSERT INTO pet (customer_id, pet_name, pet_size, pet_breed, pet_age, pet_description, pet_profile_photo, pet_vaccination_status, pet_vaccination_card, pet_vaccination_date, pet_vaccination_expiry, pet_special_instruction)
VALUES
(1, 'Buddy', 'Regular Dog', 'Labrador Retriever', 3, 'Loves to play fetch', 'uploads/buddy.jpg', 'Vaccinated', 'uploads/buddy_vaccine.pdf', '2024-06-10', '2025-06-10', 'No chicken diet'),
(2, 'Whiskers', 'Regular Cat', 'Persian', 2, 'Fluffy and loves naps', 'uploads/whiskers.jpg', 'Not Vaccinated', NULL, NULL, NULL, 'Keep indoors only'),
(3, 'Max', 'Large Dog', 'German Shepherd', 4, 'Trained for security', 'uploads/max.jpg', 'Vaccinated', 'uploads/max_vaccine.pdf', '2023-09-20', '2024-09-20', 'Needs daily exercise'),
(4, 'Luna', 'Small Dog', 'Chihuahua', 1, 'Very energetic and playful', 'uploads/luna.jpg', 'Vaccinated', 'uploads/luna_vaccine.pdf', '2024-02-15', '2025-02-15', 'Sensitive to cold weather'),
(5, 'Shadow', 'Regular Dog', 'Siberian Husky', 5, 'Enjoys long runs in the snow', 'uploads/shadow.jpg', 'Not Vaccinated', NULL, NULL, NULL, 'Requires extra hydration');



INSERT INTO service (service_name, service_rate) VALUES
('Pet Hotel', 750.00),
('Daycare', 480.00),
('Grooming', 550.00),
('Training', 400.00),
('Veterinary Checkup', 1600.00);

-- Insert sample data into Booking Table
INSERT INTO booking (pet_id, service_id, payment_id, payment_status, admin_id, booking_date, booking_status, booking_check_in, booking_check_out) VALUES
(1, 1, 1, 'Paid', 1, '2025-02-26', 'Confirmed', '10:00:00', '12:00:00'),
(2, 2, 2, 'Pending', 2, '2025-02-27', 'Confirmed', '11:00:00', '14:00:00'),
(3, 3, 3, 'Paid', 3, '2025-02-28', 'Completed', '09:00:00', '10:30:00'),
(4, 4, 4, 'Paid', 4, '2025-03-01', 'Confirmed', '13:00:00', '15:00:00'),
(5, 5, 5, 'Pending', 5, '2025-03-02', 'Cancelled', NULL, NULL);
