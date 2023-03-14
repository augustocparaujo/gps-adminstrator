<?php
include_once('topo.php');
$id = $_GET['id'];
$sql = mysqli_query($conexao, "select * from funcionarios where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
//idfuncionario,tipo	descricao	valor	usuariocad	datacad	

echo '
<input type="text" class="hidden" id="id" value="' . $id . '"/>
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
include_once('funcionarios-tab.php');
echo '
        <div class="d-flex justify-content-between">
        <h4 class="card-title mb-0"></h4>
        <div class="button-canto-inferior" data-toggle="modal" data-target="#cadastrar" title="cadastrar"><i class="fa fa-plus"></i></div>
        </div>

        <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Valor</th>
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

echo '
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
        <input type="text" class="hidden" name="funcionario" id="funcionario" value="' . $id . '"/>
          <div class="row">
            <label class="col-md-6 col-sm-12">Tipo
              <select type="text" class="form-control" name="tipo" required>
                <option value="">selecione</option>
                <option value="entrada">entrada</option>
                <option value="saida">saida</option>
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

include_once('rodape.php');
?>
<script>
    $('.funcionarios').addClass('active');
    $('.funcionarios-listar,.funcionarios-proventos').addClass('ativo2');
    /*
    //tabela
    $(function() {
        tabela();
    });

    function tabela() {
        let id = $('#funcionario').val();
        $.get('funcionarios-proventos-tabela.php', {
            id: id
        }, function(data) {
            $('#tabela').show().html(data);
        });
        return false;
    }
    //cadastrar movimento
    $('#formCadastrar').submit(function() {
        $('#cadastrar').modal('hide');
        $('#processando').modal('show');
        $.ajax({
            type: 'post',
            url: 'funcionarios-movimento-update.php',
            data: $('#formCadastrar').serialize(),
            success: function(data) {
                $('#processando').modal('hide');
                $('#retorno').show().fadeOut(2500).html(data);
                tabela();
            }
        });
        return false;
    });
    //alterar plano
    function alterar(id) {
        $('#alterar').modal('show');
        $.get('funcionarios-movimento-retorno.php', {
            id: id
        }, function(data) {
            $('#retornoMovimento').show().html(data);
        });
        return false;
    }
    $('#formAlterarM').submit(function() {
        $('#alterar').modal('hide');
        $('#processando').modal('show');
        $.ajax({
            type: 'post',
            url: 'funcionarios-movimento-update.php',
            data: $('#formAlterarM').serialize(),
            success: function(data) {
                $('#processando').modal('hide');
                $('#retorno').show().fadeOut(2500).html(data);
                tabela();
            }
        });
        return false;
    });
    //excluir
    function excluir(id) {
        var r = confirm('Deseja excluir?');
        if (r == true) {
            $('#processando').modal('show');
            $.get('funcionarios-movimento-excluir.php', {
                id: id
            }, function(data) {
                $('#processando').modal('hide');
                $('#retorno').show().fadeOut(2500).html(data);
                tabela();
            });
            return false;
        }
    }*/
</script>