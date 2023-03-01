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
            <h4 class="card-title mb-0">Clientes</h4>
            <button class="btn btn-primary mr-2 hidden" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>
                        
        <table class="table table-striped w-100">
            <thead>
            <tr>
                <th> Nome </th>
                <th> CPF/CNPJ </th>
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
include('rodape.php');
?>
<script>
    //marcar menu
    $('.clientes','.clientes-listar').addClass('active');
    //tabela
    $(function() { tabela(); });
    function tabela(){
        $.ajax({
            type:'post',
            url:'clientes-tabela.php',
            data:'html',
            success:function(data){ $('#tabela').show().html(data);}
        });
        return false;
    }  
</script>