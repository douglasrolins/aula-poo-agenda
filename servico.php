<?php
include_once 'app/models/Servico.php';
include_once 'app/views/ServicoView.php';
include_once 'app/controllers/ServicoController.php';

include_once 'app/controllers/EmpresaController.php';

// Inclui o cabeçalho
include_once 'includes/header.php';

?>
<div class="title"><h1>Serviços</h1></div>

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
        //$logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco
        $valor = $_POST['valor'];
        $tempo = $_POST['tempo'];
        $empresa_id = $_POST['empresa_id'];

        // Verifica se um arquivo de imagem foi enviado
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Define o diretório de destino onde a imagem será salva
            $diretorioDestino = __DIR__ . '/includes/img/';

            // Obtém o nome do arquivo enviado
            $nomeArquivo = $_FILES['logo']['name'];

            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $diretorioDestino . $nomeArquivo)) {
                // O arquivo foi carregado com sucesso
                //echo 'Imagem carregada com sucesso.';
                $urlImagem = '/includes/img/' . $nomeArquivo; 
                $logo = $urlImagem;
                // Agora, você pode salvar o nome do arquivo no banco de dados ou realizar outras ações necessárias.
            } else {
                // Ocorreu um erro ao mover o arquivo
                echo 'Erro ao carregar a imagem.';
            }
        } else {
            // Nenhum arquivo de imagem enviado
            //echo 'Nenhuma imagem foi enviada.';
            $logo = null;
        }

        // Criação de uma instância da classe Serviço com os dados do formulário
        $servico = new Servico($id, $nome, $logo, $valor, $tempo, $empresa_id);

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
        //$logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco
        $valor = $_POST['valor'];
        $tempo = $_POST['tempo'];
        $empresa_id = $_POST['empresa_id'];

        // Verifica se um arquivo de imagem foi enviado
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Define o diretório de destino onde a imagem será salva
            $diretorioDestino = __DIR__ . '/includes/img/';

            // Obtém o nome do arquivo enviado
            $nomeArquivo = $_FILES['logo']['name'];

            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $diretorioDestino . $nomeArquivo)) {
                // O arquivo foi carregado com sucesso
                //echo 'Imagem carregada com sucesso.';
                $urlImagem = '/includes/img/' . $nomeArquivo; 
                $logo = $urlImagem;
                // Agora, você pode salvar o nome do arquivo no banco de dados ou realizar outras ações necessárias.
            } else {
                // Ocorreu um erro ao mover o arquivo
                echo 'Erro ao carregar a imagem.';
            }
        } else {
            // Nenhum arquivo de imagem enviado
            //echo 'Nenhuma imagem foi enviada.';
            $logo = null;
        }

        // Criação de uma instância da classe Serviço com os dados do formulário
        $servico = new Servico($id, $nome, $logo, $valor, $tempo, $empresa_id);

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
        $empresaController = new EmpresaController();
        $empresas = $empresaController->obterTodasEmpresas();
        $servicoView->exibirFormularioCadastro($empresas);
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $servicoId = $_GET['id'];
            $servico = $servicoController->obterServicoPorId($servicoId);
            $empresaController = new EmpresaController();
            $empresas = $empresaController->obterTodasEmpresas();
            $servicoView->exibirFormularioEdicao($servico,$empresas);
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