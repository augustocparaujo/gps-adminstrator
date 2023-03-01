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
$sql = mysqli_query($conexao,"select chip.*, produto.descricao, veiculo.placa from chip
left join produto on chip.chip = produto.id
left join veiculo on chip.idveiculo = veiculo.id
where chip.idcliente='$id' order by chip.id asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">'.$dd['id'].'</td>
        <td>'.$dd['descricao'].'</td>
        <td>'.$dd['icc'].'</td>
        <td>'.$dd['numero'].'</td>
        <td>'.$dd['placa'].'</td>
        <td>
            <a href="#" onclick="alterarChip('.$dd['id'].')"><i class="fa fa-edit fa-2x"></i></a>&ensp;
            <a href="#" onclick="excluirChip('.$dd['id'].')"><i class="fa fa-trash fa-2x text-danger"></i></a>
        </td>
    </tr>';
}
?>
