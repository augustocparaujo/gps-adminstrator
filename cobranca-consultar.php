<?php 
session_start();
include_once('conexao.php'); 
$idempresa = $_SESSION['idempresa'];
$sql = mysqli_query($conexao,"SELECT * FROM dadoscobranca") 
or die (mysqli_error($conexao));
$d = mysqli_fetch_array($sql);

//verificar pra qual api mandar
if($d['recebercom'] == 'JUNO'){
    include('api_juno.php');
    //passa valores para função
    consultarCobrancaJuno($_GET['id']);

}elseif($d['recebercom'] == 'GERENCIANET'){
    include('api_gerencianet.php');
    consultaCobranca($_GET['id']);

}else{
    echo' <div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" style="">
        <button class="toast-close-button">×</button>
        <div class="toast-title">Erro inesperado!</div>
    </div>
</div>';
}

?>             