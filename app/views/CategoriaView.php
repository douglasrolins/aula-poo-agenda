<?php

class CategoriaView
{
    // Método para exibir o formulário de cadastro de categoria
    public function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro
        echo "
        <h3 class='subtitle'>Nova Categoria</h3>
        <form action='categoria.php' method='post' enctype='multipart/form-data' class='categoria-form'>
            <input type='hidden' name='action' value='new'>
            <div class='form-group'>
                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' class='form-control' required>
            </div>
            <div class='form-group'>
                <label for='descricao'>Descrição:</label>
                <textarea id='descricao' name='descricao' class='form-control' required></textarea>
            </div>
            <div class='form-group'>
                <label for='logo'>Logo:</label>
                <input type='file' id='logo' name='logo' class='form-control' accept='image/*'>
            </div>
            <button type='submit' class='btn btn-primary'>Cadastrar</button>
        </form>
        ";
    }

    // Método para exibir a lista de categorias em uma tabela
    public function exibirListaCategorias($categorias)
    {
        echo "<div style='place-items: center; display: grid;' >";
        echo "<button type='submit' class='btn btn-primary' onclick=\"window.location.href='categoria.php?action=new'\">Inserir Categoria</button>";
        echo "<h3>Lista de Categorias</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Descrição</th><th>Logo</th><th>Ações</th></tr>";
        foreach ($categorias as $categoria) {
            echo "<tr>";
            echo "<td>{$categoria->getNome()}</td>";
            echo "<td>{$categoria->getDescricao()}</td>";
            echo "<td>{$categoria->getLogo()}</td>";
            echo "<td><a href='categoria.php?action=edit&id={$categoria->getId()}'>Editar</a> <a href='categoria.php?action=delete&id={$categoria->getId()}' onclick='return confirmarExclusao()'>Apagar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    public function exibirFormularioEdicao($categoria)
    {
        echo "
            <h2 class='subtitle'>Editar Categoria</h2>
            <form action='categoria.php' method='post' enctype='multipart/form-data' class='categoria-form'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id' value='{$categoria->getId()}'>
               
                <div class='form-group'>
                    <label for='nome'>Nome:</label>
                    <input type='text' id='nome' name='nome' class='form-control' required value='{$categoria->getNome()}'>
                </div>
                <div class='form-group'>
                    <label for='descricao'>Descrição:</label>
                    <textarea id='descricao' name='descricao' class='form-control' required>{$categoria->getDescricao()}</textarea>
                </div>
                <div class='form-group'>
                    <label for='logo'>Logo:</label>
                    <input type='file' id='logo' name='logo' class='form-control' accept='image/*' value='{$categoria->getLogo()}'>
                </div>
                <button type='submit' class='btn btn-primary'>Cadastrar</button>
            </form>
        ";
    }


    // Outros métodos relacionados à visualização da categoria podem ser adicionados aqui
}
