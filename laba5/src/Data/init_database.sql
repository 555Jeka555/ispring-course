CREATE DATABASE php_course;
USE php_course;

CREATE TABLE user
(
	user_id INT UNSIGNED AUTO_INCREMENT,
	first_name VARCHAR(200) NOT NULL,
	second_name VARCHAR(200) NOT NULL,
	middle_name VARCHAR(200), 
	gender VARCHAR(200) NOT NULL,
	birth_date DATE NOT NULL,
	email VARCHAR(200) UNIQUE NOT NULL,
	phone VARCHAR(20) UNIQUE,
	avatar_path VARCHAR(200),
	PRIMARY KEY (user_id)
)