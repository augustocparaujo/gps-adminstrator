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
$sql = mysqli_query($conexao,"select * from veiculo where idcliente='$id' order by id asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">'.$dd['id'].'</td>
        <td class="caixaalta">'.$dd['placa'].'</td>
        <td class="caixaalta">'.$dd['modelo'].'</td>
        <td class="caixaalta">'.$dd['cor'].'</td>
        <td>'.$dd['ano'].'</td>
        <td>
            <a href="#" onclick="alterarVeiculo('.$dd['id'].')"><i class="fa fa-edit fa-2x"></i></a>&ensp;
            <a href="#" onclick="excluirVeiculo('.$dd['id'].')"><i class="fa fa-trash fa-2x text-danger"></i></a>
        </td>
    </tr>';
}
