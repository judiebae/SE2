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
    admin_id VARCHAR(10) PRIMARY KEY,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(100) UNIQUE NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    admin_position VARCHAR(50) NOT NULL
);

-- Create Customer table
CREATE TABLE customer (
    customer_id VARCHAR(10) PRIMARY KEY,
    customer_first_name VARCHAR(50) NOT NULL,
    customer_last_name VARCHAR(50) NOT NULL,
    customer_email VARCHAR(100) UNIQUE NOT NULL,
    customer_contact_number VARCHAR(15) NOT NULL,
    customer_password VARCHAR(255) NOT NULL,
    customer_membership_status VARCHAR(20) DEFAULT 'Regular'
);

-- Create Service table
CREATE TABLE service (
    service_id VARCHAR(10) PRIMARY KEY,
    service_name VARCHAR(50) NOT NULL,
    service_rate DECIMAL(10,2) NOT NULL
);

-- Create Pet table
CREATE TABLE pet (
    pet_id VARCHAR(10) PRIMARY KEY,
    customer_id VARCHAR(10) NOT NULL,
    pet_name VARCHAR(50) NOT NULL,
    pet_size VARCHAR(20),
    pet_breed VARCHAR(50),
    pet_age INT(2),
    pet_gender VARCHAR(10),
    pet_vaccination_status VARCHAR(10),
    pet_vaccination_card TEXT,
    pet_special_instruction TEXT,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
);

-- Create Payment table
CREATE TABLE payment (
    payment_id VARCHAR(10) PRIMARY KEY,
    payment_reference_number VARCHAR(50) UNIQUE NOT NULL,
    payment_category VARCHAR(10),
    payment_amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(15) NOT NULL,
    payment_status VARCHAR(15) NOT NULL,
    payment_date DATE NOT NULL,
    proof_of_payment TEXT,
    customer_id VARCHAR(10) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
);

