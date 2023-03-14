<?php
include_once('topo.php');
$sql = mysqli_query($conexao, "select * from empresa") or die(mysqli_error($conexao));
$dde = mysqli_fetch_array($sql);
echo '
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
include_once('parametros-tab.php');
echo '
          <form method="post" id="form" enctype="multipart/form-data">
          <input typo="text" class="hidden" name="id"value="' . @$dde['id'] . '"/>

            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Nome
                <input type="text" class="form-control" placeholder="Nome" name="nome" value="' . @$dde['nome'] . '" />
              </label> 
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Fantasia
                <input type="text" class="form-control" placeholder="Fantasia" name="fantasia" value="' . @$dde['fantasia'] . '" />
              </label>               
            </div>

            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">CPF/CNPJ
                <input type="text" class="form-control" placeholder="CNPJ ou CPF" name="cnpj_cpf" value="' . @$dde['cnpj_cpf'] . '" />
              </label>          
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">IE
                <input type="text" class="form-control" placeholder="Inscrição estadual" name="ie" value="' . @$dde['ie'] . '" />
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Contato
                <input type="text" class="form-control celular" placeholder="Contato" name="contato" value="' . @$dde['contato'] . '" />
              </label>
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Email
                <input type="email" class="form-control" placeholder="E-mail" name="email" value="' . @$dde['email'] . '" />
              </label>
            </div>

            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">CEP
                <input type="text" class="form-control cepBusca" placeholder="CEP" name="cep" value="' . @$dde['cep'] . '"/>
              </label>
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Endereço
                <input type="text" class="form-control enderecoBusca" placeholder="Endereço" name="endereco" value="' . @$dde['endereco'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Número
                <input type="text" class="form-control" placeholder="Número" name="numero" value="' . @$dde['numero'] . '"/>
              </label>
            </div>
            <div class="row">
              <label class="col-lg-4 col-md-4 col-sm-6 col-xs-12">Bairro
                <input type="text" class="form-control bairroBusca" placeholder="Bairro" name="bairro" value="' . @$dde['bairro'] . '"/>
              </label>
              <label class="col-lg-4 col-md-4 col-sm-6 col-xs-12">Cidade
                <input type="text" class="form-control cidadeBusca" placeholder="Cidade" name="cidade" value="' . @$dde['cidade'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Estado
                <input type="text" class="form-control ufBusca" placeholder="UF" name="estado" value="' . @$dde['estado'] . '"/>
              </label>
              </div>
              <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Complemento
                <input type="text" class="form-control" placeholder="Complemento" name="complemento" value="' . @$dde['complemento'] . '"/>
              </label>
              </div>
              <div class="row"></div><hr>
              <div class="row">
              <input type="text" class="hidden" name="arquivoantigo" value="' . @$dde['logo'] . '"/>
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Salvar logo (*APENAS .PNG - 150PXx150PX)
                <input type="file" class="form-control" name="arquivo" accept="image/png"/>
              </label>
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Logo
                <center>';
$filename = 'assets/' . @$dde['logo'];
if (file_exists($filename)) {
  echo '<img src="assets/' . @$dde['logo'] . '"/>';
} else {
  echo 'Sem logo';
}
echo '
                </center>
              </label>              
              </div>


            <div class="row">
            <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Salvar</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- content-wrapper ends -->';
include_once('rodape.php');
?>
<script>
  $('.parametros').addClass('active');
  $('.parametros-empresa').addClass('ativo2');
  //form
  //logo
  $('#form').submit(function() {
    $('#processando').modal('show');
    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: 'parametros-empresa-update.php',
      data: formData,
      success: function(data) {
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        window.setTimeout(function() {
          history.go();
        }, 2501);
      },
      cache: false,
      contentType: false,
      processData: false,
    });
    return false;
  });
</script>