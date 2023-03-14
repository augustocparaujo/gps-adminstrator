<?php
include_once('topo.php');
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = $iduser;
}
$sql = mysqli_query($conexao, "select * from usuario where id='$id'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);
echo '
<div class="content-wrapper">   
  <div class="row">
  <!--aqui-->

  <div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mb-0">Usuário</h4>
            <button class="btn btn-primary mr-2 hidden" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div><hr>

        <form class="form-sample" id="formAtualiza" method="post">
        <input type="text" name="id" class="hidden" value="' . $id . '"/>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nome" value="' . AspasForm($dd['nome']) . '">
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                <label class="col-sm-3 col-form-label">Cargo</label>
                <div class="col-sm-9">
                <select class="form-control" name="cargo" required>';
if (!empty($dd['cargo'])) {
    echo '<option value="' . $dd['cargo'] . '">' . $dd['cargo'] . '</option>';
} else {
    echo '<option value="">selecione</option>';
}
foreach ($cargos as $item) {
    echo '<option value="' . $item . '">' . $item . '</option>';
}
echo '
                </select>
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
                <label class="col-sm-3 col-form-label">Data cadastrado</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="' . dataForm($dd['datacad']) . '"/>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contato</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control celular" name="contato" value="' . $dd['contato'] . '"/>
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
            <div class="row">';
if ($tipouser == 'full' or $iduser == $dd['id']) {
    echo '
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Senha</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="senha" placeholder="*********"/>
                </div>
                </div>
            </div>';
}
echo '

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

        <hr><p class="card-description"> Permissões </p>
        <div class="row">
        
        
        </div> 

    </div>
  </div>
</div>

    <!--aqui-->
  </div>
</div>
    <!-- content-wrapper ends -->';
include_once('rodape.php');
?>
<script>
    //marcar menu
    $('.usuarios').addClass('active');
    //atualiza
    $('#formAtualiza').submit(function() {
        $.ajax({
            type: 'post',
            url: 'usuarios-update.php',
            data: $('#formAtualiza').serialize(),
            success: function(data) {
                $('#retorno').show().html(data);
            }
        })
        return false;
    });
</script>