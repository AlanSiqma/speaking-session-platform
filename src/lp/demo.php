<?php
// Arquivo para criar alguns cadastros de demonstração
// Execute este arquivo uma vez para popular com dados de teste

$cadastros_demo = [
    [
        'id' => uniqid(),
        'nome' => 'Maria Silva Santos',
        'email' => 'maria.silva@email.com',
        'telefone' => '(11) 99999-1234',
        'objetivo' => 'Melhorar apresentações no trabalho e falar com mais confiança em reuniões',
        'data_cadastro' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'ip' => '192.168.1.100'
    ],
    [
        'id' => uniqid(),
        'nome' => 'João Oliveira',
        'email' => 'joao.oliveira@empresa.com',
        'telefone' => '(21) 98888-5678',
        'objetivo' => 'Preparação para apresentações de vendas e networking',
        'data_cadastro' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'ip' => '192.168.1.101'
    ],
    [
        'id' => uniqid(),
        'nome' => 'Ana Costa Ferreira',
        'email' => 'ana.costa@gmail.com',
        'telefone' => '(31) 97777-9999',
        'objetivo' => 'Superar timidez e melhorar comunicação em público',
        'data_cadastro' => date('Y-m-d H:i:s', strtotime('-5 hours')),
        'ip' => '192.168.1.102'
    ],
    [
        'id' => uniqid(),
        'nome' => 'Pedro Henrique',
        'email' => 'pedro.h@startup.com',
        'telefone' => '(47) 96666-3333',
        'objetivo' => 'Pitch para investidores e apresentações corporativas',
        'data_cadastro' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'ip' => '192.168.1.103'
    ],
    [
        'id' => uniqid(),
        'nome' => 'Carla Meneses',
        'email' => 'carla.meneses@outlook.com',
        'telefone' => '',
        'objetivo' => 'Comunicação mais fluida para aulas online e webinars',
        'data_cadastro' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
        'ip' => '192.168.1.104'
    ]
];

$arquivo = 'cadastros.json';

// Só cria os dados demo se o arquivo não existir
if (!file_exists($arquivo)) {
    if (file_put_contents($arquivo, json_encode($cadastros_demo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo "✅ Dados de demonstração criados com sucesso!<br>";
        echo "📊 " . count($cadastros_demo) . " cadastros de exemplo adicionados<br><br>";
        echo "<strong>Próximos passos:</strong><br>";
        echo "1. <a href='index.html'>Ver Landing Page</a><br>";
        echo "2. <a href='admin.php'>Acessar Admin</a> (senha: speakai2026)<br>";
        echo "3. Teste o formulário de cadastro<br>";
    } else {
        echo "❌ Erro ao criar dados de demonstração";
    }
} else {
    echo "⚠️ Arquivo de cadastros já existe. Dados demo não foram criados para não sobrescrever.";
}
?>