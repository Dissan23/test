INSERT INTO users (email, password, password_hash, role, age, sex, name, last_name, login, username) VALUES
                                                                                                         ('Adminich@mail.com', 'example_password', '\$2y$10\$rz2qp9.88sTE4jPcHC7VmOhVIFLRnZK7AMcgj5HbnXp/0NLpRSL2S', 1, 52, 'M', 'Patric', 'Star', 'Patrus', 'admin'),
                                                                                                         ('bobius@mail.com', 'example_password', '\$2y$10\$rz2qp9.88sTE4jPcHC7VmOhVIFLRnZK7AMcgj5HbnXp/0NLpRSL2S', 2, 13, 'F', 'Spange', 'Bob', 'Spunger', 'bobius')
ON DUPLICATE KEY UPDATE password = VALUES(password), password_hash = VALUES(password_hash), role = VALUES(role), age = VALUES(age), sex = VALUES(sex), name = VALUES(name), last_name = VALUES(last_name), login = VALUES(login), username = VALUES(username);





