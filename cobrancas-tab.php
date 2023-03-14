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

@$banco = @$_POST['banco'];
if(!empty($_POST['inicio']) AND !empty($_POST['fim'])){
    $inicio = dataBanco(@$_POST['inicio']);
    $fim = dataBanco(@$_POST['fim']);
}else{
    $inicio = date('Y-m-01');
    $fim = date('Y-m-t');
}

$sql = mysqli_query($conexao,"SELECT * FROM cobranca 
WHERE banco LIKE '%$banco%' AND vencimento BETWEEN '$inicio' AND '$fim'") or die (mysqli_error($conexao));
$n = 1;
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td>'.@$n.'</td>
        <td class="py-1">'.@$dd['code'].'</td>
        <td>'.@$dd['cliente'].'</td>
        <td>'.$dd['tipo'].'-'.$dd['banco'].'</td>
        <td>'.dataForm($dd['vencimento']).'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'.dataForm(@$dd['datapagamento']).'</td>
        <td>'.$dd['valorpago'].'</td>
        <td>'.label($dd['situacao']).'</td>
    </tr>';
    @$n++;
    @$total = @$total + $dd['valor'];
    @$recebido = @$recebido + $dd['valorpago'];
}
echo'
<tr style="background:#E6E6FA">
    <td colspan="4"></td>
    <td class="text-primary"><b>Total</b></td>
    <td class="text-primary"><b>R$ '.Real(@$total).'</b></td>
    <td class="text-success"><b>Recebido</b></td>
    <td class="text-success"><b>R$ '.Real(@$recebido).'</b></td>
    <td></td>
</tr>
';
