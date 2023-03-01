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


$id = $_GET['id'];
$sql = mysqli_query($conexao,"select produto.*, categoria.descricao as nomecategoria from produto 
LEFT JOIN categoria ON produto.categoria = categoria.id
where produto.id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<input type="text" class="hidden" name="id" value="'.$dd['id'].'"/>
<div class="row">
<label class="col-lg-6 col-sm-12">Categoria
    <select type="text" class="form-control" name="categoria" required>';
        if(!empty($dd['categoria'])){ echo '<option value="'.$dd['categoria'].'">'.$dd['nomecategoria'].'</option>'; }else{ echo'<option value="">selecione</option>'; }
        $sql1 = mysqli_query($conexao,"select * from categoria order by descricao asc");
        while($d = mysqli_fetch_array($sql1)){ echo'<option value="'.$d['id'].'">'.$d['descricao'].'</option>'; }echo'
    </select>
</label>
<label class="col-lg-6 col-sm-12">Operadora
    <select type="text" class="form-control" name="operadora">';
        if(!empty($dd['operadora'])){ echo'<option value="'.$dd['operadora'].'">'.$dd['operadora'].'</option>';}
        else{ echo'<option value="">seleciona</option>'; }
        foreach($operadoras as $item){ echo'<option value="'.$item.'">'.$item.'</option>'; }echo'
    </select>
</label>
</div>
<div class="row">
<label class="col-lg-6 col-sm-12">Marca
    <input type="text" class="form-control" name="marca" value="'.$dd['marca'].'"/>
</label>
<label class="col-lg-6 col-sm-12">Modelo
    <input type="text" class="form-control" name="modelo" value="'.$dd['modelo'].'"/>
</label>
</div>
<div class="row">
<label class="col-lg-12 col-sm-12">Descrição
    <input type="text" class="form-control" placeholder="Descrição" name="descricao" value="'.AspasForm($dd['descricao']).'" required/>
</label>
</div>
<div class="row"> 
<label class="col-lg-6 col-sm-12">Quantidade
    <input type="number" class="form-control" name="quantidade" value="'.$dd['quantidade'].'" required/>
</label>
<label class="col-lg-6 col-sm-12">Quantidade mínimo
    <input type="number" class="form-control" name="quantidademinimo" value="'.$dd['quantidademinimo'].'"/>
</label>
</div>  
<div class="row"> 
<label class="col-lg-6 col-sm-12">Valor compra
    <input type="text" class="form-control real" name="valorcompra" value="'.Real($dd['valorcompra']).'"/>
</label>
<label class="col-lg-6 col-sm-12">Valor venda
    <input type="text" class="form-control real" name="valorvenda" value="'.Real($dd['valorvenda']).'"/>
</label>
</div>';
?>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/jquery.maskMoney.js"></script>
<script src="assets/js/meusscripts.js"></script>