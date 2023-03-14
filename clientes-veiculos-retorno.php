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

$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from veiculo where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
$idcliente = $dd['idcliente'];
echo'
    <input type="text" class="hidden" name="id" value="'.$id.'"/>
    <input type="text" class="hidden" name="idcliente" value="'.$idcliente.'"/>
    <div class="row">
    <label class="col-md-6 col-sm-12">Placa
    <input type="text" class="form-control caixaalta" name="placa" value="'.$dd['placa'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">Marca
      <input type="text" class="form-control caixaalta" name="marca" value="'.$dd['marca'].'"/>
    </label>
  </div>

  <div class="row">
    <label class="col-md-6 col-sm-12">Modelo
    <input type="text" class="form-control caixaalta" name="modelo" value="'.$dd['modelo'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">Ano
      <input type="text" class="form-control" name="ano" value="'.$dd['ano'].'"/>
    </label>
  </div>

  <div class="row">
    <label class="col-md-6 col-sm-12">Cor
    <input type="text" class="form-control caixaalta" name="cor" value="'.$dd['cor'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">Chassi
      <input type="text" class="form-control" name="chassi" value="'.$dd['chassi'].'"/>
    </label>
  </div>

  <div class="row">
    <label class="col-md-6 col-sm-12">Renavam
    <input type="text" class="form-control" name="renavam" value="'.$dd['renavam'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">Cidade
      <input type="text" class="form-control caixaalta" name="cidade" value="'.$dd['cidade'].'"/>
    </label>
  </div>

  <div class="row">
  <label class="col-md-12 col-sm-12">Observação
    <textarea row="3" class="form-control" name="obs">'.$dd['obs'].'</textarea>
  </label>
  </div>          
';
