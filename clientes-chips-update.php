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
if(isset($_SESSION['gps_iduser'])!=true ){echo '<script>location.href="sair.php";</script>'; }

//dados: idplano	idcliente	chip numero	icc	apn	estado	usuariocad	datacad	

@$idcliente = $_POST['idcliente'];
if(!empty($_POST['idplano'])): @$idplano = $_POST['idplano']; else: $idplano = 0; endif;
@$idcliente	= $_POST['idcliente'];
@$idveiculo	= $_POST['veiculo'];
if(!empty($_POST['chip'])): @$chip = $_POST['chip']; else: $chip = 0; endif;
@$icc = $_POST['icc'];
@$imei = $_POST['imei'];
@$numero = $_POST['numero'];
@$apn = AspasBanco($_POST['apn']);
@$estado = $_POST['estado'];

if(!empty($_POST['id'])){
    $id = $_POST['id'];    
    mysqli_query($conexao,"update chip set idplano='$idplano',idcliente='$idcliente',idveiculo='$idveiculo', chip='$chip',numero='$numero',icc='$icc',apn='$apn',estado='$estado',
    usuariocad='$nomeuser',datacad=NOW() where id='$id'") or die (mysqli_error($conexao));

    $query = mysqli_query($conexao,"select * from produto where id='$chip'");
    $r = mysqli_fetch_array($query);
    if($r['quantidade'])

    echo sucesso();

}else{

    if(!empty($_POST['idcliente']) AND !empty($_POST['chip'])){
    mysqli_query($conexao,"insert into chip  (idplano,idcliente,idveiculo,chip,numero,icc,apn,estado,usuariocad,datacad)
    values ('$idplano','$idcliente','$idveiculo','$chip','$numero','$icc','$apn','$estado','$nomeuser',NOW())
    ") or die (mysqli_error($conexao));
    echo sucesso();
    }
}
