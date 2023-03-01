<!DOCTYPE html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Speedtracker</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link rel="stylesheet" href="assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
              <center><h3><b>Speedtracker</b></h3></center>
                <form id="form" method="post">
                  <div class="form-group">
                    <label class="label">CPF</label>
                    <div class="input-group">
                      <input type="text" class="form-control cpf2" placeholder="CPF" name="cpf"/>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fa fa-id-badge"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Senha</label>
                    <div class="input-group">
                      <input type="password" class="form-control" placeholder="*********" name="senha"/>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fa fa-key"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary submit-btn btn-block" id="aguarde">ENTRAR</button>
                  </div>
                  <div class="form-group" id="retorno"></div>
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                    </div>
                    <a href="#" class="text-small forgot-password text-black">Esqueçeu a senha?</a>
                  </div>
                  <div class="text-block text-center my-3">
                  </div>
                </form>
              </div>
              <p class="footer-text text-center">copyright © 2022 Speedtracker. Todos os direitors resetvados.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/js/vendor.bundle.addons.js"></script>
    <script src="assets/js/shared/off-canvas.js"></script>
    <script src="assets/js/shared/misc.js"></script>
    <!--meus script -->
    <script src="assets/js/jquery.mask.js"></script>
    <script src="assets/js/jquery.maskMoney.js"></script>
    <script src="assets/js/meusscripts.js"></script>
    <script>
      $('#form').submit(function(){
        $('#aguarde').show().attr('disabled',true).text('Aguarde, Processando...');
        $.ajax({
          type:'post',
          url:'proc_login.php',
          data:$('#form').serialize(),
          success:function(data){
            $('#retorno').show().fadeOut(5000).html(data);
            $('#aguarde').show().attr('disabled',false).text('ENTRAR');
          }
        });
        return false;
      });
    </script>
  </body>
</html>