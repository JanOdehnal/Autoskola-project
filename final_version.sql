-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema drive_sch_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema drive_sch_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS drive_sch_db DEFAULT CHARACTER SET utf8 ;
USE drive_sch_db ;

-- -----------------------------------------------------
-- Table drive_sch_db.lector
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS drive_sch_db.lector ( -- prefer vehicle???
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NULL,
  surname VARCHAR(45) NULL,
  email VARCHAR(45) NULL UNIQUE,
  password VARCHAR(45) NULL,
  verify_lector VARCHAR(45) NULL,
  phone_number VARCHAR(12) NULL, -- for foreins, int(12) is imposible
  possicion ENUM('lector', 'admin') NULL,
  prefer_veh INT NULL, -- if lector specialized on some type of vehicle
  PRIMARY KEY (id),
  FOREIGN KEY (prefer_veh) REFERENCES course (id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table drive_sch_db.student
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS drive_sch_db.student (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NULL,
  surname VARCHAR(45) NULL,
  email VARCHAR(45) NULL UNIQUE,
  password VARCHAR(45) NULL,
  verify_student VARCHAR(45) NULL,
  phone_number VARCHAR(12) NULL, -- for foreins, int(12) is imposible
  PRIMARY KEY (id))
ENGINE = InnoDB;

-- FOREIGN KEY (user_id) REFERENCES users(id)
-- -----------------------------------------------------
-- Table drive_sch_db.sides
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS drive_sch_db.sides (
  id INT NOT NULL AUTO_INCREMENT,
  town VARCHAR(45) NULL,
  street VARCHAR(45) NULL,
  GPS_coordinate VARCHAR(45) NULL UNIQUE,
  more_info VARCHAR(45) NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table drive_sch_db.course
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS drive_sch_db.course (
id INT NOT NULL AUTO_INCREMENT,
vehicle_type VARCHAR(45) NULL UNIQUE,
num_of_less INT NULL,
PRIMARY KEY (id))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table drive_sch_db.student_course table n:m
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS drive_sch_db.student_course_lec (
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  lector_id INT NOT NULL,
  PRIMARY KEY (student_id, course_id, lector_id),
  FOREIGN KEY (student_id) REFERENCES student (id),
  FOREIGN KEY (course_id) REFERENCES course (id),
  FOREIGN KEY (lector_id) REFERENCES lector (id))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table drive_sch_db.timetable
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS drive_sch_db.timetable (
  lesson_date DATETIME NULL,
  lesson_num INT NULL,
  student_id INT NOT NULL,
  sides_id INT NOT NULL,
  PRIMARY KEY (student_id, sides_id),
  FOREIGN KEY (student_id) REFERENCES student(id),
  FOREIGN KEY (sides_id) REFERENCES sides(id))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
