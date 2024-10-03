<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-voltar {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer; /* Muda o cursor para indicar que é clicável */
        }

        .btn-voltar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h2>Usuários Cadastrados</h2>

<!-- Botão de Voltar com JavaScript -->
<button class="btn-voltar" onclick="window.history.back();">Voltar</button>

<!-- Formulário de Pesquisa -->
<form method="GET" action="">
    <input type="text" name="search" placeholder="Pesquisar por aluno ou curso">
    <button type="submit">Buscar</button>
</form>

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
    include 'php/db.php';

    $host = 'localhost';
    $db = 'senai_aulaphp';
    $user = 'yuri2';
    $pass = '123';
    $port = 3307;

    $database = new Database($host, $db, $user, $pass, $port);
    $pdo = $database->connect();

    if ($pdo) {
        try {
            // Inicializa a variável para a busca
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Prepara a consulta, usando LIKE para pesquisa
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nome LIKE :search OR curso LIKE :search");
            $stmt->execute(['search' => "%$search%"]);

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                echo "<tr>
                <td>{$user['id']}</td>
                <td>{$user['nome']}</td>
                <td>{$user['email']}</td>
                <td>{$user['idade']}</td>
                <td>{$user['curso']}</td>
                <td>
                    <a href='editar.php?id={$user['id']}'>Editar</a>
                    <a href='excluir.php?id={$user['id']}' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a>
                </td>
              </tr>";
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários: " . $e->getMessage();
        }
    } else {
        echo "Conexão com o banco de dados não estabelecida.";
    }
    ?>
</table>
</body>
</html>
