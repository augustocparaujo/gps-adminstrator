<?php
session_start();
include_once('conexao.php');
include_once('funcoes.php');
session_destroy();
session_unset();
ob_end_clean();// J� podemos encerrar o buffer e limpar tudo que h� nele
echo "<script>location.href='login.php'</script>";
