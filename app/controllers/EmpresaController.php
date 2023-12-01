<?php

include_once 'app/models/Empresa.php';
include_once 'app/models/Database.php';

class EmpresaController
{

    public function obterTodasEmpresas()
    {
        $db = new Database();
        $conn = $db->connect();

        $empresas = array();

        $query = "SELECT * FROM empresa";
        $result = $conn->query($query);

        if ($result) {  // Verificar se a consulta foi bem-sucedida
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $empresa = new Empresa($row['id'], $row['nome'], $row['cnpj'], $row['endereco'], $row['telefone']);
                    $empresas[] = $empresa;
                }
            } else {
                echo "Nenhuma empresa encontrado.";
            }
        } else {
            echo "Erro na consulta: " . $conn->error;
        }

        $conn->close();
        return $empresas;
    }


    public static function obterEmpresaPorId($id)
    {

        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("SELECT * FROM empresa WHERE id = ?");
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

            // Crie um objeto Empresa com os dados
            $empresa = new Empresa($row['id'], $row['nome'], $row['cnpj'], $row['endereco'], $row['telefone']);
            return $empresa;
        } else {
            echo "Erro na consulta: " . $conn->error;
        }


        $conn->close();

        return null;
    }
}
