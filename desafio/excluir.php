<?php
// Inclui o arquivo 'db.php' que provavelmente contém a classe ou função para conectar ao banco de dados
include 'php/db.php';

// Definindo os parâmetros para a conexão com o banco de dados MySQL
$host = 'localhost';   // Servidor onde o banco de dados está hospedado
$db = 'senai_aulaphp'; // Nome do banco de dados
$user = 'yuri2';       // Nome de usuário para acessar o banco
$pass = '123';         // Senha correspondente ao usuário
$port = 3307;          // Porta do MySQL (usualmente 3306, mas neste caso é 3307)

// Instancia a classe Database (presente no db.php) com os parâmetros de conexão ao banco
$database = new Database($host, $db, $user, $pass, $port);
// Conecta-se ao banco de dados e armazena a conexão na variável $pdo
$pdo = $database->connect();

// Verifica se a conexão com o banco foi estabelecida com sucesso
if ($pdo) {
    // Verifica se o parâmetro 'id' foi passado via GET (pela URL)
    // Isso indica que a operação de exclusão será feita com base no ID de um usuário fornecido na URL
    if (isset($_GET['id'])) { // Foi alterado de $_POST para $_GET, ou seja, agora os dados são enviados via URL
        $deleteId = $_GET['id']; // Obtém o valor do 'id' da URL e armazena na variável $deleteId
        
        // Prepara uma declaração SQL para excluir o usuário com o ID correspondente
        $deleteStmt = $pdo->prepare("DELETE FROM usuario WHERE id = :id");
        // Associa o valor do ID obtido na URL ao parâmetro ':id' na declaração SQL
        $deleteStmt->bindParam(':id', $deleteId);
        // Executa a instrução preparada de exclusão no banco de dados
        $deleteStmt->execute();

        // Exibe um alerta em JavaScript informando que o usuário foi excluído com sucesso
        // Após o alerta, redireciona para a página 'default.php'
        echo "<script>alert('Usuário excluído com sucesso!'); window.location='default.php';</script>";
    } else {
        // Caso o ID do usuário não tenha sido fornecido via URL
        echo "ID do usuário não fornecido.";
    }
} else {
    // Caso a conexão com o banco de dados não tenha sido estabelecida
    echo "Conexão com o banco de dados não estabelecida.";
}
?>

