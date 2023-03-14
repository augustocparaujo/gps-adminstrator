<?php
include_once('conexao.php');
$id = $_GET['id'];

if (!empty($_GET['id'])) {

    include_once('api_gerencianet.php');
    receberCobranca($id);
} else {
    echo '
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> X</button>
        <strong><i class="icon fa fa-check"></i><strong> Erro inesperado! 
    </div>';
}
