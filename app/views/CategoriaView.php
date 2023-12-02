<?php

class CategoriaView
{
    // Método para exibir o formulário de cadastro de categoria
    public function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro
        echo "
        <h3>Nova Categoria</h3>
        <form action='categoria.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='action' value='new'>
            <div>
                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' required>
            </div>
            <div>
                <label for='descricao'>Descrição:</label>
                <textarea id='descricao' name='descricao' required></textarea>
            </div>
            <div>
                <label for='logo'>Logo:</label>
                <input type='file' id='logo' name='logo' accept='image/*'>
            </div>
            <button type='submit'>Cadastrar</button>
        </form>
        ";
    }

    // Método para exibir a lista de categorias em uma tabela
    public function exibirListaCategorias($categorias)
    {
        echo "<div style='place-items: center; display: grid;' >";
        echo "<button type='submit' onclick=\"window.location.href='categoria.php?action=new'\">Inserir Categoria</button>";
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
            <h2>Editar Categoria</h2>
            <form action='categoria.php' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id' value='{$categoria->getId()}'>
               
                <div >
                    <label for='nome'>Nome:</label>
                    <input type='text' id='nome' name='nome' required value='{$categoria->getNome()}'>
                </div>
                <div >
                    <label for='descricao'>Descrição:</label>
                    <textarea id='descricao' name='descricao' required>{$categoria->getDescricao()}</textarea>
                </div>
                <div >
                    <label for='logo'>Logo:</label>
                    <input type='file' id='logo' name='logo' accept='image/*' value='{$categoria->getLogo()}'>
                </div>
                <button type='submit'>Atualizar</button>
            </form>
        ";
    }


    // Outros métodos relacionados à visualização da categoria podem ser adicionados aqui
}
