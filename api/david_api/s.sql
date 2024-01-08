DROP DATABASE IF EXISTS `stayNL`;

CREATE DATABASE `stayNL`;

USE `stayNL`;

CREATE TABLE `staynl`.`kamer_info` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `location` TEXT NOT NULL,
    `foto` TEXT NOT NULL,
    `informatie_kamer` TEXT NOT NULL,
    `faciliteiten` TEXT NOT NULL,
    `beschikbaarheid` DATE NOT NULL,
    `kamer_spec` TEXT NOT NULL,
    `maximum_guests` INT NOT NULL,
    `type` TEXT NOT NULL,
    PRIMARY KEY (`id`)
);