-- Create Booking table
CREATE TABLE booking (
    booking_id VARCHAR(10) PRIMARY KEY,
    pet_id VARCHAR(10) NOT NULL,
    service_id VARCHAR(10) NOT NULL,
    payment_id VARCHAR(10) NOT NULL,
    payment_status VARCHAR(15) NOT NULL,
    admin_id VARCHAR(10) NOT NULL,
    booking_date DATE NOT NULL,
    booking_status VARCHAR(15) NOT NULL,
    booking_check_in TEXT,
    booking_check_out TEXT,
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES service(service_id) ON DELETE CASCADE,
    FOREIGN KEY (payment_id) REFERENCES payment(payment_id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Create Payment Membership Status table
CREATE TABLE payment_membership_status (
    payment_membership_id VARCHAR(10) PRIMARY KEY,
    payment_id VARCHAR(10) NOT NULL,
    admin_id VARCHAR(10) NOT NULL,
    FOREIGN KEY (payment_id) REFERENCES payment(payment_id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Create Admin Activities Reminders table
CREATE TABLE admin_activities_reminders (
    activity_id VARCHAR(10) PRIMARY KEY,
    admin_id VARCHAR(10) NOT NULL,
    activity_date DATE NOT NULL,
    activity_time TIME NOT NULL,
    activity_description TEXT,
    activity_type VARCHAR(15),
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

-- Insert sample data into Customer Table
INSERT INTO customer (customer_id, customer_first_name, customer_last_name, customer_email, customer_contact_number, customer_password, customer_membership_status) VALUES
('C001', 'Alice', 'Brown', 'alice@example.com', '09123456789', 'hashedpassword6', 'Regular'),
('C002', 'Bob', 'Green', 'bob@example.com', '09234567890', 'hashedpassword7', 'Silver'),
('C003', 'Charlie', 'White', 'charlie@example.com', '09345678901', 'hashedpassword8', 'Gold'),
('C004', 'Diana', 'Black', 'diana@example.com', '09456789012', 'hashedpassword9', 'Platinum'),
('C005', 'Ethan', 'Gray', 'ethan@example.com', '09567890123', 'hashedpassword10', 'Regular');

-- Insert sample data
-- Insert sample data into Admin Table
INSERT INTO admin (admin_id, admin_name, admin_email, admin_password, admin_position) VALUES
('A001', 'John Doe', 'john@example.com', 'hashedpassword1', 'Manager'),
('A002', 'Jane Smith', 'jane@example.com', 'hashedpassword2', 'Supervisor'),
('A003', 'Mike Johnson', 'mike@example.com', 'hashedpassword3', 'Staff'),
('A004', 'Emily Davis', 'emily@example.com', 'hashedpassword4', 'Coordinator'),
('A005', 'David Wilson', 'david@example.com', 'hashedpassword5', 'HR');

-- Insert sample data into Payment Table
INSERT INTO payment (payment_id, payment_reference_number, payment_category, payment_amount, payment_method, payment_status, payment_date, proof_of_payment, customer_id) VALUES
('P001', 'REF12345', 'Booking', 1000.00, 'Gcash', 'Fully Paid', '2025-02-25', 'proof1.jpg', 'C001'),
('P002', 'REF67890', 'Membership', 500.00, 'PayMaya', 'Down Payment', '2025-02-26', 'proof2.jpg', 'C002'),
('P003', 'REF11223', 'Booking', 1500.00, 'Cash', 'Fully Paid', '2025-02-27', 'proof3.jpg', 'C003'),
('P004', 'REF44556', 'Membership', 750.00, 'Gcash', 'Fully Paid', '2025-02-28', 'proof4.jpg', 'C004'),
('P005', 'REF77889', 'Booking', 1200.00, 'PayMaya', 'Down Payment', '2025-03-01', 'proof5.jpg', 'C005');

-- Insert sample data into Payment Membership Status Table
INSERT INTO payment_membership_status (payment_membership_id, payment_id, admin_id) VALUES
('PM001', 'P001', 'A001'),
('PM002', 'P002', 'A002'),
('PM003', 'P003', 'A003'),
('PM004', 'P004', 'A004'),
('PM005', 'P005', 'A005');

-- Insert sample data into Admin Activities Reminders Table
INSERT INTO admin_activities_reminders (activity_id, admin_id, activity_date, activity_time, activity_description, activity_type) VALUES
('ACT001', 'A001', '2025-02-25', '10:00:00', 'Team Meeting', 'Meeting'),
('ACT002', 'A002', '2025-02-26', '14:00:00', 'Client Follow-up', 'Reminder'),
('ACT003', 'A003', '2025-02-27', '09:00:00', 'System Maintenance', 'Task'),
('ACT004', 'A004', '2025-02-28', '11:30:00', 'Budget Review', 'Event'),
('ACT005', 'A005', '2025-03-01', '13:45:00', 'HR Briefing', 'Meeting');

-- Insert sample data into Pet Table
INSERT INTO pet (pet_id, customer_id, pet_name, pet_size, pet_breed, pet_age, pet_gender, pet_vaccination_status, pet_vaccination_card, pet_special_instruction) VALUES
('PET001', 'C001', 'Buddy', 'Regular Dog', 'Golden Retriever', 3, 'Male', 'Yes', 'vacc_card1.jpg', 'Needs daily exercise'),
('PET002', 'C002', 'Milo', 'Small Dog', 'Pomeranian', 2, 'Male', 'Yes', 'vacc_card2.jpg', 'Grooming required weekly'),
('PET003', 'C003', 'Luna', 'Cat', 'Siamese', 4, 'Female', 'Yes', 'vacc_card3.jpg', 'Prefers quiet spaces'),
('PET004', 'C004', 'Rocky', 'Large Dog', 'German Shepherd', 5, 'Male', 'Yes', 'vacc_card4.jpg', 'Needs a lot of space'),
('PET005', 'C005', 'Coco', 'Regular Dog', 'Beagle', 3, 'Female', 'No', 'None', 'Loves to play fetch');


-- Insert sample data into Service Table
INSERT INTO service (service_id, service_name, service_rate) VALUES
('S001', 'Pet Daycare', 500.00),
('S002', 'Pet Hotel', 1000.00),
('S003', 'Grooming', 300.00);

-- Insert sample data into Booking Table
INSERT INTO booking (booking_id, pet_id, service_id, payment_id, payment_status, admin_id, booking_date, booking_status, booking_check_in, booking_check_out) VALUES
('B001', 'PET001', 'S001', 'P001', 'Completed', 'A001', '2025-02-25', 'Confirmed', '2025-02-26 10:00:00', '2025-02-27 10:00:00'),
('B002', 'PET002', 'S002', 'P002', 'Pending', 'A002', '2025-02-26', 'Pending', '2025-02-27 11:00:00', '2025-02-28 11:00:00'),
('B003', 'PET003', 'S003', 'P003', 'Completed', 'A003', '2025-02-27', 'Confirmed', '2025-02-28 09:00:00', '2025-03-01 09:00:00'),
('B004', 'PET004', 'S001', 'P004', 'Cancelled', 'A004', '2025-02-28', 'Cancelled', '2025-02-29 12:00:00', '2025-03-01 12:00:00'),
('B005', 'PET005', 'S002', 'P005', 'Completed', 'A005', '2025-03-01', 'Completed', '2025-03-02 14:00:00', '2025-03-03 14:00:00');

