<?php 
include_once('conexao.php');
$id = $_POST['id'];
//tipo boleto
$sql = mysqli_query($conexao,"SELECT * FROM cobranca WHERE id='$id'") or die (mysqli_error($conexao));
$d = mysqli_fetch_array($sql);

if($d['banco'] == 'BANCO JUNO'){
    
    include_once('api_juno.php');
    cancelarCobranca($id,$_POST['obs']);

}elseif($d['banco'] == 'GERENCIANET'){

    include_once('api_gerencianet.php');
    cancelarCobranca($id,$_POST['obs']);

}else{
    echo'<div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" style="">
        <button class="toast-close-button">×</button>
        <div class="toast-title">Erro inesperado!</div>
    </div>
    </div>';
}

?>             