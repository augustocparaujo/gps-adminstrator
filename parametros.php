<?php
include('topo.php');
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mb-0">Parâmetros</h4>
          <button class="btn btn-primary mr-2 hidden" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>';
          include('parametros-tab.php');echo'
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- content-wrapper ends -->';
include('rodape.php');
?>
<script>
  $('.parametros').addClass('active');
</script>