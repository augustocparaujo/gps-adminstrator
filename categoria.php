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
            <h4 class="card-title mb-0">Categoria</h4>
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
</div><!-- content-wrapper ends -->';

echo '
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
        <div class="row">
          <label class="col-md-12 col-sm-12">Descrição
            <input type="text" class="form-control" name="descricao" required/>
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="retornoCategoria">    
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
  $('.estoque', '.categoria').addClass('active');
  //tabela
  $(function() {
    tabela();
  });

  function tabela() {
    $.get('categoria-tab.php', function(data) {
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
      url: 'categoria-update.php',
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
    $.get('categoria-retorno.php', {
      id: id
    }, function(data) {
      $('#processando').modal('hide');
      $('#retornoCategoria').show().html(data);
    });
    return false;
  }
  $('#formAlterar').submit(function() {
    $('#alterar').modal('hide');
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'categoria-update.php',
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
      $.get('categoria-excluir.php', {
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