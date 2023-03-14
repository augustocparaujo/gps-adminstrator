<?php
echo '
<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link funcionarios-dados" href="funcionarios-exibir.php?id=' . $id . '">Dados funcionário</a></li>
    <li class="nav-item"><a class="nav-link funcionarios-proventos" href="funcionarios-proventos.php?id=' . $id . '">Proventos</a></li>
    <li class="nav-item"><a class="nav-link funcionarios-financeiro" href="funcionarios-financeiro.php?id=' . $id . '">Financeiro</a></li>   
    <li class="nav-item"><a class="nav-link funcionarios-ponto" href="funcionarios-ponto.php?id=' . $id . '">Ponto</a></li>
    <li class="nav-item"><a class="nav-link funcionarios-contracheque" href="funcionarios-contracheque.php?id=' . $id . '">Contra cheque</a></li> 

</ul><br />
';