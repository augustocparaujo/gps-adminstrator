<?php
//Desenvolvido por André Melo
//Alterações por Augusto Araujo
ob_start();
@session_start();
include_once('conexao.php'); 
include_once('funcoes.php');
$idempresa = $_SESSION['idempresa'];
$iduser = $_SESSION['gps_iduser'];
$nomeuser = $_SESSION['usuario'];//pega usuario que est� executando a a�o
$situacaouser = $_SESSION['gps_situacaouser'];
$ip = $_SERVER['REMOTE_ADDR']; // pegar ip da maquina
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); //pega nome da maquina

//configuração boleto
$sql0 = mysqli_query($conexao,"SELECT * FROM dadoscobranca WHERE recebercom='Banco do Brasil'") or die (mysqli_error($conexao));
$ddcb = mysqli_fetch_array($sql0);
#################################
define('BB_MULTA', $ddcb['multaapos']); //valor da multa
define('BB_APOSVENCIMENTO', $ddcb['aposvencimento']);
define('BB_DESCONTO', $ddcb['valordesconto']); //valor desconto
define('BB_DATAEXPIRACAODESCONTO', $ddcb['diasdesconto']); //data para desconto
define('BB_CLIENT_ID', $ddcb['clienteid']);
define('BB_CLIENT_SECRET', $ddcb['clientesecret']);
define('BB_CONVENIO', $ddcb['convenio']); //codigo de teste
define('BB_CARTEIRA', $ddcb['carteira']);
define('BB_VARIACAOCARTEIRA', $ddcb['variacaocarteira']);
#################################
//para teste
define('BB_OAUTH2', 'https://oauth.sandbox.bb.com.br'); //teste
define('BB_API', 'https://api.hm.bb.com.br');
define('BB_APPKEY', 'd27b77790bffab901364e17d90050156b9c1a5bd');
#################################
//produção
/* define('BB_OAUTH2', 'https://oauth.bb.com.br');
define('BB_API', 'https://api.bb.com.br');
define('BB_APPKEY', '7091208b02ffbe30136ce18120050356b9c1a5ba'); */

//gerar o token
function AccessToken($ts){
    if ($ts == 0) {$scope = 'cobrancas.boletos-requisicao';} //cria//altera/baixa/cancela
    if ($ts == 1) {$scope = 'cobrancas.boletos-info';} //consulta
    $post = array('grant_type' => 'client_credentials', 'scope' => $scope);
    $base64 = base64_encode(BB_CLIENT_ID . ':' . BB_CLIENT_SECRET);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, BB_OAUTH2.'/oauth/token');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic '.$base64,
        'Content-Type: application/x-www-form-urlencoded'
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response);
    //print_r($response);
    $access_token = $json->access_token;
    return $access_token;
}

###############################################################################################################

