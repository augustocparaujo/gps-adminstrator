<?php
@session_start();
include('conexao.php'); 
include_once('funcoes.php');
@$iduser = $_SESSION['gps_iduser'];
@$nomeuser = $_SESSION['gps_nomeuser'];
@$usercargo = $_SESSION['gps_cargouser'];
@$tipouser = $_SESSION['gps_tipouser'];
@$situacaouser = $_SESSION['gps_situacaouser'];
@$ip = $_SERVER['REMOTE_ADDR'];
@$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//token privado da empresa
$query2 = mysqli_query($conexao,"SELECT * FROM dadoscobranca WHERE recebercom='GERENCIANET'") or die (mysqli_error($conexao));
$retPrivado = mysqli_fetch_array($query2);
$aposvencimento = $retPrivado['aposvencimento'];
$multaapos = $retPrivado['multaapos'];
$jurosapos = $retPrivado['jurosapos'];
$cliente_id = $retPrivado['clienteid'];
$cliente_secret = $retPrivado['clientesecret'];

//teste
define('clienteid',$cliente_id);
define('secretid',$cliente_secret);
define('URL_API','https://sandbox.gerencianet.com.br');

//produção
/* define("clienteid",$cliente_id);
define("secretid",$cliente_secret);
define("URL_API","https://api.gerencianet.com.br"); */

function AcessoToken(){
  $url = URL_API.'/v1/authorize';
  $base64 = base64_encode(clienteid.':'.secretid);
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"grant_type": "client_credentials"}',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic '.$base64,
      'Content-Type: application/json'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $json = json_decode($response);
  //print_r($response);
  return $json->access_token;
}
//echo AcessoToken();


