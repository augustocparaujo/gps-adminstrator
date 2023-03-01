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
            <h4 class="card-title mb-0">Usuários</h4>
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>
                        
      <table class="table table-striped w-100">
        <thead>
          <tr>
            <th> Usuário </th>
            <th> Acesso </th>
            <th> Situação </th>
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
    <!-- content-wrapper ends -->

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
            <label>Nome</label>
            <input type="text" class="form-control" placeholder="Nome" name="nome" required/>
        </div>
        <div class="form-group">
            <label>Cargo</label>
            <select class="form-control" name="cargo" required>';
                foreach($cargos as $item){ echo'<option value="'.$item.'">'.$item.'</option>';}
            echo'
            </select>
        </div>
        <div class="form-group">
            <label>CPF</label>
            <input type="text" class="form-control cpf2" placeholder="CPF" name="cpf" required/>
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" class="form-control" placeholder="E-mail" name="email" required/>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="text" class="form-control" placeholder="senha" name="senha" required/>
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
    $('.usuarios').addClass('active');
    //tabela
    $(function() { tabela(); });
    function tabela(){
        $.ajax({
            type:'post',
            url:'usuarios-tabela.php',
            data:'html',
            success:function(data){ $('#tabela').show().html(data);}
        });
        return false;
    }
    //bloquear
    function bloquear(id,i){
      $.get('usuarios-bloquear.php',{id:id,i:i},function(data){ 
        $('#retorno').show().fadeOut(5000).html(data); 
        tabela(); 
      });
      return false;
    }
    //cadastrar
    $('#formCadastrar').submit(function(){
      $('#cadastrar').modal('hide');
        $.ajax({
            type:'post',
            url:'usuarios-update.php',
            data:$('#formCadastrar').serialize(),
            success:function(data){ $('#retorno').show().fadeOut(5000).html(data); 
            tabela(); 
            }
        });
        return false;
    });
</script>