//criar boletos
function gerarCobranca($idcliente,$nparcela,$dataVencimento,$valor,$descricao){
    include_once('conexao.php');
    for($i = 1; $i <= $nparcela;){      

    $parcela = $i;   
    $sql0 = mysqli_query($conexao,"SELECT MAX(code) AS code FROM cobranca WHERE banco='Banco do Brasil'") or die (mysqli_error($conexao));
    $dd0 = mysqli_fetch_array($sql0);
    $numeroTitulo = intval($dd0['code']) + $i + 10;
    //$numeroTitulo = strtotime(date('Hms'));
    //cliente
    $sql = mysqli_query($conexao,"SELECT * FROM cliente WHERE id='$idcliente'") or die (mysqli_error($conexao));
    $dd = mysqli_fetch_array($sql);
    $nome = $dd['nome'];
    $cpf = $dd['cpf'];
    $cnpj = $dd['cnpj'];
    $cep = $dd['cep'];
    $endereco = AspasBanco($dd['rua']);
    $bairro = AspasBanco($dd['bairro']);
    $cidade = AspasBanco($dd['municipio']);
    $uf = $dd['estado'];

############################################################################
        $v1 = explode("-",$dataVencimento);
        $diaReal = $v1[0];

        if($parcela >= 2){           

            $v = explode(".",$dataVencimentoBB);
            $mes = $v[1] + 1;

            if($mes == 02){
                $dataVencimentoBB = date('28.02.Y',strtotime($dataVencimentoBB));
            }else{
                $dataVencimentoBB = date($v1[0].'.m.Y',strtotime('+1 months',strtotime($dataVencimentoBB)));
            }

        } else {              
            $dataVencimentoBB = date('d.m.Y', strtotime($dataVencimento)); 
        }
############################################################################

    //nosso número de cobrança
    $numeroTituloCliente = "000" . (BB_CONVENIO . str_pad($numeroTitulo, 10, '0', STR_PAD_LEFT));
    //cpf ou cnpj
    if($cpf != ''){ 
        $identificacao = preg_replace("/[^0-9]/", "", $cpf);
        $tipopessoa = 1;
    }else{ 
        $identificacao = preg_replace("/[^0-9]/", "", $cnpj); 
        $tipopessoa = 2;
    }

    $pagador = (object)array(
        "tipoInscricao" => $tipopessoa,
        "numeroInscricao" => $identificacao,
        "nome" => (string) $nome,
        "endereco" => (string) $endereco . ', ' . $bairro,
        "cep" => preg_replace("/[^0-9]/", "", $cep),
        "cidade" => (string) $cidade,
        "bairro" => (string) $bairro,
        "uf" => (string) $uf,
    );

    $juros = (object)array( 
        "tipo" => 0 
    ); 

    $datamulta = date('d.m.Y', strtotime('+'.BB_APOSVENCIMENTO.'days', strtotime($dataVencimentoBB)));    
    //multa // forma se valor ou porcentagem //tipo dia ou mes
     //forma valor // tipo dia
        $multa = (object)array( 
            "tipo" => 1,
            "data" => $datamulta,
            "valor" => BB_MULTA,
        ); 
    
    //print_r($multa);
    $diasparadesconto = date('d.m.Y', strtotime('-'.BB_DATAEXPIRACAODESCONTO.'days', strtotime($dataVencimentoBB)));    
    //dias para desconto
    $desconto = (object)array(
        "tipo" => 1,
        "dataExpiracao" => $diasparadesconto,
        "valor" => BB_DESCONTO,
    );

    $post = array(
        "numeroConvenio" => BB_CONVENIO,
        "numeroCarteira" => BB_CARTEIRA,
        "numeroVariacaoCarteira" => BB_VARIACAOCARTEIRA,
        "codigoAceite" => "A",
        "codigoModalidade" => 1,
        "codigoTipoTitulo" => 4,
        "dataVencimento" => $dataVencimentoBB,
        "valorOriginal" => $valor,
        "quantidadeDiasProtesto" => 0,
        "textoMensagemBloquetoTitulo" => $descricao,
        "descricaoTipoTitulo" => $descricao,
        "numeroTituloBeneficiario" => $numeroTitulo,
        "numeroTituloCliente" => $numeroTituloCliente,
        "jurosMora" => $juros,
        "multa" => $multa,
        "desconto" => $desconto,
        "pagador" => $pagador,
        "indicadorPix" => "S"
    );

    $token = AccessToken(0);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, BB_API . '/cobrancas/v2/boletos?gw-dev-app-key='.BB_APPKEY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);      

        // log: cobranca	erro	mensa	data	
        if(@$json['error'] != ''){
            $erro = $json['statusCode'];
            if($json['message'] == 'Application key is not allowed to call this resource method'){
                $mensa = 'A chave do aplicativo não tem permissão para chamar este método de recurso';
            }else{
                $mensa = $json['message'];
            }
           
            mysqli_query($conexao,"INSERT INTO log_cobranca (idcliente,cliente,data,log) VALUES ('$idcliente','$nome',NOW(),'$mensa')") or die (mysqli_error($conexao));
            echo persona($mensa,'danger');

        }elseif(@$json['erros'] != ''){
            $jsonerror = $json['erros'];
            foreach ($jsonerror as $itemerror) {
                $erro = $itemerror['codigo'];
                    $mensa = $itemerror['mensagem'];
            }

            mysqli_query($conexao,"INSERT INTO log_cobranca (idcliente,cliente,data,log) VALUES ('$idcliente','$nome',NOW(),'$mensa')") or die (mysqli_error($conexao));
            echo persona($mensa,'danger');
        }else{

            $numero = $json['numero'];
            $codigoLinhaDigitavel = $json['linhaDigitavel'];
            $codigoBarraNumerico = $json['codigoBarraNumerico'];
            //echo ''.$json['qrCode']['url']; echo'<br />';
            $txId = $json['qrCode']['txId'];
            $qrCode = $json['qrCode']['emv'];
            //inserir no banco tabela cobrança
            $vencimentoreal = dataBanco($dataVencimentoBB);
            $barcode = $qrCode;

            mysqli_query($conexao,"INSERT INTO cobranca (idcliente,custom_id,idcobranca,nparcela,parcela,banco,tipo,tipocobranca,code,installmentLink,codigobarra,
            codigodelinhadigitavel,ncobranca,cliente,descricao,obs,vencimento,valor,situacao,datagerado,qrcode,qrcode2)
            VALUES ('$idcliente','$txId','$numero','$nparcela','$parcela','Banco do Brasil','BOLETO_PIX','plano','$numeroTitulo','$barcode',
            '$codigoBarraNumerico','$codigoLinhaDigitavel','$numero','$nome','$descricao','$descricao','$vencimentoreal','$valor','PENDENTE',NOW(),'$qrCode','$qrCode')") 
            or die (mysqli_error($conexao));

            echo persona('Gerado com sucesso','success');  

        }
    
        $i++;
        sleep(2);
    }
        
} //GerarBoleto

