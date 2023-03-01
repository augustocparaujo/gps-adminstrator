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
$qtn = $_GET['qtn'];
if($_GET['id']!='' && $_GET['qtn']!=''){

$queryp = mysqli_query($conexao,"SELECT * FROM produto WHERE id='$id'") or die (mysqli_error($conexao));
$retp = mysqli_fetch_array($queryp);

$total = $retp['valorvenda'] * $qtn;
echo Real($total);
}

