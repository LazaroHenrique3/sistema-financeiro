<?php
@session_start();
require_once("../conexao.php");
require_once("verificar.php");

//Recuperar dados do usuário logado

$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM usuarios WHERE id = '{$id_usuario}'";

$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nome_usuario = $result[0]['nome'];
$email_usuario = $result[0]['email'];
$nivel_usuario = $result[0]['nivel'];

//Menus do painel
$menu1 =  'home';
$menu2 =  'clientes';
$menu3 =  'niveis';
$menu4 =  'usuarios';
$menu5 =  'produtos';
$menu6 =  'categorias';
$menu7 =  'marcas';
$menu8 =  'vendas';


if (@$_GET['pag'] == "") {
    $pagina = $menu1;
} else {
    $pagina = $_GET['pag'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css" />
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    
    <title><?= $nome_sistema ?></title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?pag=<?= $menu1 ?>"><img src="../img/logo.png" alt="logo" width="40px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?pag=<?= $menu1 ?>">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastros
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu2 ?>">Clientes</a></li>

                            <?php if ($_SESSION['nivel_usuario'] == 'Administrador') { ?>
                                <li><a class="dropdown-item" href="index.php?pag=<?= $menu4 ?>">Usuários</a></li>
                            <?php } ?>

                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu5 ?>">Produtos</a></li>

                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu3 ?>">Níveis de Usuários</a></li>

                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu6 ?>">Categorias de Produto</a></li>

                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu7 ?>">Marcas de Produto</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Movimentações
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?pag=<?= $menu8 ?>">Venda</a></li>
                        </ul>
                    </li>

                </ul>
                <div class="d-flex"> 
                    <img class="img-profile rounded-circle" src="../img/user.png" alt="user-logo" width="40px" height="40px">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $nome_usuario ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">Editar Dados</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!--Onde vai ser alocado o conteúdo da página-->
    <div class="container mb-4">
        <?php
        require_once($pagina . '.php')
        ?>
    </div>

</body>

</html>

<!-- Modal -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-perfil" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome-usuario" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome-usuario" name="nome-usuario" value="<?= $nome_usuario ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email-usuario" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-usuario" name="email-usuario" value="<?= $email_usuario ?>">
                    </div>

                    <div class="mb-3">
                        <label for="senha-usuario" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha-usuario" name="senha-usuario" placeholder="Nova senha">
                    </div>

                    <small>
                        <div id="mensagem-perfil" align="center"></div>
                    </small>

                    <input type="hidden" id="id-usuario" name="id-usuario" value="<?= $id_usuario ?>">

                </div>
                <div class="modal-footer">
                    <button id="btn-fechar-perfil" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajax para inserir ou editar dados -->
<script type="text/javascript">
    let pagina = '<?= $pagina ?>';

    $("#form-perfil").submit(function() {
        //Para não atualizar a página
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "editar-perfil.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem-perfil').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag=" + pagina;
                } else {
                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)
            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>