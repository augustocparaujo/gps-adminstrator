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


$sql = mysqli_query($conexao,"select * from usuario ORDER BY nome ASC") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">
        <img src="assets/images/faces-clipart/pic-1.png" alt="image"> '.$dd['nome'].'</td>
        <td>'.$dd['cpf'].'</td>
        <td>';if($dd['situacao'] == 1){ echo'<label class="badge badge-success">Ativo</label>'; }else{ echo'<label class="badge badge-danger">Bloqueado</label>'; }echo'       </td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td> 
        <a href="usuarios-perfil.php?id='.$dd['id'].'" class="fa fa-edit fa-2x" title="alterar"></a>&ensp;';
        if($dd['situacao'] == 1){ echo'<a onclick="bloquear('.$dd['id'].',0)" title="bloquear"><i class="fa fa-lock fa-2x text-danger"></i></a>';}
        else{ echo'<a onclick="bloquear('.$dd['id'].',1)" title="desbloquear"><i class="fa fa-unlock fa-2x text-success"></i></a>'; }echo'
        </td>
    </tr>';
}
?>
