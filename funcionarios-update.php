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
//nome	cargo	cpf	rg	nascimento	email	contato	cep	endereco	numero	bairro	cidade	estado	atividades	usuariocad	datacad	

@$id = $_POST['id'];
@$nome = AspasBanco($_POST['nome']);
@$cargo = $_POST['cargo'];
@$contato = limpa($_POST['contato']);
@$cpf = limpa($_POST['cpf']);
@$rg = AspasBanco($_POST['rg']);
@$nascimento = dataBanco($_POST['nascimento']);
@$email = $_POST['email'];
@$cep = limpa($_POST['cep']);
@$endereco = AspasBanco($_POST['endereco']);
@$numero = $_POST['numero'];
@$bairro = AspasBanco($_POST['bairro']);
@$cidade = AspasBanco($_POST['cidade']);
@$estado = AspasBanco($_POST['estado']);
@$banco = AspasBanco($_POST['banco']);
@$agencia = AspasBanco($_POST['agencia']);
@$conta = AspasBanco($_POST['conta']);
@$tipochave = $_POST['tipochave'];
@$chavepix = AspasBanco($_POST['chavepix']);
@$inicioatividade = dataBanco($_POST['inicioatividade']);
@$atividades = AspasBanco($_POST['atividades']);

if(!empty($_POST['id'])):
    
    mysqli_query($conexao,"update funcionarios set nome='$nome',cargo='$cargo',cpf='$cpf',contato='$contato',
    rg='$rg',nascimento='$nascimento',email='$email',cep='$cep',endereco='$endereco',numero='$numero',
    bairro='$bairro',cidade='$cidade',estado='$estado',banco='$banco',agencia='$agencia',conta='$conta',
    tipochave='$tipochave',chavepix='$chavepix',inicioatividade='$inicioatividade',atividades='$atividades',
    usuariocad='$nomeuser',datacad=NOW() where id='$id'") or die (mysqli_error($conexao));
    echo sucesso();

else:
    mysqli_query($conexao,"insert into funcionarios (nome,cargo,cpf,contato,atividades,usuariocad,datacad)
    values ('$nome','$cargo','$cpf','$contato','$atividades','$nomeuser',NOW())") or die (mysqli_error($conexao));
    echo sucesso();
endif;
