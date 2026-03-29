-- 1. Criar a base de dados (usa o nome que definiste no teu conectar)
CREATE DATABASE IF NOT EXISTS projeto_imc;
USE projeto_imc;

-- 2. Criar a tabela de estudantes
CREATE TABLE IF NOT EXISTS estudantes (
    idestudante INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    peso DECIMAL(5,2) NOT NULL,
    imc DECIMAL(5,2) NOT NULL
);

-- 3. Inserir alguns dados de teste pra vermos a tabela a funcionar
INSERT INTO estudantes (nome, idade, peso, imc) VALUES 
('Ana Souza', 21, 65.50, 22.10),
('Bruno Lima', 24, 82.00, 26.50),
('Carla Dias', 19, 58.20, 20.40),
('Diego Silva', 22, 90.00, 29.10);