<?php

class ServicoView
{

    private $base_url;

    public function __construct()
    {
        $this->base_url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/';
    }


    // Método para exibir o formulário de cadastro do serviço
    public function exibirFormularioCadastro($empresas)
    {
        // HTML para o formulário de cadastro de serviço
        echo "
        <h3>Novo Serviço</h3>
        <form action='servico.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='action' value='new'>
            <div>
                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' required>
            </div>
            <div>
                <label for='logo'>Logo:</label>
                <input type='file' id='logo' name='logo' accept='image/*'>
            </div>
            <div>
                <label for='valor'>Preço:</label>
                <input type='number' id='valor' name='valor' required'>
            </div>
            <div>
                <label for='tempo'>Tempo:</label>
                <input type='number' id='tempo' name='tempo' required>
             </div>

             <div>
             <label for='empresa_id'>Empresa:</label>
             <select id='empresa_id' name='empresa_id' required>
                 <option value=''>Selecione a empresa</option>";
        foreach ($empresas as $empresa) {
            echo "<option value='{$empresa->getId()}'>{$empresa->getNome()}</option>";
        }
        echo "
             </select>
             </div>
            <button type='submit'>Cadastrar</button>
        </form>
        ";
    }

    // Método para exibir a lista de serviços em uma tabela
    public function exibirListaServicos($servicos)
    {
        
        echo "<div style='place-items: center; display: grid;' >";
        echo "<button type='submit' onclick=\"window.location.href='servico.php?action=new'\">Inserir Serviço</button>";
        echo "<h3>Lista de Serviços</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Logo</th><th>Preço</th><th>Tempo</th><th>Empresa</th><th>Ações</th></tr>";
        foreach ($servicos as $servico) {
            echo "<tr>";
            echo "<td>{$servico->getNome()}</td>";
            echo "<td> <img src={$this->base_url}{$servico->getLogo()} width=30px> </td>";
            echo "<td>{$servico->getValor()}</td>";
            echo "<td>{$servico->getTempo()}</td>";
            echo "<td>{$servico->getEmpresaId()}</td>";
            echo "<td><a href='servico.php?action=edit&id={$servico->getId()}'>Editar</a> <a href='servico.php?action=delete&id={$servico->getId()}' onclick='return confirmarExclusao()'>Apagar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    public function exibirFormularioEdicao($servico, $empresas)
    {
        echo "
            <h2>Editar Serviço</h2>
            <form action='servico.php' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id' value='{$servico->getId()}'>
               
                <div>
                    <label for='nome'>Nome:</label>
                    <input type='text' id='nome' name='nome' required value='{$servico->getNome()}'>
                </div>
                <div >
                    <label for='logo_atual'>Logo atual:</label>
                    <img src={$this->base_url}{$servico->getLogo()} width=30px>
                    <input type='text' id='logo_atual' name='logo_atual' readonly value='{$servico->getLogo()}'>
                </div>
                <div>
                    <label for='logo'>Escolher nova Logo:</label>
                    <input type='file' id='logo' name='logo' accept='image/*'}'>
                </div>
                <div>
                    <label for='valor'>Valor:</label>
                    <input type='number' id='valor' name='valor' required value='{$servico->getValor()}'>
                </div>

                <div>
                    <label for='tempo'>Tempo:</label>
                    <input type='number' id='tempo' name='tempo' required value='{$servico->getTempo()}'>
                </div>

                <div>
                <label for='empresa_id'>Empresa:</label>
                <select id='empresa_id' name='empresa_id' required>
                    <option value=''>Selecione a empresa</option>";
        foreach ($empresas as $empresa) {
            $selected = ($empresa->getId() == $servico->getEmpresaId()) ? 'selected' : '';
            echo "<option value='{$empresa->getId()}' $selected>{$empresa->getNome()}</option>";
        }
        echo "
                </select>
                </div>

                <button type='submit'>Atualizar</button>
            </form>
        ";
    }


    // Outros métodos relacionados à visualização dos serviços podem ser adicionados aqui
}
