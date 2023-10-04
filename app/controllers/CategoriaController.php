<?php

include_once 'app/models/Categoria.php';
include_once 'app/models/Database.php';

class CategoriaController
{

    public function obterTodasCategorias()
    {
        $db = new Database();
        $conn = $db->connect();

        $categorias = array();

        $query = "SELECT * FROM categoria";
        $result = $conn->query($query);

        if ($result) {  // Verificar se a consulta foi bem-sucedida
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categoria = new Categoria($row['idcategoria'], $row['nome'], $row['descricao'], $row['logo']);
                    $categorias[] = $categoria;
                }
            } else {
                echo "Nenhuma categoria encontrada.";
            }
        } else {
            echo "Erro na consulta: " . $conn->error;
        }

        $conn->close();
        return $categorias;
    }


    public static function obterCategoriaPorId($id)
    {

        $db = new Database();
        $conn = $db->connect();

        // Prepara a consulta SQL
        $stmt = $conn->prepare("SELECT * FROM categoria WHERE idcategoria = ?");
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

            // Crie um objeto Categoria com os dados
            $categoria = new Categoria($row['idcategoria'], $row['nome'], $row['descricao'], $row['logo']);
            return $categoria;
        } else {
            echo "Erro na consulta: " . $conn->error;
        }


        $conn->close();

        return null;
    }


    // Método para editar uma categoria existente
    public function editarCategoria($id)
    {
        // Lógica para editar a categoria no banco de dados
        // Pode chamar a classe de modelo Categoria e usar seus métodos para isso
        // Exemplo: Categoria::editar($id, $nome, $descricao, $logo);
    }

    // Método para deletar uma categoria existente
    public function deletarCategoria($id)
    {
        // Lógica para deletar a categoria do banco de dados
        // Pode chamar a classe de modelo Categoria e usar seus métodos para isso
        // Exemplo: Categoria::deletar($id);
    }
}
