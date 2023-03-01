<?php
include('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from cliente where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
$dia = $dd['diavencimento'];
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
            <th>Vencimento</th>
            <th>Valor</th>
            <th>Data/Pag</th>
            <th>Valor/Pag</th>
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

echo'
<!-- Modal -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Gerar cobrança</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" method="post" id="gerarCobranca">
      <input type="text" class="hidden" id="id" name="idcliente" value="'.$id.'"/>
      <div class="modal-body">

        <label class="col-12">Serviço
          <select type="text" class="form-control" name="servico">';
          $sql = mysqli_query($conexao,"select servico.*, plano.descricao as descricaoservico from servico
          left join plano on servico.idservico = plano.id
          where servico.idcliente='$id' order by servico.id asc") or die (mysqli_error($conexao));
          while($dd = mysqli_fetch_array($sql)){echo'
              <option value="'.$dd['idservico'].'">'.$dd['descricaoservico'].'</option>';
          }echo'
          </select>
        </label>

        <label class="col-12">Banco
          <select type="text" class="form-control" name="banco" required>
          <option value="CARTEIRA">CARTEIRA</option>
            <option value="BANCO JUNO">BANCO JUNO</option>
            <option value="GERENCIANET">GERENCIANET</option>
            <option value="BANCO DO BRASIL">BANCO DO BRASIL</option>
          </select>
        </label>

        <label class="col-12">Parcelas
          <input type="number" class="form-control" name="nparcela" value="1"/>
        </label>
        <label class="col-12">Vencimento
          <input type="text" class="form-control data" name="vencimento" value="'.date($dia.'-m-Y').'" required/>
        </label>
        <label class="col-12">Valor
          <input type="text" class="form-control real" name="valor" placeholder="0,00"/>
        </label>

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
<div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancelar cobrança</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" method="post" id="cancelarCobranca">
      <div class="modal-body" id="callbackCancel">
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
<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cobrança cancelada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="callbackVer">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>';

include('rodape.php'); ?>
<script>
$('.clientes').addClass('active');
$('.clientes-financeiro').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  let id = $('#id').val();
  $.get('clientes-financeiro-tab.php',{id:id},function(data){ 
    $('#tabela').show().html(data);
  });
  return false;
};
//gerarCobranca
$('#gerarCobranca').submit(function(){
  $('#cadastrar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
    type:'post',
    url:'cobranca-gerar.php',
    data:$('#gerarCobranca').serialize(),
    success:function(data){
      $('#processando').modal('hide');
      $('#retorno').show().html(data);
      tabela();
    }
  });
  return false;
});
//cancelar
function cancelarCobranca(id){
  $('#cancelar').modal('show');
  $.get('cobranca-cancelar-retorno.php',{id:id},function(data){
    $('#callbackCancel').show().html(data);
  });
  return false;
}
//formcancelar
$('#cancelarCobranca').submit(function(){
  $('#cancelar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
    type:'post',
    url:'cobranca-cancelar.php',
    data:$('#cancelarCobranca').serialize(),
    success:function(data){
      $('#processando').modal('hide');
      $('#retorno').show().html(data);
      tabela();
    }
  });
  return false;
});
//cancelar ver
function ver(id){
  $('#ver').modal('show');
  $.get('cobranca-cancelar-ver.php',{id:id},function(data){
    $('#callbackVer').show().html(data);
  });
  return false;
}
//receber
function receberCobranca(id){
  $('#processando').modal('show');
  $.get('cobranca-receber.php',{id:id},function(data){
    $('#processando').modal('hide');
    $('#retorno').show().html(data);
    tabela();
  });
  return false;
}
</script>