--
-- Création de la base
--
DROP DATABASE IF EXISTS db_agenda;
CREATE DATABASE db_agenda DEFAULT CHARACTER SET 'utf8';
USE db_agenda;

--
-- Création des tables
--

-- Création de la table Utilisateurs
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT,
    mail VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    lastName VARCHAR(30),
    firstName VARCHAR(30) NOT NULL,
    dateInscription DATETIME NOT NULL,
    PRIMARY KEY (id)
) ENGINE = INNODB;

-- Création de la table Evenements
CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    place VARCHAR(30) NOT NULL,
    start DATETIME NOT NULL,
    end DATETIME NOT NULL,
    creator INT UNSIGNED NOT NULL,
    PRIMARY KEY (id)
) ENGINE = INNODB;

-- Création de la table Demander contact
CREATE TABLE shareRequests (
    idApplicant INT UNSIGNED,
    idRecipient INT UNSIGNED,
    dateRequest DATETIME NOT NULL,
    message TEXT,
    accepted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (idApplicant, idRecipient)
) ENGINE = INNODB;

-- Création de la table Inviter
CREATE TABLE invite (
    idInviter INT UNSIGNED,
    idGuest INT UNSIGNED,
    idEvent INT UNSIGNED,
    dateInvitation DATETIME NOT NULL,
    message TEXT,
    accepted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (idInviter, idEvent, idGuest)
) ENGINE = INNODB;

--
-- Création des clés étrangères
--

ALTER TABLE events
    ADD CONSTRAINT fk_event_creator FOREIGN KEY (creator) REFERENCES users(id);

ALTER TABLE shareRequests
    ADD CONSTRAINT fk_shareRequest_idApplicant FOREIGN KEY (idApplicant) REFERENCES users(id),
    ADD CONSTRAINT fk_shareRequest_idRecipient FOREIGN KEY (idRecipient) REFERENCES users(id);

ALTER TABLE invite
    ADD CONSTRAINT fk_invite_idInviter FOREIGN KEY (idInviter) REFERENCES users(id),
    ADD CONSTRAINT fk_invite_idGuest FOREIGN KEY (idGuest) REFERENCES users(id),
    ADD CONSTRAINT fk_invite_idEvent FOREIGN KEY (idEvent) REFERENCES events(id);

--
-- Ajout des données
--

INSERT INTO users  VALUES
    (1, 'link@hyrule.com', '$2y$10$GKnzByqPIk3lqTU6n8.S2.6kAXgwLys.kkV/rHyI2OfhK.ODmCmE2', '', 'Link', '1986-02-21'),
    (2, 'princesseZelda@hyrule.com', '$2y$10$IGTRk6Az2GfXTw8FdqCFfev75HmOeXoowj177mHkShYg8dQEyKptW', '', 'Princesse Zelda', '1986-02-21'),
    (3, 'tingle@hyrule.com', '$2y$10$TPDCFK5Dm6W/ZpsrWr1bceBHVBt2yPYzQlwfnjQpaRXbwEiv8CRmW', '', 'Tingle', '1986-02-21'),
    (4, 'midona@crepuscule.com', '$2y$10$0BCKrFGp8DnCrjCQR5Adm.SRuoEAAFKirYWou/CQAWMLHXAHYtKnK', '', 'Midona', '2017-02-13'),
    (5, 'malon@hyrule.com', '$2y$10$9ZwLxWGj1c.bhx7IvccexeqY5CXNlApkEFeXzwixa5hqDgA37LYi6', '', 'Malon', '2017-02-13'),
    (6, 'impa@sheikah.com', '$2y$10$NJO33QtQu.zC1wkSYgCh3eDj6ub/bATBBQRxeI7v35PhZmHCnCWk2', '', 'Impa', '2017-02-13'),
    (7, 'arbreMojo@hyrule.com', '$2y$10$RITngDdyfu8IDR3pV3Vncu.xNrbANGQIqRyyS8tc3OtHmyBW0px..', '', 'L\'Arbre Mojo', '2017-02-13'),
    (8, 'ganondorf@hyrule.com', '$2y$10$T6GF6mbLGx68YGeE3ey3rec69nl4o8qguwsRHUoTkDroimfILvrPW', 'Dragmire', 'Ganondorf', '2017-02-13'),
    (9, 'ruto@hyrule.com', '$2y$10$OO36sO07/6kBfcv5d9K9OO4rc.Sky8mbu7PSct3gDqvv3lLorxz3m', '', 'Ruto', '2017-02-13'),
    (10, 'darunia@hyrule.com', '$2y$10$bZhc4V2IlTsoJoM2McY6aeHt2TK2B4OiD0Vy7Q66801eH4nUwGvyi', '', 'Darunia', '2017-02-13'),
    (11, 'exelo@minish.com', '$2y$10$bbp.YHVcQS3s/I7zqWUQQ.GiVInRvDlIZLxgaQNdrEIHktmTybPNy', '', 'Exelo', '2017-02-13');

INSERT INTO events VALUES
    (1, 'Anniversaire Princesse Zelda', 'Château d\'Hyrule', '2017-02-21 19:50:00', '2017-02-21 23:45:00', 2),
    (2, 'Célébration de la Chute de Ganondorf', 'Château d\'Hyrule', '2017-03-03 07:00:00', '2017-03-04 07:00:00', 2);

INSERT INTO shareRequests VALUES
    (2, 1, '2017-01-04', NULL, 1),
    (3, 1, '2017-01-04', NULL, 0),
    (3, 2, '2017-01-04', NULL, 0);

INSERT INTO invite VALUES
    (2, 1, 2, '2017-01-30', NULL, 0),
    (2, 1, 1, '2017-01-30', NULL, 1);