CREATE DATABASE IF NOT EXISTS projeto_imc;
USE projeto_imc;

CREATE TABLE IF NOT EXISTS estudantes (
    idestudante INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    peso DECIMAL(5,2) NOT NULL,
    altura DECIMAL(5,2) NOT NULL,
    imc DECIMAL(5,2)
);

INSERT INTO estudantes (nome, sobrenome, idade, peso, altura) VALUES 
('Ana', 'Souza', 21, 65.50, 1.70),
('Bruno', 'Lima', 24, 82.00, 1.85),
('Carla', 'Dias', 19, 58.20, 1.65),
('Diego', 'Silva', 22, 90.00, 1.90);