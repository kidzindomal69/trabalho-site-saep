<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Definindo a codificação de caracteres para UTF-8 -->
    <meta charset="UTF-8">
    <!-- Configurando a viewport para responsividade em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilização do botão de voltar */
        .btn-voltar {
            display: inline-block; /* Faz o botão se comportar como um bloco em linha */
            margin-bottom: 20px; /* Espaçamento abaixo do botão */
            padding: 10px 15px; /* Espaçamento interno do botão */
            background-color: #007BFF; /* Cor de fundo do botão */
            color: white; /* Cor do texto do botão */
            text-decoration: none; /* Remove o sublinhado */
            border-radius: 5px; /* Bordas arredondadas */
            transition: background-color 0.3s; /* Transição suave na mudança de cor */
            cursor: pointer; /* Indica que o elemento é clicável */
        }

        /* Estilo do botão ao passar o mouse */
        .btn-voltar:hover {
            background-color: #0056b3; /* Cor de fundo alterada ao passar o mouse */
        }
    </style>
</head>
<body>
<h2>Usuários Cadastrados</h2>

<!-- Botão de Voltar que utiliza JavaScript para voltar à página anterior -->
<button class="btn-voltar" onclick="window.history.back();">Voltar</button>

<!-- Formulário de pesquisa que envia um GET -->
<form method="GET" action="">
    <input type="text" name="search" placeholder="Pesquisar por aluno ou curso"> <!-- Campo de texto para pesquisa -->
    <button type="submit">Buscar</button> <!-- Botão de submissão -->
</form>

<!-- Tabela para exibir os usuários cadastrados -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Idade</th>
        <th>Curso</th>
        <th>Ações</th>
    </tr>
    <?php
    // Inclui o arquivo de conexão com o banco de dados
    include 'php/db.php';

    // Definindo as credenciais para conexão com o banco de dados
    $host = 'localhost';
    $db = 'senai_aulaphp';
    $user = 'yuri2';
    $pass = '123';
    $port = 3307;

    // Criação de uma nova instância da classe Database
    $database = new Database($host, $db, $user, $pass, $port);
    $pdo = $database->connect(); // Conexão ao banco de dados

    if ($pdo) {
        try {
            // Inicializa a variável para a busca
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Prepara a consulta SQL, usando LIKE para busca
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nome LIKE :search OR curso LIKE :search");
            $stmt->execute(['search' => "%$search%"]); // Executa a consulta com o parâmetro de busca

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os usuários como um array associativo

            // Loop através dos usuários e gera as linhas da tabela
            foreach ($users as $user) {
                echo "<tr>
                <td>{$user['id']}</td>
                <td>{$user['nome']}</td>
                <td>{$user['email']}</td>
                <td>{$user['idade']}</td>
                <td>{$user['curso']}</td>
                <td>
                    <a href='editar.php?id={$user['id']}'>Editar</a> <!-- Link para editar o usuário -->
                    <a href='excluir.php?id={$user['id']}' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a> <!-- Link para excluir o usuário com confirmação -->
                </td>
              </tr>";
            }
        } catch (PDOException $e) {
            // Exibe mensagem de erro se a consulta falhar
            echo "Erro ao buscar usuários: " . $e->getMessage();
        }
    } else {
        // Mensagem de erro caso a conexão não seja estabelecida
        echo "Conexão com o banco de dados não estabelecida.";
    }
    ?>
</table>
</body>
</html>
