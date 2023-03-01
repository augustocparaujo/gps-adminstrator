      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category">Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Área de trabalho</span>
              </a>
            </li>

            <li class="nav-item clientes">
              <a class="nav-link" data-toggle="collapse" href="#clientes" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Cliente</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="clientes">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item clientes-listar">
                    <a class="nav-link" href="clientes-listar.php">Listar</a>
                  </li>
                  <li class="nav-item clientes-cadastrar">
                    <a class="nav-link" href="clientes-cadastrar.php">Cadastrar</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item financeiro">
              <a class="nav-link" data-toggle="collapse" href="#financeiro" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Financeiro</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="financeiro">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item financeiro-cobranca">
                    <a class="nav-link" href="cobrancas.php">Cobranças</a>
                  </li>
                  <li class="nav-item financeiro-caixa">
                    <a class="nav-link" href="caixa-controle.php">Controle de caixa</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item estoque">
              <a class="nav-link" data-toggle="collapse" href="#estoque" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Estoque</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="estoque">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item estqoue-listar">
                    <a class="nav-link" href="estoque-listar.php">Listar</a>
                  </li>
                  <li class="nav-item estoque-categoria">
                    <a class="nav-link" href="categoria.php">Categoria</a>
                  </li>
                  <li class="nav-item estoque-fornecedor">
                    <a class="nav-link" href="fornecedor.php">Fornecedor</a>
                  </li>
                  <li class="nav-item estoque-entrada-saida">
                    <a class="nav-link" href="estoque-entrada-saida.php">Entrada/Saída</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item planos">
              <a class="nav-link" data-toggle="collapse" href="#planos" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Serviços</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="planos">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item planos-listar">
                    <a class="nav-link" href="planos-listar.php">Listar</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="">Relatório</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item funcionarios">
              <a class="nav-link" data-toggle="collapse" href="#funcionarios" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Funcionários</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="funcionarios">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item funcionarios-listar">
                    <a class="nav-link" href="funcionarios-listar.php">Listar</a>
                  </li>
                  <li class="nav-item funcionarios-controle">
                    <a class="nav-link" href="funcionarios-controle.php">Controle pagamento</a>
                  </li>
                  <li class="nav-item funcionarios-folha">
                    <a class="nav-link" href="funcionarios-folha.php">Folha de pagamento</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item usuarios">
              <a class="nav-link" href="usuarios.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Usuários</span>
              </a>
            </li>
            <li class="nav-item parametros">
              <a class="nav-link" href="parametros-email.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Parâmetros</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->