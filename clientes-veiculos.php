<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from cliente where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo '
<input type="text" class="hidden" id="id" value="' . $id . '"/>
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
include_once('clientes-tab.php');
echo '
        <div class="d-flex justify-content-between">
        <h4 class="card-title mb-0"></h4>
          <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>

          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Cor</th>
                <th>Ano</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody id="tabela"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->';

echo '
<!-- Modal -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post">
      <input type="text" class="hidden" name="idcliente" value="' . $id . '"/>
      <div class="modal-body">

        <div class="row">
          <label class="col-md-6 col-sm-12">Placa
          <input type="text" class="form-control caixaalta" name="placa"/>
          </label>
          <label class="col-md-6 col-sm-12">Marca
            <input type="text" class="form-control caixaalta" name="marca"/>
          </label>
        </div>

        <div class="row">
          <label class="col-md-6 col-sm-12">Modelo
          <input type="text" class="form-control caixaalta" name="modelo"/>
          </label>
          <label class="col-md-6 col-sm-12">Ano
            <input type="text" class="form-control" name="ano"/>
          </label>
        </div>

        <div class="row">
          <label class="col-md-6 col-sm-12">Cor
          <input type="text" class="form-control caixaalta" name="cor"/>
          </label>
          <label class="col-md-6 col-sm-12">Chassi
            <input type="text" class="form-control" name="chassi"/>
          </label>
        </div>

        <div class="row">
          <label class="col-md-6 col-sm-12">Renavam
          <input type="text" class="form-control" name="renavam"/>
          </label>
          <label class="col-md-6 col-sm-12">Cidade
            <input type="text" class="form-control caixaalta" name="cidade"/>
          </label>
        </div>

        <div class="row">
        <label class="col-md-12 col-sm-12">Observação
          <textarea row="3" class="form-control" name="obs"></textarea>
        </label>
        </div>          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>';

echo '
<!-- Modal -->
<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="retornoVeiculo">         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>';

include_once('rodape.php');
?>
<script>
  $('.clientes').addClass('active');
  $('.clientes-veiculos').addClass('ativo2');
  //tabela
  $(function() {
    tabela();
  });

  function tabela() {
    let id = $('#id').val();
    $.get('clientes-tab-veiculos.php', {
      id: id
    }, function(data) {
      $('#tabela').show().html(data);
    });
    return false;
  };
  //cadastrar
  $('#formCadastrar').submit(function() {
    $('#cadastrar').modal('hide');
    $.ajax({
      type: 'post',
      url: 'clientes-veiculos-update.php',
      data: $('#formCadastrar').serialize(),
      success: function(data) {
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      }
    });
    return false;
  });
  //alterar
  function alterarVeiculo(id) {
    $('#alterar').modal('show');
    $.get('clientes-veiculos-retorno.php', {
      id: id
    }, function(data) {
      $('#retornoVeiculo').show().html(data);
    });
    return false;
  }
  $('#formAlterar').submit(function() {
    $('#alterar').modal('hide');
    $.ajax({
      type: 'post',
      url: 'clientes-veiculos-update.php',
      data: $('#formAlterar').serialize(),
      success: function(data) {
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      }
    });
    return false;
  });
  //excluir
  function excluirVeiculo(id) {
    $.get('clientes-veiculos-excluir.php', {
      id: id
    }, function(data) {
      $('#retorno').show().fadeOut(2500).html(data);
      tabela();
    });
    return false;
  }
</script>