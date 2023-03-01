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


$sql = mysqli_query($conexao,"select * from cliente ORDER BY nome ASC") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">
        <img src="assets/images/faces-clipart/pic-1.png" alt="image"> '.$dd['nome'].'</td>
        <td>'.@$dd['cpf'].''.@$dd['cnpj'].'</td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td> 
        <a href="clientes-exibir.php?id='.$dd['id'].'" class="fa fa-edit fa-2x" title="alterar"></a>
        </td>
    </tr>';
}
?>
