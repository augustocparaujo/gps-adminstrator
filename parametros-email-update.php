
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
//id,contaemail,servidor_smtp,porta,senha_email,assunto,antes,depois,texto,usuariocad,data

@$id = $_POST['id'];
@$contaemail = AspasBanco($_POST['contaemail']);
@$servidor_smtp = AspasBanco($_POST['servidor_smtp']);
@$porta = $_POST['port'];
@$senha_email = AspasBanco($_POST['senha_email']);
@$assunto = AspasBanco($_POST['assunto']);
@$antes = $_POST['antes'];
@$depois = $_POST['depois'];
@$texto = AspasBanco($_POST['texto']);

if(!empty($_POST['id'])):
    mysqli_query($conexao,"update email set 
    contaemail='$contaemail',
    servidor_smtp='$servidor_smtp',
    porta='$porta',
    senha_email='$senha_email',
    assunto='$assunto',
    antes='$antes',
    depois='$depois',
    texto='$texto',
    usuariocad='$nomeuser',
    data=NOW() where id='$id'") or die (mysqli_error($conexao));
    echo sucesso();
else:
    mysqli_query($conexao,"insert into email (contaemail,servidor_smtp,porta,senha_email,assunto,antes,depois,texto,usuariocad,data)
    values ('$contaemail','$servidor_smtp','$porta','$senha_email','$assunto','$antes','$depois','$texto','$nomeuser',NOW())
    ") or die (mysqli_error($conexao));
    echo sucesso();
endif;


?>