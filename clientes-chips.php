<?php
include('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from chip where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<input type="text" class="hidden" id="id" value="'.$id.'"/>
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
              <th>CHIP</th>
              <th>ICC</th>
              <th>Número</th>
              <th>Veículo</th>
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
      <form class="forms-sample" id="formCadastrar" method="post">
      <input type="text" class="hidden" name="idcliente" value="'.$id.'"/>
      <div class="modal-body">      
        <div class="row">
          <label class="col-md-12 col-sm-12">Chip
            <select type="text" class="form-control" name="chip">
              <option value="">selecione</option>';
                $sql1 = mysqli_query($conexao,"select * from produto order by operadora asc");
                while($r = mysqli_fetch_array($sql1)){ echo'<option value="'.$r['id'].'">'.$r['operadora'].'</option>'; }
              echo'
            </select>
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

        <div class="row">
          <label class="col-md-6 col-sm-12">APN
          <input type="text" class="form-control" name="apn"/>
          </label>
          <label class="col-md-6 col-sm-12">UF
            <input type="text" class="form-control" name="estado" minlength="2" maxlength="2"/>
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
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="retornoChips">    
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
$('.clientes-chips').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  let id = $('#id').val();
  $.get('clientes-chips-tab.php',{id:id},function(data){ 
    $('#tabela').show().html(data);
  });
  return false;
};
//cadastrar
$('#formCadastrar').submit(function(){
  $('#cadastrar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'clientes-chips-update.php',
      data:$('#formCadastrar').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data); 
      tabela(); 
      }
  });
  return false;
});

//alterar
function alterarChip(id){
  $('#processando').modal('show');
  $('#alterar').modal('show');
  $.get('clientes-chips-retorno.php',{id:id},function(data){
    $('#processando').modal('hide');
    $('#retornoChips').show().html(data);
  });
  return false;
}
$('#formAlterar').submit(function(){
  $('#alterar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'clientes-chips-update.php',
      data:$('#formAlterar').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data); 
      tabela(); 
      }
  });
  return false;
});
//excluir
function excluirChip(id){
  var r = confirm('Deseja excluir?');
  if(r == true){
    $('#processando').modal('show');
    $.get('clientes-chips-excluir.php',{id:id},function(data){
      $('#processando').modal('hide');
      $('#retorno').show().fadeOut(2500).html(data);
      tabela();
    });
  return false;
  }
}
</script>