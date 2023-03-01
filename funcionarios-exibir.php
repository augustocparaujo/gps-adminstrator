<?php
include('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao,"select * from funcionarios where id='$id'") or die (mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mb-0">Alterar funcionário</h4>
          <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div><hr>
            <form method="post" id="formAlterar">
                <input type="text" class="hidden" name="id" value="'.$dd['id'].'">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cargo</label>
                        <div class="col-sm-9">
                            <select type="text" class="form-control" name="cargo" required>
                            <option value="'.$dd['cargo'].'">'.$dd['cargo'].'</option>';
                            foreach($cargos as $item){ echo'<option value="'.$item.'">'.$item.'</option>'; }
                            echo'
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ínicio atividade</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="inicioatividade" value="'.date($dd['inicioatividade']).'"/>
                    </div>            
                    </div>
                </div>           
                </div>

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
                    <label class="col-sm-3 col-form-label">CPF</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control cpf2" name="cpf" value="'.$dd['cpf'].'"/>
                        </div>
                    </div>
                </div>
                </div>
              
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">RG</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="rg" value="'.$dd['rg'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nascimento</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control data" name="nascimento" value="'.dataForm($dd['nascimento']).'"/>
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
                <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Atividades</label>
                <div class="col-sm-12">
                    <textarea row="3" class="form-control" name="atividades">'.$dd['atividades'].'</textarea>
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
                        <input type="text" class="form-control" name="tipochave" value="'.$dd['tipochave'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Chave PIX</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="chavepix" value="'.$dd['chavepix'].'"/>
                    </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Banco</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="banco" value="'.$dd['banco'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Agência</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="agencia" value="'.$dd['agencia'].'"/>
                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Conta</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="conta" value="'.$dd['conta'].'"/>
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
            <div class="row"></div><hr>
            <h4 class="card-title mb-0">Financeiro funcionário</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Moeda</th>
                        <th>Valor</th>
                        <th>Data/Pag</th>
                        <th>Agendado</th>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post">
        <div class="modal-body">
        <input type="text" class="hidden" name="funcionario" id="funcionario" value="'.$id.'"/>
          <div class="row">
            <label class="col-md-6 col-sm-12">Tipo
              <select type="text" class="form-control" name="tipo" required>
                <option value="">selecione</option>
                <option value="vale">vale</option>
                <option value="salário">salário</option>
                <option value="comissão">comissão</option>
                <option value="outros">outros</option>
              </select>
            </label>

            <label class="col-md-6 col-sm-12">Moeda
                <select type="text" class="form-control" name="moeda" required>
                    <option value="">selecione</option>
                    <option value="dinheiro">dinheiro</option>
                    <option value="trasnferência">trasnferência</option>
                    <option value="pix">pix</option>
                    <option value="outros">outros</option>
                </select>
            </label>

            <label class="col-md-12 col-sm-12">Descrição
              <input type="text" class="form-control" name="descricao" required/>
            </label>

          </div>
          <div class="row">
            <label class="col-md-6 col-sm-12">Valor
              <input type="text" class="form-control real" name="valor" required/>
            </label>

            <label class="col-md-6 col-sm-12">Situação
                <select type="text" class="form-control" name="situacao" required>
                    <option value="">selecione</option>
                    <option value="pago">pago</option>
                    <option value="agendado">agendado</option>
                </select>
            </label>
          </div>
          <div class="row">
          <label class="col-md-6 col-sm-12">Data pago
                <input type="text" class="form-control data" name="data"/>
            </label>
          <label class="col-md-6 col-sm-12">Agendado para
            <input type="text" class="form-control data" name="agendadopara"/>
          </label>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>';

echo'
<!-- Modal -->
<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterarM" method="post">
        <div class="modal-body" id="retornoMovimento">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>';

include('rodape.php');
?>
<script>
$('.funcionarios').addClass('active');
//tabela
$(function() { tabela(); });
function tabela(){
    let id = $('#funcionario').val();
    $.get('funcionarios-movimento-tabela.php',{id:id},function(data){ 
          $('#tabela').show().html(data);
    });
    return false;
}
//alterar
$('#formAlterar').submit(function(){
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'funcionarios-update.php',
      data:$('#formAlterar').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data); 
        window.setTimeout(function() { history.go(); }, 2501);
      }
  });
  return false;
});
//cadastrar movimento
$('#formCadastrar').submit(function(){
    $('#cadastrar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'funcionarios-movimento-update.php',
      data:$('#formCadastrar').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data); 
        tabela();
      }
  });
  return false;
});
//alterar plano
function alterar(id){
    $('#alterar').modal('show');
    $.get('funcionarios-movimento-retorno.php',{id:id},function(data){
    $('#retornoMovimento').show().html(data);
    });
    return false;
}
$('#formAlterarM').submit(function(){
    $('#alterar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'funcionarios-movimento-update.php',
      data:$('#formAlterarM').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data); 
        tabela();
      }
  });
  return false;
});
//excluir
function excluir(id){
  var r = confirm('Deseja excluir?');
  if(r == true){
    $('#processando').modal('show');
    $.get('funcionarios-movimento-excluir.php',{id:id},function(data){
      $('#processando').modal('hide');
      $('#retorno').show().fadeOut(2500).html(data);
      tabela();
    });
  return false;
  }
}
</script>