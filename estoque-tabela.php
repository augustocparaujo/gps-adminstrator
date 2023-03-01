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


$sql = mysqli_query($conexao,"select produto.*, categoria.descricao as nomecategoria from produto 
LEFT JOIN categoria ON produto.categoria = categoria.id") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td>'.$dd['id'].'</td>
        <td class="py-1">'.$dd['descricao'].'</td>
        <td>'.$dd['nomecategoria'].'</td>
        <td>'.$dd['quantidade'].'</td>
        <td>'.$dd['quantidademinimo'].'</td>
        <td>
            <a href="#" onclick="alterar('.$dd['id'].')" class="fa fa-edit fa-2x" title="alterar"></a>&ensp; 
            <a href="#" class="fa fa-plus-circle fa-2x" title="entrada"></a>&ensp; 
            <a href="#" class="fa fa-minus-circle fa-2x text-danger" title="saída"></a>            
        </td>
    </tr>';
}
?>
