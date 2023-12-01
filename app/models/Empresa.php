<?php

include_once 'Database.php';

class Empresa
{
    private $id;
    private $nome;
    private $cnpj;
    private $endereco;
    private $telefone;

    public function __construct($id, $nome, $cnpj, $endereco, $telefone)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
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

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    // Métodos para cadastro
    public function cadastrar()
    {
        // Conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("INSERT INTO empresa (nome, cnpj, endereco, telefone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->nome, $this->cnpj, $this->endereco, $this->telefone);

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
        $stmt = $conn->prepare("UPDATE empresa SET nome = ?, cnpj = ?, endereco = ?, telefone = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $this->nome, $this->cnpj, $this->endereco, $this->telefone, $this->id);

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
        $stmt = $conn->prepare("DELETE FROM empresa WHERE id = ?");
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