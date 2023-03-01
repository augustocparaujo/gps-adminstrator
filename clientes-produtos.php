<?php
include('topo.php');
$id = $_GET['id'];
$query = mysqli_query($conexao,"SELECT * FROM cliente WHERE id='$id'") or die (mysqli_error($conexao));
$ddc = mysqli_fetch_array($query);
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
        include('clientes-tab.php'); echo'
        <div class="d-flex justify-content-between">
        <h4 class="card-title mb-0"></h4>
          <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Agendado</th> 
                <th>Produto</th>
                <th>QUANT</th>
                <th>Valor</th>
                <th>Data</th>             
                <th>Situação</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody id="tabela"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->';
echo'
<!-- Modal -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post" autocomplete="off">
      <div class="modal-body"> 
      <input type="hidden" name="idcliente" id="idcliente" value="'.@$id.'"/>
      <input type="hidden" name="situacao" value="PENDENTE"/>
        <div class="row">
        <label class="col-lg-2 col-md-6 col-sm-12">Tipo
            <select type="text" class="form-control" name="tipo" id="tipo" required>
              <option value="">selecione</option>
              <option value="Comodato">Comodato</option>
              <option value="Venda">Venda</option>
            </select>
          </label>
          <label class="col-lg-1 col-md-6 col-sm-12">QTN
          <input type="number" class="form-control" name="quantidade" id="idquantidade" value="1" min="1" required/>
        </label>
        <label class="col-lg-6 col-md-6 col-sm-12">Produto
          <select type="text" class="form-control" name="idproduto" id="idproduto" required>
            <option value="">selecione</option>';
              $sql1 = mysqli_query($conexao,"select * from produto order by descricao asc");
              while($r = mysqli_fetch_array($sql1)){ echo'<option value="'.$r['id'].'">'.$r['id'].' | Marca:'.$r['marca'].' | Modelo:'.$r['modelo'].' | Descrição:'.$r['descricao'].' | Estoque:'.$r['quantidade'].' | '.Real($r['valorvenda']).'</option>'; }
            echo'
          </select>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Forma/Pag
        <select type="text" class="form-control" id="formapagamento" name="formapagamento" required>
          <option value=""">selecione</option>
          <option value="Comodato" id="comodato">Comodato</option>
          <option value="Carteira" class="some" id="carteira">Carteira</option>
          <option value="Boleto" class="some" id="boleto">Boleto</option>
        </select>
        </label>
        </div>   
        <hr style="border: 1px solid black">
        <div class="row">
        <label class="col-lg-2 col-md-6 col-sm-12">Banco
        <select type="text" class="form-control" name="banco">
          <option value="CARTEIRA">CARTEIRA</option>';
          if($ddc['banco'] != ''){ echo'<option value="'.$ddc['banco'].'">'.$ddc['banco'].'</option>'; }else { echo'<option value="">selecione</option>';}
          $sqlb = mysqli_query($conexao,"select recebercom from dadoscobranca") or die (mysqli_error($conexao));
          while($ddb = mysqli_fetch_array($sqlb)){
              echo'<option value="'.$ddb['recebercom'].'">'.$ddb['recebercom'].'</option>';
          }echo'          
        </select>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Parcelas
          <input type="number" class="form-control" name="parcela" id="parcelas" value="1" min="1"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Vencimento
          <input type="date" class="form-control" name="vencimento" id="vencimento" value="'.date('Y-m-d').'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Valor a receber
          <input type="text" class="form-control real" name="valorareceber" id="valorareceber" placeholder="0,00" readonly/>
        </label>
        </div>
        <hr>
        <div class="row">
        <label class="col-lg-2 col-md-6 col-sm-12">Crédito
          <input type="text" class="form-control real" name="valorcredito" id="cartaocredito" placeholder="Digite o valor" value="'.Real(0).'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Débito
          <input type="text" class="form-control real" name="valordebito" id="cartaodebito" placeholder="Digite o valor" value="'.Real(0).'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Dinheiro
          <input type="text" class="form-control real" name="valordinheiro" id="dinheiro" placeholder="Digite o valor" value="'.Real(0).'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Pix
          <input type="text" class="form-control real" name="valorpix" id="pix" placeholder="Digite o valor" value="'.Real(0).'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Taxa
          <input type="text" class="form-control real" name="valortaxa" id="taxa" placeholder="Digite o valor" value="'.Real(0).'"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12">Valor total
          <input type="text" class="form-control real" name="valortotal" id="valortotal" placeholder="0,00" readonly/>
        </label>
        </div>  
        <hr style="border: 1px solid black">
        <div class="row">
        <label class="col-lg-2 col-md-6 col-sm-12">Agendar instalação
        <select type="text" class="form-control" name="agendado" id="instalacao" required>
          <option value="">selecione</option>  
          <option value="sim">sim</option>
          <option value="não">não</option>          
        </select>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12 datainstalacao">Data
          <input type="date" class="form-control" name="datainstalacao"/>
        </label>
        <label class="col-lg-2 col-md-6 col-sm-12 datainstalacao">Período
        <select type="text" class="form-control" name="periodo" id="periodo">
          <option value="">selecione</option>  
          <option value="Manhã">Manhã</option>
          <option value="Tarde">Tarde</option>  
          <option value="Noite">Noite</option>         
        </select>
        </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>';
echo'
<!-- Modal -->
<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Exibir cadastro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample">
      <div class="modal-body" id="retornoProduto"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Fechar</button>
      </div>
      </form>   
    </div>
  </div>
</div>';
include('rodape.php');
?>
<script>
$('.clientes').addClass('active');
$('.clientes-produtos').addClass('ativo2');
//tabela
$(function() { tabela(); });
function tabela(){
  let id = $('#idcliente').val();
  $.get('clientes-produtos-tab.php',{id:id},function(data){ 
    $('#tabela').show().html(data);
  });
  return false;
};
//cadastrar
$('#formCadastrar').submit(function(){
  $('#cadastrar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
    type:'post',
    url:'clientes-produtos-update.php',
    data:$('#formCadastrar').serialize(),
    success:function(data){
      $('#processando').modal('hide');
      $('#retorno').show().html(data);
      tabela();
     $('#formCadastrar').each(function(){ this.reset(); });
      //window.setTimeout( function() { history.go(); }, 2000);
    }
  });
  return false;
});
//forma pagamento
$(function(){
  $('#formapagamento').on('change', function(){
    var valor = ($(this).val());
    if(valor == 'Carteira'){
      $('#dinheiro').removeAttr('readonly');
      $('#cartaocredito').removeAttr('readonly');
      $('#cartaodebito').removeAttr('readonly');
      $('#pix').removeAttr('readonly');
      $('#parcelas').removeAttr('readonly');
      $('#vencimento').removeAttr('readonly');
    }else if(valor == 'Boleto'){
      $('#taxa').attr('readonly',true);
      $('#dinheiro').attr('readonly',true);
      $('#cartaocredito').attr('readonly',true);
      $('#cartaodebito').attr('readonly',true);
      $('#pix').attr('readonly',true);
      $('#parcelas').removeAttr('readonly');
      $('#bancocarteira').attr('disabled',true);
      $('#bancojuno').attr('disabled',false);
      $('#bancogerencianet').attr('disabled',false);
      $('#bancodobrasil').attr('disabled',false);   
    }else if(valor == 'Comodato'){
      $('#taxa').attr('readonly',true);
      $('#dinheiro').attr('readonly',true);
      $('#cartaocredito').attr('readonly',true);
      $('#cartaodebito').attr('readonly',true);
      $('#pix').attr('readonly',true);
      $('#parcelas').attr('readonly',true);
      $('#bancocarteira').attr('disabled',true);
      $('#bancojuno').attr('disabled',true);
      $('#bancogerencianet').attr('disabled',true);
      $('#bancodobrasil').attr('disabled',true);
    }
  }).trigger('change');
})
//instalação
$(function(){
  $('#instalacao').on('change', function(){
    var valor = ($(this).val());
    if(valor == 'sim'){
      $('.datainstalacao').show();
      $('#periodo').show().attr('required',true);
    }else{
      $('.datainstalacao').hide();
      $('#periodo').show().attr('required',false);
    }
  }).trigger('change');
})
//exibir
function exibir(id){
  $('#alterar').modal('show');
  $.get('clientes-produto-retorno.php',{id:id},function(data){
    //var ret = html(data);
    //document.getElementById('txtstart').value = ret;
    $('#retornoProduto').show().html(data);
  });
  return false;
}

//tipo de venda
$(function(){
  $('#tipo').on('change', function(){
    var valor = ($(this).val());
    if(valor == 'Venda'){
      $('#comodato').hide();
      $('.some').show();
    }else if(valor == 'Comodato'){
      $('#comodato').show();
      $('.some').hide();
    }else{
      $('#comodato').hide();
      $('.some').hide();
    }
  }).trigger('change');
});

//calcular valor total * quantidade
$(function(){  
  $('#idproduto').on('change', function(){
    //obter o id produto
    var id = $(this).val();
    var qtn = $('#idquantidade').val();
    $.get('calcula-produto.php',{id:id,qtn:qtn},function(data){
      $('#valorareceber').val(data);
    });
    return false;    
  }).trigger('change');
});

//calcular valor total * quantidade
$(function(){  
  $('#idquantidade').on('change', function(){
    //obter o id produto
    var id = $('#idproduto').val();
    var qtn = $(this).val();
    $.get('calcula-produto.php',{id:id,qtn:qtn},function(data){
      $('#valorareceber').val(data);
    });
    return false; 
  }).trigger('change');
});


//caixar de valores
$('#cartaocredito,#cartaodebito,#dinheiro,#pix,#taxa').keyup(function(){ mostraTotal();});
function mostraTotal(){
  //adiciona valor a variavel
  valorCredito = 0,00;
  valorDebito = 0,00;
  valorDinheiro = 0,00;
  valorPix = 0,00;
  valorTaxa = 0,00;
  //da um get nos valores existentes ou digitados    
  cartaocredito = $('#cartaocredito').val();
  cartaodebito = $('#cartaodebito').val();
  dinheiro = $('#dinheiro').val();
  pix = $('#pix').val();
  taxa = $('#taxa').val();
  //atribuir valor caso haja
  if(cartaocredito != ''){valorCredito = cartaocredito;}
  if(cartaodebito != ''){valorDebito = cartaodebito;}
  if(dinheiro != ''){valorDinheiro = dinheiro;}
  if(pix != ''){valorPix = pix;}
  if(taxa != ''){valorTaxa = taxa;}
  //perai que term que converter
  total = moedaParaNumero(cartaocredito) + moedaParaNumero(cartaodebito) + moedaParaNumero(dinheiro) + moedaParaNumero(pix) + moedaParaNumero(taxa);
  var totalReal = total.toLocaleString('pt-br', {minimumFractionDigits: 2});
  $('#valortotal').val(totalReal);
};

//aqui tu converte real em moeda
function moedaParaNumero(valor){
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace(".","").replace(",","."));
}
</script>