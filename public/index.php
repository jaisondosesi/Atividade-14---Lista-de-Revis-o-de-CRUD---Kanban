<?php
session_start();
include '../db/conexao.php'; 

$tarefas_fazer = [];
$tarefas_fazendo = [];
$tarefas_pronto = [];

$sql = "SELECT tarefas.*, usuarios.nome AS usuario_nome 
        FROM tarefas 
        JOIN usuarios ON tarefas.id_usuario = usuarios.id 
        ORDER BY FIELD(prioridade, 'alta', 'media', 'baixa'), data_cadastro ASC";

$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    while ($tarefa = $resultado->fetch_assoc()) {
        switch ($tarefa['status']) {
            case 'a fazer':
                $tarefas_fazer[] = $tarefa;
                break;
            case 'fazendo':
                $tarefas_fazendo[] = $tarefa;
                break;
            case 'pronto':
                $tarefas_pronto[] = $tarefa;
                break;
        }
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    
    <link rel="stylesheet" href="../assets/style.css"> 
    
</head>
<body>

    <header>
        <nav class="menu-principal">
            <ul>
                <li><a href="index.php">Gerenciar Tarefas</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                <li><a href="cadastro-tarefa.php">Cadastrar Tarefa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Gerenciamento de Tarefas</h1>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="mensagem-sucesso">
                <?php 
                echo $_SESSION['mensagem']; 
                unset($_SESSION['mensagem']);
                ?>
            </div>
        <?php endif; ?>

        <div class="container-colunas">

            <div class="coluna">
                <h2>A Fazer</h2>
                <?php if (empty($tarefas_fazer)): ?>
                    <p class="sem-tarefas">Nenhuma tarefa aqui.</p>
                <?php else: ?>
                    <?php foreach ($tarefas_fazer as $tarefa): ?>
                        <div class="card-tarefa">
                            <h3><?php echo htmlspecialchars($tarefa['descricao']); ?></h3>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($tarefa['setor']); ?></p>
                            <p><strong>Usuário:</strong> <?php echo htmlspecialchars($tarefa['usuario_nome']); ?></p>
                            <p><strong>Prioridade:</strong> 
                                <span class="prioridade-<?php echo $tarefa['prioridade']; ?>">
                                    <?php echo ucfirst($tarefa['prioridade']); ?>
                                </span>
                            </p>
                            
                            <form action="processa-status.php" method="POST" class="form-status">
                                <input type="hidden" name="id_tarefa" value="<?php echo $tarefa['id_tarefa']; ?>">
                                <select name="novo_status">
                                    <option value="a fazer" selected>A Fazer</option>
                                    <option value="fazendo">Fazendo</option>
                                    <option value="pronto">Pronto</option>
                                </select>
                                <button type="submit">Mudar</button>
                            </form>

                            <div class="card-acoes">
                                <a href="cadastro-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" class="btn-editar">Editar</a>
                                <a href="excluir-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" 
                                   class="btn-excluir" 
                                   onclick="return confirm('Tem certeza?');">Excluir</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="coluna">
                <h2>Fazendo</h2>
                <?php if (empty($tarefas_fazendo)): ?>
                    <p class="sem-tarefas">Nenhuma tarefa aqui.</p>
                <?php else: ?>
                    <?php foreach ($tarefas_fazendo as $tarefa): ?>
                         <div class="card-tarefa">
                            <h3><?php echo htmlspecialchars($tarefa['descricao']); ?></h3>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($tarefa['setor']); ?></p>
                            <p><strong>Usuário:</strong> <?php echo htmlspecialchars($tarefa['usuario_nome']); ?></p>
                            <p><strong>Prioridade:</strong> 
                                <span class="prioridade-<?php echo $tarefa['prioridade']; ?>">
                                    <?php echo ucfirst($tarefa['prioridade']); ?>
                                </span>
                            </p>
                            
                            <form action="processa-status.php" method="POST" class="form-status">
                                <input type="hidden" name="id_tarefa" value="<?php echo $tarefa['id_tarefa']; ?>">
                                <select name="novo_status">
                                    <option value="a fazer">A Fazer</option>
                                    <option value="fazendo" selected>Fazendo</option>
                                    <option value="pronto">Pronto</option>
                                </select>
                                <button type="submit">Mudar</button>
                            </form>

                            <div class="card-acoes">
                                <a href="cadastro-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" class="btn-editar">Editar</a>
                                <a href="excluir-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" 
                                   class="btn-excluir" 
                                   onclick="return confirm('Tem certeza?');">Excluir</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="coluna">
                <h2>Pronto</h2>
                <?php if (empty($tarefas_pronto)): ?>
                    <p class="sem-tarefas">Nenhuma tarefa aqui.</p>
                <?php else: ?>
                    <?php foreach ($tarefas_pronto as $tarefa): ?>
                         <div class="card-tarefa">
                            <h3><?php echo htmlspecialchars($tarefa['descricao']); ?></h3>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($tarefa['setor']); ?></p>
                            <p><strong>Usuário:</strong> <?php echo htmlspecialchars($tarefa['usuario_nome']); ?></p>
                            <p><strong>Prioridade:</strong> 
                                <span class="prioridade-<?php echo $tarefa['prioridade']; ?>">
                                    <?php echo ucfirst($tarefa['prioridade']); ?>
                                </span>
                            </p>
                            
                            <form action="processa-status.php" method="POST" class="form-status">
                                <input type="hidden" name="id_tarefa" value="<?php echo $tarefa['id_tarefa']; ?>">
                                <select name="novo_status">
                                    <option value="a fazer">A Fazer</ooption>
                                    <option value="fazendo">Fazendo</option>
                                    <option value="pronto" selected>Pronto</option>
                                </select>
                                <button type="submit">Mudar</button>
                            </form>

                            <div class="card-acoes">
                                <a href="cadastro-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" class="btn-editar">Editar</a>
                                <a href="excluir-tarefa.php?id=<?php echo $tarefa['id_tarefa']; ?>" 
                                   class="btn-excluir" 
                                   onclick="return confirm('Tem certeza?');">Excluir</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>

</body>
</html>