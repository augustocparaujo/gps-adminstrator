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
$sql = mysqli_query($conexao,"select * from cobranca where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
    <input type="text" class="hidden" name="id" value="'.$dd['id'].'"/>
    <label class="col-12">Cobrança
        <input type="text" class="form-control" value="'.@$dd['code'].'"readonly/>
    </label>
    <label class="col-12">Valor
        <input type="text" class="form-control" value="'.Real(@$dd['valor']).'"readonly/>
    </label>
    <label class="col-12">Vencimento
        <input type="text" class="form-control" value="'.dataForm(@$dd['vencimento']).'"readonly/>
    </label>
    <label class="col-12">Justificativa
        <textarea rows="3" class="form-control" name="obs" required></textarea>
    </label>
';
