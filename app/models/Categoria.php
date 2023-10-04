<?php

include_once 'Database.php';

class Categoria
{
    private $id;
    private $nome;
    private $descricao;
    private $logo;

    public function __construct($id, $nome, $descricao, $logo)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->logo = $logo;
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

    // Métodos para cadastro
    public function cadastrar()
    {
        // Conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("INSERT INTO categoria (nome, descricao, logo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->nome, $this->descricao, $this->logo);

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
        $stmt = $conn->prepare("UPDATE categoria SET nome = ?, descricao = ?, logo = ? WHERE idcategoria = ?");
        $stmt->bind_param("sssi", $this->nome, $this->descricao, $this->logo, $this->id);

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
        $stmt = $conn->prepare("DELETE FROM categoria WHERE idcategoria = ?");
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
