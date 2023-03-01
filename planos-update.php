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

//dados
@$id = $_POST['id'];
@$descricao = AspasBanco($_POST['descricao']);
@$valor = Moeda($_POST['valor']);

if(!empty($_POST['id'])){
    
    mysqli_query($conexao,"update plano set descricao='$descricao',valor='$valor' where id='$id'") or die (mysqli_error($conexao));

    echo sucesso();

}else{
    if(!empty($_POST['descricao']) AND !empty($_POST['valor'])){
        
        mysqli_query($conexao,"insert into plano (descricao,valor,usuariocad,datacad) values ('$descricao','$valor','$nomeuser',NOW())") or die (mysqli_error($conexao));

        echo sucesso();
    }
}

?>
