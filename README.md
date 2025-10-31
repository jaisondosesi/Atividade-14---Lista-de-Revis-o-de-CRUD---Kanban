📋 Gerenciador de Tarefas (Kanban)
Este é um sistema simples de gerenciamento de tarefas (To-Do List) desenvolvido em PHP puro, MySQL e CSS. A aplicação permite o cadastro de usuários e tarefas, e organiza as tarefas em um painel visual no estilo Kanban ("A Fazer", "Fazendo", "Pronto").

Este projeto foi desenvolvido como parte de uma atividade de revisão de conceitos de CRUD (Create, Read, Update, Delete).

✨ Funcionalidades Principais
Visualização Kanban: Organize tarefas em três colunas: "A Fazer", "Fazendo" e "Pronto".

👤 Gerenciamento de Usuários: Cadastro de novos usuários.

📝 CRUD de Tarefas: Crie, edite e exclua tarefas.

🔗 Atribuição de Tarefas: Vincule cada tarefa a um usuário específico.

⚡ Atualização Rápida: Mude o status da tarefa diretamente do painel principal.

💻 Tecnologias Utilizadas
Backend: PHP

Banco de Dados: MySQL

Frontend: HTML5 e CSS3

Servidor Local (Requerido): XAMPP, WAMP, MAMP ou similar.

📁 Estrutura do Projeto
A estrutura de pastas está organizada para separar responsabilidades:

/ATIVIDADE-14---LISTA-DE-REVIS-O-DE-CRUD---KANBAN/
│
├── assets/
│   └── style.css           # Folha de estilo principal
│
├── db/
│   ├── conexao.php         # Script de conexão com o banco
│   └── db.sql              # Script SQL para criar o banco e as tabelas
│
└── public/
    ├── index.php             # Painel Kanban (Leitura de tarefas)
    ├── cadastro-usuario.php  # Formulário de criação de usuários
    ├── cadastro-tarefa.php   # Formulário de criação/edição de tarefas
    ├── processa-status.php   # Script (backend) para mudar status
    └── excluir-tarefa.php    # Script (backend) para excluir tarefa
🚀 Instruções de Instalação e Execução
Siga estes passos para rodar o projeto localmente:

Clone o Repositório

Bash

git clone https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git
(Ou simplesmente baixe o ZIP)

Inicie seu Servidor Local

Inicie os serviços Apache e MySQL no seu painel XAMPP (ou similar).

Importe o Banco de Dados

Abra o phpMyAdmin (ex: http://localhost/phpmyadmin).

Crie um novo banco de dados chamado exatamente meu_projeto_tarefas.

Selecione este banco de dados.

Vá até a aba "Importar", clique em "Escolher arquivo" e selecione o arquivo db/db.sql deste repositório.

Clique em "Executar" no final da página.

Configure a Conexão

Abra o arquivo db/conexao.php no seu editor de código.

IMPORTANTE: Verifique se as credenciais correspondem ao seu MySQL. O código está configurado para:

$servidor = "localhost";

$usuario = "root";

$senha = "root"; (No seu caso, ou "" se for o padrão XAMPP)

$banco = "meu_projeto_tarefas";

Acesse a Aplicação

Mova a pasta do projeto para o diretório htdocs do seu XAMPP.

Abra o seu navegador e acesse o diretório public/ do projeto.

Exemplo: http://localhost/ATIVIDADE-14.../public/index.php

🔧 Como Usar
Cadastre um Usuário: Comece por aceder ao menu "Cadastrar Usuário".

Cadastre uma Tarefa: Aceda a "Cadastrar Tarefa", escreva a descrição e atribua-a ao usuário que acabou de criar.

Gerencie: Volte ao "Gerenciar Tarefas" (index.php) para ver sua nova tarefa no painel. A partir daqui, você pode movê-la de status, editá-la ou excluí-la.