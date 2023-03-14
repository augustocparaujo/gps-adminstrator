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

//dados: categoria,operadora,marca,modelo,descricao,quantidade,quantidademinimo,valorcompra,valorvenda
@$id = $_POST['id'];
@$categoria = $_POST['categoria'];
@$operadora = $_POST['operadora'];
@$marca = $_POST['marca'];
@$modelo = $_POST['modelo'];
@$descricao = AspasBanco($_POST['descricao']);
@$quantidade = $_POST['quantidade'];
@$quantidademinimo = $_POST['quantidademinimo'];
@$valorcompra = Moeda($_POST['valorcompra']);
@$valorvenda = Moeda($_POST['valorvenda']);

if(!empty($_POST['id'])){
    
    mysqli_query($conexao,"update produto set categoria='$categoria',operadora='$operadora',marca='$marca',modelo='$modelo',
    descricao='$descricao',quantidade='$quantidade',quantidademinimo='$quantidademinimo',valorcompra='$valorcompra',
    valorvenda='$valorvenda',usuariocad='$nomeuser' where id='$id'") or die (mysqli_error($conexao));

    echo sucesso();

}else{
    if(!empty($_POST['descricao']) AND !empty($_POST['valorvenda'])){
        
        mysqli_query($conexao,"insert into produto (categoria,operadora,marca,modelo,descricao,quantidade,quantidademinimo,valorcompra,valorvenda,usuariocad,datacad) 
        values ('$categoria','$operadora','$marca','$modelo','$descricao','$quantidade','$quantidademinimo','$valorcompra','$valorvenda','$nomeuser',NOW())") or die (mysqli_error($conexao));

        echo sucesso();
    }
}
