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
            <h4 class="card-title mb-0">Serviços</h4>
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>
                        
      <table class="table table-striped w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Cadastro</th>
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
            <label>Descrição</label>
            <input type="text" class="form-control" placeholder="Descrição" name="descricao" required/>
        </div>
        <div class="form-group">
            <label>Valor</label>
            <input type="text" class="form-control real" placeholder="0,00" name="valor" required/>
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alterar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" id="formAlterar" method="post">
      <div class="modal-body" id="plano">
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
    $('.planos','.planos-listar').addClass('active');
    //tabela
    $(function() { tabela(); });
    function tabela(){
        $.ajax({
            type:'post',
            url:'planos-tabela.php',
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
            url:'planos-update.php',
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
      $.get('planos-retorno.php',{id:id},function(data){
        $('#plano').show().html(data);
      });
      return false;
    }
    //cadastrar
    $('#formAlterar').submit(function(){
    $('#alterar').modal('hide');
      $.ajax({
          type:'post',
          url:'planos-update.php',
          data:$('#formAlterar').serialize(),
          success:function(data){ $('#retorno').show().fadeOut(5000).html(data); 
          tabela(); 
          }
      });
      return false;
    });
</script>