SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS socialnet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE socialnet;


CREATE TABLE IF NOT EXISTS account (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    fullname    VARCHAR(100) NOT NULL,
    password    VARCHAR(255) NOT NULL,
    description TEXT,
    is_admin    TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS login_attempts (
    ip_address VARCHAR(45) PRIMARY KEY,
    attempts   INT DEFAULT 1,
    last_attempt DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO account (username, fullname, password, description, is_admin) VALUES
("admin", "Toàn Thắng", '$2y$12$Umg4FRol5TqMWi5AAm5UY.e2KlG7R5J8ndWAUgIYmCzEF.cWHREE.', "**CTF Player, cybersecurity enthusiast.**\n**Blog**: https://attom.id.vn/\n**GitHub**: https://github.com/a-tt-om\n**LinkedIn**: https://www.linkedin.com/in/4tt0m/\n**CTFtime**: https://ctftime.org/user/220551\nI'm pretty sure this website is secure :b", 1),
("test1", "Test 1", '$2y$12$9AZqvTn4Kjauz4xigz0IPu2snJQSVTp0QzwSW4o58VDlLDDQ8IVYS', "Test user 1 account.", 0),
("test2", "Test 2", '$2y$12$leKcCsj3HJbUTpchnx71auLMbYoEhUTwXy/o4EQ2VfnWaZGwTvxWi', "Test user 2 account.", 0),
("test3", "Test 3", '$2y$12$lnuOjY35KoQBslbO.pP0/eu8phxrd9n60C2KNzslvTwC3EEECpNoG', "Test user 3 account.", 0),
("test4", "Test 4", '$2y$12$LcOROlRQcYMM7T.XQMyx6OnMxn.VTI.j/dGGikPH4UNQVg3dXpCsG', "Test user 4 account.", 0),
("test5", "Test 5", '$2y$12$JNfSEHPAkZsNSRY.6JPQ5uDQNew..Hx06.M63OojiKxC7o895kHza', "Test user 5 account.", 0);
