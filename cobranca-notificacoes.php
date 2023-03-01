<?php
//recebe informaçõess
header('Access-Control-Allow-Origin: *; Content-Type: application/json;');

############################### gerencianet ###############################
if($_GET['customid'] != ''){
  //$code = json_encode($_POST['notification']);
  //$code = substr($code,1);
  //$code = substr($code, 0, -1);
   $customid = $_GET['customid'];
  //https://api.gerencianet.com.br/v1/notification/
  include('conexao.php');
  $query0 = mysqli_query($conexao,"SELECT * FROM cobranca WHERE custom_id='$customid'") or die (mysqli_error($conexao));
  $retCob = mysqli_fetch_array($query0);
  $idcobranca = $retCob['ncobranca'];
  $idcliente = $retCob['idcliente'];

  //token privado da empresa
  $query2 = mysqli_query($conexao,"SELECT * FROM dadoscobranca WHERE clienteid <> '' AND clientesecret <> ''") or die (mysqli_error($conexao));
  $retPrivado = mysqli_fetch_array($query2);
  $cliente_id = $retPrivado['clienteid'];
  $cliente_secret = $retPrivado['clientesecret'];

  //teste
  define('clienteid',$cliente_id);
  define('secretid',$cliente_secret);
  define('URL_API','https://sandbox.gerencianet.com.br');

  //produção
  //define("clienteid",$cliente_id);
  //define("secretid",$cliente_secret);
  //define("URL_API","https://api.gerencianet.com.br");

  function AcessoTokenG(){
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
  ################################################# CONSULTA BOLETO GNET ################################################
  //consultar -> /v1/charge/:id
  function consultaBoletoGerenciaNet($idcobranca){
    include('conexao.php'); 
    $query0 = mysqli_query($conexao,"SELECT * FROM cobranca WHERE ncobranca='$idcobranca'") or die (mysqli_error($conexao));
    $retCob = mysqli_fetch_array($query0);
    $idcliente = $retCob['idcliente'];
    $nomecliente = $retCob['cliente'];

    $token = AcessoTokenG();
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
  
      mysqli_query($conexao,"UPDATE cobranca SET valorpago='$valorpago',datapagamento=NOW(), situacao='$situacao' WHERE ncobranca='$idcobranca'") or die (mysqli_error($conexao));

      //reativação automatica do login
      //print $situacao;
      if($situacao == 'RECEBIDO'){
          //alimeNta o caixa
          mysqli_query($conexao,"INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
          VALUES ('ENTRADA','$nomecliente','BOLETO','$valorpago','$valorpago','$valorpago',NOW(),NOW(),'BAIXA AUTOMATICA','RECEBIDO')") 
          or die (mysqli_error($conexao));
          
        function AspasBanco2($string){
          $string = str_replace(chr(146).chr(146),'"', $string);
          $string = str_replace(chr(146),"'",$string);
          return addslashes($string);
        };
        
          $query = mysqli_query($conexao,"SELECT * FROM contratos WHERE idcliente='$idcliente'") or die(mysqli_error($conexao));
          while($ret = mysqli_fetch_array($query)){
            if($ret['situacao'] == 'Bloqueado'){

            $login = AspasBanco2($ret['login']);
            //plano cliente
            $plano = $ret['plano'];
            $queryplano = mysqli_query($conexao,"SELECT plano.plano,servidor,servidor.id,ip,user,password 
            FROM plano LEFT JOIN servidor ON plano.servidor = servidor.id
            WHERE plano.id='$plano'");
            $retorno = mysqli_fetch_array($queryplano);
            $nomeplano = $retorno['plano'];
            $idservidor = $retorno['servidor'];
            $ipservidor = $retorno['ip'];
            $user = $retorno['user'];
            $passwords = $retorno['password'];
            require_once('routeros_api.class.php');
            $mk = new RouterosAPI();
            if($mk->connect($ipservidor, decrypt($user), decrypt($passwords))) {
                $find = @$mk->comm("/ppp/secret/print", array("?name" =>  utf8_decode($login),));                                        
                //existe
                if (count($find) >= 1) {  
                    $Finduser  = $find[0];
                    $find = $mk->comm("/ppp/secret/set", array(
                        ".id" =>  $Finduser['.id'],
                        "profile" =>  utf8_decode(AspasBanco2($nomeplano)),
                    ));
                    $find = @$mk->comm("/ppp/active/print", array("?name" =>  utf8_decode($login),));
                    if (count($find) >= 1) {
                        $Finduser  = $find[0];
                        $find = $mk->comm("/ppp/active/remove", array(".id" =>  $Finduser['.id'],));
                    }             
                }
            }
            mysqli_query($conexao,"UPDATE contratos SET situacao='ATIVO' WHERE idcliente='$idcliente'") or die (mysqli_error($conexao));
          }

          }
          mysqli_query($conexao,"UPDATE cliente SET situacao='ATIVO', atualizado=NOW() WHERE id='$idcliente'") or die (mysqli_error($conexao)); 
      }
    }
  }
  
  echo consultaBoletoGerenciaNet($idcobranca);
}//fim gerencianet



############################### baixa juno ###############################
if(!empty(@$_POST['chargeCode'])){
  $code = json_decode(@$_POST['chargeCode']);
  $query0 = mysqli_query($conexao,"SELECT * FROM cobranca WHERE code='$code'") or die (mysqli_error($conexao));
  $retCob = mysqli_fetch_array($query0);
  $idcobranca = $retCob['idcobranca'];
  $idempresa = $retCob['idempresa'];
  $idcliente = $retCob['idcliente'];
  $tipoboleto = $retCob['tipo'];

  $sqlc = mysqli_query($conexao,"SELECT cliente.nome FROM cliente WHERE id='$idcliente'");
  $retornoc = mysqli_fetch_array($sqlc);
  $nomecliente = $retornoc['nome'];

  ####################################################################################################################
  //token privado da empresa
  $query2 = mysqli_query($conexao,"SELECT * FROM dadoscobranca WHERE tokenprivado <> '' AND clienteid	<> '' AND clientesecret <> ''") or die (mysqli_error($conexao));

  if(mysqli_num_rows($query2) == 1){

    $retPrivado = mysqli_fetch_array($query2);
    $tokenprivado = $retPrivado['tokenprivado'];
    $aposvencimento = $retPrivado['aposvencimento'];
    $multaapos = $retPrivado['multaapos'];
    $jurosapos = $retPrivado['jurosapos'];

    #####################################################################################################################
          include('api_juno.php');
          //verificar banco token  
          $token = AccessToken();  
          $url = 'https://api.juno.com.br/api-integration/charges/';

          //de posse do token solicitar a criação da cobrança
          if(!empty(@$token)){
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
                'Authorization: Bearer '.$token,
                'X-Api-Version: 2',
                'X-Resource-Token:'.$tokenprivado,
                'Content-Type: application/json;charset=UTF-8'
                  ),
              ));
              $response = curl_exec($curl);
              curl_close($curl);
              $json = json_decode($response,true);
              //baixa no banco caso já tenha recebido
              print_r($response);           
              if($json['status'] == 'PAID' OR $json['status'] == 'MANUAL_RECONCILIATION'){ 
                if($tipoboleto == 'Boleto'){
                    $json2 = $json['payments'];
                      $datapagameto = date('Y-m-d');
                      $valorpago = Moeda($json['amount']);
                    //}
                  }else{
                    $json2 = $json['payments'];
                    foreach ($json2 as $item) { 
                      $datapagameto = $item['releaseDate'];
                      $valorpago = $item['amount'];
                    }
                  }
                $status = 'RECEBIDO';
                mysqli_query($conexao,"UPDATE cobranca SET valorpago='$valorpago',datapagamento='$datapagameto',situacao='$status' WHERE idcobranca='$idcobranca'") or die (mysqli_error($conexao));
                mysqli_query($conexao,"INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
                VALUES ('Entrada','$nomecliente','$tipoboleto','$valorpago','$valorpago','$valorpago','$datapagameto','$datapagameto','Baixa manual','RECEBIDO')") 
                or die (mysqli_error($conexao)); 

                if($status == 'RECEBIDO'){
                    //alimeNta o caixa
                    mysqli_query($conexao,"INSERT INTO caixa (tipo,nomecliente,descricao,valor,valorpago,pix,data,datapagamento,user,situacao) 
                    VALUES ('ENTRADA','$nomecliente','BOLETO','$valorpago','$valorpago','$valorpago',NOW(),NOW(),'BAIXA AUTOMATICA','RECEBIDO')") 
                    or die (mysqli_error($conexao));

                  print $status;
                  require_once('routeros_api.class.php');
                  $mk = new RouterosAPI();
                  function AspasBanco2($string){
                    $string = str_replace(chr(146).chr(146),'"', $string);
                    $string = str_replace(chr(146),"'",$string);
                    return addslashes($string);
                  };
                  
                    $query = mysqli_query($conexao,"SELECT * FROM contratos WHERE idcliente='$idcliente'") or die(mysqli_error($conexao));
                    while($ret = mysqli_fetch_array($query)){
                      if($ret['situacao'] == 'Bloqueado'){
                      $login = AspasBanco2($ret['login']);
                      //plano cliente
                      $plano = $ret['plano'];
                      $queryplano = mysqli_query($conexao,"SELECT plano.plano,servidor,servidor.id,ip,user,password 
                      FROM plano LEFT JOIN servidor ON plano.servidor = servidor.id
                      WHERE plano.id='$plano'");
                      $retorno = mysqli_fetch_array($queryplano);
                      $nomeplano = $retorno['plano'];
                      $idservidor = $retorno['servidor'];
                      $ipservidor = $retorno['ip'];
                      $user = $retorno['user'];
                      $passwords = $retorno['password'];
                      if($mk->connect($ipservidor, decrypt($user), decrypt($passwords))) {
                          $find = @$mk->comm("/ppp/secret/print", array("?name" =>  utf8_decode($login),));                                        
                          //existe
                          if (count($find) >= 1) {  
                              $Finduser  = $find[0];
                              $find = $mk->comm("/ppp/secret/set", array(
                                  ".id" =>  $Finduser['.id'],
                                  "profile" =>  utf8_decode(AspasBanco2($nomeplano)),
                              ));
                              $find = @$mk->comm("/ppp/active/print", array("?name" =>  utf8_decode($login),));
                              if (count($find) >= 1) {
                                  $Finduser  = $find[0];
                                  $find = $mk->comm("/ppp/active/remove", array(".id" =>  $Finduser['.id'],));
                              }             
                          }
                      }
                      mysqli_query($conexao,"UPDATE contratos SET situacao='ATIVO' WHERE idcliente='$idcliente'") or die (mysqli_error($conexao));                        
          
          
                    }
          
                    }
                    mysqli_query($conexao,"UPDATE cliente SET situacao='ATIVO', atualizado=NOW() WHERE id='$idcliente'") or die (mysqli_error($conexao)); 
                }
              }          
          }
  }
}

?>