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
@$id = $_POST['id'];
@$descricao = AspasBanco($_POST['descricao']);
if(!empty($_POST['id'])){
    mysqli_query($conexao,"update categoria set descricao='$descricao',usuariocad='$nomeuser',datacad=NOW() where id='$id'") or die (mysqli_error($conexao));
    echo sucesso();
}else{        
    mysqli_query($conexao,"insert into categoria (descricao,usuariocad,datacad) 
    values ('$descricao','$nomeuser',NOW())") or die (mysqli_error($conexao));
    echo sucesso();}
