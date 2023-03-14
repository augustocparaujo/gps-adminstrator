<?php
include_once('topo.php');


$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$url = str_replace("/parametros.php", "", $url);

echo '
<div class="content-wrapper">   
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">';
include_once('parametros-tab.php');
$sql = mysqli_query($conexao, "select * from dadoscobranca where recebercom='BANCO JUNO'") or die(mysqli_error($conexao));
$dd = mysqli_fetch_array($sql);

echo '          
          <form method="post" id="formJ">
            <input typo="text" class="hidden" name="id"value="' . @$dd['id'] . '"/>
            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-danger"><b>BANCO JUNO</b>
                <input type="text" class="form-control" name="recebercom" value="BANCO JUNO" readonly/>
              </label>

              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Token privado
                <input type="text" class="form-control" name="tokenprivado" value="' . AspasForm(@$dd['tokenprivado']) . '"/>
              </label>
            </div>
            <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Chave pix juno <i style="color:red">*chave pix do juno</i>
              <input type="text" class="form-control" name="chavepixaleatoria" value="' . AspasForm(@$dd['chavepixaleatoria']) . '"/>
            </label>
            
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente id
              <input type="text" class="form-control" name="clienteid" value="' . AspasForm(@$dd['clienteid']) . '"/>
            </label>
            </div>

            <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente secret
              <input type="text" class="form-control" name="clientesecret" value="' . AspasForm(@$dd['clientesecret']) . '"/>
            </label>  
            
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 notificacao">URL de notificação
              <input type="text" class="form-control" name="url" value="' . @$url . '/cobranca-notificacoes.php" readonly/>
            </label>

            </div>

            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-6  col-xs-12">Após/venc
              <input type="number" class="form-control" placeholder="Aceitar após vencimento" name="aposvencimento" value="' . @$dd['aposvencimento'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Dias/desc
              <input type="number" class="form-control" placeholder="Dias para desconto" name="diasdesconto" value="' . @$dd['diasdesconto'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Desconto
              <input type="text" class="form-control real" name="valordesconto" value="' . Real(@$dd['valordesconto']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Multa 
              <input type="text" class="form-control real" name="multaapos" value="' . Real(@$dd['multaapos']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Juros
              <input type="text" class="form-control real" name="jurosapos" value="' . Real(@$dd['jurosapos']) . '"/>
              </label>           
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><br />
                <button type="submit" class="btn btn-primary btn-block">Salvar</button>
              </label>
            </div>
          </form>

          <div class="row"></div><hr>';
$sql2 = mysqli_query($conexao, "select * from dadoscobranca where recebercom='GERENCIANET'") or die(mysqli_error($conexao));
$dd2 = mysqli_fetch_array($sql2);

echo '
          <form method="post" id="formG">
            <input typo="text" class="hidden" name="id"value="' . @$dd2['id'] . '"/>
            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-danger"><b>GERENCIANET</b>
                <input type="text" class="form-control" name="recebercom" value="GERENCIANET" readonly/>
              </label>

              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 notificacao">URL de notificação
              <input type="text" class="form-control" name="url" value="' . @$url . '/cobranca-notificacoes.php" readonly/>
              </label>

            </div>
            <div class="row">            
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente id
              <input type="text" class="form-control" name="clienteid" value="' . AspasForm(@$dd2['clienteid']) . '"/>
            </label>

            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente secret
              <input type="text" class="form-control" name="clientesecret" value="' . AspasForm(@$dd2['clientesecret']) . '"/>
            </label>            
            </div>

            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-6  col-xs-12">Após/venc
              <input type="number" class="form-control" placeholder="Aceitar após vencimento" name="aposvencimento" value="' . @$dd2['aposvencimento'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Dias/desc
              <input type="number" class="form-control" placeholder="Dias para desconto" name="diasdesconto" value="' . @$dd2['diasdesconto'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Desconto
              <input type="text" class="form-control real" name="valordesconto" value="' . Real(@$dd2['valordesconto']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Multa 
              <input type="text" class="form-control real" name="multaapos" value="' . Real(@$dd2['multaapos']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Juros
              <input type="text" class="form-control real" name="jurosapos" value="' . Real(@$dd2['jurosapos']) . '"/>
              </label>           
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><br />
                <button type="submit" class="btn btn-primary btn-block">Salvar</button>
              </label>
            </div>
          </form>

          <div class="row"></div><hr>';
