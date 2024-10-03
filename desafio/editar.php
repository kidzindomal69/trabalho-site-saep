<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Configura o tipo de documento como HTML5 e define a linguagem da página como português do Brasil -->
    <meta charset="UTF-8"> <!-- Define o charset para UTF-8, garantindo a correta codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Faz com que a página seja responsiva -->
    <title>Editar Usuário</title> <!-- Define o título da página que aparecerá na aba do navegador -->
</head>
<body>
<h2>Editar Usuário</h2> <!-- Título da página exibido ao usuário -->

<?php
// Inclui o arquivo 'db.php' que contém a classe para a conexão com o banco de dados
include 'php/db.php';

// Definindo os parâmetros da conexão com o banco de dados MySQL
$host = 'localhost';   // Servidor onde o banco de dados está hospedado
$db = 'senai_aulaphp'; // Nome do banco de dados
$user = 'yuri2';       // Nome do usuário para acessar o banco
$pass = '123';         // Senha do banco de dados
$port = 3307;          // Porta do MySQL

// Instancia a classe Database com os parâmetros definidos
$database = new Database($host, $db, $user, $pass, $port);
// Estabelece conexão com o banco de dados e armazena a conexão em $pdo
$pdo = $database->connect();

// Verifica se a conexão foi estabelecida com sucesso
if ($pdo) {
    // Verifica se o ID do usuário foi passado via método GET (URL)
    if (isset($_GET['id'])) {
        $userId = $_GET['id']; // Obtém o valor do 'id' da URL e armazena na variável $userId
        
        // Prepara uma consulta SQL para buscar os dados do usuário com o ID fornecido
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = :id");
        // Associa o valor do ID ao parâmetro ':id' da consulta
        $stmt->bindParam(':id', $userId);
        // Executa a consulta
        $stmt->execute();
        // Obtém os dados do usuário como um array associativo
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário foi encontrado
        if ($user) {
            // Exibe o formulário com os dados do usuário preenchidos para edição
            echo "<form method='post' action='editar.php'>
                <input type='hidden' name='id' value='{$user['id']}'> <!-- Campo oculto com o ID do usuário -->
                Nome: <input type='text' name='nome' value='{$user['nome']}' required><br> <!-- Campo para o nome -->
                E-mail: <input type='email' name='email' value='{$user['email']}' required><br> <!-- Campo para o e-mail -->
                Idade: <input type='number' name='idade' value='{$user['idade']}' required><br> <!-- Campo para a idade -->
                Curso: <input type='text' name='curso' value='{$user['curso']}' required><br> <!-- Campo para o curso -->
                <input type='submit' value='Salvar'> <!-- Botão para salvar as mudanças -->
            </form>";
        } else {
            // Caso o usuário não seja encontrado no banco de dados
            echo "Usuário não encontrado.";
        }
    }

    // Verifica se o formulário foi enviado com os dados do usuário para serem atualizados
    if (isset($_POST['id'])) {
        $updateId = $_POST['id'];         // Obtém o ID do formulário (campo oculto)
        $updateNome = $_POST['nome'];     // Obtém o nome atualizado do formulário
        $updateEmail = $_POST['email'];   // Obtém o e-mail atualizado
        $updateIdade = $_POST['idade'];   // Obtém a idade atualizada
        $updateCurso = $_POST['curso'];   // Obtém o curso atualizado

        // Prepara a instrução SQL para atualizar os dados do usuário com base no ID
        $updateStmt = $pdo->prepare("UPDATE usuario SET nome = :nome, email = :email, idade = :idade, curso = :curso WHERE id = :id");
        // Associa os valores aos parâmetros da consulta SQL
        $updateStmt->bindParam(':nome', $updateNome);
        $updateStmt->bindParam(':email', $updateEmail);
        $updateStmt->bindParam(':idade', $updateIdade);
        $updateStmt->bindParam(':curso', $updateCurso);
        $updateStmt->bindParam(':id', $updateId);
        // Executa a atualização no banco de dados
        $updateStmt->execute();

        // Exibe uma mensagem de sucesso e redireciona para a página 'default.php'
        echo "<script>alert('Usuário editado com sucesso!'); window.location='default.php';</script>";
    }
} else {
    // Caso a conexão com o banco de dados falhe
    echo "Conexão com o banco de dados não estabelecida.";
}
?>

</body>
</html>
