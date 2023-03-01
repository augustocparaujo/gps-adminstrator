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
$sql = mysqli_query($conexao,"select * from categoria where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<input type="text" class="hidden" name="id" value="'.$dd['id'].'"/>
<div class="row">
<label class="col-md-12 col-sm-12">Descrição
  <input type="text" class="form-control" name="descricao" value="'.$dd['descricao'].'" required/>
</label>
</div>';
?>