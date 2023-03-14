<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from funcionarios where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo '
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        ';
include_once('funcionarios-tab.php');
echo '

        <div class="d-flex justify-content-between">
          <div class="button-canto-inferior hidden" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>
                <input type="text" class="hidden" name="id" value="' . $dd['id'] . '">
               

                <div class="row">
                    rmontar contra gerarpdf ou imprimir (filtro por mês e ano)
                </div>
  

   


                  </div>
      </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->';
include_once('rodape.php');
?>
<script>
    //marcar menu
    $('.funcionarios').addClass('active');
    $('.funcionarios-listar,.funcionarios-contracheque').addClass('ativo2');
    //alterar
    /*   $('#formAlterar').submit(function() {
          $('#processando').modal('show');
          $.ajax({
              type: 'post',
              url: 'funcionarios-update.php',
              data: $('#formAlterar').serialize(),
              success: function(data) {
                  $('#processando').modal('hide');
                  $('#retorno').show().fadeOut(2500).html(data);
                  window.setTimeout(function() {
                      history.go();
                  }, 2501);
              }
          });
          return false;
      }); */
</script>