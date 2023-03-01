<?php
ob_start();
session_start();
include('conexao.php'); 
include('funcoes.php');
@$iduser = $_SESSION['gps_iduser'];
@$nomeuser = $_SESSION['gps_nomeuser'];
@$usercargo = $_SESSION['gps_cargouser'];
@$tipouser = $_SESSION['gps_tipouser'];
@$situacaouser = $_SESSION['gps_situacaouser'];
@$ip = $_SERVER['REMOTE_ADDR'];
@$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
if(isset($_SESSION['gps_iduser'])!=true ){echo '<script>location.href="sair.php";</script>'; }

$id = $_GET['id'];
$sql = mysqli_query($conexao,"select chip.*, produto.descricao, veiculo.placa,veiculo.modelo from chip
left join produto on chip.chip = produto.id
left join veiculo on chip.idveiculo = veiculo.id
where chip.id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
$idcliente = $dd['idcliente'];
echo'
    <input type="text" class="hidden" name="id" value="'.$id.'"/>
    <input type="text" class="hidden" name="idcliente" value="'.$idcliente.'"/>
  <div class="row">
    <label class="col-md-12 col-sm-12">Chip
      <select type="text" class="form-control" name="chip">
        <option value="'.@$dd['chip'].'">'.@$dd['descricao'].'</option>';
          $sql1 = mysqli_query($conexao,"select * from produto order by operadora asc");
          while($r = mysqli_fetch_array($sql1)){ echo'<option value="'.$r['id'].'">'.$r['operadora'].'</option>'; }
        echo'
      </select>
    </label>
  </div>   

  <div class="row">
    <label class="col-md-12 col-sm-12">Veículo
      <select type="text" class="form-control caixaalta" name="veiculo">';
        if(empty($dd['veiculo'])){ echo'<option value="'.$dd['idveiculo'].'">'.$dd['modelo'].'->'.$dd['placa'].'</option>'; }else{ echo'<option value="">selecione</option>';}
          $sql2 = mysqli_query($conexao,"select * from veiculo where idcliente='$idcliente' order by placa asc");
          while($r2 = mysqli_fetch_array($sql2)){ echo'<option value="'.$r2['id'].'">'.$r2['modelo'].'->'.$r2['placa'].'</option>'; }
        echo'
      </select>
    </label>
  </div>

  <div class="row">
    <label class="col-md-6 col-sm-12">Número
      <input type="text" class="form-control" name="numero" value="'.$dd['numero'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">ICC
      <input type="text" class="form-control" name="icc" value="'.$dd['icc'].'"/>
    </label>
  </div>

  <div class="row">
    <label class="col-md-6 col-sm-12">APN
    <input type="text" class="form-control" name="apn" value="'.$dd['apn'].'"/>
    </label>
    <label class="col-md-6 col-sm-12">UF
      <input type="text" class="form-control" name="estado" minlength="2" maxlength="2" value="'.$dd['estado'].'"/>
    </label>
  </div>
</div>
';
?>