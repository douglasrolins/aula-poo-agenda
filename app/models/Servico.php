<?php

include_once 'Database.php';

class Servico
{
    private $id;
    private $nome;
    private $descricao;
    private $logo;
    private $preco;
    private $tempo;

    public function __construct($id, $nome, $descricao, $logo, $preco, $tempo)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->logo = $logo;
        $this->preco = $preco;
        $this->tempo = $tempo;
    }

    // Getters e Setters para os atributos

    public function getid()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getTempo()
    {
        return $this->tempo;
    }

    public function setTempo($tempo)
    {
        $this->tempo = $tempo;
    }

    // Métodos para cadastro
    public function cadastrar()
    {
        // Conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("INSERT INTO servico (nome, descricao, logo, preco, tempo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdi", $this->nome, $this->descricao, $this->logo, $this->preco, $this->tempo);

        // Executa a consulta
        if ($stmt->execute()) {
            $stmt->close();
            $db->closeConnection();
            return true;
        } else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }
    }

    // Método para atualização
    public function atualizar()
    {
        // Conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("UPDATE servico SET nome = ?, descricao = ?, logo = ?, preco = ?, tempo = ? WHERE idservico = ?");
        $stmt->bind_param("sssdii", $this->nome, $this->descricao, $this->logo, $this->preco, $this->tempo, $this->id);

        // Executa a consulta
        if ($stmt->execute()) {
            $stmt->close();
            $db->closeConnection();
            return true;
        } else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }
    }

    // Método para apagar
    public function deletar()
    {
        // Conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("DELETE FROM servico WHERE idservico = ?");
        $stmt->bind_param("i", $this->id);

        // Executa a consulta
        if ($stmt->execute()) {
            $stmt->close();
            $db->closeConnection();
            return true;
        } else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }
    }
}
