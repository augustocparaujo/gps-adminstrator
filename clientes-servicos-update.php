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

$idcliente = $_POST['idcliente'];
$idservico = $_POST['servico'];
$descricao = AspasBanco($_POST['descricao']);
if(!empty($idservico) AND !empty($idcliente)){
    
    mysqli_query($conexao,"insert into servico (descricao,idcliente,idservico,datacad,usuariocad)
    values('$descricao','$idcliente','$idservico',NOW(),'$nomeuser')") or die (mysqli_error($conexao));

    echo sucesso();
}

?>
