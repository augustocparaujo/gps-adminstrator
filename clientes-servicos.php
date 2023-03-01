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
                <th>Descrição</th>
                <th>Serviço</th>
                <th>Valor</th>
                <th>Usuário</th>
                <th>Data</th>
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
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post">
      <input type="text" class="hidden" id="id" name="idcliente" value="'.$id.'"/>
      <div class="modal-body">
      
        <div class="row">
        <label class="col-md-12 col-sm-12">Descrição
          <input type="text" class="form-control" name="descricao" required/>
        </label>
        </div>       

        <div class="row">
          <label class="col-md-12 col-sm-12">Serviço
            <select type="text" class="form-control" name="servico" required>
            <option value="">selecione</option>';
              //servicos
              $sql2 = mysqli_query($conexao,"select * from plano") or die (mysqli_error($conexao));
              while($dd2 = mysqli_fetch_array($sql2)){
                echo'<option value="'.$dd2['id'].'">'.$dd2['descricao'].'</option>';
              }
            echo'
            </select>
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
include('rodape.php');
?>
<script>
$('.clientes').addClass('active');
$('.clientes-servicos').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  let id = $('#id').val();
  $.get('clientes-tab-servicos.php',{id:id},function(data){ 
    $('#tabela').show().html(data);
  });
  return false;
};
//cadastrar
$('#formCadastrar').submit(function(){
  $('#cadastrar').modal('hide');
  $.ajax({
      type:'post',
      url:'clientes-servicos-update.php',
      data:$('#formCadastrar').serialize(),
      success:function(data){ $('#retorno').show().fadeOut(2500).html(data); 
      tabela(); 
      }
  });
  return false;
});
//excluir
function excluirServicos(id){
  $.get('clientes-servicos-excluir.php',{id:id},function(data){
    $('#retorno').show().fadeOut(2500).html(data);
    tabela();
  });
  return false;
}
</script>