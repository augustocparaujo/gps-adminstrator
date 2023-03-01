<?php
include('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from cliente where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
        include('clientes-tab.php'); echo'
            <form method="post" id="formAtualiza">
            <input type="text" class="hidden" name="id" value="'.$id.'"/>
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nome" value="'.$dd['nome'].'">
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Apelido</label>
                    <div class="col-sm-9">
                        <input type="text" select class="form-control" name="apelido" value="'.$dd['apelido'].'"/>
                    </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tipo de pessoa</label>
                    <div class="col-sm-9">
                        <select type="text" class="form-control" id="tipopessoa" name="tipopessoa" required>
                            <option value="'.$dd['tipopessoa'].'">'.$dd['tipopessoa'].'</option>
                            <option value="física">física</option>
                            <option value="jurídica">jurídica</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 física" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">CPF</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cpf2 física" name="cpf" value="'.$dd['cpf'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">CNPJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cnpj jurídica" name="cnpj" value="'.$dd['cnpj'].'" required/>
                    </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6 física" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">RG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control física" name="rg" value="'.$dd['rg'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 física" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Data nascimento</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control física" name="nascimento" value="'.$dd['nascimento'].'"/>
                    </div>            
                    </div>
                </div>
                <!--pessoa jurídica-->
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fantasia</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control jurídica" name="fantasia" value="'.$dd['fantasia'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Data ínicio/criação</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control jurídica" name="datacricao" value="'.dataForm($dd['nascimento']).'"/>
                    </div>            
                    </div>
                </div>
                </div>                

                <div class="row">

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">E-mail</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" value="'.$dd['email'].'"/>
                    </div>            
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control celular" name="contato" value="'.$dd['contato'].'"/>
                    </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control celular" name="contato1" value="'.$dd['contato1'].'"/>
                    </div>
                    </div>
                </div>
                
                </div>

                <div class="row"></div><hr>
                <div class="row" style="background:#DCDCDC ">

                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Banco</label>
                        <div class="col-sm-9">
                            <select type="text" class="form-control" name="banco" rquired>';
                            if(!empty($dd['banco'])){ echo'<option value="'.$dd['banco'].'">'.$dd['banco'].'</option>'; } else { echo'<option value="">selecione</option>';}
                            $sqlb = mysqli_query($conexao,"select recebercom from dadoscobranca") or die (mysqli_error($conexao));
                            while($ddb = mysqli_fetch_array($sqlb)){
                                echo'<option value="'.$ddb['recebercom'].'">'.$ddb['recebercom'].'</option>';
                            }echo'
                            <option value="CARTEIRA" id="bancocarteira">CARTEIRA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Vencimento</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" maxlength="2" name="diavencimento" value="'.$dd['diavencimento'].'"/>
                        </div>
                    </div>
                </div>

                </div>
                
                <div class="row"></div><hr>

                <div class="row física" style="display:none; background:#DCDCDC">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nome pai</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nomepai" value="'.$dd['nomepai'].'"/>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nome mãe</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nomemae" value="'.$dd['nomemae'].'"/>
                    </div>
                    </div>
                </div>
                </div> 

                <div class="row"></div><hr>

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">CEP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cepBusca" name="cep" value="'.$dd['cep'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Endereço</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control enderecoBusca" name="endereco" value="'.$dd['endereco'].'"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Número</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="numero" value="'.$dd['numero'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bairro</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control bairroBusca" name="bairro" value="'.$dd['bairro'].'"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Cidade</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cidadeBusca" name="cidade" value="'.$dd['cidade'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Estado</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ufBusca" name="estado" value="'.$dd['estado'].'"/>
                    </div>
                </div>
                </div>
                </div> 



                <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label"></label>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Salvar</button>
                    </div>
                    </div>
                </div>
                </div> 

            </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- content-wrapper ends -->';
include('rodape.php');
?>
<script>
$('.clientes').addClass('active');
$('.clientes-dados').addClass('ativo2');
//tipo cliente
$(function() {
$('#tipopessoa').on('change', function() {
    var valor = ($(this).val());
    if(valor == 'física'){
        $('.física').show().attr('required', true);
        $('.jurídica').hide().removeAttr('required');
    }else{
        $('.jurídica').show().attr('required', true);
        $('.física').hide().removeAttr('required');
    }
    }).trigger('change');
});
//formAtualiza
$('#formAtualiza').submit(function(){
    $.ajax({
        type:'post',
        url:'clientes-update.php',
        data:$('#formAtualiza').serialize(),
        success:function(data){ $('#retorno').show().fadeOut(5000).html(data); }
    });
    return false;
});
</script>