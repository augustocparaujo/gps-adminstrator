<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from cliente where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
//número de os
$query = mysqli_query($conexao, "SELECT * FROM atendimento WHERE idcliente='$id'") or die(mysqli_error($conexao));

echo '
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
              <th>Tipo</th>
              <th>Forma</th>
              <th>Agendado</th>
              <th>Período</th>
              <th>Produto</th>
              <th>QUANT</th>
              <th>Situação</th>
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
      <div class="modal-body"> 

      <div class="row">
      <input type="hidden" name="idcliente" id="idcliente" value="' . @$id . '"/>

        <label class="col-md-6 col-sm-12">N° OS
          <input type="text" class="form-control" name="os" value="' . @$numeroos . '"readonly/>
        </label>
        <label class="col-md-6 col-sm-12">Cliente
          <input type="text" class="form-control" name="idcliente" value="' . @$id . '"readonly/>
        </label>          
      </div>
      
        <div class="row">
        <label class="col-md-6 col-sm-12">Número
          <input type="text" class="form-control" name="numero" required/>
        </label>
        <label class="col-md-6 col-sm-12">ICC
          <input type="text" class="form-control" name="icc"/>
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

include_once('rodape.php');
?>
<script>
  $('.clientes').addClass('active');
  $('.clientes-atendimento').addClass('ativo2');
  //tabela
  $().ready(function() {
    tabela();
  });

  function tabela() {
    let id = $('#idcliente').val();
    $.get('clientes-atendimento-tab.php', {
      id: id
    }, function(data) {
      $('#tabela').show().html(data);
    });
    return false;
  }
</script>