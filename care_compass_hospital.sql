-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Feb 23, 2025 at 06:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `care_compass_hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `patient_email` varchar(100) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` datetime NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_name`, `patient_email`, `doctor_id`, `appointment_date`, `status`) VALUES
(14, 'K A D Sandul Dulhan', 'kadsdulhan@gmail.com', 8, '2025-02-23 17:09:00', 'Completed'),
(15, 'K A D Tharun Rashmin', 'tharun@gmail.com', 9, '2025-02-23 17:10:00', 'Pending'),
(16, 'Chaveesha Siriwardhana', 'chaveesha@gmail.com', 9, '2025-02-23 17:15:00', 'Pending'),
(17, 'Veenaka Vishwajith', 'veenaka@gmail.com', 10, '2025-02-23 15:17:00', 'Pending'),
(18, 'Gihan Dhanushka', 'gihan@gmail.com', 7, '2025-02-23 16:22:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `contact`) VALUES
(7, 'Dr. Samantha Perera', 'Cardiologist', '071-1234567'),
(8, 'Dr. Ruwan Dissanayake', 'Orthopedic Surgeon', ' 077-2345678'),
(9, 'Dr. Tharindu Kumarasinghe', ' Pediatrician', '078-3456789'),
(10, 'Dr. Nadeesha Silva', 'Dermatologist', '076-4567890'),
(11, 'Dr. Hiruni Fernando', 'General Physician', '075-5678901');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `id`, `rating`, `comments`) VALUES
(5, 23, 5, 'Excellent service! The staff were very caring, and the hospital environment was clean and welcoming. I felt well taken care of throughout my visit.'),
(6, 26, 4, 'Overall, a great experience. The waiting time was a bit long, but the doctors were thorough and explained everything clearly. Would recommend!'),
(7, 26, 4, 'Overall, a great experience. The waiting time was a bit long, but the doctors were thorough and explained everything clearly. Would recommend!'),
(8, 24, 5, 'I was very impressed with the care provided. The doctors were attentive, and the nurses were very compassionate. I will definitely return if needed.'),
(9, 25, 5, 'Absolutely amazing service! The staff were incredibly friendly and professional. The doctor took the time to explain everything, and I felt very comfortable throughout the process.');

-- --------------------------------------------------------

--
-- Table structure for table `medical_reports`
--

CREATE TABLE `medical_reports` (
  `report_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_file` varchar(255) NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `report_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_reports`
--

INSERT INTO `medical_reports` (`report_id`, `id`, `report_title`, `report_file`, `report_date`, `doctor_id`, `report_details`) VALUES
(8, 23, 'Annual Health Check-up', '', '2025-02-23 17:19:20', 7, 'The patient underwent a thorough annual check-up. No major health concerns were detected. Blood pressure and cholesterol levels are within normal limits. Further tests recommended for cholesterol monitoring.\r\n\r\n'),
(9, 24, 'Fracture Diagnosis and Treatment', '', '2025-02-23 17:20:35', 8, 'Veenaka presented with a fracture in her left leg following a fall. X-rays confirmed a clean break. Cast applied, and follow-up visit scheduled in two weeks.'),
(10, 25, ' Pediatric Vaccination', '', '2025-02-23 17:21:12', 9, ' Kusal received his scheduled vaccination shots. No adverse reactions were observed. Recommended follow-up vaccinations in six months.\r\n\r\n'),
(11, 26, 'Skin Rash Treatment', '', '2025-02-23 17:21:44', 10, ' Chaveesha presented with a skin rash. Diagnosis: allergic reaction. Prescribed topical cream and antihistamines. The rash is expected to subside in a few days.'),
(12, 27, 'Blood Test Results', '', '2025-02-23 17:33:12', 11, ' Blood tests show slightly elevated sugar levels. Further tests recommended for diabetes screening. Blood count and liver function are within normal ranges.');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `id`, `amount`, `payment_method`, `payment_date`, `status`) VALUES
(3, 24, 12000.00, 'credit_card', '2025-02-23 17:44:52', 'Pending'),
(4, 24, 12000.00, 'credit_card', '2025-02-23 17:45:00', 'Pending'),
(5, 24, 150000.00, 'bank_transfer', '2025-02-23 17:45:14', 'Pending'),
(6, 24, 150000.00, 'bank_transfer', '2025-02-23 17:45:17', 'Pending'),
(7, 25, 50000.00, 'credit_card', '2025-02-23 17:46:23', 'Pending'),
(8, 25, 50000.00, 'credit_card', '2025-02-23 17:46:27', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrator','hospital_staff','patient') NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `name`, `phone`) VALUES
(13, 'Admin1', '$2y$10$vstZGX.RPjoQW1.cvfxuSuWet9.3JOqGLYAHQ62k0A29ODGqqLvda', 'administrator', 'admin1@gmail.com', 'admin1', '0762528128'),
(18, 'Staff1', '$2y$10$7jnDLKT6TFRTEcLhlG6quuOI2c5w0Fqc5T26xl81qi5KbIqWNNm0q', 'hospital_staff', 'staff1@gmail.com', 'Staff1', '0715656565'),
(23, 'Sandul', '$2y$10$lt5M/e2KhDXX56f0cKwcl.eanH92jI2/32qKGHlD4F2.3VHI6mvvO', 'patient', 'kadsdulhan@gmail.com', 'K A D Sandul Dulhan', '0718819658'),
(24, 'Veenaka ', '$2y$10$EAoMPmNJkeeTb8RUzZM3Hewfcsih0r/u85molM5MN8gFtJlWy0tHq', 'patient', 'veenaka@gmail.com', 'Veenaka Vishwajith', '0765696678'),
(25, 'Kusal', '$2y$10$4yS4bE1kOMBzRB9hHvsRu.WmJV4R8vMI95V10wdwRjG0iB51ReJyi', 'patient', 'kusal@gmail.com', 'Kusal Bhawantha', '0762842818'),
(26, 'Chaveesha', '$2y$10$SzV3Nju9t.NnoNl9ljhoq.sZanGoF7PknOEvKLwdYtbb8XnXBDjqG', 'patient', 'chaveesha@gmail.com', 'Chaveesha Siriwardhana', '0771576830'),
(27, 'Gihan', '$2y$10$CQnMcpOLrntI3Bn94sZt5..j6n1MHzGE0L5Y1G4GFMqlpU0TBt8f.', 'patient', 'gihan@gmail.com', 'Gihan Dhanushka', '0756324179'),
(28, 'Staff2', '$2y$10$e03oFU9aQP8P7QW4Dyvsp.jyN5cxlyy543s3NsPjNEtzVLClAb1eq', 'hospital_staff', 'staff2@gmail.com', 'Staff2', '0718819658');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `medical_reports`
--
ALTER TABLE `medical_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD CONSTRAINT `medical_reports_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
