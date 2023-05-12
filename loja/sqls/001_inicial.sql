CREATE DATABASE lojinha COLLATE 'utf8_unicode_ci';

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT ,
    nome VARCHAR(255) NOT NULL ,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha CHAR(60) NOT NULL ,
    PRIMARY KEY (id)
)
ENGINE = InnoDB;

CREATE TABLE ofertas (
    id INT NOT NULL AUTO_INCREMENT ,
    vendedor_id INT NOT NULL ,
    comprador_id INT,
    descricao VARCHAR(255) NOT NULL ,
    preco DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (vendedor_id) REFERENCES usuarios (id),
    FOREIGN KEY (comprador_id) REFERENCES usuarios (id)
)
ENGINE = InnoDB;
