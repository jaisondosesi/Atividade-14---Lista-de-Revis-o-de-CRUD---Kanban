# Atividade-14---Lista-de-Revis-o-de-CRUD---Kanban


# SQL

CREATE DATABASE IF NOT EXISTS kanban_industria;

USE kanban_industria;

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE Tarefas (
    id_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_fk INT NOT NULL,
    descricao TEXT NOT NULL,
    nome_setor VARCHAR(100) NOT NULL,
    prioridade ENUM('baixa', 'média', 'alta') NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status ENUM('a fazer', 'fazendo', 'pronto') DEFAULT 'a fazer' NOT NULL,
    CONSTRAINT fk_usuario
        FOREIGN KEY(id_usuario_fk) 
        REFERENCES Usuarios(id_usuario)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE INDEX idx_status ON Tarefas(status);
CREATE INDEX idx_usuario ON Tarefas(id_usuario_fk);
