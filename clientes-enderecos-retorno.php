<?php
ob_start();
session_start();
include_once('conexao.php');
include_once('funcoes.php');
@$iduser = $_SESSION['gps_iduser'];
@$nomeuser = $_SESSION['gps_nomeuser'];
@$usercargo = $_SESSION['gps_cargouser'];
@$tipouser = $_SESSION['gps_tipouser'];
@$situacaouser = $_SESSION['gps_situacaouser'];
@$ip = $_SERVER['REMOTE_ADDR'];
@$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
if (isset($_SESSION['gps_iduser']) != true) {
  echo '<script>location.href="sair.php";</script>';
}

$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from endereco where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
$idcliente = $dd['idcliente'];
echo '
    <input type="text" class="hidden" name="id" value="' . $id . '"/>
    <input type="text" class="hidden" name="idcliente" value="' . $dd['idcliente'] . '"/>
    <div class="row">
      <label class="col-md-12 col-sm-12">Serviço
        <select type="text" class="form-control" name="idservico">
          <option value="">selecione</option>';
$sql2 = mysqli_query($conexao, "select servico.*, plano.descricao as descricaoservico from servico
          left join plano on servico.idservico = plano.id
          where servico.idcliente='$idcliente' order by servico.id asc") or die(mysqli_error($conexao));
while ($dd2 = mysqli_fetch_array($sql2)) {
  echo '
            <option value="' . $dd2['id'] . '">' . $dd2['descricaoservico'] . '</option>';
}
echo '
        </select>
      </label>
    </div>

    <div class="row">
    <label class="col-md-6 col-sm-12">CEP
    <input type="text" class="form-control cepBusca" name="cep" value="' . $dd['cep'] . '"/>
    </label>
    <label class="col-md-6 col-sm-12">Endereço
    <input type="text" class="form-control enderecoBusca" name="endereco" value="' . $dd['endereco'] . '"/>
    </label>
    </div>

    <div class="row">
    <label class="col-md-6 col-sm-12">Bairro
    <input type="text" class="form-control bairroBusca" name="bairro" value="' . $dd['bairro'] . '"/>
    </label>
    <label class="col-md-6 col-sm-12">Cidade
    <input type="text" class="form-control cidadeBusca" name="cidade" value="' . $dd['cidade'] . '"/>
    </label>
    </div>

    <div class="row">
    <label class="col-md-6 col-sm-12">Estado
    <input type="text" class="form-control ufBusca" name="uf" value="' . $dd['uf'] . '"/>
    </label>
    <label class="col-md-6 col-sm-12">Complemento
    <input type="text" class="form-control" name="complemento" value="' . $dd['complemento'] . '"/>
    </label>
    </div>    
';
?>
<!--meus script -->
<script src="assets/js/buscacep.js"></script>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/jquery.maskMoney.js"></script>
<script src="assets/js/meusscripts.js"></script>