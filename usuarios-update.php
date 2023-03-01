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
@$nome = AspasBanco($_POST['nome']);
@$cargo = AspasBanco($_POST['cargo']);
@$contato = AspasBanco($_POST['contato']);
@$email = AspasBanco($_POST['email']);
@$cpf = limpa($_POST['cpf']);
@$cpf_crp = md5($cpf);
@$senha_crp = md5($_POST['senha']);

if(!empty($_POST['id'])){
    
    mysqli_query($conexao,"update usuario set nome='$nome',cargo='$cargo',contato='$contato',email='$email',cpf='$cpf',cpf_crp='$cpf_crp' where id='$id'") 
    or die (mysqli_error($conexao));

    if(!empty($_POST['senha'])){ mysqli_query($conexao,"update usuario set senha='$senha' where id='$id'");  }

    echo sucesso();

}else{

    mysqli_query($conexao,"insert into usuario 
    (nome,cargo,email,cpf,cpf_crp,senha_crp,situacao,usuariocad,datacad)
    values
    ('$nome','$cargo','$email','$cpf','$cpf_crp','$senha_crp',1,'$nomeuser',NOW())
    ") or die (mysqli_error($conexao));

    echo sucesso();
}

?>
