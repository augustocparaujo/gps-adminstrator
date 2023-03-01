<?php
include('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from cliente where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
        include('clientes-tab.php'); echo'
        <div class="d-flex justify-content-between">
        <h4 class="card-title mb-0"></h4>
          <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>
          <table class="table table-striped w-100">
          <thead>
            <tr>
              <th>#</th>
              <th>Tipo</th>
              <th>Descrição</th>
              <th>IMG</th>
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

echo'
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
      <form class="forms-sample" id="formCadastrar" method="post" enctype="multipart/form-data">
      <input type="text" class="hidden" id="id" name="idcliente" value="'.$id.'"/>
      <div class="modal-body">   
      
        <div class="row">
          <label class="col-md-6 col-sm-12">Tipo
            <select type="text" class="form-control" id="tipo" name="tipo">
              <option value="observação">observação</option>
              <option value="documento">documento</option>
            </select>
          </label>
        </div>   

        <div class="row">
          <label class="col-md-12 col-sm-12">Descrição
            <textarea row="3" class="form-control" name="descricao" required></textarea>
          </label>
        </div>
        
        <div class="row">
          <label class="col-md-12 col-sm-12">Documento
            <input type="file" class="form-control" name="arquivo" accept="image/jpg,image/jpeg,image/png,application/pdf"/>
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

echo'
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
      <form class="forms-sample" id="formAlterar" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="retornoObs">    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>';

include('rodape.php');
?>
<script>
$('.clientes').addClass('active');
$('.clientes-observacoes').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  let id = $('#id').val();
  $.get('clientes-observacoes-tab.php',{id:id},function(data){ 
    $('#tabela').show().html(data);
  });
  return false;
};
//cadastrar
$('#formCadastrar').submit(function(){
  $('#cadastrar').modal('hide');
  $('#processando').modal('show');
    var formData = new FormData(this);
  $.ajax({
      type:'post',
      url:'clientes-observacoes-update.php',
      data:formData,
      success:function(data){ 
          $('#processando').modal('hide');
          $('#retorno').show().fadeOut(2500).html(data);
          $('#formCadastrar').each(function(){this.reset();});
      tabela(); 
      },
    cache: false,
    contentType: false,
    processData: false,
  });
  return false;
});

//form-enviaroficio
//alterar
function alterar(id){
  $('#alterar').modal('show');
  $('#processando').modal('show');
  $.get('clientes-observacoes-retorno.php',{id:id},function(data){
      $('#processando').modal('hide');
    $('#retornoObs').show().html(data);
  });
  return false;
}
$('#formAlterar').submit( function(){
    $('#alterar').modal('hide');
    $('#processando').modal('show');
  var formData = new FormData(this);
  $.ajax({
    type:'POST',
    url:'clientes-observacoes-update.php',
    data: formData,
    success:function(data){
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
    },
    cache: false,
    contentType: false,
    processData: false,
  });
  return false;
});
//excluir
function excluir(id){
  var r = confirm("Desejar excluir?");
  if(r == true) {
    $('#processando').modal('show');
      $.get('clientes-observacoes-excluir.php',{id:id},function(data){
          $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        tabela();
      });
    return false;
  }
}
</script>