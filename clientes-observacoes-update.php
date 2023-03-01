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

@$id = $_POST['id'];
@$idcliente = $_POST['idcliente'];
if(!empty($_POST['idservico'])): @$idservico = $_POST['idservico']; else: $idservico = 0; endif;
@$tipo = $_POST['tipo'];
@$descricao = AspasBanco($_POST['descricao']);
    if(empty($_POST['id']) AND !empty($_POST['descricao'])){
        mysqli_query($conexao,"insert into obs (idcliente,tipo,descricao,usuariocad,datacad) values ('$idcliente','$tipo','$descricao','$nomeuser',NOW())") or die (mysqli_error($conexao));
        
        $idnovo = mysqli_insert_id($conexao);
        //aidicionar aquivo
        if($_FILES['arquivo']['name'] != ''){
            $diretorio = "assets/doc/";
            $extensao = strrchr($_FILES['arquivo']['name'],'.');
            $novonome = md5(date('ms')).$extensao;
            $filename = $_FILES['arquivo']['tmp_name'];
            mysqli_query($conexao,"UPDATE obs SET documento='$novonome' WHERE id='$idnovo'") or die (mysqli_error($conexao));
            move_uploaded_file($filename, "$diretorio/$novonome");
        }
        echo sucesso();    
    }elseif (!empty($_POST['id']) AND !empty($_POST['descricao'])){
        mysqli_query($conexao,"update obs set idcliente='$idcliente',tipo='$tipo',descricao='$descricao',usuariocad='$nomeuser',datacad=NOW() where id='$id'") or die (mysqli_error($conexao));
        //apargar arquivo ou foto antigo
        if($_POST['arquivoantigo'] != ''){ unlink("assets/doc/".@$_POST['arquivoantigo']); }
        //aidicionar aquivo
        if($_FILES['arquivo']['name'] != ''){
            $diretorio = "assets/doc/";
            $extensao = strrchr($_FILES['arquivo']['name'],'.');
            $novonome = md5(date('ms')).$extensao;
            $filename = $_FILES['arquivo']['tmp_name'];
            mysqli_query($conexao,"UPDATE obs SET documento='$novonome' WHERE id='$id'") or die (mysqli_error($conexao));
            move_uploaded_file($filename, "$diretorio/$novonome");
        }
        echo sucesso();
    }else{
        echo persona('Erro inesperado');
    }
?>