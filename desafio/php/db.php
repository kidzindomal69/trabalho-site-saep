<?php
// Define a classe Database para gerenciar a conexão ao banco de dados
class Database {
    private $pdo; // Variável para armazenar a conexão PDO
    private $host; // Variável para armazenar o host do banco de dados
    private $db; // Variável para armazenar o nome do banco de dados
    private $user; // Variável para armazenar o nome do usuário do banco de dados
    private $pass; // Variável para armazenar a senha do usuário do banco de dados
    private $port; // Variável para armazenar a porta do banco de dados (default é 3307)

    // Construtor para definir as configurações do banco de dados
    public function __construct($host, $db, $user, $pass, $port = 3307) {
        $this->host = $host; // Inicializa a variável host
        $this->db = $db; // Inicializa a variável db
        $this->user = $user; // Inicializa a variável user
        $this->pass = $pass; // Inicializa a variável pass
        $this->port = $port; // Inicializa a variável port, permitindo a porta 3307 como padrão
    }

    // Método para conectar ao banco de dados
    public function connect() {
        try {
            // Tenta criar uma nova conexão PDO
            $this->pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            // Define o modo de erro do PDO para exceções
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo; // Retorna a conexão PDO em caso de sucesso
        } catch (PDOException $e) {
            // Captura exceções se a conexão falhar
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage() . "<br>";
            return null; // Retorna null em caso de erro na conexão
        }
    }

    // Método para obter a conexão PDO
    public function getConnection() {
        return $this->pdo; // Retorna a conexão PDO armazenada
    }
}
?>

