CREATE DATABASE users;

CREATE TABLE gender (
    genderId INT PRIMARY KEY AUTO_INCREMENT,
    gender VARCHAR(20) NOT NULL
);

INSERT INTO gender (genderId, gender) VALUES (1, 'Male'), (2, 'Female'), (3, 'Other');
