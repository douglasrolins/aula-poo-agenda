<?php
include_once 'app/models/Servico.php';
include_once 'app/views/ServicoView.php';
include_once 'app/controllers/ServicoController.php';

// Inclui o cabeçalho
include_once 'includes/header.php';

?>
<div class="title">Serviços</div>

<?php
// Instanciar classes
$servicoController = new ServicoController();
$servicoView = new ServicoView();

// Verifica se algum formulário foi submetido e realiza as ações correspondentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'new') {
        // Captura dos dados do formulário
        $id = null;
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco
        $preco = $_POST['preco'];
        $tempo = $_POST['tempo'];

        // Criação de uma instância da classe Serviço com os dados do formulário
        $servico = new Servico($id, $nome, $descricao, $logo, $preco, $tempo);

        // Tenta cadastrar o servico
        if ($servico->cadastrar()) {
            echo "<div style='text-align: center;' ><b style='color:green;'>Serviço cadastrado com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;' ><b style='color:red;'>Ocorreu um erro ao cadastrar o servico.</b></div><br><br>";
        }
    }

    if ($_POST['action'] === 'edit') {
        // Captura dos dados do formulário
        $id = $_POST['id']; // ID do serviço a ser atualizada
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco
        $preco = $_POST['preco'];
        $tempo = $_POST['tempo'];

        // Criação de uma instância da classe Serviço com os dados do formulário
        $servico = new Servico($id, $nome, $descricao, $logo, $preco, $tempo);

        // Tenta atualizar o serviço
        if ($servico->atualizar()) {
            echo "<div style='text-align: center;'><b style='color:green;'>Serviço atualizado com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao atualizar o serviço.</b></div><br><br>";
        }
    }
}

// Obém a ação que será realizada (edição, novo cadastro ou apagar)
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'new':
        $servicoView->exibirFormularioCadastro();
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $servicoId = $_GET['id'];
            $servico = $servicoController->obterServicoPorId($servicoId);
            $servicoView->exibirFormularioEdicao($servico);
        } else {
            echo "ID do serviço não especificado.";
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $servicoId = $_GET['id'];
            $servico = $servicoController->obterServicoPorId($servicoId);

            try {
                $servico->deletar();
                echo "<div style='text-align: center;' ><b style='color:green;'>Serviço -- {$servico->getNome()} -- excluído com sucesso!</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='servico.php'>Voltar</a></div>";
            } catch (\Throwable $th) {
                echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao tentar excluir o serviço.</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='servico.php'>Voltar</a></div>";
                throw $th;
            }
        } else {
            echo "ID do serviço não especificado.";
        }
        break;

    default:
        $servicos = $servicoController->obterTodosServicos();
        $servicoView->exibirListaServicos($servicos);
        break;
}

// Inclui o rodapé
include_once 'includes/footer.php';
?>