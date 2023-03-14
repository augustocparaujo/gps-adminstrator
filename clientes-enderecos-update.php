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

//idcliente	idservico	tipo	cep	endereco	bairro	cidade	uf	complemento	latitude	longitude	
@$id = $_POST['id'];
@$idcliente = $_POST['idcliente'];
@$idservico	= $_POST['idservico'];
if(!empty($_POST['servico'])): @$tipo	= $_POST['servico']; else: $tipo = 0; endif;
@$cep = $_POST['cep'];
@$endereco = $_POST['endereco'];
@$bairro = $_POST['bairro'];
@$cidade = $_POST['cidade'];
@$uf = $_POST['uf'];
@$complemento = $_POST['complemento'];

    if(empty($_POST['id'])):
        
    mysqli_query($conexao,"insert into endereco (idcliente,tipo,cep,endereco,bairro,cidade,uf,complemento)
    values ('$idcliente','$tipo','$cep','$endereco','$bairro','$cidade','$uf','$complemento')
    ") or die (mysqli_error($conexao));
    
    echo sucesso();
    
    elseif (!empty($_POST['id'])):
        
    mysqli_query($conexao,"update endereco set idcliente='$idcliente',idservico='$idservico',tipo='$tipo',cep='$cep',endereco='$endereco',bairro='$bairro',cidade='$cidade',uf='$uf',complemento='$complemento' where id='$id'") or die (mysqli_error($conexao));
    
    echo sucesso();
        
    endif;
