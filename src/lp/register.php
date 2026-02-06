<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Obtém os dados do formulário
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
$objetivo = isset($_POST['objetivo']) ? trim($_POST['objetivo']) : '';

// Validação básica
if (empty($nome) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Nome e email são obrigatórios']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

// Prepara os dados
$novoRegistro = [
    'id' => uniqid(),
    'nome' => $nome,
    'email' => $email,
    'telefone' => $telefone,
    'objetivo' => $objetivo,
    'data_cadastro' => date('Y-m-d H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido'
];

// Nome do arquivo JSON
$arquivo = 'cadastros.json';

// Lê os registros existentes
$registros = [];
if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $registros = json_decode($conteudo, true) ?? [];
}

// Verifica se o email já existe
foreach ($registros as $registro) {
    if ($registro['email'] === $email) {
        echo json_encode(['success' => false, 'message' => 'Este email já está cadastrado']);
        exit;
    }
}

// Adiciona o novo registro
$registros[] = $novoRegistro;

// Salva no arquivo JSON
if (file_put_contents($arquivo, json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode([
        'success' => true, 
        'message' => 'Cadastro realizado com sucesso!',
        'data' => [
            'nome' => $nome,
            'email' => $email
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar o cadastro']);
}
?>