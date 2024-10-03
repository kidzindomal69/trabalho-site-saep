<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o tipo de documento como HTML5 e define a linguagem da página como português do Brasil -->
    <meta charset="UTF-8"> <!-- Define o charset para UTF-8, garantindo a correta codificação de caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Faz com que a página seja responsiva em diferentes dispositivos -->
    <title>Usuários Cadastrados</title> <!-- Define o título da página, que aparecerá na aba do navegador -->
    <link rel="stylesheet" href="style.css"> <!-- Importa uma folha de estilos CSS externa -->
</head>
<body>
<h2>Usuários Cadastrados</h2> <!-- Título da página que será exibido ao usuário -->
<table border="1"> <!-- Cria uma tabela HTML com borda para exibir os usuários cadastrados -->
    <tr>
        <!-- Define os cabeçalhos da tabela -->
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Idade</th>
        <th>Curso</th>
        <th>Ações</th>
    </tr>
    <?php
    // Inclui o arquivo 'db.php' que contém a classe Database para conexão com o banco de dados
    include 'php/db.php';

    // Definindo os parâmetros de conexão com o banco de dados MySQL
    $host = 'localhost';   // Servidor onde o banco de dados está hospedado
    $db = 'senai_aulaphp'; // Nome do banco de dados
    $user = 'yuri2';       // Nome do usuário para acessar o banco de dados
    $pass = '123';         // Senha correspondente ao usuário
    $port = 3307;          // Porta do MySQL (usualmente 3306, mas neste caso é 3307)

    // Instancia a classe Database com os parâmetros definidos
    $database = new Database($host, $db, $user, $pass, $port);
    // Estabelece a conexão com o banco de dados e armazena a conexão na variável $pdo
    $pdo = $database->connect();

    // Verifica se a conexão com o banco de dados foi estabelecida
    if ($pdo) {
        try {
            // Obtém todos os registros da tabela 'usuario'
            $stmt = $pdo->query("SELECT * FROM usuario");
            // Fetch all recupera todos os registros como um array associativo
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop através de cada usuário e cria uma linha na tabela com os dados
            foreach ($users as $user) {
                // Exibe os dados do usuário em uma nova linha da tabela
                echo "<tr>
                <td>{$user['id']}</td> <!-- Exibe o ID do usuário -->
                <td>{$user['nome']}</td> <!-- Exibe o nome do usuário -->
                <td>{$user['email']}</td> <!-- Exibe o e-mail do usuário -->
                <td>{$user['idade']}</td> <!-- Exibe a idade do usuário -->
                <td>{$user['curso']}</td> <!-- Exibe o curso do usuário -->
                <td>
                    <!-- Links de ação: Editar e Excluir -->
                    <a href='editar.php?id={$user['id']}'>Editar</a> <!-- Link para editar o usuário, passando o ID pela URL -->
                    <a href='excluir.php?id={$user['id']}' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a> <!-- Link para excluir o usuário, com uma confirmação antes -->
                </td>
              </tr>";
            }
        } catch (PDOException $e) {
            // Em caso de erro ao buscar usuários, exibe uma mensagem de erro
            echo "Erro ao buscar usuários: " . $e->getMessage();
        }
    } else {
        // Caso a conexão com o banco de dados não seja estabelecida, exibe uma mensagem de erro
        echo "Conexão com o banco de dados não estabelecida.";
    }
    ?>
</table>
</body>
</html>
