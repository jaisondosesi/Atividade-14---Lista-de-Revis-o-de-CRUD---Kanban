<?php
session_start();
include '../db/conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$mensagem = "";
$modo_edicao = false;
$id_tarefa_edicao = null;

$usuario_logado_id   = (int) $_SESSION['usuario_id'];
$usuario_logado_nome = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'Usuário';

$dados_tarefa = [
    'id_usuario' => $usuario_logado_id,
    'descricao'  => '',
    'setor'      => '',
    'prioridade' => 'baixa',
    'status'     => 'a fazer'
];

// ----- EDIÇÃO -----
if (isset($_GET['id'])) {
    $modo_edicao = true;
    $id_tarefa_edicao = (int) $conexao->real_escape_string($_GET['id']);

    // Garante que a tarefa é do usuário logado
    $sql_busca = "SELECT * FROM tarefas WHERE id_tarefa = $id_tarefa_edicao AND id_usuario = $usuario_logado_id";
    $resultado_busca = $conexao->query($sql_busca);

    if ($resultado_busca && $resultado_busca->num_rows > 0) {
        $dados_tarefa = $resultado_busca->fetch_assoc();
    } else {
        $modo_edicao = false;
        $mensagem = "Erro: Tarefa não encontrada ou sem permissão. Criando nova tarefa.";
    }
}

