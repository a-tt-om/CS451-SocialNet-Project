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


-- Passwords: admin/admin, test1/test1, test2/test2, test3/test3, test4/test4, test5/test5
INSERT INTO account (username, fullname, password, description, is_admin) VALUES
("admin", "Toàn Thắng", '$2y$12$tjTGbEHJfOKtgc2XSFa.1ut8wM84RBG.7GhwkvCYlb1ocpqFCtXIe', "I'm pretty sure this website is secure :b", 1),
("test1", "Test 1", '$2y$12$/qFssWoyEx3373G./zSIeOFRJpTrWdCZ18WU5ShmHDUqHH1BKZGuq', "Test user 1 account.", 0),
("test2", "Test 2", '$2y$12$DjE4SC49wUI/A2EI/Fy5PuKtz/GSFIUqEiBm99LBAbVv6GtgqIchi', "Test user 2 account.", 0),
("test3", "Test 3", '$2y$12$VctdBmD/asv1XW5iakAvLOqCPnqzHNM7x7RYPkBlcxrziu5Up9vPC', "Test user 3 account.", 0),
("test4", "Test 4", '$2y$12$w1K8IVKB6BAemjWPEKcmVerkdsR0Mz/PYhQqMU/Oo9ehsw4C1Ut/m', "Test user 4 account.", 0),
("test5", "Test 5", '$2y$12$IOVmiNW4OzAq31Xuwanyr.gpAd5sIerNwsIuAGn61w4hkvxAP57IC', "Test user 5 account.", 0);
