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
            <h4 class="card-title mb-0">Estoque</h4>
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>                        
      <table class="table table-striped w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Estoque</th>
            <th>Estoque mínimo</th>
            <th>#</th>
          </tr>
        </thead>
        <tbody id="tabela"></tbody>
      </table>
    </div>
  </div>
</div>

    <!--aqui-->
  </div>
</div><!-- content-wrapper ends -->

<!-- Modal -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formCadastrar" method="post">
      <div class="modal-body">
        <div class="form-group">
        <label>Categoria</label>
            <select type="text" class="form-control" name="categoria" required>
                <option value="">selecione</option>';
                $sql1 = mysqli_query($conexao,"select * from categoria order by descricao asc");
                while($d = mysqli_fetch_array($sql1)){ echo'<option value="'.$d['id'].'">'.$d['descricao'].'</option>'; }echo'
            </select>
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <input type="text" class="form-control" placeholder="Descrição" name="descricao" required/>
        </div>
        <div class="form-group">
            <label>Quantidade</label>
            <input type="number" class="form-control" name="quantidade" required/>
        </div>   
        <div class="form-group">
            <label>Quantidade mínimo</label>
            <input type="number" class="form-control" name="quantidademinimo"/>
        </div>   
        <div class="form-group">
            <label>Valor compra</label>
            <input type="text" class="form-control real" name="valorcompra"/>
        </div>
        <div class="form-group">
            <label>Valor venda</label>
            <input type="text" class="form-control real" name="valorvenda"/>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>   
    </div>
  </div>
</div>

<!-- Modal retorno-->
<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="retornoEstoque">
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
    $('.estoque','.estoque-listar').addClass('active');
    //tabela
    $(function() { tabela(); });
    function tabela(){
        $.ajax({
            type:'post',
            url:'estoque-tabela.php',
            data:'html',
            success:function(data){ $('#tabela').show().html(data);}
        });
        return false;
    }
    //cadastrar
    $('#formCadastrar').submit(function(){
    $('#cadastrar').modal('hide');
        $.ajax({
            type:'post',
            url:'estoque-update.php',
            data:$('#formCadastrar').serialize(),
            success:function(data){ 
            $('#retorno').show().fadeOut(5000).html(data); 
            tabela(); 
            }
        });
        return false;
    });
    //alterar plano
    function alterar(id){
      $('#alterar').modal('show');
      $.get('estoque-retorno.php',{id:id},function(data){
        $('#retornoEstoque').show().html(data);
      });
      return false;
    }
    //cadastrar
    $('#formAlterar').submit(function(){
    $('#alterar').modal('hide');
    $('#processando').modal('show');
      $.ajax({
          type:'post',
          url:'estoque-update.php',
          data:$('#formAlterar').serialize(),
          success:function(data){ 
            $('#processando').modal('hide');
            $('#retorno').show().fadeOut(5000).html(data); 
          tabela(); 
          }
      });
      return false;
    });
</script>