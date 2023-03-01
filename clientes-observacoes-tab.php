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
//	id	idcliente	tipo contrato	descricao	documento	usuariocad	datacad	

$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from obs where idcliente='$id' order by tipo asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td class="py-1">'.$dd['id'].'</td>
        <td>'.$dd['tipo'].'</td>
        <td>'.$dd['descricao'].'</td>
        <td>';
            if(!empty($dd['documento'])): echo'<a href="#" data-fancybox data-type="iframe" data-src="assets/doc/'.$dd['documento'].'">Visualizar</a>'; endif;
            echo'
        </td>
        <td>
            <a href="#" onclick="alterar('.$dd['id'].')"><i class="fa fa-edit fa-2x"></i></a>&ensp; 
            <a href="#" onclick="excluir('.$dd['id'].')"><i class="fa fa-trash fa-2x text-danger"></i></a>
        </td>
    </tr>';
}
?>