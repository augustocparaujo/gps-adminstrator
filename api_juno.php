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

//token privado da empresa
$query2 = mysqli_query($conexao, "SELECT * FROM dadoscobranca WHERE recebercom='BANCO JUNO'") or die(mysqli_error($conexao));
$retPrivado = mysqli_fetch_array($query2);
$tokenprivado = $retPrivado['tokenprivado'];
$aposvencimento = $retPrivado['aposvencimento'];
$multaapos = $retPrivado['multaapos'];
$jurosapos = $retPrivado['jurosapos'];
$cliente_id = $retPrivado['clienteid'];
$cliente_secret = $retPrivado['clientesecret'];

//desenvolcido por André R. Melo
define('JUNO_CLIENT_ID', $cliente_id);
define('JUNO_CLIENT_SECRET', $cliente_secret);
define('JUNO_OAUTH2', 'https://sandbox.boletobancario.com/authorization-server/oauth/token');
//define('JUNO_OAUTH2', 'https://api.juno.com.br/authorization-server/oauth/token');

########################################################## OBTER TOKEN JUNO ######################################################################
function AccessTokenJuno()
{
  include('conexao.php');
  //gera o token
  $scope = "all";
  $post = array(
    'grant_type' => 'client_credentials',
    'scope' => $scope,
    "expires_in" => 3600
  );
  $base64 = base64_encode(JUNO_CLIENT_ID . ':' . JUNO_CLIENT_SECRET);
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, JUNO_OAUTH2);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . $base64,
    'Content-Type: application/x-www-form-urlencoded'
  ));
  //tratar resposta
  $response = curl_exec($curl);
  curl_close($curl);
  $json = json_decode($response);
  //print_r($response);
  $access_token = @$json->access_token;

  //verificar token no banco se ainda é válido
  $query = mysqli_query($conexao, "SELECT * FROM token_cli") or die(mysqli_error($conexao));
  if (mysqli_num_rows($query) == 1) {
    $ret = mysqli_fetch_array($query);
    $idtoken = $ret['id'];
    //comparar daa hora
    if ($ret['expira'] > date('Y-m-d H:i:s')) {
      $access_token = $ret['token'];
    } else {
      mysqli_query($conexao, "DELETE FROM token_cli") or die(mysqli_error($conexao));
      //exckuir e salvar novo
      $datahora = date('Y-m-d H:i:s');
      $datahora = date('Y-m-d H:i:s ', strtotime('+25 minutes', strtotime($datahora)));
      mysqli_query($conexao, "INSERT INTO token_cli (token,data,expira) 
        VALUES ('$access_token',NOW(),'$datahora')") or die(mysqli_error($conexao));
      //print('Gerado e salvo com sucesso');         
    }
  } else {
    //e não existir token ainda adiciona um
    $datahora = date('Y-m-d H:i:s');
    $datahora = date('Y-m-d H:i:s ', strtotime('+25 minutes', strtotime($datahora)));
    mysqli_query($conexao, "INSERT INTO token_cli (token,data,expira) 
      VALUES ('$access_token',NOW(),'$datahora')") or die(mysqli_error($conexao));
    //print('Gerado e salvo com sucesso'); 
  }

  return $access_token;
}

########################################################## GERAR COBRANÇA ######################################################################

function gerarCobranca($idcliente, $nparcelas, $vencimento, $valor, $obs)
{
  include('conexao.php');
  $obs = AspasBanco($obs);
  $custom_id = gerarToken(false) . gerarToken(true);
  //dados do cliente
  $queryCliente = mysqli_query($conexao, "SELECT * FROM cliente WHERE id='$idcliente'") or die(mysqli_error($conexao));
  $ddcliente = mysqli_fetch_array($queryCliente);
  @$nomecliente = $ddcliente['nome']; //NOME CLIENTE
  @$valor = $valor; //VALOR BOLETO
  if (@$ddcliente['cpf'] != '' and @$ddcliente['cnpj'] == '') {
    @$doccliente = $ddcliente['cpf'];
  } else {
    @$doccliente = $ddcliente['cnpj'];
  }  //DOCUMENTO BOLETO
  //token privado da empresa
  $query2 = mysqli_query($conexao, "SELECT * FROM dadoscobranca WHERE recebercom='BANCO JUNO'") or die(mysqli_error($conexao));
  if (mysqli_num_rows($query2) == 1) { //dados banco
    $retPrivado = mysqli_fetch_array($query2);
    $tokenprivado = $retPrivado['tokenprivado'];
    $aposvencimento = $retPrivado['aposvencimento'];
    if ($retPrivado['multaapos'] != '0.00') {
      $multaapos = $retPrivado['multaapos'];
    } else {
      $multaapos = "";
    }
    if ($retPrivado['jurosapos'] != '0.00') {
      $jurosapos = $retPrivado['jurosapos'];
    } else {
      $jurosapos = "";
    }
    if ($retPrivado['valordesconto'] != '0.00') {
      $valordesconto = $retPrivado['valordesconto'];
    } else {
      $valordesconto = "";
    }
    $diasparadesconto = $retPrivado['diasdesconto'];

    if (!empty($retPrivado['chavepixaleatoria'])) {
      $tipoboleto = 'BOLETO_PIX';
      @$tipocobranca = ['BOLETO_PIX']; //TIPO DE COBANCA: BOLETO OU BOLETO_PIX
      $chavepixaleatoria = $retPrivado['chavepixaleatoria'];
    } else {
      $chavepixaleatoria = "";
      $tipoboleto = 'BOLETO';
      @$tipocobranca = ['BOLETO']; //TIPO DE COBANCA: BOLETO OU BOLETO_PIX
    }
    //token empresa
    $token = AccessTokenJuno();
    $curl = curl_init();
    $charge = (object)array(
      //chave pix
      "pixKey" => $chavepixaleatoria,
      //obter qr code
      "pixincludeImage" => true,
      //decrição da cobrança
      "description" => $obs,
      //total se for mais de um
      //"totalAmount" => 20.00,
      //valor da cobrança única ou por parcela
      "amount" => $valor,
      //vencimento
      "dueDate" => dataBanco($vencimento),
      //numero total de parcelas
      "installments" => $nparcelas,
      //número de dias para pagamento apos o vencimento
      "maxOverdueDays" => $aposvencimento,
      //multa após o vencimento
      "fine" => $multaapos,
      //juros ao mês
      "interest" => $jurosapos,
      //valor do descont
      "discountAmount" => $valordesconto,
      //múmero de dias para desconto
      "discountDays" => $diasparadesconto,
      //tipo de cobrança
      "paymentTypes" => $tipocobranca,
      //válido apenas para cartão credito, adiantamento de valor
      "paymentAdvance" => false,
    );

    $address = (object)array(
      "street" => AspasBanco($ddcliente['endereco']),
      "number" => "",
      "complement" => "",
      "neighborhood" => AspasBanco($ddcliente['bairro']),
      "city" => AspasBanco($ddcliente['cidade']),
      "state" => AspasBanco($ddcliente['estado']),
      "postCode" => limpa($ddcliente['cep'])
    );

    $billing = (object)array(
      "name" => $ddcliente['nome'],
      "document" => limpa($doccliente),
      "email" => $ddcliente['email'],
      "address" => $address,
      "notify" => true,
    );

    $dados = (object)array(
      "charge" => $charge,
      "billing" => $billing
    );

    $url = 'https://sandbox.boletobancario.com/api-integration/charges/';
    //$url = 'https://api.juno.com.br/api-integration/charges/';                            
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dados),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
        'X-Api-Version: 2',
        'X-Resource-Token:' . $tokenprivado,
        'Content-Type: application/json;charset=UTF-8'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    //print_r($json);
    //print('<hr>');
    if (!empty($json['error'])) {
      $jsonerror = $json['details'];
      foreach ($jsonerror as $itemerror) {
        if (!empty(AspasBanco(@$itemerror['field']))) {
          @$campo = AspasBanco(@$itemerror['field']);
        } else {
          @$campo = '';
        };
        $message = AspasBanco($itemerror['message']);
        $log = AspasBanco('Campo: ' . $campo . ' | Erro: ' . $message);
        mysqli_query($conexao, "INSERT INTO log_cobranca (idcliente,cliente,data,log) 
                                    VALUE ('$idcliente','$nomecliente',NOW(),'$log')") or die(mysqli_error($conexao));

        echo deletePersona(@$log);
      }
    } else {
      $json2 = $json['_embedded']['charges'];
      foreach ($json2 as $item) {
        //tratar retorno
        $idcobranca = $item['id'];
        $code = $item['code'];
        $vencimento = $item['dueDate'];
        $link = $item['link'];
        $codigobarra = $item['payNumber'];
        $installmentLink = $item['installmentLink'];
        if ($item['status'] == 'ACTIVE') {
          $situacao = 'PENDENTE';
        } else {
          $situacao = $item['status'];
        };
        if ($situacao == "PENDENTE") {
          if (!empty($link) and !empty($idcobranca)) {
            mysqli_query($conexao, "INSERT INTO cobranca (idcliente,idcobranca,banco,custom_id,nparcela,tipo,tipocobranca,code,link,
                                            installmentLink,codigobarra,cliente,descricao,obs,vencimento,valor,situacao,datagerado)
                                            VALUES ('$idcliente','$idcobranca','BANCO JUNO','$custom_id','$nparcelas','$tipoboleto','plano','$code','$installmentLink','$link',
                                            '$codigobarra','$nomecliente','$obs','$obs','$vencimento','$valor','$situacao',NOW())")
              or die(mysqli_error($conexao));

            /*
                                            //dispara email: $vencimento,$valor,$codigobarra,$link,$pdf,$emailcliente,$nomecliente
                                            include('api_email.php');
                                            $nomecliente = $ddcliente['nome'];
                                            $emailcliente = $ddcliente['email'];
                                            enviaEmail($vencimento,$valor,$codigobarra,$link,$pdf,$emailcliente,$nomecliente);
                                            */
          }
          echo sucesso();
        }
      }
    } //fim retorno cobrança gerada
  } else {
    echo deletePersona('Dados de banco incompleto');
  } //fim dados banco
}

########################################################## CONSULTA SE JÁ FOI PAGO ######################################################################

function consultarCobranca($id)
{
  include('conexao.php');
  $query = mysqli_query($conexao, "SELECT cobranca.*, cliente.nome FROM cobranca 
  LEFT JOIN cliente ON cobranca.idcliente = cliente.id
  WHERE cobranca.id='$id'") or die(mysqli_error($conexao));
  $ddcc = mysqli_fetch_array($query);
  $code = $ddcc['idcobranca'];
  $nomecliente = $ddcc['nome'];

  $query2 = mysqli_query($conexao, "SELECT * FROM dadoscobranca WHERE recebercom='BANCO JUNO'") or die(mysqli_error($conexao));
  $retPrivado = mysqli_fetch_array($query2);
  $tokenprivado = $retPrivado['tokenprivado'];


  $token = AccessTokenJuno();
  if (!empty(@$token)) {
    $url = 'https://sandbox.boletobancario.com/api-integration/charges/';
    //$url = 'https://api.juno.com.br/api-integration/charges/';
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url . $code,
      //CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_CUSTOMREQUEST => 'GET',
      //CURLOPT_POSTFIELDS => json_encode($dados),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
        'X-Api-Version: 2',
        'X-Resource-Token:' . $tokenprivado,
        'Content-Type: application/json;charset=UTF-8'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    //baixa no banco caso já tenha recebido
    //print_r($json);
    if ($json['status'] == 'PAID' or $json['status'] == 'MANUAL_RECONCILIATION') {
      //resposta do pagamento
      $json2 = $json['payments'];
      //percore o array para ver a data dop pagamento
      //foreach ($json2 as $item) { 
      //datapagamento
      if (!empty($item['releaseDate'])) {
        $datapagameto = $item['releaseDate'];
      } else {
        $datapagameto = date('Y-m-d');
      }
      //valor pago
      if (!empty($item['amount'])) {
        $valorpago = $item['amount'];
      } else {
        $valorpago = Moeda($json['amount']);
      }

      $status = 'RECEBIDO';
      mysqli_query($conexao, "UPDATE cobranca SET valorpago='$valorpago',datapagamento='$datapagameto',situacao='$status' WHERE idcobranca='$code'") or die(mysqli_error($conexao));
      //alimeNta o caixa
      mysqli_query($conexao, "INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
          VALUES ('ENTRADA','$nomecliente','BOLETO','$valorpago','$valorpago','$valorpago','$datapagameto','$datapagameto','BAIXA SISTEMA','RECEBIDO')")
        or die(mysqli_error($conexao));
      echo persona('Recebido com sucesso');
    } else {
      persona('Aguardando pagamento');
    }
  } else {
    echo deletePersona('Sem token');
  }
}

########################################################## CONCELAR COBRANÇA ######################################################################

function cancelarCobranca($id, $obs)
{
  include('conexao.php');
  $query = mysqli_query($conexao, "SELECT * FROM cobranca WHERE id='$id'") or die(mysqli_error($conexao));
  $ddcc = mysqli_fetch_array($query);
  $code = $ddcc['idcobranca'];

  $query2 = mysqli_query($conexao, "SELECT * FROM dadoscobranca WHERE recebercom='BANCO JUNO'") or die(mysqli_error($conexao));
  $retPrivado = mysqli_fetch_array($query2);
  $tokenprivado = $retPrivado['tokenprivado'];

  $token = AccessTokenJuno();
  if (!empty($tokenprivado) || !empty($token)) {
    $url = 'https://sandbox.boletobancario.com/api-integration/charges/';
    //$url = 'https://api.juno.com.br/charges/'; 
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url . $code . '/cancelation',
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_CUSTOMREQUEST => 'PUT',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
        'X-Api-Version: 2',
        'X-Resource-Token: ' . $tokenprivado,
        'Content-Type: application/json;charset=UTF-8'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    // print_r($response);
    //se for me branco a resposta
    $obs = AspasBanco($obs) . ' Data: ' . date('d-m-Y H:m:s');
    mysqli_query($conexao, "UPDATE cobranca SET situacao='CANCELADO',obs='$obs' WHERE id='$id'") or die(mysqli_error($conexao));
    echo deletePersona('Cancelado');
  } else {
    echo deletePersona('Erro inesperado!');
  }
}
