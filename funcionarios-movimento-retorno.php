<?php
ob_start();
session_start();
include('conexao.php'); 
include('funcoes.php');
@$iduser = $_SESSION['gps_iduser'];
@$nomeuser = $_SESSION['gps_nomeuser'];
@$usercargo = $_SESSION['gps_cargouser'];
@$tipouser = $_SESSION['gps_tipouser'];
@$situacaouser = $_SESSION['gps_situacaouser'];
@$ip = $_SERVER['REMOTE_ADDR'];
@$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
if(isset($_SESSION['gps_iduser'])!=true ){echo '<script>location.href="sair.php";</script>'; }

$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from caixa where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<input type="text" class="hidden" name="id" value="'.$dd['id'].'"/>
<input type="text" class="hidden" name="funcionario" value="'.$dd['funcionario'].'"/>
<div class="row">
  <label class="col-md-6 col-sm-12">Tipo
    <select type="text" class="form-control" name="tipo" required>
      <option value="'.$dd['tipo'].'">'.$dd['tipo'].'</option>
      <option value="vale">vale</option>
      <option value="salário">salário</option>
      <option value="comissão">comissão</option>
      <option value="outros">outros</option>
    </select>
  </label>

  <label class="col-md-6 col-sm-12">Moeda
      <select type="text" class="form-control" name="moeda" required>
          <option value="'.$dd['moeda'].'">'.$dd['moeda'].'</option>
          <option value="dinheiro">dinheiro</option>
          <option value="trasnferência">trasnferência</option>
          <option value="pix">pix</option>
          <option value="outros">outros</option>
      </select>
  </label>

  <label class="col-md-12 col-sm-12">Descrição
    <input type="text" class="form-control" name="descricao" value="'.$dd['descricao'].'" required/>
  </label>

</div>
<div class="row">
  <label class="col-md-6 col-sm-12">Valor
    <input type="text" class="form-control real" name="valor" value="'.Real($dd['valor']).'" required/>
  </label>

  <label class="col-md-6 col-sm-12">Situação
      <select type="text" class="form-control" name="situacao" required>
          <option value="'.$dd['situacao'].'">'.$dd['situacao'].'</option>
          <option value="pago">pago</option>
          <option value="agendado">agendado</option>
      </select>
  </label>
</div>
<div class="row">
<label class="col-md-6 col-sm-12">Data pago
      <input type="text" class="form-control data" name="data" value="'; if($dd['data'] != '0000-00-00'){ echo @$dd['data']; } echo'"/>
  </label>
<label class="col-md-6 col-sm-12">Agendado para
  <input type="text" class="form-control data" name="agendadopara" value="'; if($dd['agendadopara'] != '0000-00-00'){ echo @$dd['agendadopara']; } echo'"/>
</label>
</div> ';
?>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/jquery.maskMoney.js"></script>
<script src="assets/js/meusscripts.js"></script>