//json_encode(GerarBoleto(777710,11.00,"20.04.2022","AUUGUSTO CEZAR PINHEIRO",96050176876,68741515,"Rua 39 Salles Jardim","Titanlandia","Castanhal","PA"));

###############################################################################################################

///consulta para verificar se foi gerada corretamente boletos/{id}
function consultarCobranca($id){
    //configuração boleto
    include_once('conexao.php'); 
    $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));
    $r = mysqli_fetch_array($sql);
    $numeroTituloCliente = $r['ncobranca'];
    $valor = $r['valor'];

    $token = AccessToken(1);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, BB_API . '/cobrancas/v2/boletos/' . $numeroTituloCliente . '?gw-dev-app-key=' . BB_APPKEY . '&numeroConvenio=' . BB_CONVENIO);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    //print_r($response);
    //return $json;
    //se retoronar erro
    // log: cobranca	erro	mensa	data	

    $cobranca = $numeroTituloCliente;
    if(@$json['error'] != ''){
        $erro = $json['statusCode'];
            $mensa = $json['message'];     
        mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$numeroTituloCliente','$erro','$mensa',NOW())") or die (mysqli_error($conexao));
        echo persona($mensa,'danger');

    }elseif(@$json['erros'] != ''){
        $jsonerror = $json['erros'];
        foreach ($jsonerror as $itemerror) {
            $erro = $itemerror['codigo'];
            $mensa = $itemerror['mensagem'];

            mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$numeroTituloCliente','$erro','$mensa',NOW())") or die (mysqli_error($conexao));                    
            echo persona($mensa,'danger');           
        }        
    }elseif(@$json['errors'] != ''){
        $jsonerror = $json['errors'];
        foreach ($jsonerror as $itemerror) {
            $erro = $itemerror['code'];
            $mensa = $itemerror['message'];

            mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$numeroTituloCliente','$erro','$mensa',NOW())") or die (mysqli_error($conexao));                    
            echo persona($mensa,'danger');           
        }        
    }else{
                    
        if($json['codigoEstadoTituloCobranca'] == 6 OR $json['codigoEstadoTituloCobranca'] == 7){ //se pago
            $valorpago = $json['valorPagoSacado'];
            $datapagamento =  date('Y-m-d',strtotime($json['dataRecebimentoTitulo']));
            $situacao = 'RECEBIDO'; 

            mysqli_query($conexao,"UPDATE cobranca SET valorpago='$valorpago',datapagamento='$datapagameto',situacao='$situacao' WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));
            //alimeNta o caixa
            mysqli_query($conexao,"INSERT INTO caixa (banco,tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user) 
            VALUES ('Banco do Brasil','ENTRADA','$nomecliente','BOLETO','$valorpago','$valorpago','$valorpago','$datapagameto','$datapagameto','BAIXA SISTEMA')") 
            or die (mysqli_error($conexao));
            echo persona('Recebido com sucesso','success');

        }else{
            echo persona('Aguardando pagamento','success');
        }
    }  

}//echo Consultar('00031285571670346778');

###############################################################################################################

//boletos/{id}/baixar também serve como cancelamento de boleto
function receberCobranca($id,$valorpago,$datapagamento,$nomeuser){
    //configuração boleto
    include_once('conexao.php'); 
    $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));
    $r = mysqli_fetch_array($sql);
    $numeroTituloCliente = $r['ncobranca'];
    $descicao = $r['obs'].'(Recebido em carteira)';

    $post = array( "numeroConvenio" => BB_CONVENIO );
    $token = AccessToken(0);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, BB_API.'/cobrancas/v2/boletos/'.$numeroTituloCliente.'/baixar?gw-dev-app-key='.BB_APPKEY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);

            // log: cobranca	erro	mensa	data	
            $cobranca = $numeroTituloCliente;
            if(@$json['error'] != ''){
                $erro = $json['statusCode'];
                if($json['message'] == 'Application key is not allowed to call this resource method'){
                    $mensa = 'A chave do aplicativo não tem permissão para chamar este método de recurso';
                }else{
                    $mensa = $json['message'];
                }
                mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$cobranca','$erro','$mensa',NOW())") or die (mysqli_error($conexao));
                echo persona($mensa,'danger');
    
            }elseif(@$json['erros'] != ''){
                $jsonerror = $json['erros'];
                foreach ($jsonerror as $itemerror) {
                    $erro = $itemerror['codigo'];
                        $mensa = $itemerror['mensagem'];
                }
    
                mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$cobranca','$erro','$mensa',NOW())") or die (mysqli_error($conexao));
                echo persona($mensa,'danger');
            }

            //se for me branco a resposta
            mysqli_query($conexao,"UPDATE cobranca SET situacao='RECEBIDO',valorpago='$valorpago',
            datapagamento='$datapagamento',obs='$descicao',usuarioatualizou='$nomeuser',atualizado=NOW() WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));  

            echo persona('Recebido com sucesso','success');

}//BaixarBoleto('00031285570000077779');   

