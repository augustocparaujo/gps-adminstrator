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

//id	tipo	modeda	funcionario	descricao	valor	data	agendadopara	situacao	usuariocad	datacad	
@$id = $_POST['id'];
@$tipo = $_POST['tipo'];
@$moeda = $_POST['moeda'];
@$funcionario = $_POST['funcionario'];
@$descricao = AspasBanco($_POST['descricao']);
@$valor	= Moeda($_POST['valor']);
@$data = dataBanco($_POST['data']);
if(!empty($_POST['agendadopara'])){ @$agendadopara	= dataBanco($_POST['agendadopara']); }else{ @$agendadopara	= '0000-00-00';}
if(!empty($_POST['data'])){ @$data = dataBanco($_POST['data']); }else { @$data = '0000-00-00'; }
@$situacao = $_POST['situacao'];

if(!empty($_POST['id'])){    
    mysqli_query($conexao,"update caixa set tipo='$tipo',moeda='$moeda',funcionario='$funcionario',descricao='$descricao',
    valor='$valor',data='$data',agendadopara='$agendadopara',situacao='$situacao' where id='$id'") or die (mysqli_error($conexao));
    echo sucesso();
}else{        
    mysqli_query($conexao,"insert into caixa (tipo,moeda,funcionario,descricao,valor,data,agendadopara,situacao,usuariocad,datacad) 
    values ('$tipo','$moeda','$funcionario','$descricao','$valor','$data','$agendadopara','$situacao','$nomeuser',NOW())") or die (mysqli_error($conexao));
    echo sucesso();
}
