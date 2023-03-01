<?php
include('topo.php');
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mb-0">Controle de caixa</h4>
          <div class="button-canto-inferior" data-toggle="modal" data-target="#filtrarModal" title="filtrar"><i class="fa fa-search"></i></div>
        </div><hr>
            <table class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Moeda</th>
                        <th>Valor</th>
                        <th>Data/Pag</th>
                        <th>Agendado</th>
                        <th>Situação</th>
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
<div class="modal fade" id="filtrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Filtrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" method="post" id="pesquisar">
      <div class="modal-body">

        <label class="col-12">Ínicio pagamento
          <input type="date" class="form-control" name="inicio"/>
        </label>
        <label class="col-12">Fim pagamento
            <input type="date" class="form-control" name="fim"/>
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

include('rodape.php');
?>
<script>
$('.financeiro').addClass('active');
$('.financeiro-caixa').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  $.ajax({
    type:'post',
    url:'caixa-tab.php',
    data:'html',
    success:function(data){ 
    $('#tabela').show().html(data);
    }
  });
  return false;
};
//filtrar
$('#pesquisar').submit(function(){
  $('#filtrarModal').modal('hide');
  $('#processando').modal('show');
  $.ajax({
    type:'post',
    url:'caixa-tab.php',
    data:$('#pesquisar').serialize(),
    success:function(data){
      $('#processando').modal('hide');
      $('#tabela').show().html(data);
    }
  });
  return false;
});
</script>