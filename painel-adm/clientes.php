<?php
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'clientes';

require_once($pagina . "/campos.php");
?>

<div class="col-md-12 my-4">
    <a href="#" onclick="inserir()" type="button" class="btn btn-dark">Novo Cliente</a>
</div>

<div class="tabela bg-light" id="listar">

</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Inserir Registro</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="<?= $campo1 ?>" class="form-label"><?= $campo1 ?></label>
                        <input type="text" class="form-control" id="<?= $campo1 ?>" name="<?= $campo1 ?>" placeholder="<?= $campo1 ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="<?= $campo2 ?>" class="form-label"><?= $campo2 ?></label>
                        <input type="text" class="form-control cpf-mask" id="<?= $campo2 ?>" name="<?= $campo2 ?>" placeholder="<?= $campo2 ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="<?= $campo3 ?>" class="form-label"><?= $campo3 ?></label>
                        <input type="tel" class="form-control telefone-mask" id="<?= $campo3 ?>" name="<?= $campo3 ?>" placeholder="<?= $campo3 ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                        <textarea class="form-control" id="<?= $campo4 ?>" name="<?= $campo4 ?>" placeholder="Observação" rows="3"></textarea>
                    </div>

                    <small>
                        <div id="mensagem" align="center"></div>
                    </small>

                    <input type="hidden" id="id" name="id">

                </div>
                <div class="modal-footer">
                    <button id="btn-fechar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Excluir Registro</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-excluir" method="post">
                <div class="modal-body">

                    Deseja realmente excluir o registro: <span id="nome-excluido"></span> ?
                    <br><br>
                    <small>
                        <div id="mensagem-excluir" align="center"></div>
                    </small>

                    <input type="hidden" id="id-excluir" name="id-excluir">

                </div>
                <div class="modal-footer">
                    <button id="btn-fechar-excluir" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var pag = "<?= $pagina ?>";
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    //Macaras dos campos de cadastro de Cliente
    $('.telefone-mask').mask("(99) 99999-9999");
    $('.cpf-mask').mask("999.999.999-99");
</script>
<script src="../js/ajax.js"></script>