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

if(!empty($_POST['inicio']) AND !empty($_POST['fim'])){
    $inicio = dataBanco(@$_POST['inicio']);
    $fim = dataBanco(@$_POST['fim']);
}else{
    $inicio = date('Y-m-01');
    $fim = date('Y-m-t');
}
$sql = mysqli_query($conexao,"select caixa.*, funcionarios.nome, cliente.nome as nomecliente from caixa 
left join funcionarios on caixa.funcionario = funcionarios.id
left join cliente on caixa.cliente = cliente.id
where data BETWEEN '$inicio' AND '$fim' order by data asc") or die (mysqli_error($conexao));
@$n = 1;
if(mysqli_num_rows($sql) >= 1){
while($dd = mysqli_fetch_array($sql)){
    echo'<tr>
        <td>'.@$n.'</td>
        <td>'.@$dd['nome'].''.@$dd['nomecliente'].'</td>
        <td class="py-1">'.$dd['descricao'].'</td>
        <td class="py-1">'.$dd['tipo'].'</td>
        <td class="py-1">'.$dd['moeda'].'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'; if($dd['data'] != '0000-00-00'){ echo dataForm($dd['data']); } echo'</td>
        <td>'; if($dd['agendadopara'] != '0000-00-00'){ echo dataForm($dd['agendadopara']); } echo'</td>
        <td>';
            if($dd['situacao'] == 'pago' OR $dd['situacao'] == 'RECEBIDO'){ echo '<label class="badge badge-success">Pago</label>'; }
            if($dd['situacao'] == 'agendado'){ echo '<label class="badge badge-warning">Agendado</label>'; }
            echo'        
        </td>
    </tr>';
    @$n++;
    @$total = @$total + $dd['valor'];
}
echo'
<tr>
    <td colspan="4"></td>
    <td class="text-success"><b>Total</b></td>
    <td class="text-success"><b>R$ '.Real($total).'</b></td>
    <td colspan="3"></td>
</tr>
';

}else{ echo'<tr><td colspan="10">Sem regsitro</td></tr>'; }
