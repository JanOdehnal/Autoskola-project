-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema aut_project
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema aut_project
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS aut_project DEFAULT CHARACTER SET utf8 ;
USE aut_project ;

-- -----------------------------------------------------
-- Table aut_project.lector
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aut_project.lector (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NULL,
  surname VARCHAR(45) NULL,
  email VARCHAR(45) NULL, -- uniqie and not null l will solve in php
  password VARCHAR(45) NULL,
  verify_lector VARCHAR(45) NULL,
  phone_number VARCHAR(12) NULL, -- for foreins, int(12) is imposible
  possicion ENUM('lector', 'admin') NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table aut_project.student
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aut_project.student (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NULL,
  surname VARCHAR(45) NULL,
  email VARCHAR(45) NULL,
  password VARCHAR(45) NULL,
  verify_student VARCHAR(45) NULL,
  phone_number VARCHAR(12) NULL, -- for foreins, int(12) is imposible
  vehicle_type ENUM('manual', 'automatic', 'motorbike') NULL,
  lector_id INT NOT NULL,
  PRIMARY KEY (id, lector_id),
  INDEX fk_student_lector_idx (lector_id ASC),
  CONSTRAINT fk_student_lector
    FOREIGN KEY (lector_id)
    REFERENCES aut_project.lector (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table aut_project.sides
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aut_project.sides (
  id INT NOT NULL AUTO_INCREMENT,
  town VARCHAR(45) NULL,
  street VARCHAR(45) NULL,
  GPS_coordinate VARCHAR(45) NULL,
  more_info VARCHAR(45) NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table aut_project.timetable
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS aut_project.timetable (
  lesson_date DATETIME NULL,
  lesson_num INT NULL,
  student_id INT NOT NULL,
  student_lector_id INT NOT NULL,
  sides_id INT NOT NULL,
  PRIMARY KEY (student_id, student_lector_id, sides_id),
  INDEX fk_timetable_sides1_idx (sides_id ASC),
  CONSTRAINT fk_timetable_student1
    FOREIGN KEY (student_id , student_lector_id)
    REFERENCES aut_project.student (id , lector_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_timetable_sides1
    FOREIGN KEY (sides_id)
    REFERENCES aut_project.sides (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
