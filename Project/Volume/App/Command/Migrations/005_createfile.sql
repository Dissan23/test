CREATE TABLE IF NOT EXISTS files (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     path VARCHAR(255) NOT NULL,
                                     name VARCHAR(255) NOT NULL,
                                     is_dir BOOLEAN NULL,
                                     access VARCHAR(255) NULL,
                                     ext VARCHAR(25) NULL
);
