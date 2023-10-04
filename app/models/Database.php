<?php

include_once __DIR__ . '/../../config/config.php';

class Database
{
    private $servername;  // Host do banco de dados
    private $username;  // Nome de usuário do banco de dados
    private $password;    // Senha do banco de dados
    private $dbname; // Nome do banco de dados
    private $conn; // Objeto que guardará a conexão com o banco

    // Defini os valores iniciais ao instanciar a classe
    public function __construct() {
        $this->servername = DB_HOST;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;
    }

    // Método para estabelecer a conexão com o banco de dados
    public function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Verifica a conexão
        if ($this->conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    // Método para fechar a conexão com o banco de dados
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}