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

//dados: nome	contato	material	usuariocad	datacad	
@$id = $_POST['id'];
@$nome = AspasBanco($_POST['nome']);
@$contato = limpa($_POST['contato']);
@$material = AspasBanco($_POST['material']);

if(!empty($_POST['id'])){
    
    mysqli_query($conexao,"update fornecedor set nome='$nome',contato='$contato',material='$material' where id='$id'") or die (mysqli_error($conexao));

    echo sucesso();

}else{
    if(!empty($_POST['nome'])){
        
        mysqli_query($conexao,"insert into fornecedor (nome,contato,material,usuariocad,datacad) 
        values ('$nome','$contato','$material','$nomeuser',NOW())") or die (mysqli_error($conexao));

        echo sucesso();
    }
}

?>
