CREATE DATABASE IF NOT EXISTS meu_projeto_tarefas;

USE meu_projeto_tarefas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE tarefas (
    id_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    descricao TEXT NOT NULL,
    setor VARCHAR(100) NOT NULL,
    prioridade VARCHAR(5) NOT NULL CHECK (prioridade IN ('baixa', 'media', 'alta')),
    data_cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(7) NOT NULL DEFAULT 'a fazer' CHECK (status IN ('a fazer', 'fazendo', 'pronto')),

    CONSTRAINT fk_usuario
        FOREIGN KEY(id_usuario) 
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);