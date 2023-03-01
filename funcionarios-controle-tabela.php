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

if(empty($_POST['inicio']) AND empty($_POST['fim'])){
    @$inicio = dataBanco($_POST['inicio']);
    @$fim = dataBanco($_POST['fim']);
}else{    
    @$inicio = date('Y-m-01');
    @$fim = date('Y-m-t');
}

if(empty($_POST['funcionario'])){ 
    @$f = @$_POST['funcionario'];
    $funcionario = 'funcionario='.$f;
}else{
    $funcionario = 'funcionario <> 0';
}

@$situacao = $_POST['situacao'];

$sql = mysqli_query($conexao,"select caixa.*, funcionarios.nome from caixa 
left join funcionarios on caixa.funcionario = funcionarios.id
where caixa.data between '$inicio' and '$fim' and '$funcionario' and caixa.situacao like '%$situacao%' order by caixa.data asc") or die (mysqli_error($conexao));

if(mysqli_num_rows($sql) >= 1){
while($dd = mysqli_fetch_array($sql)){
    echo'<tr>
        <td>'.$dd['id'].'</td>
        <td>'.$dd['nome'].'</td>
        <td class="py-1">'.$dd['descricao'].'</td>
        <td class="py-1">'.$dd['tipo'].'</td>
        <td class="py-1">'.$dd['moeda'].'</td>
        <td>'.Real($dd['valor']).'</td>
        <td>'; if($dd['data'] != '0000-00-00'){ echo dataForm($dd['data']); } echo'</td>
        <td>'; if($dd['agendadopara'] != '0000-00-00'){ echo dataForm($dd['agendadopara']); } echo'</td>
        <td>';
            if($dd['situacao'] == 'pago'){ echo '<label class="badge badge-success">Pago</label>'; }
            if($dd['situacao'] == 'agendado'){ echo '<label class="badge badge-warning">Agendado</label>'; }
            echo'        
        </td>
    </tr>';
}}else{ echo'<tr><td colspan="9">Sem regsitro</td></tr>'; }
?>