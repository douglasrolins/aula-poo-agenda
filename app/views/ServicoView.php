<?php

class ServicoView
{
    // Método para exibir o formulário de cadastro do serviço
    public function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro de serviço
        echo "
        <h3 class='subtitle'>Novo Serviço</h3>
        <form action='servico.php' method='post' enctype='multipart/form-data' class='categoria-form'>
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
            <div class='form-group'>
                <label for='preco'>Preço:</label>
                <input type='number' id='preco' name='preco' class='form-control' required'>
            </div>
            <div class='form-group'>
                <label for='tempo'>Tempo:</label>
                <input type='number' id='tempo' name='tempo' class='form-control' required>
             </div>
            <button type='submit' class='btn btn-primary'>Cadastrar</button>
        </form>
        ";
    }

    // Método para exibir a lista de serviços em uma tabela
    public function exibirListaServicos($servicos)
    {
        $base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
        echo "<div style='place-items: center; display: grid;' >";
        echo "<button type='submit' class='btn btn-primary' onclick=\"window.location.href='servico.php?action=new'\">Inserir Serviço</button>";
        echo "<h3>Lista de Serviços</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Descrição</th><th>Logo</th><th>Preço</th><th>Tempo</th><th>Ações</th></tr>";
        foreach ($servicos as $servico) {
            echo "<tr>";
            echo "<td>{$servico->getNome()}</td>";
            echo "<td>{$servico->getDescricao()}</td>";
            echo "<td> <img src={$base_url}{$servico->getLogo()} width=30px> </td>";
            echo "<td>{$servico->getPreco()}</td>";
            echo "<td>{$servico->getTempo()}</td>";
            echo "<td><a href='servico.php?action=edit&id={$servico->getId()}'>Editar</a> <a href='servico.php?action=delete&id={$servico->getId()}' onclick='return confirmarExclusao()'>Apagar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    public function exibirFormularioEdicao($servico)
    {
        echo "
            <h2 class='subtitle'>Editar Serviço</h2>
            <form action='servico.php' method='post' enctype='multipart/form-data' class='categoria-form'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id' value='{$servico->getId()}'>
               
                <div class='form-group'>
                    <label for='nome'>Nome:</label>
                    <input type='text' id='nome' name='nome' class='form-control' required value='{$servico->getNome()}'>
                </div>
                <div class='form-group'>
                    <label for='descricao'>Descrição:</label>
                    <textarea id='descricao' name='descricao' class='form-control' required>{$servico->getDescricao()}</textarea>
                </div>
                <div class='form-group'>
                    <label for='logo'>Logo:</label>
                    <input type='file' id='logo' name='logo' class='form-control' accept='image/*' value='{$servico->getLogo()}'>
                </div>
                <div class='form-group'>
                    <label for='preco'>Preço:</label>
                    <input type='number' id='preco' name='preco' class='form-control' required value='{$servico->getPreco()}'>
                </div>

                <div class='form-group'>
                    <label for='tempo'>Tempo:</label>
                    <input type='number' id='tempo' name='tempo' class='form-control' required value='{$servico->getTempo()}'>
                </div>

                <button type='submit' class='btn btn-primary'>Atualizar</button>
            </form>
        ";
    }


    // Outros métodos relacionados à visualização dos serviços podem ser adicionados aqui
}
