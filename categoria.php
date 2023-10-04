<?php
include_once 'app/models/Categoria.php';
include_once 'app/views/CategoriaView.php';
include_once 'app/controllers/CategoriaController.php';

// Inclui o cabeçalho
include_once 'includes/header.php';

?>
<div class="title">Categorias</div>

<?php
// Instanciar classes
$categoriaController = new CategoriaController();
$categoriaView = new CategoriaView();

// Verifica se algum formulário foi submetido e realiza as ações correspondentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'new') {
        // Captura dos dados do formulário
        $id = null;
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco

        // Criação de uma instância da classe Categoria com os dados do formulário
        $categoria = new Categoria($id, $nome, $descricao, $logo);

        // Tenta cadastrar a categoria
        if ($categoria->cadastrar()) {
            echo "<div style='text-align: center;' ><b style='color:green;'>Categoria cadastrada com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;' ><b style='color:red;'>Ocorreu um erro ao cadastrar a categoria.</b></div><br><br>";
        }
    }

    if ($_POST['action'] === 'edit') {
        // Captura dos dados do formulário
        $id = $_POST['id']; // ID da categoria a ser atualizada
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $logo = isset($_POST['logo']) ? $_POST['logo'] : null;  // Define logo como null caso esteja em branco

        // Criação de uma instância da classe Categoria com os dados do formulário
        $categoria = new Categoria($id, $nome, $descricao, $logo);

        // Tenta atualizar a categoria
        if ($categoria->atualizar()) {
            echo "<div style='text-align: center;'><b style='color:green;'>Categoria atualizada com sucesso.</b></div><br><br>";
        } else {
            echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao atualizar a categoria.</b></div><br><br>";
        }
    }
}

// Obém a ação que será realizada (caso edição, novo cadastro ou apagar)
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'new':
        $categoriaView->exibirFormularioCadastro();
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $categoriaId = $_GET['id'];
            $categoria = $categoriaController->obterCategoriaPorId($categoriaId);
            $categoriaView->exibirFormularioEdicao($categoria);
        } else {
            echo "ID da categoria não especificado.";
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $categoriaId = $_GET['id'];
            $categoria = $categoriaController->obterCategoriaPorId($categoriaId);

            try {
                $categoria->deletar();
                echo "<div style='text-align: center;' ><b style='color:green;'>Categoria -- {$categoria->getNome()} -- excluída com sucesso!</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='categoria.php'>Voltar</a></div>";
            } catch (\Throwable $th) {
                echo "<div style='text-align: center;'><b style='color:red;'>Ocorreu um erro ao tentar excluir a categoria.</b></div><br><br>";
                echo "<div style='text-align: center;' ><a href='categoria.php'>Voltar</a></div>";
                throw $th;
            }
        } else {
            echo "ID da categoria não especificado.";
        }
        break;

    default:
        $categorias = $categoriaController->obterTodasCategorias();
        $categoriaView->exibirListaCategorias($categorias);
        break;
}

// Inclui o rodapé
include_once 'includes/footer.php';
?>