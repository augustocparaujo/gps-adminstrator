<?php
include_once('topo.php');
echo '
<div class="content-wrapper">   
  <div class="row">
  <!--aqui-->

  <div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mb-0">Fornecedor</h4>
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>                        
      <table class="table table-striped w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Contato</th>
            <th>Material</th>
            <th>#</th>
          </tr>
        </thead>
        <tbody id="tabela"></tbody>
      </table>
    </div>
  </div>
</div>

    <!--aqui-->
  </div>
</div><!-- content-wrapper ends -->

<!-- Modal -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post">
      <div class="modal-body">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" placeholder="Nome" name="nome" required/>
        </div>
        <div class="form-group">
            <label>Contato</label>
            <input type="text" class="form-control celular" placeholder="(99)99999-9999" name="contato"/>
        </div>
        <div class="form-group">
            <label>Material</label>
            <input type="text" class="form-control" placeholder="Cabo,Chip,Fusível,etc" name="material"/>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>

<!-- Modal retorno-->
<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="retornoFornecedor">
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
  //marcar menu
  $('.estoque', '.fornecedor').addClass('active');
  //tabela
  $(function() {
    tabela();
  });

  function tabela() {
    $.ajax({
      type: 'post',
      url: 'fornecedor-tabela.php',
      data: 'html',
      success: function(data) {
        $('#tabela').show().html(data);
      }
    });
    return false;
  }
  //cadastrar
  $('#formCadastrar').submit(function() {
    $('#cadastrar').modal('hide');
    $.ajax({
      type: 'post',
      url: 'fornecedor-update.php',
      data: $('#formCadastrar').serialize(),
      success: function(data) {
        $('#retorno').show().fadeOut(5000).html(data);
        tabela();
      }
    });
    return false;
  });
  //alterar plano
  function alterar(id) {
    $('#alterar').modal('show');
    $.get('fornecedor-retorno.php', {
      id: id
    }, function(data) {
      $('#retornoFornecedor').show().html(data);
    });
    return false;
  }
  //cadastrar
  $('#formAlterar').submit(function() {
    $('#alterar').modal('hide');
    $.ajax({
      type: 'post',
      url: 'fornecedor-update.php',
      data: $('#formAlterar').serialize(),
      success: function(data) {
        $('#retorno').show().fadeOut(5000).html(data);
        tabela();
      }
    });
    return false;
  });
</script>