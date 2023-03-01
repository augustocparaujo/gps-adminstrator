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


$sql = mysqli_query($conexao,"select * from fornecedor order by nome asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td>'.$dd['id'].'</td>
        <td class="py-1">'.$dd['nome'].'</td>
        <td class="celular">'.$dd['contato'].'</td>
        <td>'.$dd['material'].'</td>
        <td> <a href="#" onclick="alterar('.$dd['id'].')" class="fa fa-edit fa-2x" title="alterar"></a></td>
    </tr>';
}
?>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/jquery.maskMoney.js"></script>
<script src="assets/js/meusscripts.js"></script>