<?php
include('topo.php');
echo'
<div class="content-wrapper">   
  <div class="row">
  <!--aqui-->

  <div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mb-0">Funcionários</h4>
            <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div><hr>
        <table class="table table-striped w-100">
            <thead>
            <tr>
                <th> Nome </th>
                <th> CPF</th>
                <th> Cargo</th>
                <th> Cadastro </th>
                <th> # </th>
            </tr>
            </thead>
            <tbody id="tabela"></tbody>
        </table>
        </div>
    </div>
    </div>

    <!--aqui-->
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

          <div class="row">
            <label class="col-md-6 col-sm-12">Cargo
              <select type="text" class="form-control" name="cargo" required>
              <option value="">selecione</option>';
              foreach($cargos as $item){ echo'<option value="'.$item.'">'.$item.'</option>'; }
              echo'
              </select>
            </label>

            <label class="col-md-6 col-sm-12">Nome
              <input type="text" class="form-control" name="nome" required/>
            </label>

          </div>
          <div class="row">
            <label class="col-md-6 col-sm-12">Contato
              <input type="text" class="form-control celular" name="contato"/>
            </label>

            <label class="col-md-6 col-sm-12">CPF
              <input type="text" class="form-control cpf2" name="cpf"/>
            </label>
          </div>
          <div class="row">
            <label class="col-md-12 col-sm-12">Atividades
              <textarea row="3" class="form-control" name="atividades"></textarea>
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

include('rodape.php');
?>
<script>
//marcar menu
$('.funcionarios-','.funcionarios-listar').addClass('active');
//tabela
$(function() { tabela(); });
function tabela(){
    $.ajax({
        type:'post',
        url:'funcionarios-tabela.php',
        data:'html',
        success:function(data){ 
          $('#tabela').show().html(data);
        }
    });
    return false;
}
//cadastrar
$('#formCadastrar').submit(function(){
  $('#cadastrar').modal('hide');
  $('#processando').modal('show');
  $.ajax({
      type:'post',
      url:'funcionarios-update.php',
      data:$('#formCadastrar').serialize(),
      success:function(data){ 
        $('#processando').modal('hide');
        $('#formCadastrar').each(function(){this.reset();});
        $('#retorno').show().fadeOut(5000).html(data); 
        tabela(); 
      }
  });
  return false;
});
</script>