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

//dados
@$id = $_POST['id'];
@$tipopessoa	= $_POST['tipopessoa'];
@$nome = $_POST['nome'];
@$apelido = $_POST['apelido'];
@$cpf = limpa($_POST['cpf']);
@$rg = $_POST['rg'];
@$fantasia = $_POST['fantasia'];
@$cnpj = limpa($_POST['cnpj']);
@$ie = $_POST['ie'];
if($_POST['tipopessoa'] == 'física'){ @$nascimento	= dataBanco($_POST['nascimento']); }else{ @$nascimento = dataBanco($_POST['datacriacao']); }
@$nomepai = $_POST['nomepai'];
@$nomemae = $_POST['nomemae'];
@$contato = limpa($_POST['contato']);
@$contato1 = limpa($_POST['contato1']);
@$email = $_POST['email'];
@$cep = $_POST['cep'];
@$endereco = $_POST['endereco'];
@$numero = $_POST['numero'];
@$bairro = $_POST['bairro'];
@$cidade = $_POST['cidade'];
@$estado = $_POST['estado'];
@$diavencimento = $_POST['diavencimento'];
@$banco = $_POST['banco'];

if(!empty($_POST['id'])):
    
    mysqli_query($conexao,"update cliente set 
    tipopessoa='$tipopessoa',nome='$nome',apelido='$apelido',cpf='$cpf',rg='$rg',fantasia='$fantasia',cnpj='$cnpj',ie='$ie',nascimento='$nascimento',nomepai='$nomepai',nomemae='$nomemae',
    contato='$contato',contato1='$contato1',email='$email',cep='$cep',endereco='$endereco',numero='$numero',bairro='$bairro',cidade='$cidade',estado='$estado',diavencimento='$diavencimento',banco='$banco' where id='$id'") or die (mysqli_error($conexao));

    echo sucesso();

else:
        
        mysqli_query($conexao,"insert into cliente 
        (tipopessoa,nome,apelido,cpf,rg,fantasia,cnpj,ie,nascimento,pai,mae,contato,contato1,email,cep,endereco,numero,bairro,cidade,estado,usuariocad,datacad,diavencimento,banco)
        values
        ('$tipopessoa','$nome','$apelido','$cpf','$rg','$fantasia','$cnpj','$ie','$nascimento','$nomepai','$nomemae','$contato','$contato1','$email','$cep','$endereco','$numero','$bairro,'$cidade','$estado','$nomeuser',NOW(),'$diavencimento','$banco')") or die (mysqli_error($conexao));

    $id = mysqli_insert_id($conexao);

    echo"<script>window.location.href='clientes-exibir.php?id=$id'</script>";

    echo sucesso();
    
endif;
