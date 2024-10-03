<?php
// Define as variáveis com as credenciais de conexão ao banco de dados
$host = 'localhost'; // Endereço do servidor de banco de dados (localhost indica que está na mesma máquina)
$db = 'senai_aulaphp'; // Nome do banco de dados
$user = 'yuri2'; // Nome do usuário do banco de dados
$pass = '123'; // Senha do usuário do banco de dados
$port = 3307; // Porta utilizada pelo servidor MySQL (normalmente 3306, mas nesse caso é 3307)

// Inclui o arquivo db.php, que contém a classe para conexão com o banco de dados
require_once 'db.php';

// Instanciando o objeto Database e estabelecendo a conexão ao banco de dados
$database = new Database($host, $db, $user, $pass, $port);
$database->connect();
$pdo = $database->getConnection(); // Obtém a conexão PDO para executar consultas

// Mensagens de feedback
$message = '';

// Excluindo usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    try {
        // Obtém o ID do usuário a ser excluído
        $id = $_POST['id'];

        // Prepara a instrução SQL para excluir um usuário da tabela 'usuario'
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->bindParam(':id', $id); // Associa o parâmetro :id ao valor de $id
        $stmt->execute(); // Executa a instrução

        // Define uma mensagem de sucesso após a exclusão
        $message = "Usuário excluído com sucesso!";
    } catch (PDOException $e) {
        // Caso ocorra um erro, define a mensagem de erro
        $message = "Erro ao excluir: " . $e->getMessage();
    }
}

// Obtendo todos os usuários
$users = []; // Inicializa um array para armazenar os usuários
try {
    // Executa uma consulta para buscar todos os usuários da tabela 'usuario'
    $stmt = $pdo->query("SELECT * FROM usuario");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Armazena todos os resultados em um array associativo
} catch (PDOException $e) {
    // Se ocorrer um erro ao buscar os usuários, exibe a mensagem de erro
    echo "Erro ao buscar usuários: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8 para suportar caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->
    <title>Usuários Cadastrados</title> <!-- Define o título da página -->
    <link rel="stylesheet" href="style.css"> <!-- Importa uma folha de estilo externa -->
</head>
<body>
    <h2>Usuários Cadastrados</h2> <!-- Título da seção -->

    <?php if ($message): ?> <!-- Verifica se há uma mensagem para exibir -->
        <p><?php echo $message; ?></p> <!-- Exibe a mensagem de feedback -->
    <?php endif; ?>

    <!-- Tabela que lista todos os usuários cadastrados -->
    <table border="1"> <!-- Define uma tabela com borda -->
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Idade</th>
            <th>Curso</th>
            <th>Ações</th> <!-- Coluna para as ações (editar/excluir) -->
        </tr>
        <?php foreach ($users as $user): ?> <!-- Itera sobre cada usuário -->
            <tr>
                <td><?php echo $user['id']; ?></td> <!-- Exibe o ID do usuário -->
                <td><?php echo $user['nome']; ?></td> <!-- Exibe o nome do usuário -->
                <td><?php echo $user['email']; ?></td> <!-- Exibe o e-mail do usuário -->
                <td><?php echo $user['idade']; ?></td> <!-- Exibe a idade do usuário -->
                <td><?php echo $user['curso']; ?></td> <!-- Exibe o curso do usuário -->
                <td>
                    <!-- Formulário para excluir o usuário -->
                    <form action="insert.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete"> <!-- Define a ação como 'delete' -->
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>"> <!-- Passa o ID do usuário -->
                        <input type="submit" value="Excluir"> <!-- Botão para excluir -->
                    </form>
                    <!-- Formulário para editar o usuário -->
                    <form action="edit.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>"> <!-- Passa o ID do usuário -->
                        <input type="submit" value="Editar"> <!-- Botão para editar -->
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

