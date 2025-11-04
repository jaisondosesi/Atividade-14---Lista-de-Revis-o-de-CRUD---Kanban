<h1 align="center">📋 Lista de Revisão de CRUD — Kanban</h1>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-blue?logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-Database-orange?logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/CRUD-Create%20Read%20Update%20Delete-brightgreen"/>
  <img src="https://img.shields.io/badge/Kanban-Board-success?logo=trello&logoColor=white"/>
  <img src="https://img.shields.io/badge/HTML-CSS-lightgrey?logo=html5&logoColor=white"/>
</p>

---

## 🧠 **Resumo Executivo**
Aplicação web estilo **Kanban** desenvolvida em **PHP + MySQL**, com foco em revisar operações **CRUD** (Create, Read, Update, Delete).  
O sistema organiza tarefas nas colunas **A Fazer**, **Fazendo** e **Pronto**, com interface simples e intuitiva.  

> 🎯 Objetivo: reforçar conceitos fundamentais de CRUD, manipulação de banco de dados e layout dinâmico.

---

## ⚙️ **Tecnologias Utilizadas**

| Categoria | Tecnologia |
|:----------:|:------------|
| Linguagem | 🧩 PHP (puro) |
| Banco de Dados | 🐘 MySQL |
| Frontend | 🎨 HTML + CSS |
| Servidor | 🌐 Apache (XAMPP/WAMP) |
| Banco | 💾 `meu_projeto_tarefas` |

---

## 🚀 **Passo a Passo — Instalação e Execução**

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/jaisondosesi/Atividade-14---Lista-de-Revis-o-de-CRUD---Kanban.git

2️⃣ Mover para o diretório do servidor local
C:\xampp\htdocs\Atividade-14---Lista-de-Revis-o-de-CRUD---Kanban

3️⃣ Iniciar os serviços

Abra o XAMPP Control Panel

Inicie Apache e MySQL

4️⃣ Criar o banco de dados

Acesse phpMyAdmin

Vá em Databases → Create

Crie o banco com o nome:

meu_projeto_tarefas

Clique em Importar e selecione:

db/db.sql

5️⃣ Configurar conexão no PHP

Edite o arquivo db/conexao.php:

<?php
$servidor = "localhost";
$usuario  = "root";           // seu usuário MySQL
$senha    = "";               // sua senha MySQL (vazia no XAMPP padrão)
$banco    = "meu_projeto_tarefas";
?>

6️⃣ Acessar a aplicação

Abra no navegador:

http://localhost/Atividade-14---Lista-de-Revis-o-de-CRUD---Kanban/public/index.php

📦 Estrutura do Projeto
/Atividade-14---Lista-de-Revis-o-de-CRUD---Kanban
├─ assets/
│  └─ style.css              # Estilos visuais do Kanban
├─ db/
│  ├─ conexao.php            # Configuração de conexão MySQL
│  └─ db.sql                 # Script de criação das tabelas
├─ public/
│  ├─ index.php              # Página principal (Kanban)
│  ├─ cadastro-usuario.php   # CRUD de usuários
│  ├─ cadastro-tarefa.php    # CRUD de tarefas
│  ├─ processa-status.php    # Atualização de status das tarefas
│  └─ excluir-tarefa.php     # Exclusão de tarefas
└─ DER.png                   # Diagrama entidade-relacionamento

🧩 Fluxo de Uso
Função	Caminho	Descrição
➕ Cadastrar Usuário	public/cadastro-usuario.php	Insere novos usuários
📝 Cadastrar Tarefa	public/cadastro-tarefa.php	Cria tarefas vinculadas a um usuário
🔄 Mover Status	public/index.php	Atualiza coluna no Kanban
✏️ Editar Tarefa	public/cadastro-tarefa.php	Edição inline ou via formulário
❌ Excluir Tarefa	public/excluir-tarefa.php	Remove tarefa do banco
🧪 Testes & Métricas

✅ Checklist Funcional

 Criar usuários

 Criar tarefas

 Mover tarefas entre colunas

 Editar e excluir

 Persistência após reload

📊 Métricas recomendadas

Tempo médio de carregamento (index.php)

Log de erros (error_log)

Status HTTP (Network → DevTools)