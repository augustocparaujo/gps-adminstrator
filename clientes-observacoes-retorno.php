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
$sql = mysqli_query($conexao,"select * from obs where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<input type="text" class="hidden" name="id" value="'.$id.'"/>
<div class="row">
  <label class="col-md-6 col-sm-12">Tipo
    <select type="text" class="form-control" id="tipo" name="tipo">
    <option value="'.$dd['tipo'].'">'.$dd['tipo'].'</option>
      <option value="observação">observação</option>
      <option value="documento">documento</option>
    </select>
  </label>
</div>   

<div class="row">
  <label class="col-md-12 col-sm-12">Descrição
    <textarea row="3" class="form-control" name="descricao" required>'.$dd['descricao'].'</textarea>
  </label>
</div>


<div class="row">
<input type="text" style="display:none" name="arquivoantigo" value="'.$dd['documento'].'"/>
  <label class="col-md-12 col-sm-12">Documento
    <input type="file" class="form-control" name="arquivo" accept="image/jpg,image/jpeg,image/png,application/pdf" required/>
  </label>
</div>';
?>
