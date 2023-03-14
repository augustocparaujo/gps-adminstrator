
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
//tokenprivado	clienteid	clientesecret	chavepixaleatoria	recebercom	aposvencimento	diasdesconto	valordesconto	multaapos	jurosapos	usuariocad	datacad	

@$id = $_POST['id'];
@$tokenprivado = AspasBanco($_POST['tokenprivado']);
@$clienteid    = AspasBanco($_POST['clienteid']);
@$clientesecret    = AspasBanco($_POST['clientesecret']);
@$chavepixaleatoria    = AspasBanco($_POST['chavepixaleatoria']);
@$recebercom = $_POST['recebercom'];
if ($_POST['aposvencimento'] != '') {
    @$aposvencimento = $_POST['aposvencimento'];
} else {
    @$aposvencimento = 0;
}
if ($_POST['diasdesconto'] != '') {
    @$diasdesconto = $_POST['diasdesconto'];
} else {
    $diasdesconto = 0;
}
@$valordesconto = Moeda($_POST['valordesconto']);
@$multaapos = Moeda($_POST['multaapos']);
@$jurosapos = Moeda($_POST['jurosapos']);
@$url = AspasBanco($_POST['url']);

@$convenio = $_POST['convenio'];
@$contrato = $_POST['contrato'];
@$agencia = $_POST['agencia'];
@$conta = $_POST['conta'];
@$codigocedente = $_POST['codigocedente'];
@$variacaocarteira = $_POST['variacaocarteira'];
@$carteira = $_POST['carteira'];

if (!empty($_POST['id'])) {
    mysqli_query($conexao, "update dadoscobranca set 
    tokenprivado='$tokenprivado',
    clienteid='$clienteid',
    clientesecret='$clientesecret',
    chavepixaleatoria='$chavepixaleatoria',
    recebercom='$recebercom',
    aposvencimento='$aposvencimento',
    diasdesconto='$diasdesconto',
    valordesconto='$valordesconto',
    multaapos='$multaapos',
    jurosapos='$jurosapos',
    convenio='$convenio',
    contrato='$contrato',
    agencia='$agencia',
    conta='$conta',
    codigocedente='$codigocedente',
    variacaocarteira='$variacaocarteira',
    carteira='$carteira',
    usuariocad='$nomeuser',
    datacad=NOW(),
    url='$url'
    where id='$id'") or die(mysqli_error($conexao));
    echo sucesso();
} else {
    mysqli_query($conexao, "insert into dadoscobranca (tokenprivado,clienteid,clientesecret,chavepixaleatoria,recebercom,aposvencimento,
    diasdesconto,valordesconto,multaapos,jurosapos,contrato,convenio,agencia,conta,codigocedente,variacaocarteira,carteira,usuariocad,datacad,url)
    values ('$tokenprivado','$clienteid','$clientesecret','$chavepixaleatoria','$recebercom','$aposvencimento',
    '$diasdesconto','$valordesconto','$multaapos','$jurosapos','$contrato','$convenio','$agencia','$conta','$codigocedente','$variacaocarteira','$carteira','$nomeuser',NOW(),'$url')
    ") or die(mysqli_error($conexao));
    echo sucesso();
}


?>