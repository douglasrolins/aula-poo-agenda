<?php
include_once 'app/models/Empresa.php';
include_once 'app/views/EmpresaView.php';
include_once 'app/controllers/EmpresaController.php';

// Inclui o cabeçalho
include_once 'includes/header.php';

?>
<div><h1>Empresas</h1></div>

<?php
// Instanciar classes
$empresaController = new EmpresaController();
$empresaView = new EmpresaView();

// Verifica se algum formulário foi submetido e realiza as ações correspondentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'new') {
        // Captura dos dados do formulário
        $id = null;
        $nome = $_POST['nome'];
        $cnpj = $_POST['cnpj'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];

        // Criação de uma instância da classe Serviço com os dados do formulário
        $empresa = new Empresa($id, $nome, $cnpj, $endereco, $telefone);

        // Tenta cadastrar o empresa
        if ($empresa->cadastrar()) {
            echo "<div style='text-align: center;' ><b style='color:green;'>Empresa cadastrada com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;' ><b style='color:red;'>Ocorreu um erro ao cadastrar a empresa.</b></div><br><br>";
        }
    }

    if ($_POST['action'] === 'edit') {
        // Captura dos dados do formulário
        $id = $_POST['id']; // ID da empresa a ser atualizada
        $nome = $_POST['nome'];
        $cnpj = $_POST['cnpj'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];

        // Criação de uma instância da classe Serviço com os dados do formulário
        $empresa = new Empresa($id, $nome, $cnpj, $endereco, $telefone);

        // Tenta atualizar a empresa
        if ($empresa->atualizar()) {
            echo "<div style='text-align: center;'><b style='color:green;'>Empresa atualizada com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao atualizar a empresa.</b></div><br><br>";
        }
    }
}

// Obém a ação que será realizada (edição, novo cadastro ou apagar)
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'new':
        $empresaView->exibirFormularioCadastro();
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $empresaId = $_GET['id'];
            $empresa = $empresaController->obterEmpresaPorId($empresaId);
            $empresaView->exibirFormularioEdicao($empresa);
        } else {
            echo "ID da empresa não especificado.";
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $empresaId = $_GET['id'];
            $empresa = $empresaController->obterEmpresaPorId($empresaId);

            try {
                $empresa->deletar();
                echo "<div style='text-align: center;' ><b style='color:green;'>Empresa -- {$empresa->getNome()} -- excluído com sucesso!</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='empresa.php'>Voltar</a></div>";
            } catch (\Throwable $th) {
                echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao tentar excluir a empresa.</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='empresa.php'>Voltar</a></div>";
                throw $th;
            }
        } else {
            echo "ID da empresa não especificado.";
        }
        break;

    default:
        $empresas = $empresaController->obterTodasEmpresas();
        $empresaView->exibirListaEmpresas($empresas);
        break;
}

// Inclui o rodapé
include_once 'includes/footer.php';
?>