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
$sql = mysqli_query($conexao,"SELECT cliente_produto.*, produto.descricao as nomeproduto FROM cliente_produto
LEFT JOIN produto ON cliente_produto.idproduto = produto.id 
WHERE cliente_produto.idcliente='$id' ORDER BY datacad DESC") or die (mysqli_error($conexao));
if(mysqli_num_rows($sql) >= 1){
while($dd = mysqli_fetch_array($sql)){echo'
    <tr class="caixaalta">
        <td class="py-1">'.$dd['id'].'</td>
        <td>'.$dd['tipo'].'</td>
        <td>'.$dd['agendado'].'</td>
        <td>'.$dd['nomeproduto'].'</td>
        <td>'.$dd['quantidade'].'</td>
        <td>'.Real($dd['valortotal']).'</td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td>'.situacao($dd['situacao']).'</td>
        <td>
            <a href="#" onclick="exibir('.$dd['id'].')" title="Exibir"><i class="fa fa-eye fa-2x"></i></a>        
        </td>
    </tr>';
}}else{ echo'<tr><td colspan="9">Sem registro</td></tr>';}
