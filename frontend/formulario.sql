CREATE DATABASE formulario;
USE formulario;

CREATE TABLE itens(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codigo INT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    data_entrada DATE NOT NULL,
    data_saida DATE
);