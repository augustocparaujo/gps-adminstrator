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
$sql = mysqli_query($conexao, "select * from produto where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo '
<input type="text" class="hidden" name="id" value="' . $dd['id'] . '"/>
<div class="form-group">
<label>Nome</label>
    <input type="text" class="form-control" placeholder="Nome" name="nome" value="' . $dd['nome'] . '" required/>
</div>

    <label>Contato</label>
    <input type="text" class="form-control celular" placeholder="(99)99999-9999"  name="contato" value="' . $dd['contato'] . '"/>
</div>
<div class="form-group">
    <label>Material</label>
    <input type="text" class="form-control" placeholder="Cabo,Chip,Fusível,etc" name="material" value="' . $dd['material'] . '"/>
</div>   ';
?>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/jquery.maskMoney.js"></script>
<script src="assets/js/meusscripts.js"></script>