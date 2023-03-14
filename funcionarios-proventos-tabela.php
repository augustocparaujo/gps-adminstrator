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
//salario, comissão, etc e saidas como vale, etc
//idfuncionario,tipo	descricao	valor	usuariocad	datacad	
