
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
if (isset($_SESSION['gps_iduser']) != true) {
    echo '<script>location.href="sair.php";</script>';
}
//nome,fantasia,cnpj_cpf,ie,nascimento,cep,endereco,numero,bairro,cidade,uf,complemento,contato,email,logo
@$id = $_POST['id'];
@$nome = AspasBanco($_POST['nome']);
@$fantasia = AspasBanco($_POST['fantasia']);
@$cnpj_cpf = limpa($_POST['cnpj_cpf']);
@$ie = limpa($_POST['ie']);
@$cep = limpa($_POST['cep']);
@$endereco = AspasBanco($_POST['endereco']);
@$numero = AspasBanco($_POST['numero']);
@$bairro = AspasBanco($_POST['bairro']);
@$cidade = AspasBanco($_POST['cidade']);
@$uf = $_POST['estado'];
@$complemento = AspasBanco($_POST['complemento']);
@$contato = limpa($_POST['contato']);
@$email = $_POST['email'];

if (!empty($_POST['id'])) :
    mysqli_query($conexao, "update empresa set 
    nome='$nome',
    fantasia='$fantasia',
    cnpj_cpf='$cnpj_cpf',
    ie='$ie',
    cep='$cep',
    endereco='$endereco',
    numero='$numero',
    bairro='$bairro',
    cidade='$cidade',
    uf='$uf',
    complemento='$complemento',
    contato='$contato',
    email='$email'
    where id='$id'") or die(mysqli_error($conexao));
    echo sucesso();
else :
    mysqli_query($conexao, "insert into empresa (nome,fantasia,cnpj_cpf,ie,cep,endereco,numero,bairro,cidade,uf,complemento,contato,email)
    values ('$nome','$fantasia','$cnpj_cpf','$ie','$cep','$endereco','$numero','$bairro','$cidade','$uf','$complemento','$contato','$email')") or die(mysqli_error($conexao));
    $id = mysqli_insert_id($conexao);
    echo sucesso();
endif;


if ($_FILES['arquivo']['name'] != '') {

    @$arquivoantigo = @$_POST['arquivoantigo'];
    if (!empty(@$arquivoantigo)) {
        unlink("assets/" . @$arquivoantigo);
    }

    $diretorio = "assets/";
    $extensao = strrchr($_FILES['arquivo']['name'], '.');
    $novonome = md5(date('ms')) . $extensao;

    $filename = $_FILES['arquivo']['tmp_name'];
    $width = 150;
    $height = 150;
    list($width_orig, $height_orig) = getimagesize($filename);
    $ratio_orig = $width_orig / $height_orig;
    if ($width / $height > $ratio_orig) {
        $width = $height * $ratio_orig;
    } else {
        $height = $width / $ratio_orig;
    }
    $image_p = imagecreatetruecolor($width, $height);

    if ($extensao == '.png') {

        $image = imagecreatefrompng($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagepng($image_p, $diretorio . $novonome, 8);

        mysqli_query($conexao, "UPDATE empresa SET logo='$novonome' WHERE id='$id'") or die(mysqli_error($conexao));
    } else {
        echo persona('Apenas imagem .png');
    }
}
?>