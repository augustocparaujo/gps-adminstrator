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
if (isset($_SESSION['gps_iduser']) != true) {
    echo '<script>location.href="sair.php";</script>';
}
/* idagenda,idproduto,idcliente,tipo,quantidade,formapagamento,banco,parcela,vencimento,valordinheiro,valorcredito,
	valordebito,valorpix,valortaxa,valortotal,agendado,situacao,usuariocad,datacad,dataalt	*/

$idproduto = $_POST['idproduto'];
$queryp = mysqli_query($conexao, "SELECT * FROM produto WHERE id='$idproduto'") or die(mysqli_error($conexao));
$retp = mysqli_fetch_array($queryp);

$nomeproduto = $retp['descricao'];
$idcliente = $_POST['idcliente'];
$tipo = $_POST['tipo'];
$quantidade = $_POST['quantidade'];
$formapagamento = $_POST['formapagamento'];
$banco = $_POST['banco'];
if ($_POST['parcela'] != '') {
    $parcela = $_POST['parcela'];
} else {
    $parcela = 0;
}
$vencimento = dataBanco($_POST['vencimento']);

$valordinheiro = Moeda($_POST['valordinheiro']);
$valorcredito = Moeda($_POST['valorcredito']);
$valordebito = Moeda($_POST['valordebito']);
$valorpix = Moeda($_POST['valorpix']);
$valortaxa = Moeda($_POST['valortaxa']);
$valorReceber = Moeda($_POST['valorareceber']);
$valortotal = $valordinheiro + $valorcredito + $valordebito + $valorpix + $valortaxa;
$valordesconto = $valortotal - $valorReceber;

if ($valortotal != '0.00') {
    $valorBoleto = $valortotal;
} else {
    $valorBoleto = $valorReceber + $valortaxa;
}

$situacao = $_POST['situacao'];
$usuariocad = $iduser;
$datacad =  date('Y-m-d');
$agendado = $_POST['agendado'];
$datainstalacao = dataBanco($_POST['datainstalacao']);
$periodo = $_POST['periodo'];
$descricao = AspasBanco('Saída em ' . $formapagamento . ' | Produto:' . $nomeproduto . ' | QTN:' . $quantidade);

