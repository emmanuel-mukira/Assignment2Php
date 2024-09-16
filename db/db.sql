CREATE DATABASE users;

CREATE TABLE gender (
    genderId INT PRIMARY KEY AUTO_INCREMENT,
    gender VARCHAR(20) NOT NULL
);

INSERT INTO gender (genderId, gender) VALUES (1, 'Male'), (2, 'Female'), (3, 'Other');

CREATE TABLE roles (
    roleId INT PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(15) NOT NULL
);

INSERT INTO roles (roleId, role) VALUES (1, 'Admin'), (2, 'User'), (3, 'Guest');

CREATE TABLE users (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(60) NOT NULL,
    genderId INT,
    roleId INT,
    CONSTRAINT fk_genderId FOREIGN KEY (genderId) REFERENCES gender(genderId),
    CONSTRAINT fk_roleId FOREIGN KEY (roleId) REFERENCES roles(roleId)
);