################################################# GERA BOLETO GNET ################################################
function gerarCobranca($idcliente,$nparcelas,$vencimento,$valor,$obs){
  include('conexao.php');
  $valorreal = $valor;
  $obs = $obs; //descrição do boleto
  $valor = Intval(limpa($valor)); //valor do boleto
  $vencimento = dataBanco($vencimento);
  $nparcelas = Intval($nparcelas);
  $token = AcessoToken();

  for($i = 1; $i <= $nparcelas;){
    //se segundo loop adiciona mais um mês
    if($i >= 2){ 
      $vencimento = date('Y-m-d', strtotime('+1 month', strtotime($vencimento))); /*1 mês*/ 
    }

  //dados da empresa
  $query2 = mysqli_query($conexao,"SELECT * FROM dadoscobranca WHERE recebercom='GERENCIANET' AND clienteid <> '' AND clientesecret <> ''") or die (mysqli_error($conexao));
  if(mysqli_num_rows($query2) == 1){//dados banco
      $retPrivado = mysqli_fetch_array($query2);
      $aposvencimento = $retPrivado['aposvencimento'];
      if($retPrivado['multaapos'] != '0.00'){ $multaapos = limpa($retPrivado['multaapos']); }else{ $multaapos = 0;}
      if($retPrivado['jurosapos'] != '0.00'){ $jurosapos = limpa($retPrivado['jurosapos']); }else{ $jurosapos = 0; }
      if($retPrivado['valordesconto'] != '0.00'){ $valordesconto = Intval(limpa($retPrivado['valordesconto'])); }else{ $valordesconto = 0; }
      $datadesconto = date('Y-m-d', strtotime('-'.$retPrivado['diasdesconto'].' days', strtotime($vencimento)));
      $urlnotificacao = $retPrivado['url'];

      //dados do cliente
      $queryCliente = mysqli_query($conexao,"SELECT * FROM cliente WHERE id='$idcliente'") or die (mysqli_error($conexao));
      $ddcliente = mysqli_fetch_array($queryCliente);
      $nomecliente = AspasBanco($ddcliente['nome']); //nome cliente
      $email = $ddcliente['email']; //email cliente
      if(@$ddcliente['cpf'] != '' AND @$ddcliente['cnpj'] == ''){ @$doccliente = $ddcliente['cpf']; } else{ @$doccliente = $ddcliente['cnpj']; }  //documento cliente
      $contato = $ddcliente['contato'];
      $rua = $ddcliente['endereco'];
      $numero = $ddcliente['numero'];
      $bairro = $ddcliente['bairro'];
      $cep = $ddcliente['cep'];
      $municipio = $ddcliente['cidade'];
      $complemento = '123';
      $estado = $ddcliente['estado'];
      $tipoboleto = 'BOLETO';//$ddcliente['tipodecobranca'];

      $custom_id = gerarToken(false).gerarToken(true);
    
    //tratar e enviar dados
    $url = URL_API.'/v1/charge/one-step';
    $curl = curl_init();
    $item_1 = [
        "name" => $obs, // nome do item, produto ou serviço
        "amount" => $nparcelas, // quantidade
        "value" => $valor, // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
    ];
    $items = [
        $item_1
    ];
    $metadata = array(
      "custom_id" => $custom_id,
      "notification_url"=> 'https://augustocezar.com.br/gps/notificacao.php?customid='.$custom_id //$urlnotificacao."?customid=$custom_id"
      );
    $address = [
        "street" => $rua,
        "number" => $numero,
        "neighborhood" => $bairro,
        "zipcode" => $cep,
        "city" => $municipio,
        "complement" => $complemento,
        "state" => $estado,
    ];
    $customer = [
        "name" => $nomecliente, // nome do cliente
        "cpf" => $doccliente, // cpf válido do cliente
        "phone_number" => $contato, // telefone do cliente
        "address" => $address,
    ];
    $configurations = [ // configurações de juros e mora
        "fine" => $multaapos, // porcentagem de multa
        "interest" => $jurosapos, // porcentagem de juros
    ];
    $conditional_discount = [ // configurações de desconto condicional
        "type" => "currency", // seleção do tipo de moeda->currency ou parcenage->percentage
        "value" => $valordesconto, // porcentagem de desconto
        "until_date" => $datadesconto, // data máxima para aplicação do desconto
    ];
    $bankingBillet = [
        "expire_at" => $vencimento, // data de vencimento do titulo
        "message" => $obs, // mensagem a ser exibida no boleto
        "customer" => $customer,
        "conditional_discount" => $conditional_discount,
    ];
    $payment = [
        "banking_billet" => $bankingBillet, // forma de pagamento (banking_billet = boleto)
    ];
    $body = [
        "items" => $items,
        "metadata" =>$metadata,
        "payment" => $payment,
    ];

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($body),
      CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer $token",
          "Content-Type: application/json"
        ),
    ));    
    $response = curl_exec($curl);    
    curl_close($curl);
    $json = json_decode($response,true);    
    //print_r($response);
    if($json['code'] == 200){ 

        //status
        switch ($json['data']['status']) {
        case 'waiting':
            $situacao = 'PENDENTE';
            break;
        case 'unpaid':
            $situacao = 'PENDENTE';
            break;
        case 'paid':
            $situacao = 'RECEIBIDO';
            break;
        case 'settled':
            $situacao = 'RECEBIDO';
            break;
        case 'canceled':
            $situacao = 'CANCELADO';
        break;
        }
        $vencimentoreal = dataBanco($vencimento);
        $barcode = $json['data']['barcode'];
        $qrcode_image = AspasBanco($json['data']['pix']['qrcode_image']);
        $link = AspasBanco($json['data']['link']);
        $billet_link = AspasBanco($json['data']['billet_link']);
        $pdf = AspasBanco($json['data']['pdf']['charge']);
        $charge_id = $json['data']['charge_id'];

        $sql2 = mysqli_query($conexao,"SELECT code FROM cobranca WHERE code <> '' ORDER BY code DESC") or die (mysqli_error($conexao));
        if(mysqli_num_rows($sql2) >= 1){ 
          @$code = 1234567890; 
        } else { 
          $d2 = mysqli_fetch_array($sql2); @$code = $d2['code'] + 1; 
        } 

        mysqli_query($conexao,"INSERT INTO cobranca (idcliente,banco,custom_id,idcobranca,nparcela,tipo,tipocobranca,code,link,
        installmentLink,pdf,codigobarra,ncobranca,cliente,descricao,obs,vencimento,valor,situacao,datagerado,qrcode)
        VALUES ('$idcliente','GERENCIANET','$custom_id','$charge_id','$nparcelas','$tipoboleto','plano','$charge_id','$link','$billet_link','$pdf',
        '$barcode','$charge_id','$nomecliente','$obs','$obs','$vencimentoreal','$valorreal','$situacao',NOW(),'$qrcode_image')") 
        or die (mysqli_error($conexao));

        echo persona('Cobrança gerado com sucesso','success');        
    
    }else{ 
        if ($json['code'] == 3500037) {
            echo persona('Vencimento inválido','danger');
        } elseif ($json['code'] == 3500034){
          //print_r($json);
              echo persona('Dados do cliente inválido!<br />Boleto não gerado!<br />Gerar boleto manual','danger');
        } else {
            echo persona('Erro código: '.$json['code'].',<br />erro: '.$json['error'].'<br /> Descricação: '.$json['error_description'].'','danger');
            //print_r($response);
        }
    } 
  }else{
    echo persona('Dados Gerencianet incompletos','danger');
  }

  $i++;
}
}
//echo gerarCobrancaGerencianet();

