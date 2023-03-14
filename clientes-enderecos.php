<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from endereco where idcliente='$id'") or die(mysqli_error($conexao));
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
              <th>Serviço</th>
              <th>Endereço</th>
              <th>Cidade</th>
              <th>Bairro</th>
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
        <label class="col-md-6 col-sm-12">CEP
        <input type="text" class="form-control cepBusca" name="cep"/>
        </label>
        <label class="col-md-6 col-sm-12">Endereço
        <input type="text" class="form-control enderecoBusca" name="endereco"/>
        </label>
        </div>

        <div class="row">
        <label class="col-md-6 col-sm-12">Bairro
        <input type="text" class="form-control bairroBusca" name="bairro"/>
        </label>
        <label class="col-md-6 col-sm-12">Cidade
        <input type="text" class="form-control cidadeBusca" name="cidade"/>
        </label>
        </div>

        <div class="row">
        <label class="col-md-6 col-sm-12">Estado
        <input type="text" class="form-control ufBusca" name="uf"/>
        </label>
        <label class="col-md-6 col-sm-12">Complemento
        <input type="text" class="form-control" name="complemento"/>
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
      <input type="text" class="hidden" name="idcliente" value="' . $id . '"/>
      <div class="modal-body" id="retornoEndereco">     

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
  $('.clientes-enderecos').addClass('ativo2');
  //tabela
  $(function() {
    tabela();
  });

  function tabela() {
    let id = $('#id').val();
    $.get('clientes-enderecos-tab.php', {
      id: id
    }, function(data) {
      $('#tabela').show().html(data);
    });
    return false;
  };

  //cadastrar
  $('#formCadastrar').submit(function() {
    $('#cadastrar').modal('hide');
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'clientes-enderecos-update.php',
      data: $('#formCadastrar').serialize(),
      success: function(data) {
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      }
    });
    return false;
  });

  //alterar
  function alterar(id) {
    $('#processando').modal('show');
    $('#alterar').modal('show');
    $.get('clientes-enderecos-retorno.php', {
      id: id
    }, function(data) {
      $('#processando').modal('hide');
      $('#retornoEndereco').show().html(data);
    });
    return false;
  }

  $('#formAlterar').submit(function() {
    $('#alterar').modal('hide');
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'clientes-enderecos-update.php',
      data: $('#formAlterar').serialize(),
      success: function(data) {
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      }
    });
    return false;
  });


  //excluir
  function excluir(id) {
    var r = confirm('Deseja excluir?');
    if (r == true) {
      $('#processando').modal('show');
      $.get('clientes-enderecos-excluir.php', {
        id: id
      }, function(data) {
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      });
      return false;
    }
  }
</script>