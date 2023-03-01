<?php 
include('conexao.php');
include('funcoes.php');
session_start();
if(isset($_POST['cpf']) || isset($_POST['senha']));{
	if(strlen($_POST['cpf']) == 0) { /*condicional verifica se veio em branco */
		echo '<button class="btn btn-danger submit-btn btn-block">Digite seu CPF!</button>';
	} else if(strlen($_POST['senha']) == 0) {
		echo '<button class="btn btn-danger submit-btn btn-block">Digite sua senha!</button>';
	} else{
		@$cpf_crp = $conexao->real_escape_string(md5(addslashes(limpa($_POST['cpf']))));
		@$senha = $conexao->real_escape_string(strip_tags(md5($_POST['senha'])));

		if(!empty(@$cpf_crp) AND !empty(@$senha)){
			$sql = mysqli_query($conexao,"SELECT * FROM usuario WHERE cpf_crp='$cpf_crp' AND senha_crp='$senha' AND situacao <> 0 LIMIT 1") or die (mysqli_error($conexao));
			$ddu = mysqli_fetch_array($sql);
				if(empty($ddu)){ echo '<button class="btn btn-danger submit-btn btn-block">Usuário ou senha inválido!</button>';}
				else{
					$_SESSION['gps_iduser'] = $ddu['id'];
					$_SESSION['gps_nomeuser'] = $ddu['nome'];
					$_SESSION['gps_cargouser'] = $ddu['cargo'];
					$_SESSION['gps_situacaouser'] = $ddu['situacao'];
					$_SESSION['gps_tipouser'] = $ddu['tipo'];
					$ip = $_SERVER['REMOTE_ADDR']; // pegar ip da maquina
					$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); //pega nome da maquina
					echo "<script>location.href='index.php';</script>";
					}
			}else{ 
				echo '<button class="btn btn-danger submit-btn btn-block">Error!</button>';
			}

	}
}
	
?>