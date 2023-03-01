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
$sql = mysqli_query($conexao,"SELECT cliente_produto.*, produto.descricao as nomeproduto, atendimento.periodo,atendimento.agendado AS dataagendado FROM cliente_produto
LEFT JOIN produto ON cliente_produto.idproduto = produto.id 
LEFT JOIN atendimento ON cliente_produto.idagenda = atendimento.id 
WHERE cliente_produto.id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);

echo'
<input type="hidden" name="id" id="id" value="'.@$id.'"/>
<input type="hidden" name="idcliente" id="idcliente" value="'.@$id.'"/>

  <div class="row">
  <label class="col-lg-2 col-md-6 col-sm-12">Tipo
      <select type="text" class="form-control" name="tipo" id="tipo" required readonly>
           <option value="'.$dd['tipo'].'">'.$dd['tipo'].'</option> 
        <option value="Comodato">Comodato</option>
        <option value="Venda">Venda</option>
      </select>
    </label>

  <label class="col-lg-6 col-md-6 col-sm-12">Pruduto
    <select type="text" class="form-control" name="idproduto" required readonly>
      <option value="'.$dd['idproduto'].'">'.$dd['nomeproduto'].'</option>';
        $sql1 = mysqli_query($conexao,"select * from produto order by descricao asc");
        while($r = mysqli_fetch_array($sql1)){ echo'<option value="'.$r['id'].'">Marca:'.$r['marca'].' | Modelo:'.$r['modelo'].' | Descrição:'.$r['descricao'].' | Estoque:'.$r['quantidade'].' | '.Real($r['valorvenda']).'</option>'; }
      echo'
    </select>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Forma/Pag
  <select type="text" class="form-control" id="formapagamento" name="formapagamento" required readonly>
    <option value="'.$dd['formapagamento'].'">'.$dd['formapagamento'].'</option>
    <option value="Dinheiro">Dinheiro</option>
    <option value="Boleto">Boleto</option>
    <option value="Cartão credito">Cartão credito</option>
    <option value="Cartão débito">Cartão débito</option>
    <option value="PIX">PIX</option>
    <option value="Comodato">comodato</option>
    <option value="Outro">Outro</option>
  </select>
  </label>

  </div>   
  <hr style="border: 1px solid black">
  <div class="row">

  <label class="col-lg-2 col-md-6 col-sm-12">Banco
  <select type="text" class="form-control" name="banco" readonly>';
    if(!empty($dd['banco'])){ echo'<option value="'.$dd['banco'].'">'.$dd['banco'].'</option>'; } else { echo '<option value="">selecione</option>'; }
    $sqlb = mysqli_query($conexao,"select recebercom from dadoscobranca") or die (mysqli_error($conexao));
    while($ddb = mysqli_fetch_array($sqlb)){
        echo'<option value="'.$ddb['recebercom'].'">'.$ddb['recebercom'].'</option>';
    }echo'
    <option value="CARTEIRA" id="bancocarteira">CARTEIRA</option>
  </select>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Quantidade
    <input type="number" class="form-control" name="quantidade" value="'.$dd['quantidade'].'" required readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Parcelas
    <input type="number" class="form-control" name="parcela" id="parcelas" value="'.$dd['parcela'].'" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Vencimento
    <input type="date" class="form-control" name="vencimento" id="vencimento" value="'.date($dd['vencimento']).'" readonly/>
  </label>

  </div>
  <hr style="border: 1px solid black">
  <div class="row">

  <label class="col-lg-2 col-md-6 col-sm-12">Crédito
    <input type="text" class="form-control real" name="valorcredito" id="cartaocredito" value="'.Real($dd['valorcredito']).'" placeholder="Digite o valor" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Débito
    <input type="text" class="form-control real" name="valordebito" id="cartaodebito" value="'.Real($dd['valordebito']).'" placeholder="Digite o valor" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Dinherio
    <input type="text" class="form-control real" name="valordinheiro" id="dinheiro" value="'.Real($dd['valordinheiro']).'" placeholder="Digite o valor" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Pix
    <input type="text" class="form-control real" name="valorpix" id="pix" value="'.Real($dd['valorpix']).'" placeholder="Digite o valor" readonly/>
  </label>
  
  <label class="col-lg-2 col-md-6 col-sm-12">Taxa
    <input type="text" class="form-control real" name="valortaxa" value="'.Real($dd['valortaxa']).'" placeholder="Digite o valor" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Valor total
    <input type="text" class="form-control real" name="valortotal" value="'.Real($dd['valortotal']).'" id="valortotal" placeholder="0,00" readonly/>
  </label>
  </div>  
  
  <hr style="border: 1px solid black">
  <div class="row">

  <label class="col-lg-2 col-md-6 col-sm-12">Agendar instalação
  <select type="text" class="form-control" name="agendado" id="instalacao" required readonly>
    <option value="'.$dd['agendado'].'">'.$dd['agendado'].'</option>  
    <option value="sim">sim</option>
    <option value="não">não</option>          
  </select>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12 datainstalacao">Data
    <input type="date" class="form-control" name="datainstalacao" value="'.date($dd['dataagendado']).'" readonly/>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12 datainstalacao">Período
  <select type="text" class="form-control" name="periodo" id="periodo" readonly>
    <option value="'.$dd['periodo'].'">'.$dd['periodo'].'</option>  
    <option value="Manhã">Manhã</option>
    <option value="Tarde">Tarde</option>  
    <option value="Noite">Noite</option>         
  </select>
  </label>

  <label class="col-lg-2 col-md-6 col-sm-12">Situação
  <select type="text" class="form-control" name="situacao" readonly>
    <option value="'.$dd['situacao'].'">'.$dd['situacao'].'</option>  
    <option value="PENDENTE">PENDENTE</option>
    <option value="EM ATENDIMENTO">EM ATENDIMENTO</option>  
    <option value="CANCELADO">CANCELADO</option>         
    <option value="FINALIZADO">FINALIZADO</option>
  </select>
  </label>

  </div>';



?>