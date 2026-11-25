

CREATE DATABASE IF NOT EXISTS questoes;

USE questoes;

CREATE TABLE IF NOT EXISTS questoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta TEXT NOT NULL,
    alternativaA VARCHAR(255) NOT NULL,
    alternativaB VARCHAR(255) NOT NULL,
    alternativaC VARCHAR(255) NOT NULL,
    alternativaD VARCHAR(255) NOT NULL,
    alternativaE VARCHAR(255) NOT NULL,
    resposta_correta CHAR(1) NOT NULL
);

INSERT INTO questoes
(pergunta, alternativaA, alternativaB, alternativaC,
 alternativaD, alternativaE, resposta_correta)
VALUES
('Pergunta 1', 'A1', 'B1', 'C1', 'D1', 'E1', 'A'),
('Pergunta 2', 'A2', 'B2', 'C2', 'D2', 'E2', 'B'),
('Pergunta 3', 'A3', 'B3', 'C3', 'D3', 'E3', 'C'),
('Pergunta 4', 'A4', 'B4', 'C4', 'D4', 'E4', 'D'),
('Pergunta 5', 'A5', 'B5', 'C5', 'D5', 'E5', 'E'),
('Pergunta 6', 'A6', 'B6', 'C6', 'D6', 'E6', 'A'),
('Pergunta 7', 'A7', 'B7', 'C7', 'D7', 'E7', 'B'),
('Pergunta 8', 'A8', 'B8', 'C8', 'D8', 'E8', 'C'),
('Pergunta 9', 'A9', 'B9', 'C9', 'D9', 'E9', 'D'),
('Pergunta 10', 'A10', 'B10', 'C10', 'D10', 'E10', 'E'),
('Pergunta 11', 'A11', 'B11', 'C11', 'D11', 'E11', 'A'),
('Pergunta 12', 'A12', 'B12', 'C12', 'D12', 'E12', 'B'),
('Pergunta 13', 'A13', 'B13', 'C13', 'D13', 'E13', 'C'),
('Pergunta 14', 'A14', 'B14', 'C14', 'D14', 'E14', 'D'),
('Pergunta 15', 'A15', 'B15', 'C15', 'D15', 'E15', 'E'),
('Pergunta 16', 'A16', 'B16', 'C16', 'D16', 'E16', 'A'),
('Pergunta 17', 'A17', 'B17', 'C17', 'D17', 'E17', 'B'),
('Pergunta 18', 'A18', 'B18', 'C18', 'D18', 'E18', 'C'),
('Pergunta 19', 'A19', 'B19', 'C19', 'D19', 'E19', 'D'),
('Pergunta 20', 'A20', 'B20', 'C20', 'D20', 'E20', 'E');

SELECT * FROM questoes;
