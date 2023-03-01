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

$sql = mysqli_query($conexao,"SELECT historico_produto.*, produto.descricao AS nomeproduto,produto.quantidade AS estoque,produto.quantidademinimo AS estoqueminimo FROM historico_produto
LEFT JOIN produto ON historico_produto.idproduto = produto.id
ORDER BY datacad ASC") or die (mysqli_error($conexao));
if(mysqli_num_rows($sql) >= 1){ 
while($dd = mysqli_fetch_array($sql)){echo'
    <tr>
        <td>'.$dd['id'].'</td>
        <td>'.$dd['tipomovimento'].'</td>
        <td>'.$dd['descricao'].'</td>
        <td>'.$dd['nomeproduto'].'</td>
        <td>';if($dd['entrada'] != 0){ echo $dd['entrada']; } else { echo $dd['saida']; }echo'</td>
        <td>'.$dd['estoque'].'</td>
        <td>'.$dd['estoqueminimo'].'</td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td></td>
    </tr>';
}}else{echo'<tr><td colspan="9">Sem registro</td></tr>'; }
?>
