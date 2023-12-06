SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `hospital_management_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hospital_management_db`;

CREATE TABLE `enlisted` (
  `enlisted_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `gender` char(1) NOT NULL,
  `roll` varchar(45) NOT NULL,
  `speciality` varchar(45) DEFAULT NULL,
  `illness` varchar(45) DEFAULT NULL,
  `room_number` SMALLINT UNSIGNED DEFAULT NULL,
  `date_of_birth` DATE NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `personal_id` int(11) NOT NULL,
  `personal_id_type` varchar(45) NOT NULL,
  `arrival_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `departure_date`datetime NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `enlisted`;

INSERT INTO `enlisted` (`enlisted_id`, `first_name`, `last_name`, `gender`, `roll`, `speciality`, `illness`, `room_number`, `date_of_birth`, `email`, `phone_number`, `personal_id`, `personal_id_type`, `arrival_date`, `departure_date`) VALUES
(01, 'George', 'Khabaz', 'M', 'Doctor', 'Kids doctor', NULL, NULL, '1111-11-11', 'georg.khabaz1111@gmail.com', 33333333, 4646565657746, 'passport', NULL, NULL),
(11, 'Emily', 'Tawook', 'F', 'Patient', NULL, 'fractured bone', 101, '2010-10-20', NULL, NULL, 55886867688,'id card', CURRENT_TIMESTAMP, '1212-12-12');

CREATE TABLE `beds` (
  `room_number` SMALLINT UNSIGNED DEFAULT NULL,
  `bed_number` int(1) DEFAULT NULL,
  `patient_id` int(10) DEFAULT NULL,
  `doctor_id` int(10) DEFAULT NULL,
  `assigned` varchar(45) DEFAULT 'unassigned'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `beds`;

INSERT INTO `beds` (`room_number`, `bed_number`, `patient_id`, `doctor_id`, `assigned`) VALUES
(101, 1, 11, 01, 'assigned');

CREATE TABLE `emergancy_rooms` (
  `room_number` SMALLINT UNSIGNED DEFAULT NULL,
  `patient_id` int(10) DEFAULT NULL,
  `doctor_id` int(10) DEFAULT NULL,
  `assigned` varchar(45) DEFAULT 'unassigned'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `emergancy_rooms`;

CREATE TABLE `test_results` (
  `patient_id` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `test_name` varchar(45) NOT NULL,
  `price` int(10) NOT NULL,
  `test_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

  TRUNCATE TABLE `test_results`;

CREATE TABLE `operation_rooms` (
  `room_number` SMALLINT UNSIGNED DEFAULT NULL,
  `patient_id` int(10) DEFAULT NULL,
  `doctor_id` int(10) DEFAULT NULL,
  `assigned` varchar(45) DEFAULT 'unassigned',
  `operation_name` varchar(45) DEFAULT NULL,
  `operation_began_at` datetime DEFAULT NULL,
  `expected_duration` varchar(45) DEFAULT NULL,
  `operation_ended` datetime DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `operation_rooms`;

ALTER TABLE `enlisted`
ADD PRIMARY KEY (`enlisted_id`),
ADD KEY `FK_room_number` (`room_number`);

ALTER TABLE (`beds`)
ADD PRIMARY KEY (`room_number`),
ADD KEY `FK_patient_id` (`patient_id`),
ADD KEY `FK_doctor_id` (`doctor_id`);

ALTER TABLE `emergancy_rooms`
ADD PRIMARY KEY (`room_number`),
ADD KEY `FK_patient_id` (`patient_id`),
ADD KEY `FK_doctor_id` (`doctor_id`);

ALTER TABLE `test_results`
ADD KEY `FK_patient_id` (`patient_id`),
ADD KEY `FK_doctor_id` (`doctor_id`);

ALTER TABLE `operation_rooms`
ADD PRIMARY KEY (`room_number`),
ADD KEY `FK_patient_id` (`patient_id`),
ADD KEY `FK_doctor_id` (`doctor_id`);


ALTER TABLE `enlisted`
  MODIFY COLUMN `enlisted_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `operation_rooms`
  MODIFY COLUMN `room_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `emergancy_rooms`
  MODIFY COLUMN `id_restaurant_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `rooms`
  MODIFY COLUMN `room_number` int(11) NOT NULL AUTO_INCREMENT=100;



ALTER TABLE `enlisted`
  ADD CONSTRAINT `FK_room_number` FOREIGN KEY (`room_number`) REFERENCES `beds` (`room_number`);

ALTER TABLE `beds`
  ADD CONSTRAINT `FK_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `enlisted` (`enlisted_id`),
  ADD CONSTRAINT `FK_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `enlisted` (`enlisted_id`);

ALTER TABLE `emergancy_rooms`
  ADD CONSTRAINT `FK_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `enlisted` (`enlisted_id`),
  ADD CONSTRAINT `FK_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `enlisted` (`enlisted_id`);

  ALTER TABLE `operation_rooms`
  ADD CONSTRAINT `FK_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `enlisted` (`enlisted_id`),
  ADD CONSTRAINT `FK_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `enlisted` (`enlisted_id`);

ALTER TABLE `test_results`
  ADD CONSTRAINT `FK_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `enlisted` (`enlisted_id`),
  ADD CONSTRAINT `FK_first_name` FOREIGN KEY (`first_name`) REFERENCES `enlisted` (`first_name`),
  ADD CONSTRAINT `FK_last_name` FOREIGN KEY (`last_name`) REFERENCES `enlisted` (`last_name`);

COMMIT;
