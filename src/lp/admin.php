<?php
// Senha simples para proteger a página (em produção, use algo mais seguro)
$senha_admin = 'speakai2026';

// Verifica autenticação
session_start();
$autenticado = isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true;

// Processa login
if (!$autenticado && isset($_POST['senha'])) {
    if ($_POST['senha'] === $senha_admin) {
        $_SESSION['admin_autenticado'] = true;
        $autenticado = true;
    } else {
        $erro_login = 'Senha incorreta';
    }
}

// Processa logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Se não estiver autenticado, mostra tela de login
if (!$autenticado) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakAI - Admin Login</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="icon" type="image/x-icon" href="icon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            color: #667eea;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .error {
            color: #ff6b6b;
            text-align: center;
            margin-top: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 SpeakAI Admin</h2>
        <form method="POST">
            <div class="form-group">
                <label for="senha">Senha de Acesso:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
            <?php if (isset($erro_login)) echo "<div class='error'>$erro_login</div>"; ?>
        </form>
    </div>
</body>
</html>
<?php
exit;
}

// Se chegou até aqui, está autenticado - mostra os cadastros
$arquivo = 'cadastros.json';
$registros = [];

if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $registros = json_decode($conteudo, true) ?? [];
}

// Ordena por data mais recente
usort($registros, function($a, $b) {
    return strtotime($b['data_cadastro']) - strtotime($a['data_cadastro']);
});

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakAI - Cadastros Registrados</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="icon" type="image/x-icon" href="icon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .header h1 {
            margin-bottom: 0.5rem;
        }

        .header .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .header .logout:hover {
            background: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            color: #666;
            font-size: 1.1rem;
        }

        .registros-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .registros-header {
            background: #667eea;
            color: white;
            padding: 1.5rem;
        }

        .registros-header h2 {
            margin-bottom: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .empty-state span {
            font-size: 4rem;
            display: block;
            margin-bottom: 1rem;
        }

        .registro {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
        }

        .registro:hover {
            background: #f8f9fa;
        }

        .registro:last-child {
            border-bottom: none;
        }

        .registro-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .registro-nome {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .registro-data {
            color: #666;
            font-size: 0.9rem;
        }

        .registro-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .detail {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-weight: bold;
            color: #667eea;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            color: #333;
        }

        .objetivo-text {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            font-style: italic;
            color: #555;
        }

        .filter-container {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            min-width: 250px;
        }

        .export-btn {
            background: #ff6b6b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .export-btn:hover {
            background: #ff5252;
        }

        @media (max-width: 768px) {
            .header .logout {
                position: relative;
                top: auto;
                right: auto;
                margin-top: 1rem;
                display: inline-block;
            }

            .registro-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .filter-container {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-input {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="?logout" class="logout">🚪 Sair</a>
        <h1>📊 SpeakAI - Dashboard Admin</h1>
        <p>Gerenciamento de Cadastros da Landing Page</p>
    </div>

    <div class="container">
        <?php
        $total_cadastros = count($registros);
        $cadastros_hoje = 0;
        $cadastros_semana = 0;
        
        $hoje = date('Y-m-d');
        $uma_semana_atras = date('Y-m-d', strtotime('-7 days'));
        
        foreach ($registros as $registro) {
            $data_registro = date('Y-m-d', strtotime($registro['data_cadastro']));
            if ($data_registro === $hoje) $cadastros_hoje++;
            if ($data_registro >= $uma_semana_atras) $cadastros_semana++;
        }
        ?>

        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $total_cadastros; ?></h3>
                <p>Total de Cadastros</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $cadastros_hoje; ?></h3>
                <p>Hoje</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $cadastros_semana; ?></h3>
                <p>Últimos 7 dias</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_cadastros > 0 ? number_format($cadastros_semana / 7, 1) : '0'; ?></h3>
                <p>Média por dia</p>
            </div>
        </div>

        <div class="registros-container">
            <div class="registros-header">
                <h2>📋 Cadastros Registrados</h2>
                <p>Lista completa de todos os interessados na plataforma</p>
            </div>

            <?php if (empty($registros)): ?>
                <div class="empty-state">
                    <span>📭</span>
                    <h3>Nenhum cadastro ainda</h3>
                    <p>Os cadastros da landing page aparecerão aqui automaticamente</p>
                </div>
            <?php else: ?>
                <div class="filter-container" style="padding: 1.5rem;">
                    <input type="text" class="filter-input" placeholder="🔍 Filtrar por nome ou email..." id="filtro">
                    <a href="?export=csv" class="export-btn">📊 Exportar CSV</a>
                </div>

                <div id="registros-lista">
                    <?php foreach ($registros as $registro): ?>
                        <div class="registro" data-search="<?php echo strtolower($registro['nome'] . ' ' . $registro['email']); ?>">
                            <div class="registro-header">
                                <div class="registro-nome"><?php echo htmlspecialchars($registro['nome']); ?></div>
                                <div class="registro-data">
                                    📅 <?php echo date('d/m/Y H:i', strtotime($registro['data_cadastro'])); ?>
                                </div>
                            </div>
                            
                            <div class="registro-details">
                                <div class="detail">
                                    <div class="detail-label">📧 Email</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($registro['email']); ?></div>
                                </div>
                                
                                <?php if (!empty($registro['telefone'])): ?>
                                <div class="detail">
                                    <div class="detail-label">📱 Telefone</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($registro['telefone']); ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="detail">
                                    <div class="detail-label">🌐 IP</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($registro['ip']); ?></div>
                                </div>
                            </div>
                            
                            <?php if (!empty($registro['objetivo'])): ?>
                            <div class="objetivo-text">
                                <strong>🎯 Objetivo:</strong> <?php echo htmlspecialchars($registro['objetivo']); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Filtro em tempo real
        document.getElementById('filtro')?.addEventListener('input', function(e) {
            const filtro = e.target.value.toLowerCase();
            const registros = document.querySelectorAll('.registro');
            
            registros.forEach(registro => {
                const texto = registro.getAttribute('data-search');
                if (texto.includes(filtro)) {
                    registro.style.display = 'block';
                } else {
                    registro.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

<?php
// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv' && !empty($registros)) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="speakai_cadastros_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Cabeçalho
    fputcsv($output, ['Nome', 'Email', 'Telefone', 'Objetivo', 'Data Cadastro', 'IP'], ';');
    
    // Dados
    foreach ($registros as $registro) {
        fputcsv($output, [
            $registro['nome'],
            $registro['email'],
            $registro['telefone'] ?? '',
            $registro['objetivo'] ?? '',
            $registro['data_cadastro'],
            $registro['ip']
        ], ';');
    }
    
    fclose($output);
    exit;
}
?>