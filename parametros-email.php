<?php
include('topo.php');
$sql = mysqli_query($conexao,"select * from email") or die (mysqli_error($conexao));
$dde = mysqli_fetch_array($sql);
echo'
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
          include('parametros-tab.php');echo'
          <form method="post" id="formEmail">
          <input typo="text" class="hidden" name="id"value="'.@$dde['id'].'"/>
          
            <div class="col-md-12">
              <ol type="1">
                <li>Contratar servidor de e-mail</li>
                <li>Host do servidor</li>
                <li>Porta de comunicação</li>
                <li>Conta de e-mail válida</li>
                <li>Assunto padrão</li>
                <li>Seguir corretamente o exemplo</li>
                <li>Porta padrão: 465</li>
                <li>Provedor: Hotmail, Outlook, etc</li>
              </ol>  
            </div>

            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Servidor SMTP
                <input type="text" class="form-control" placeholder="smtp.example.com" name="servidor_smtp" value="'.@$dde['servidor_smtp'].'" />
              </label> 
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Porta servidor
                <input type="text" class="form-control" placeholder="465" name="porta" value="'.@$dde['porta'].'" />
              </label>               
            </div>

            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Conta e-mail
                <input type="text" class="form-control" placeholder="conta de e-mail" name="contaemail" value="'.@$dde['contaemail'].'" />
              </label>          
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Senha do e-mail
                <input type="password" class="form-control" placeholder="******" name="senha_email" value="'.@$dde['senha_email'].'" />
              </label>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-4 col-xs-12 hidden">Dias antes
                <input type="number" class="form-control" placeholder="" name="antes" value="'.@$dde['antes'].'"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-4 col-xs-12 hidden">Dias depois
                <input type="number" class="form-control" placeholder="" name="depois" value="'.@$dde['depois'].'"/>
              </label>
            </div>

            <div class="row">
              <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Assunto padrão
                <input type="text" class="form-control" placeholder="Assunto" name="assunto" value="'.AspasForm(@$dde['assunto']).'"/>
              </label>
              <div class="row"></div>
              <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Texto Exemplo: Olá, senhor(a): {cliente}, Fatura em aberto Valor: {valor}, Mes: {mes}, código de barras: {codigobarra}, Link do boleto: {linkboleto}, PDF do boleto: {pdf})
                <textarea rows="3" class="form-control" placeholder="Texto" name="texto">'.AspasForm(@$dde['texto']).'</textarea>
              </label>
            </div>

            <div class="row">
            <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Salvar</button>
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
  $('.parametros').addClass('active');
  $('.parametros-email').addClass('ativo2');
  //form
  $('#formEmail').submit(function(){
    $('#processando').modal('show');
    $.ajax({
      type:'post',
      url:'parametros-email-update.php',
      data:$('#formEmail').serialize(),
      success:function(data){
        $('#processando').modal('hide');
        $('#retorno').show().fadeOut(2500).html(data);
        window.setTimeout(function() { history.go(); }, 2501);
      }
    });
    return false;
  });
</script>