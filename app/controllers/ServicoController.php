<?php

include_once 'app/models/Servico.php';
include_once 'app/models/Database.php';

class ServicoController
{

    public function obterTodosServicos()
    {
        $db = new Database();
        $conn = $db->connect();

        $servicos = array();

        $query = "SELECT * FROM servico";
        $result = $conn->query($query);

        if ($result) {  // Verificar se a consulta foi bem-sucedida
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $servico = new Servico($row['idservico'], $row['nome'], $row['descricao'], $row['logo'], $row['preco'], $row['tempo']);
                    $servicos[] = $servico;
                }
            } else {
                echo "Nenhum serviço encontrado.";
            }
        } else {
            echo "Erro na consulta: " . $conn->error;
        }

        $conn->close();
        return $servicos;
    }


    public static function obterServicoPorId($id)
    {

        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("SELECT * FROM servico WHERE idservico = ?");
        $stmt->bind_param("i", $id);

        try {
            $stmt->execute();
            $result = $stmt->get_result(); // Obtém o resultado
        } catch (\Throwable $th) {
            echo "Erro ao executar ao executar a consulta.";
            //throw $th;
        }

        if ($result->num_rows > 0) {

            // Obtém a primeira linha do resultado
            $row = $result->fetch_assoc();

            // Crie um objeto Serviço com os dados
            $servico = new Servico($row['idservico'], $row['nome'], $row['descricao'], $row['logo'], $row['preco'], $row['tempo']);
            return $servico;
        } else {
            echo "Erro na consulta: " . $conn->error;
        }


        $conn->close();

        return null;
    }
}