$sql3 = mysqli_query($conexao, "select * from dadoscobranca where recebercom='BANCODOBRASIL'") or die(mysqli_error($conexao));
$dd3 = mysqli_fetch_array($sql3);

echo '
          <form method="post" id="formB">
            <input typo="text" class="hidden" name="id"value="' . @$dd3['id'] . '"/>
            <div class="row">
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-danger"><b>BANCO DO BRASIL</b>
                <input type="text" class="form-control" name="recebercom" value="BANCO DO BRASIL" readonly/>
              </label>
              
              <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 notificacao">URL de notificação
              <input type="text" class="form-control" name="url" value="' . @$url . '/cobranca-notificacoes.php" readonly/>
              </label>

            </div>
            <div class="row">

            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Contrato
              <input type="text" class="form-control" name="contrato" value="' . @$dd3['contrato'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Agência
              <input type="text" class="form-control" name="agencia" value="' . @$dd3['agencia'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Conta
              <input type="text" class="form-control" name="conta" value="' . @$dd3['conta'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Código cedente
              <input type="text" class="form-control" name="codigocedente" value="' . @$dd3['codigocedente'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Convênio
              <input type="text" class="form-control" name="convenio" value="' . @$dd3['convenio'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Carteira
              <input type="text" class="form-control" name="carteira" value="' . @$dd3['carteira'] . '"/>
            </label>
            <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-danger">Var.Carteira
              <input type="text" class="form-control" name="variacaocarteira" value="' . @$dd3['variacaocarteira'] . '"/>
            </label>
            
        
            
            </div>
            <div class="row">            
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente id
              <input type="text" class="form-control" name="clienteid" value="' . AspasForm(@$dd3['clienteid']) . '"/>
            </label>

            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Cliente secret
              <input type="text" class="form-control" name="clientesecret" value="' . AspasForm(@$dd3['clientesecret']) . '"/>
            </label>            
            </div>

            <div class="row">
              <label class="col-lg-2 col-md-2 col-sm-6  col-xs-12">Após/venc
              <input type="number" class="form-control" placeholder="Aceitar após vencimento" name="aposvencimento" value="' . @$dd3['aposvencimento'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Dias/desc
              <input type="text" class="form-control" placeholder="Dias para desconto" name="diasdesconto" value="' . @$dd3['diasdesconto'] . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Desconto
              <input type="text" class="form-control real" name="valordesconto" value="' . Real(@$dd3['valordesconto']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Multa 
              <input type="text" class="form-control real" name="multaapos" value="' . Real(@$dd3['multaapos']) . '"/>
              </label>
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Juros
              <input type="text" class="form-control real" name="jurosapos" value="' . Real(@$dd3['jurosapos']) . '"/>
              </label>           
              <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><br />
                <button type="submit" class="btn btn-primary btn-block">Salvar</button>
              </label>
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
  $('.parametros').addClass('active');
  $('.parametros-cobranca').addClass('ativo2');
  //form
  $('#formJ').submit(function() {
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'parametros-cobranca-update.php',
      data: $('#formJ').serialize(),
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
  //form
  $('#formG').submit(function() {
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'parametros-cobranca-update.php',
      data: $('#formG').serialize(),
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
  //form
  $('#formB').submit(function() {
    $('#processando').modal('show');
    $.ajax({
      type: 'post',
      url: 'parametros-cobranca-update.php',
      data: $('#formB').serialize(),
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