// ----- POST (SALVAR) -----
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao  = $conexao->real_escape_string($_POST['descricao'] ?? '');
    $setor      = $conexao->real_escape_string($_POST['setor'] ?? '');
    $prioridade = $conexao->real_escape_string($_POST['prioridade'] ?? 'baixa');

    if ($modo_edicao) {
        $status = $conexao->real_escape_string($_POST['status'] ?? 'a fazer');
    }

    if (empty($descricao) || empty($setor) || empty($prioridade)) {
        $mensagem = "Erro: Todos os campos são obrigatórios.";
        // mantém dados já digitados
        $dados_tarefa['descricao']  = $descricao;
        $dados_tarefa['setor']      = $setor;
        $dados_tarefa['prioridade'] = $prioridade;
        if ($modo_edicao) $dados_tarefa['status'] = $status;

    } else {
        if ($modo_edicao) {
            // Atualiza apenas se a tarefa for do usuário logado
            $sql = "UPDATE tarefas SET 
                        descricao  = '$descricao',
                        setor      = '$setor',
                        prioridade = '$prioridade',
                        status     = '$status'
                    WHERE id_tarefa = $id_tarefa_edicao
                      AND id_usuario = $usuario_logado_id";
            $mensagem_sucesso = "Tarefa atualizada com sucesso!";

        } else {
            $sql = "INSERT INTO tarefas (id_usuario, descricao, setor, prioridade)
                    VALUES ($usuario_logado_id, '$descricao', '$setor', '$prioridade')";
            $mensagem_sucesso = "Tarefa cadastrada com sucesso!";
        }

        if ($conexao->query($sql) === TRUE && $conexao->affected_rows > 0) {
            $_SESSION['mensagem'] = $mensagem_sucesso;
            header('Location: index.php');
            exit;
        } else {
            $mensagem = "Erro ao salvar no banco: " . $conexao->error;
        }
    }
}

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $modo_edicao ? 'Editar Tarefa' : 'Cadastrar Nova Tarefa'; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-container {
            width: 50%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-container h1 { text-align: center; }
        .form-grupo { margin-bottom: 16px; }
        .form-grupo label { display:block; margin-bottom:6px; font-weight:600; }
        .form-grupo input, .form-grupo select, .form-grupo textarea {
            width: 95%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif;
        }
        .linha-flex { display:flex; gap:8px; align-items:center; }
        .btn-sec { padding: 10px 12px; border: none; border-radius: 5px; background:#6c63ff; color:#fff; cursor:pointer; }
        .btn-sec[disabled]{ opacity: .7; cursor:not-allowed; }
        .btn-pri { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 1.05em; cursor: pointer; }
        .btn-pri:hover { background-color: #0069d9; }
        .mensagem-erro {
            background-color: #f8d7da; color:#721c24; border:1px solid #f5c6cb;
            padding: 12px; margin-bottom: 14px; border-radius: 5px; text-align:center;
        }
        .menu-principal .right { float:right; margin-right:18px; color:#fff; }
        small.hint { display:block; margin-top:6px; color:#666; }
    </style>
</head>
<body>

<header>
    <nav class="menu-principal">
        <ul>
            <li><a href="index.php">Gerenciar Tarefas</a></li>
            <li><a href="cadastro-tarefa.php">Nova Tarefa</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <span class="right">Olá, <?php echo htmlspecialchars($usuario_logado_nome); ?></span>
    </nav>
</header>

<main>
    <div class="form-container">
        <h1><?php echo $modo_edicao ? 'Editar Tarefa' : 'Cadastrar Nova Tarefa'; ?></h1>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem-erro"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <form action="cadastro-tarefa.php<?php echo $modo_edicao ? '?id=' . (int)$id_tarefa_edicao : ''; ?>" method="POST">

            <div class="form-grupo">
                <label>Usuário</label>
                <input type="text" value="<?php echo htmlspecialchars($usuario_logado_nome); ?>" readonly />
            </div>

            <div class="form-grupo">
                <label for="descricao">Descrição da Tarefa</label>
                <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($dados_tarefa['descricao']); ?></textarea>
            </div>

            <div class="form-grupo">
                <label for="cep">CEP</label>
                <div class="linha-flex" style="gap:10px">
                    <input type="text" id="cep" placeholder="Somente números (8 dígitos)" maxlength="9" style="width:60%">
                    <button type="button" id="btnCep" class="btn-sec">Buscar CEP</button>
                </div>
                <small id="cepInfo" class="hint"></small>
            </div>

            <div class="form-grupo">
                <label for="setor">Setor</label>
                <input type="text" id="setor" name="setor" value="<?php echo htmlspecialchars($dados_tarefa['setor']); ?>" required>
                <small class="hint">Dica: preencha manualmente ou use o botão “Buscar CEP” para sugerir “Bairro - Cidade”.</small>
            </div>

            <div class="form-grupo">
                <label for="prioridade">Prioridade</label>
                <select id="prioridade" name="prioridade" required>
                    <option value="baixa" <?php echo ($dados_tarefa['prioridade'] == 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                    <option value="media" <?php echo ($dados_tarefa['prioridade'] == 'media') ? 'selected' : ''; ?>>Média</option>
                    <option value="alta"  <?php echo ($dados_tarefa['prioridade'] == 'alta')  ? 'selected' : ''; ?>>Alta</option>
                </select>
            </div>

            <?php if ($modo_edicao): ?>
            <div class="form-grupo">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="a fazer"  <?php echo ($dados_tarefa['status'] == 'a fazer')  ? 'selected' : ''; ?>>A Fazer</option>
                    <option value="fazendo"  <?php echo ($dados_tarefa['status'] == 'fazendo')  ? 'selected' : ''; ?>>Fazendo</option>
                    <option value="pronto"   <?php echo ($dados_tarefa['status'] == 'pronto')   ? 'selected' : ''; ?>>Pronto</option>
                </select>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-pri">
                <?php echo $modo_edicao ? 'Atualizar Tarefa' : 'Salvar Tarefa'; ?>
            </button>
        </form>
    </div>
</main>

<script>
// ViaCEP – preencher “setor” por CEP
(function(){
  const btn   = document.getElementById('btnCep');
  const cep   = document.getElementById('cep');
  const setor = document.getElementById('setor');
  const info  = document.getElementById('cepInfo');
  if (!btn || !cep || !setor) return;

  btn.addEventListener('click', async () => {
    const raw = (cep.value || '').replace(/\D+/g,''); // só dígitos
    if (raw.length !== 8) { info.textContent = 'CEP inválido. Use 8 dígitos.'; return; }

    info.textContent = 'Consultando...';
    btn.disabled = true;

    try {
      const r = await fetch('https://viacep.com.br/ws/' + raw + '/json', {
        headers: { 'Accept':'application/json' }
      });
      if (!r.ok) throw new Error('HTTP ' + r.status);
      const data = await r.json();
      if (data.erro) { info.textContent = 'CEP não encontrado.'; return; }

      const bairro = (data.bairro || '').trim();
      const cidade = (data.localidade || '').trim();
      const uf     = (data.uf || '').trim();

      const label = [bairro, cidade].filter(Boolean).join(' - ');
      setor.value = label || (cidade || uf || '');
      info.textContent = 'Endereço encontrado: ' + (label || cidade || uf || '—');
    } catch (e) {
      info.textContent = 'Falha ao consultar CEP: ' + (e.message || e);
    } finally {
      btn.disabled = false;
    }
  });
})();
</script>

</body>
</html>
