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
$sql = mysqli_query($conexao,"select servico.*, plano.descricao as descricaoservico,plano.valor from servico
left join plano on servico.idservico = plano.id
where servico.idcliente='$id' order by servico.id asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">'.$dd['id'].'</td>
        <td>'.$dd['descricao'].'</td>
        <td>'.$dd['descricaoservico'].'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'.$dd['usuariocad'].'</td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td>
            <a href="#" onclick="alterarServicos('.$dd['id'].')" title="Alterar serviço"><i class="fa fa-edit fa-2x"></i></a>&ensp;
            <a href="#" onclick="excluirServicos('.$dd['id'].')" title="Excluir serviço"><i class="fa fa-trash fa-2x text-danger"></i></a>
        </td>
    </tr>';
}
?>
