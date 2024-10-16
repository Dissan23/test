CREATE TABLE IF NOT EXISTS users (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     email VARCHAR(255) NOT NULL UNIQUE,
                                     password VARCHAR(255) NOT NULL,
                                     password_hash VARCHAR(255) NOT NULL,
                                     role INT NOT NULL,
                                     age INT NULL,
                                     sex VARCHAR(10) NULL,
                                     name VARCHAR(255) NULL,
                                     last_name VARCHAR(255) NULL,
                                     login VARCHAR(255) NOT NULL UNIQUE,
                                     CONSTRAINT role_user FOREIGN KEY(role) REFERENCES roles(id)
);
