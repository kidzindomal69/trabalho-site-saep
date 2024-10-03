<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o tipo do documento como HTML5 e a linguagem como português do Brasil -->
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8 para suportar caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva em diferentes dispositivos -->
    <title>Cadastro de Usuários</title> <!-- Define o título da página -->

    <link rel="stylesheet" href="style.css"> <!-- Importa uma folha de estilo externa -->

    <?php
        // Definindo as configurações de conexão ao banco de dados
        $host = 'localhost';   // Endereço do servidor de banco de dados (localhost indica que está na mesma máquina)
        $db = 'senai_aulaphp'; // Nome do banco de dados
        $user = 'yuri2';       // Nome do usuário do banco de dados
        $pass = '123';         // Senha do usuário do banco de dados
        $port = 3307;          // Porta usada pelo servidor MySQL (normalmente 3306, mas nesse caso é 3307)

        // Inclui o arquivo 'db.php', que contém a classe para conexão com o banco de dados
        require_once 'php/db.php';

        // Instanciando o objeto da classe Database e conectando ao banco de dados
        $database = new Database($host, $db, $user, $pass, $port);
        $pdo = $database->connect(); // Estabelece a conexão com o banco de dados

        // Variável para armazenar uma mensagem de feedback (de sucesso ou erro)
        $message = '';

        // Verifica se o método de requisição é POST e se todos os campos necessários estão presentes
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['idade'], $_POST['curso'])) {
            try {
                // Coleta os valores dos campos do formulário e armazena em variáveis
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $idade = $_POST['idade'];
                $curso = $_POST['curso'];

                // Prepara a instrução SQL para inserir um novo usuário na tabela 'usuario'
                $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, idade, curso) VALUES (:nome, :email, :idade, :curso)");
                
                // Associa os parâmetros aos valores das variáveis
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':idade', $idade);
                $stmt->bindParam(':curso', $curso);

                // Executa a instrução SQL (inserção)
                $stmt->execute();

                // Define uma mensagem de sucesso após o cadastro
                $message = "Usuário cadastrado com sucesso!";
            } catch (PDOException $e) {
                // Define uma mensagem de erro caso ocorra uma exceção durante a execução da inserção
                $message = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    ?>
</head>

<body>
    <h2>Cadastro de Usuários</h2> <!-- Título da página -->

    <!-- Exibe a mensagem de feedback, se houver -->
    <?php if ($message): ?>
        <p><?php echo $message; ?></p> <!-- Mostra a mensagem armazenada em $message (sucesso ou erro) -->
    <?php endif; ?>

    <!-- Formulário para cadastro de usuário -->
    <form action="cadastro.php" method="POST"> <!-- O formulário envia os dados via método POST para o mesmo arquivo -->
        <input type="text" name="nome" placeholder="Nome" required><br> <!-- Campo para inserir o nome do usuário -->
        <input type="email" name="email" placeholder="E-mail" required><br> <!-- Campo para inserir o e-mail -->
        <input type="number" name="idade" placeholder="Idade" required><br> <!-- Campo para inserir a idade -->
        <input type="text" name="curso" placeholder="Curso" required><br> <!-- Campo para inserir o curso -->
        <input type="submit" value="Cadastrar"> <!-- Botão de envio do formulário -->
    </form>

    <!-- Botão para acessar a página com a tabela de usuários cadastrados -->
    <form action="default.php" method="POST"> <!-- Outro formulário que redireciona para a página 'default.php' -->
        <input type="submit" value="Ver Tabelas"> <!-- Botão para acessar a página onde são listados os usuários cadastrados -->
    </form>
</body>
</html>
