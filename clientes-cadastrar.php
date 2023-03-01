<?php
include('topo.php');
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mb-0">Cliente cadastrar</h4>
          <button class="btn btn-primary mr-2 hidden" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>
            <form method="post" action="clientes-update.php">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nome">
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Apelido</label>
                    <div class="col-sm-9">
                        <input type="text" select class="form-control" name="apelido"/>
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
                        <input type="text" class="form-control cpf2 física" name="cpf"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">CNPJ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cnpj jurídica" name="cnpj" required/>
                    </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-6 física" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">RG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control física" name="rg"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 física" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Data nascimento</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control física" name="nascimento"/>
                    </div>            
                    </div>
                </div>
                <!--pessoa jurídica-->
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fantasia</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control jurídica" name="rg"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 jurídica" style="display:none">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Data ínicio/criação</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control jurídica" name="datacricao"/>
                    </div>            
                    </div>
                </div>
                </div>       

                <div class="row">

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">E-mail</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email"/>
                    </div>            
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control celular" name="contato"/>
                    </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="contato2"/>
                    </div>
                    </div>
                </div>

                </div>

                <div class="row física" style="display:none">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nome pai</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nomepai"/>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nome mãe</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nomemae"/>
                    </div>
                    </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">CEP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cepBusca" name="cep"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Endereço</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control enderecoBusca" name="endereco"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Número</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="numero"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bairro</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control bairroBusca" name="bairro"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Cidade</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cidadeBusca" name="cidade"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Estado</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ufBusca" name="estado"/>
                    </div>
                </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary btn-block">Salvar</button>
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
$('.clientes','.clientes-cadastrar').addClass('active');
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
</script>