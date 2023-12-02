<?php

class EmpresaView
{
    // Método para exibir o formulário de cadastro da empresa
    public function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro de empresa
        echo "
        <h3>Nova Empresa</h3>
        <form action='empresa.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='action' value='new'>
            <div>
                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' required>
            </div>
            <div>
                <label for='cnpj'>CNPJ:</label>
                <input type='text' id='cnpj' name='cnpj'>
            </div>
            <div>
                <label for='endereco'>Endereço:</label>
                <input type='text' id='endereco' name='endereco'>
            </div>
            <div>
                <label for='telefone'>Telefone:</label>
                <input type='text' id='telefone' name='telefone'>
            </div>
            <button type='submit'>Cadastrar</button>
        </form>
        ";
    }

    // Método para exibir a lista de empresas em uma tabela
    public function exibirListaEmpresas($empresas)
    {
        $base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
        echo "<div style='place-items: center; display: grid;' >";
        echo "<button type='submit' onclick=\"window.location.href='empresa.php?action=new'\">Inserir Empresa</button>";
        echo "<h3>Lista de Empresas</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>CNPJ</th><th>Endereço</th><th>Telefone</th><th>Ações</th></tr>";
        foreach ($empresas as $empresa) {
            echo "<tr>";
            echo "<td>{$empresa->getNome()}</td>";
            echo "<td>{$empresa->getCNPJ()}</td>";
            echo "<td>{$empresa->getEndereco()}</td>";
            echo "<td>{$empresa->getTelefone()}</td>";
            echo "<td><a href='empresa.php?action=edit&id={$empresa->getId()}'>Editar</a> <a href='empresa.php?action=delete&id={$empresa->getId()}' onclick='return confirmarExclusao()'>Apagar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    public function exibirFormularioEdicao($empresa)
    {
        echo "
            <h2>Editar Empresa</h2>
            <form action='empresa.php' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id' value='{$empresa->getId()}'>
               
                <div>
                    <label for='nome'>Nome:</label>
                    <input type='text' id='nome' name='nome' required value='{$empresa->getNome()}'>
                </div>
                <div>
                    <label for='cnpj'>CNPJ:</label>
                    <input type='text' id='cnpj' name='cnpj' value='{$empresa->getCnpj()}'>
                </div>
                <div>
                    <label for='endereco'>Endereço:</label>
                    <input type='text' id='endereco' name='endereco' value='{$empresa->getEndereco()}'>
                </div>

                <div >
                    <label for='telefone'>Telefone:</label>
                    <input type='text' id='telefone' name='telefone' value='{$empresa->getTelefone()}'>
                </div>

                <button type='submit'>Atualizar</button>
            </form>
        ";
    }


    // Outros métodos relacionados à visualização das empresas podem ser adicionados aqui
}