###############################################################################################################
    
//boletos/{id}/baixar também serve como cancelamento de boleto
function cancelarCobranca($id,$nomeuser){
    //configuração boleto
    include_once('conexao.php'); 
    $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));
    $r = mysqli_fetch_array($sql);
    $numeroTituloCliente = $r['ncobranca'];
    $descicao = $r['obs'];

    $post = array( "numeroConvenio" => BB_CONVENIO );
    $token = AccessToken(0);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, BB_API.'/cobrancas/v2/boletos/'.$numeroTituloCliente.'/baixar?gw-dev-app-key='.BB_APPKEY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);

            // log: cobranca	erro	mensa	data	
            $cobranca = $numeroTituloCliente;
            if(@$json['error'] != ''){
                $erro = $json['statusCode'];
                if($json['message'] == 'Application key is not allowed to call this resource method'){
                    $mensa = 'A chave do aplicativo não tem permissão para chamar este método de recurso';
                }else{
                    $mensa = $json['message'];
                }
                mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$cobranca','$erro','$mensa',NOW())") or die (mysqli_error($conexao));
                echo persona($mensa,'danger');
    
            }elseif(@$json['erros'] != ''){
                $jsonerror = $json['erros'];
                foreach ($jsonerror as $itemerror) {
                    $erro = $itemerror['codigo'];
                        $mensa = $itemerror['mensagem'];
                }
    
                mysqli_query($conexao,"INSERT INTO log (cobranca,erro,mensa,data) VALUES ('$cobranca','$erro','$mensa',NOW())") or die (mysqli_error($conexao));
                echo persona($mensa,'danger');
            }

        ///nome user não está vindo com o log
        mysqli_query($conexao,"UPDATE cobranca SET situacao='CANCELADO',usuarioatualizou='$nomeuser',atualizado=NOW() WHERE id='$id' AND banco='Banco do Brasil'") or die (mysqli_error($conexao));
        echo persona('Cancelado com sucesso!','danger');

}//BaixarBoleto('00031285570000077779');    