################################################# CONSULTA BOLETO GNET ################################################
//consultar -> /v1/charge/:id
function consultaCobranca($id){
    include('conexao.php'); 
    $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id'") or die (mysqli_error($conexao));
    $r = mysqli_fetch_array($sql);
    $idcobranca = $r['ncobranca'];
    $nomecliente = $r['cliente'];

  $token = AcessoToken();
  $url = URL_API.'/v1/charge/';
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url.$idcobranca,
    //CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $token",
      "Content-Type: application/json"
        ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $json = json_decode($response,true);
  //print_r($response);
  //baixa no banco caso já tenha recebido  
  if($json['code'] == 200){ //se sucesso na geração
    //status
    switch ($json['data']['status']) {
      case 'waiting':
          $situacao = 'PENDENTE';
          $valorpago = 0.00;
          break;
      case 'unpaid':
          $situacao = 'PENDENTE';
          $valorpago = 0.00;
          break;
      case 'paid':
          $situacao = 'RECEBIDO';
          $valorcorrigido = $json['data']['total']/100;
          $valorpago = number_format((float)$valorcorrigido, 2, '.', '');
          break;
      case 'settled':
          $situacao = 'RECEBIDO';
          $valorcorrigido = $json['data']['total']/100;
          $valorpago = number_format((float)$valorcorrigido, 2, '.', '');
          break;
      case 'canceled':
          $situacao = 'CANCELADO';
          $valorpago = 0.00;
      break;
    } 

    mysqli_query($conexao,"UPDATE cobranca SET valorpago='$valorpago',situacao='$situacao' WHERE id='$id'") or die (mysqli_error($conexao));
    echo persona($situacao,'info');

    if($situacao == 'RECEBIDO'){
      //alimeNta o caixa
      mysqli_query($conexao,"INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
      VALUES ('ENTRADA','$nomecliente','BOLETO','$valorpago','$valorpago','$valorpago',NOW(),NOW(),'BAIXA AUTOMATICA','RECEBIDO')") 
      or die (mysqli_error($conexao));

    }

  }else{
    if($json['code'] == 3500037){
        echo persona('Vencimento inválido','danger');
    }else{
        echo persona('Erro código: '.$json['code'].', <br />erro: '.$json['error'].'<br /> Descricação: '.$json['error_description'].'','danger');
    }
  }
}
//echo ConsultaBoletoGerenciaNet(1659661);

################################################# CANCELA BOLETO GNET ################################################

//cancelar boleto -> /v1/charge/:id/cancel
function cancelarCobranca($id,$obs){
    include('conexao.php'); 
    $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id'") or die (mysqli_error($conexao));
    $r = mysqli_fetch_array($sql);
    $idcobranca = $r['ncobranca'];

  $token = AcessoToken();
  $url = URL_API.'/v1/charge/';
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url.$idcobranca.'/cancel',
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $token",
      "Content-Type: application/json"
        ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $json = json_decode($response,true);
  //print_r($response);
  if($json['code'] == 200){ //se sucesso no cancelamento

      ///nome user não está vindo com o log
      $obs = AspasBanco($obs).' Data: '.date('d-m-Y H:m:s');
    mysqli_query($conexao,"UPDATE cobranca SET situacao='CANCELADO',obs='$obs',atualizado=NOW() WHERE id='$id'") or die (mysqli_error($conexao));
    echo deletePersona('Cancelado com sucesso!');

  }else{
    if($json['code'] == 3500037){
        echo persona('Vencimento inválido','danger');
    }else{
        echo persona('Erro código: '.$json['code'].', <br />erro: '.$json['error'].'<br /> Descricação: '.$json['error_description'].'','danger');
    }
  }
}
//echo CancelarBoletoGerenciaNet(446694324);


//cancelar boleto -> /v1/charge/:id/settle
function receberCobranca($id){
  include('conexao.php'); 
  $sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id'") or die (mysqli_error($conexao));
  $r = mysqli_fetch_array($sql);
  $idcobranca = $r['ncobranca'];
  $idcliente = $r['idcliente'];
  $valor = $r['valor'];
  $nomecliente = $r['cliente'];

$token = AcessoToken();
$url = URL_API.'/v1/charge/';
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url.$idcobranca.'/settle',
  CURLOPT_SSL_VERIFYPEER => true,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_MAXREDIRS => 2,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer $token",
    "Content-Type: application/json"
      ),
));
$response = curl_exec($curl);
curl_close($curl);
$json = json_decode($response,true);
//print_r($response);
if($json['code'] == 200){ //se sucesso no cancelamento
    ///nome user não está vindo com o log
  mysqli_query($conexao,"UPDATE cobranca SET situacao='RECEBIDO',valorpago='$valor',datapagamento=NOW(),obs='Recebido na empresa',atualizado=NOW() WHERE id='$id'") or die (mysqli_error($conexao));                        
  echo persona('Recebido','success');

  //alimeNta o caixa
  mysqli_query($conexao,"INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
  VALUES ('ENTRADA','$nomecliente','BOLETO','$valor','$valor','$valor',NOW(),NOW(),'CARTEIRA','RECEBIDO')") 
  or die (mysqli_error($conexao));
  echo persona('Recebido com sucesso','success');

}else{
  if($json['code'] == 3500037){
      echo persona('Vencimento inválido','danger');
  }else{
      echo persona('Erro código: '.$json['code'].', <br />erro: '.$json['error'].'<br /> Descricação: '.$json['error_description'].'','danger');
  }
}
}
//echo receberBoletoGerenciaNet(446694324);
?>