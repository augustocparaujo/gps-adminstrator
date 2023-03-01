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
$hoje = date('Y-m-d');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from cobranca where idcliente='$id' order by vencimento asc") or die (mysqli_error($conexao));
while($dd = mysqli_fetch_array($sql)){echo'
    <tr tutle="'.AspasForm($dd['obs']).'">
        <td class="py-1">'.@$dd['code'].'</td>
        <td>'.$dd['tipo'].'-'.$dd['banco'].'</td>
        <td>'.dataForm($dd['vencimento']).'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'.dataForm(@$dd['datapagamento']).'</td>
        <td>'.Real($dd['valorpago']).'</td>
        <td>'.label($dd['situacao']).'</td>
        <td>';
            if ($dd['situacao'] == 'CANCELADO' OR $dd['situacao'] == 'RECEBIDO') { 

                echo'<a href="#" onclick="ver('.$dd['id'].')"><i class="fa fa-info-circle fa-2x text-danger"></i></a>';
               
            } else {  
                echo'<a href="'.$dd['link'].'" target="_blank" title="Boleto"><i class="fa fa-file-pdf-o fa-2x text-dark"></i></a>&ensp;';
                
                if($dd['banco'] == 'GERENCIANET'){ 

                echo'
                    <a href="#" onclick="receberCobranca('.$dd['id'].')" title="Receber" title="Recebe ate vencimento"><i class="fa fa-dollar fa-2x text-success"></i></a>&ensp;
                    ';
                }

                echo'<a href="#" onclick="cancelarCobranca('.$dd['id'].')" title="Cancelar"><i class="fa fa-trash fa-2x text-danger"></i></a>';
                
            }
            echo'
        </td>
    </tr>';
}
?>
