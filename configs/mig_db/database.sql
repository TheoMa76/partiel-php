CREATE DATABASE IF NOT EXISTS partielphp;
USE partielphp;

CREATE TABLE question (
    id int auto_increment NOT NULL,
    titre varchar(300) NOT NULL,
    partageurl varchar(300),
    reussite float DEFAULT 0,
    CONSTRAINT question_PK PRIMARY KEY (id)
);

CREATE TABLE reponseJuste (
	id int auto_increment NOT NULL,
	idQuestion INT NOT NULL,
	reponse varchar(300) NOT NULL,
	CONSTRAINT reponseJuste_PK PRIMARY KEY (id),
	CONSTRAINT reponseJuste_FK FOREIGN KEY (idQuestion) REFERENCES partielphp.question(id) ON DELETE CASCADE
);


CREATE TABLE reponse (
	id INT auto_increment NOT NULL,
	idQuestion INT NOT NULL,
	reponse varchar(300) NULL,
	idReponseJuste INT NOT NULL,
	CONSTRAINT reponse_PK PRIMARY KEY (id),
	CONSTRAINT reponse_FK FOREIGN KEY (idQuestion) REFERENCES partielphp.question(id),
	CONSTRAINT reponse_FK_1 FOREIGN KEY (idReponseJuste) REFERENCES partielphp.reponseJuste(id)
);