<?php
function Moeda22($get_valor) {
$source = array('.', ',');
$replace = array('', '.');
$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
if(empty($valor)){return 0;}else{return $valor;} //retorna o valor formatado para gravar no banco
};//moeda
$valor = Moeda22($_POST['valor']);
$vencimento = date('Y-m-d',strtotime($_POST['vencimento']));

//verificar pra qual api mandar
if($_POST['banco'] == 'BANCO JUNO'){

    include_once('api_juno.php');
    gerarCobranca($_POST['idcliente'],$_POST['nparcela'],$vencimento,$valor,$_POST['servico']);

}elseif($_POST['banco'] == 'GERENCIANET'){

    include_once('api_gerencianet.php');
    gerarCobranca($_POST['idcliente'],$_POST['nparcela'],$vencimento,$valor,$_POST['servico']);

}elseif($_POST['banco'] == 'BANCO DO BRASIL'){ 

    include_once('api_bb.php');  
    $idcliente = $_POST['idcliente'];
    $descricao = $_POST['servico'];
    $dataVencimento = $vencimento;
    $nparcela = $_POST['nparcela'];
    gerarCobranca($idcliente,$nparcela,$valor,$descricao,$dataVencimento);

}elseif($_POST['banco'] == 'CARTEIRA'){
    //gerar cobrança carteira
    include_once('api_carteira.php');
    gerarCobranca($_POST['idcliente'],$_POST['nparcela'],$vencimento,$valor,$_POST['servico']);
}else{
    echo' <div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" style="">
        <button class="toast-close-button">×</button>
        <div class="toast-title">Erro inesperado!</div>
    </div>
    </div>';
}
