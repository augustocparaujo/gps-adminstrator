<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from funcionarios where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo '
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        ';
include_once('funcionarios-tab.php');
echo '

        <div class="d-flex justify-content-between">
          <div class="button-canto-inferior hidden" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>
            <form method="post" id="formAlterar">
                <input type="text" class="hidden" name="id" value="' . $dd['id'] . '">
                <div class="row">
                <ol>
                <li>falta cadastrar escala de serviço</li>
                </ol>
                <div class="row"></div><hr>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cargo</label>
                        <div class="col-sm-9">
                            <select type="text" class="form-control" name="cargo" required>
                            <option value="' . $dd['cargo'] . '">' . $dd['cargo'] . '</option>';
foreach ($cargos as $item) {
    echo '<option value="' . $item . '">' . $item . '</option>';
}
echo '
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ínicio atividade</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="inicioatividade" value="' . date($dd['inicioatividade']) . '"/>
                    </div>            
                    </div>
                </div>           
                </div>

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nome" value="' . $dd['nome'] . '">
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">CPF</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control cpf2" name="cpf" value="' . $dd['cpf'] . '"/>
                        </div>
                    </div>
                </div>
                </div>
              
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">RG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="rg" value="' . $dd['rg'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nascimento</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control data" name="nascimento" value="' . dataForm($dd['nascimento']) . '"/>
                    </div>            
                    </div>
                </div>
                </div>       

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">E-mail</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" value="' . $dd['email'] . '"/>
                    </div>            
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control celular" name="contato" value="' . $dd['contato'] . '"/>
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
                        <input type="text" class="form-control cepBusca" name="cep" value="' . $dd['cep'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Endereço</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control enderecoBusca" name="endereco" value="' . $dd['endereco'] . '"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Número</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="numero" value="' . $dd['numero'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bairro</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control bairroBusca" name="bairro" value="' . $dd['bairro'] . '"/>
                    </div>
                </div>
                </div>
                </div> 

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Cidade</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control cidadeBusca" name="cidade" value="' . $dd['cidade'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Estado</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ufBusca" name="estado" value="' . $dd['estado'] . '"/>
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Atividades</label>
                <div class="col-sm-12">
                    <textarea row="3" class="form-control" name="atividades">' . $dd['atividades'] . '</textarea>
                </div>
                </div>
                </div>
                </div>
                
                <div class="row"></div><hr>

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipo de chave</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="tipochave" value="' . $dd['tipochave'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Chave PIX</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="chavepix" value="' . $dd['chavepix'] . '"/>
                    </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Banco</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="banco" value="' . $dd['banco'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Agência</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="agencia" value="' . $dd['agencia'] . '"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Conta</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="conta" value="' . $dd['conta'] . '"/>
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
include_once('rodape.php');
?>
<script>
//marcar menu
$('.funcionarios').addClass('active');
$('.funcionarios-listar,.funcionarios-dados').addClass('ativo2');
//alterar
$('#formAlterar').submit(function() {
    $('#processando').modal('show');
    $.ajax({
        type: 'post',
        url: 'funcionarios-update.php',
        data: $('#formAlterar').serialize(),
        success: function(data) {
            $('#processando').modal('hide');
            $('#retorno').show().fadeOut(2500).html(data);
            window.setTimeout(function() {
                history.go();
            }, 2501);
        }
    });
    return false;
});
</script>