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
$sql = mysqli_query($conexao,"SELECT atendimento.*, produto.descricao AS nomeproduto, cliente_produto.tipo AS formainstalacao FROM atendimento
LEFT JOIN produto ON atendimento.idproduto = produto.id
LEFT JOIN cliente_produto ON atendimento.idregistro = cliente_produto.id
WHERE atendimento.idcliente='$id' ORDER BY atendimento.id DESC") or die (mysqli_error($conexao));
if(mysqli_num_rows($sql) >= 1){
while($dd = mysqli_fetch_array($sql)){echo'
    <tr class="caixaalta">
        <td class="py-1">'.$dd['id'].'</td>
        <td>'.$dd['tipo'].'</td>
        <td>'.$dd['formainstalacao'].'</td>
        <td>'.dataForm($dd['datacad']).'</td>
        <td>'.$dd['periodo'].'</td>
        <td>'.$dd['nomeproduto'].'</td>
        <td>'.$dd['quantidade'].'</td>
        <td>'.situacao($dd['situacao']).'</td>
        <td>
            <a href="#" onclick="alert()" title="Exibir"><i class="fa fa-eye fa-2x"></i></a>&ensp;
            <a href="#" onclick="alert()" title="Alterar"><i class="fa fa-edit fa-2x"></i></a>&ensp;
            <a href="#" onclick="alert()" title="Excluir"><i class="fa fa-trash fa-2x text-danger"></i></a>        
        </td>
    </tr>';
}}else{ echo'<tr><td colspan="9">Sem registro</td></tr>'; }
