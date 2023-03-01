<?php
//permissao atualziao //recebe informaes vindas do array de permisso
function Permissao($item,$id){
    include('conexao.php');
    $hoje0 = date('Y-m-d');
    $sql = mysqli_query($conexao,"SELECT * FROM permissao WHERE iduser='$id' AND item='$item'") or die (mysqli_error($conexao));;
    if(mysqli_num_rows($sql) >=1 ){
        mysqli_query($conexao,"UPDATE permissao SET valor='ativo' WHERE iduser='$id' AND item='$item'") or die (mysqli_error($conexao));
    }else{
        mysqli_query($conexao,"INSERT INTO permissao (iduser,item,valor) VALUES ('$id','$item','ativo')") or die (mysqli_error($conexao));
    }
};

//verifica permissões no
function PermissaoCheck($item,$id){
    include('conexao.php');
    $sql1 = mysqli_query($conexao,"SELECT * FROM permissao WHERE iduser='$id' AND item='$item' AND valor='ativo'") or die (mysqli_error($conexao));
    if(mysqli_num_rows($sql1) >= 1){ return 'checked'; }
};
    
//funo limpa ponto e trao
function limpa($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    $valor = str_replace("(", "", $valor);
    $valor = str_replace(")", "", $valor);
    $valor = str_replace("@", "", $valor);
    $valor = str_replace("%", "", $valor);
    $valor = str_replace("#", "", $valor);
    $valor = str_replace("!", "", $valor);
    $valor = str_replace("'", "", $valor);
    $valor = str_replace("<", "", $valor);
    $valor = str_replace(">", "", $valor);
    return $valor;
};

function Moeda($get_valor) {
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
    if(empty($valor)){return 0;}else{return $valor;} //retorna o valor formatado para gravar no banco
};//moeda

function Moeda2($valor) {
    $valor = number_format($valor,2);
    $source = array(',', '.');
    $replace = array('.', '');
    $valor = str_replace($source, $replace, $valor);
    return $valor;
};//moeda2

//alertas
function sucesso(){
echo'<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong><i class="fa fa-check"></i> Sucesso !</strong>
</div>';
}

function delete(){
    echo'<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><i class="fa fa-times"></i> Excluido !</strong>
    </div>';
}

function deletePersona($valor){
    echo'<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><i class="fa fa-times"></i> '.$valor.' !</strong>
    </div>';
}


function persona($valor,$tipo){
echo'<div class="alert alert-'.$tipo.' alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong> '.AspasForm($valor).'</strong>
</div>';
}

function AspasForm($string){
	$string = str_replace('"',chr(146).chr(146), $string);
	$string = str_replace("'",chr(146), $string);
	return $string;
};

function AspasBanco($string){
	$string = str_replace(chr(146).chr(146),'"', $string);
	$string = str_replace(chr(146),"'",$string);
	return addslashes($string);
};

//data form
function dataForm($valor){
    if($valor != 0000-00-00){
        $valor = date('d-m-Y',strtotime($valor));
        return $valor;
    }
}
//data certa
function dataBanco($valor){
    if($valor != 0000-00-00){
        $valor = date('Y-m-d',strtotime($valor));
        return $valor;
    }
}

//conveter em valor real
function Real($valor){ if($valor==true){ return number_format($valor,2,',','.');} else { return '0,00';}};

function primeiroNome($valor){
    $primeiroNome = explode(" ", $valor);
    return $primeiroNome[0];    
}


//cargos Gerente, supervisor, tecnico, atendimento, financeiro, vendas
$cargos = array('Administrador','Analista','Atendente','Caixa','Coordenador','Financeiro','Gerente','Help Desk','Supervisor','Técnico','Vendedor','Instalador','Serviço Gerais','Outro');

function gerarToken($entropy)
{
    $s=uniqid("",$entropy);
    $num= hexdec(str_replace(".","",(string)$s));
    $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $base= strlen($index);
    $out = '';
        for($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
            $a = floor($num / pow($base,$t));
            $out = $out.substr($index,$a,1);
            $num = $num-($a*pow($base,$t));
        }
    return $out;
}

//operadores
$operadoras = array('TIM','VIVO','CLARO','OI');

//marcação
function label($valor){
    if($valor == 'PENDENTE'){ return '<label class="badge badge-primary">PENDENTE</label>'; }
    if($valor == 'VENCIDO'){ return '<label class="badge badge-warning">VENCIDO</label>'; }
    if($valor == 'CANCELADO'){ return '<label class="badge badge-danger">CANCELADO</label>'; }
    if($valor == 'RECEBIDO'){ return '<label class="badge badge-success">RECEBIDO</label>'; }
}

//situacao
function situacao($valor){
    if($valor == 'PENDENTE'){ return '<label class="badge badge-info">PENDENTE</label>'; }
    if($valor == 'EM ATENDIMENTO'){ return '<label class="badge badge-warning">EM ATENDIMENTO</label>'; }
    if($valor == 'CANCELADO'){ return '<label class="badge badge-danger">CANCELADO</label>'; }
    if($valor == 'FINALIZADO'){ return '<label class="badge badge-success">FINALIZADO</label>'; }

}

//tipo ordem
$tipoOrdem = array('Recolhimento','Instalação','Manutenção','Troca');
?>
