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

//dados: idplano	idcliente	chip imei	placa	marca	modelo	ano	cor	chassi	renavam	cidade	obs	usuariocad	datacad	

@$idcliente = $_POST['idcliente'];
if(!empty($_POST['idplano'])){ @$idplano = $_POST['idplano']; }else{ $idplano = 0; }
@$idcliente	= $_POST['idcliente'];
if(!empty($_POST['chip'])){ @$chip = $_POST['chip']; }else{ $chip = 0; }
@$imei = $_POST['imei'];
@$placa	= $_POST['placa'];
@$marca	= $_POST['marca'];
@$modelo = $_POST['modelo'];
@$ano = $_POST['ano'];
@$cor = $_POST['cor'];
@$chassi = $_POST['chassi'];
@$renavam = $_POST['renavam'];
@$cidade = $_POST['cidade'];
@$obs = $_POST['obs'];

if(!empty($_POST['id'])){
    $id = $_POST['id'];    
    mysqli_query($conexao,"update veiculo set 
    idplano='$idplano',idcliente='$idcliente',chip='$chip',imei='$imei',placa='$placa',marca='$marca',
    modelo='$modelo',ano='$ano',cor='$cor',chassi='$chassi',renavam='$renavam',cidade='$cidade',
    obs='$obs',usuariocad='$nomeuser',datacad=NOW() where id='$id'") or die (mysqli_error($conexao));

    echo sucesso();

}else{

    if(!empty($_POST['idcliente'])){
    mysqli_query($conexao,"insert into veiculo 
    (idplano,idcliente,chip,imei,placa,marca,modelo,ano,cor,chassi,renavam,cidade,obs,usuariocad,datacad)
    values
    ('$idplano','$idcliente','$chip','$imei','$placa','$marca','$modelo','$ano','$cor','$chassi','$renavam','$cidade','$obs','$nomeuser',NOW())
    ") or die (mysqli_error($conexao));
    echo sucesso();
    }
}