//se comodato
if ($idproduto != '' and $formapagamento == 'Comodato') {
    //1-tabela cliente_produto
    mysqli_query($conexao, "INSERT INTO cliente_produto (idproduto,idcliente,tipo,formapagamento,quantidade,parcela,vencimento,agendado,situacao,usuariocad,datacad)
    VALUES ('$idproduto','$idcliente','$tipo','$formapagamento','$quantidade','$parcela','$vencimento','$agendado','FINALIZADO','$usuariocad',NOW())") or die(mysqli_error($conexao));

    $idNovo = mysqli_insert_id($conexao);

    //2-atualizatabela produto
    $query = mysqli_query($conexao, "SELECT quantidade FROM produto WHERE id='$idproduto'") or die(mysqli_error($conexao));
    $produto = mysqli_fetch_array($query);
    $quantidadeatualiza = $produto['quantidade'] - $quantidade;
    mysqli_query($conexao, "UPDATE produto SET quantidade='$quantidadeatualiza' WHERE id='$idproduto'") or die(mysqli_error($conexao));

    //3-tabela historico produto
    //idproduto,idregistro,tipomovimento,idcliente,descricao,entrada,saida,usuariocad,datacad
    mysqli_query($conexao, "INSERT INTO historico_produto (idproduto,idregistro,tipomovimento,idcliente,descricao,saida,usuariocad,datacad) 
    VALUES('$idproduto','$idNovo','Saída','$idcliente','$descricao','$quantidade','$iduser',NOW())") or die(mysqli_error($conexao));

    //4-tabela atendimento
    //idregistro,idcliente,tipo,agendado,periodo,idtecnico,observacao,atendente,situacao,datacad,dataalt	
    if ($agendado == 'sim') {
        mysqli_query($conexao, "INSERT INTO atendimento (idregistro,idcliente,idproduto,quantidade,tipo,agendado,periodo,atendente,situacao,datacad)
        VALUES ('$idNovo','$idcliente','$idproduto','$quantidade','Instalação','$datainstalacao','$periodo','$iduser','$situacao',NOW())") or die(mysqli_error($conexao));
        //atualiza id agenda
        $idNovoAgenda = mysqli_insert_id($conexao);
        mysqli_query($conexao, "UPDATE cliente_produto SET idagenda='$idNovoAgenda' WHERE id='$idNovo'") or die(mysqli_error($conexao));
    }

    echo sucesso();
}

//se outra forma de pagamento
if ($idproduto != '' and $formapagamento == 'Carteira' or $formapagamento == 'Boleto') {

    //1-tabela cliente_produto
    //idagenda,idproduto,idcliente,tipo,quantidade,formapagamento,banco,parcela,vencimento,valorareceber,valordinheiro,valorcredito,valordebito,valorpix,valortaxa,valortotal,valordesconto,agendado,situacao
    mysqli_query($conexao, "INSERT INTO cliente_produto (idproduto,idcliente,tipo,formapagamento,quantidade,parcela,vencimento,
        banco,valorareceber,valordinheiro,valorcredito,valordebito,valorpix,valortaxa,valortotal,valordesconto,agendado,situacao,usuariocad,datacad)
        VALUES ('$idproduto','$idcliente','$tipo','$formapagamento','$quantidade','$parcela','$vencimento',
        '$banco','$valorReceber','$valordinheiro','$valorcredito','$valordebito','$valorpix','$valortaxa','$valortotal','$valordesconto','$agendado','FINALIZADO','$usuariocad',NOW())") or die(mysqli_error($conexao));

    $idNovo = mysqli_insert_id($conexao);

    //2-atualizatabela produto
    $query = mysqli_query($conexao, "SELECT * FROM produto WHERE id='$idproduto'") or die(mysqli_error($conexao));
    $produto = mysqli_fetch_array($query);
    $quantidadeatualiza = $produto['quantidade'] - $quantidade;
    mysqli_query($conexao, "UPDATE produto SET quantidade='$quantidadeatualiza' WHERE id='$idproduto'") or die(mysqli_error($conexao));

    //3-tabela historico produto
    //idproduto,idregistro,tipomovimento,idcliente,descricao,entrada,saida,usuariocad,datacad
    mysqli_query($conexao, "INSERT INTO historico_produto (idproduto,idregistro,tipomovimento,idcliente,descricao,saida,usuariocad,datacad) 
        VALUES('$idproduto','$idNovo','Saída','$idcliente','$descricao','$quantidade','$iduser',NOW())") or die(mysqli_error($conexao));

    //4-tabela atendimento
    //idregistro,idcliente,tipo,agendado,periodo,idtecnico,observacao,atendente,situacao,datacad,dataalt	
    if ($agendado == 'sim') {
        mysqli_query($conexao, "INSERT INTO atendimento (idregistro,idcliente,idproduto,quantidade,tipo,agendado,periodo,atendente,situacao,datacad)
            VALUES ('$idNovo','$idcliente','$idproduto','$quantidade','Instalação','$datainstalacao','$periodo','$iduser','$situacao',NOW())") or die(mysqli_error($conexao));
        //atualiza id agenda
        $idNovoAgenda = mysqli_insert_id($conexao);
        mysqli_query($conexao, "UPDATE cliente_produto SET idagenda='$idNovoAgenda' WHERE id='$idNovo'") or die(mysqli_error($conexao));
    }

    //5-se dinheiro, crédito, débito ou pix - tabela caixa
    //idregistro,tipo,moeda,funcionario,descricao,valor,data,agendadopara,situacao,usuariocad,datacad
    if ($banco == 'CARTEIRA') {
        mysqli_query($conexao, "INSERT INTO caixa (idregistro,tipo,cliente,moeda,descricao,valor,data,situacao,usuariocad,datacad) 
            VALUES ('$idNovo','Venda','$idcliente','$formapagamento','$descricao','$valortotal',NOW(),'pago','$iduser',NOW())") or die(mysqli_error($conexao));
    }

    echo persona('Venda registrada com sucesso', 'success');

    //se banco de boleto
    if ($banco == 'BANCO JUNO') {

        include_once('api_juno.php');
        gerarCobranca($idcliente, $parcela, $vencimento, $valorReceber, $descricao);
    } elseif ($banco == 'GERENCIANET') {

        include_once('api_gerencianet.php');
        gerarCobranca($idcliente, $parcela, $vencimento, $valorReceber, $descricao);
    } elseif ($banco == 'BANCO DO BRASIL') {

        include_once('api_bb.php');
        gerarCobranca($idcliente, $parcela, $vencimento, $valorReceber, $descricao);
    }
}
