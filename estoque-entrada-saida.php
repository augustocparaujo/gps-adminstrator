<?php
include('topo.php');
echo'
<div class="content-wrapper">   
  <div class="row">
  <!--aqui-->

  <div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mb-0">Histórico de entrada/saída</h4>
            <button class="btn btn-primary mr-2 hidden" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr> 
      <table class="table table-striped w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Descrição</th>
            <th>Produto</th>
            <th>QUANT</th>
            <th>Estoque</th>
            <th>Mínimo</th>
            <th>Data</th>
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
include('rodape.php');
?>
<script>
//marcar menu
$('.estoque','.estoque-entrada-saida').addClass('active');
//
$().ready(function(){ tabela(); });
//
function tabela(){
  $.get('estoque-entrada-saida-tabela.php',function(data){
    $('#tabela').show().html(data);
  });
  return false;
}
</script>