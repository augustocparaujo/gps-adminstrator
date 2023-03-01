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

if(!empty($_GET['id'])){
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from caixa where funcionario='$id' order by data asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){
    echo'<tr>
        <td>'.$dd['id'].'</td>
        <td class="py-1">'.$dd['descricao'].'</td>
        <td class="py-1">'.$dd['tipo'].'</td>
        <td class="py-1">'.$dd['moeda'].'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'; if($dd['data'] != '0000-00-00'){ echo dataForm($dd['data']); } echo'</td>
        <td>'; if($dd['agendadopara'] != '0000-00-00'){ echo dataForm($dd['agendadopara']); } echo'</td>
        <td>';
            if($dd['situacao'] == 'pago'){ echo '<label class="badge badge-success">Pago</label>'; }
            if($dd['situacao'] == 'agendado'){ echo '<label class="badge badge-warning">Agendado</label>'; }
            echo'        
        </td>
        <td>
            <a href="#" onclick="alterar('.$dd['id'].')" class="fa fa-edit fa-2x" title="alterar"></a>&ensp;
            <a href="#" onclick="excluir('.$dd['id'].')" class="fa fa-trash fa-2x text-danger" title="excluir"></a>
        </td>
    </tr>';
}}else{ echo'<tr><td colspan="9">Sem regsitro</td></tr>'; }
?>