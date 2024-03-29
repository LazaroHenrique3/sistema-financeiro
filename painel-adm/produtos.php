<?php
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'produtos';

require_once($pagina . "/campos.php");
?>

<div class="col-md-12 my-4">
    <a href="#" onclick="inserir()" type="button" class="btn btn-dark">Novo Produto</a>
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
                        <label for="exampleFormControlInput1" class="form-label"><?= $campo2 ?></label>
                        <select class="form-select" aria-label="Default select example" id="<?= $campo2 ?>" name="<?= $campo2 ?>" required>
                            <?php
                            $query = $pdo->query("SELECT * FROM categorias order by nome asc");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < @count($res); $i++) {
                                foreach ($res[$i] as $key => $value) {
                                }
                                $id_item = $res[$i]['id'];
                                $nome_item = $res[$i]['nome'];
                            ?>
                                <option <?php if (@$id_item == @$categoria) { ?> selected <?php } ?> value="<?php echo $id_item ?>"><?php echo $nome_item ?></option>

                            <?php } ?>


                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><?= $campo5 ?></label>
                        <select class="form-select" aria-label="Default select example" id="<?= $campo5 ?>" name="<?= $campo5 ?>" required>
                            <?php
                            $query = $pdo->query("SELECT * FROM marcas order by nome asc");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < @count($res); $i++) {
                                foreach ($res[$i] as $key => $value) {
                                }
                                $id_item = $res[$i]['id'];
                                $nome_item = $res[$i]['nome'];
                            ?>
                                <option <?php if (@$id_item == @$categoria) { ?> selected <?php } ?> value="<?php echo $id_item ?>"><?php echo $nome_item ?></option>

                            <?php } ?>


                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="<?= $campo3 ?>" class="form-label"><?= $campo3 ?></label>
                        <input type="number" class="form-control" id="<?= $campo3 ?>" name="<?= $campo3 ?>" min="0" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="<?= $campo4 ?>" class="form-label"><?= $campo4 ?></label>
                        <textarea class="form-control" id="<?= $campo4 ?>" name="<?= $campo4 ?>" placeholder="Descrição" rows="3"></textarea>
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
<script src="../js/ajax.js"></script>