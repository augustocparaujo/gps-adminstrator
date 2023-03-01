<?php
//$conexao = mysqli_connect("localhost","gps","wPDzPXTSeTNk7sys","gps");
$conexao = mysqli_connect("localhost","root","","gps");
/* check connection */
if (mysqli_connect_errno()) {    
    //printf('Falha na conexão: %s\n', mysqli_connect_error());
    //exit();
}else{
    $conexao->set_charset("utf8");
    //print('Conectado com sucesso!');
    //printf("inicio caracter set: %s\n", $conexao->character_set_name());
}
?>