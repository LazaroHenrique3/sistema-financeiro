<?php
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'vendas';

require_once($pagina . "/campos.php");
?>

<div class="col-md-12 my-4" data-bs-toggle="modal" data-bs-target="#modalForm">
    <a href="#" type="button" class="btn btn-dark">Nova Venda</a>
</div>

<div class="tabela bg-light" id="listar">

</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Inserir Registro</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
            </div>
            <form id="form" method="post">

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="<?= $campo1 ?>" class="d-block">
                            <?= $campo1 ?>
                        </label>
                        <small id="text-<?= $campo1 ?>"></small>
                        <select id="<?= $campo1 ?>" class="js-example-basic-single js-example-responsive form-select select" name="<?= $campo1 ?>" style="width: 100%" required>
                            <option value="selecione" selected disabled>Selecione</option>
                            <?php
                            $query = $pdo->query("SELECT * FROM clientes order by nome asc");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < @count($res); $i++) {
                                foreach ($res[$i] as $key => $value) {
                                }
                                $id_item = $res[$i]['id'];
                                $nome_item = $res[$i]['nome'];
                            ?>
                                <option <?php if (@$id_item == @$categoria) { ?> selected <?php } ?> value="<?php echo $id_item ?>">
                                    <?php echo $nome_item ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>

                    Adicionar Produtos
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="<?= $campo2 ?>" class="d-block">
                                    <?= $campo2 ?>
                                </label>
                                <small id="text-produto"></small>
                                <select id="<?= $campo2 ?>" class="js-example-basic-single js-example-responsive form-select select" name="<?= $campo2 ?>" style="width: 100%">
                                    <option selected disabled>Selecione</option>
                                    <?php
                                    $query = $pdo->query("SELECT * FROM produtos order by nome asc");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $id_item = $res[$i]['id'];
                                        $nome_item = $res[$i]['nome'];
                                    ?>
                                        <option <?php if (@$id_item == @$categoria) { ?> selected <?php } ?> value="<?php echo $id_item ?>">
                                            <?php echo $nome_item ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="number" class="form-control" id="qtdProdutos" name="qtdProdutos" min="0">
                                        <small>Quantidade <span id="alert-quant"></span> </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" onclick=" adicionarProduto()">Adicionar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Qtd</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-produtos">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" id="lista-produtos" name="lista-produtos[]">

                    <div class="mb-3">
                        <label for="<?= $campo3 ?>" class="d-block">Forma de Pagamento</label>
                        <small id="text-<?= $campo3 ?>"></small>
                        <select id="<?= $campo3 ?>" name="<?= $campo3 ?>" class="form-select form-select" aria-label=".form-select-sm example" required>
                            <option value="selecione" selected disabled>Selecione</option>
                            <option value="1">Dinheiro</option>
                            <option value="2">Pix</option>
                            <option value="3">Boleto</option>
                            <option value="4">C. Crédito</option>
                            <option value="5">C. Débito</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="<?= $campo5 ?>" class="form-label">
                            <?= $campo5 ?>
                        </label>
                        <input type="text" value="0" class="form-control" id="<?= $campo5 ?>" name="<?= $campo5 ?>" readonly required>
                    </div>

                    <small>
                        <div id="mensagem" align="center"></div>
                    </small>

                    <input type="hidden" id="id" name="id">

                </div>
                <div class="modal-footer">
                    <button id="btn-fechar" type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limparCampos()" >Cancelar</button>
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

<!-- Modal De Produtos da Compra -->
<div class="modal fade" id="verProdutos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Produtos</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Qtd</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-produtos-visualizar-detalhes">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../js/vendas.js"></script>
<script src="../js/ajax.js"></script>