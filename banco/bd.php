<?php
function verificaTabela($tabela){
    include('../conexao.php');
    $tabelas_consulta = mysqli_query($conexao,'SHOW TABLES');

    while ($tabelas_linha = mysqli_fetch_row($tabelas_consulta))    {
        $tabelas[] = $tabelas_linha[0];
    }
    if (!in_array($tabela, $tabelas)) {
        //CRIAR A TABELA
            $query = mysqli_query($conexao,"CREATE TABLE $tabela (
            id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idregistro INT(255) UNSIGNED,
            idcliente INT(255) UNSIGNED,
            tipo VARCHAR(30) NOT NULL,
            agendado DATE NULL,
            periodo VARCHAR(50) NOT NULL,
            atendente INT(255) UNSIGNED,
            situacao VARCHAR(30) NOT NULL,
            datacad TIMESTAMP NULL,
            dataalt TIMESTAMP NULL
            )");
        
            if (!$query) {
                echo 'Error: ' . mysqli_error($conexao);
                exit;
            }else{
                echo'Tabela '.$tabela.' criado com sucesso';
            }
    }else{
        return 'Tabela '.$tabela.' já existente verificar as colunas';
    }
}

function verificaTabelaClienteProduto($tabela){
    include('../conexao.php');
    $tabelas_consulta = mysqli_query($conexao,'SHOW TABLES');

    while ($tabelas_linha = mysqli_fetch_row($tabelas_consulta))    {
        $tabelas[] = $tabelas_linha[0];
    }
    if (!in_array($tabela, $tabelas)) {
        //CRIAR A TABELA
            $query = mysqli_query($conexao,"CREATE TABLE $tabela
            (
            id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idagenda INT(255) UNSIGNED NULL,
            idproduto INT(255) UNSIGNED NOT NULL,
            idcliente INT(255) UNSIGNED NOT NULL,
            tipo VARCHAR(30) NOT NULL,
            quantidade INT(4) UNSIGNED,
            formapagamento VARCHAR(100) NOT NULL,
            banco VARCHAR(30) NOT NULL,
            parcela INT(2) UNSIGNED,
            vencimento DATE NULL,
            valordinheiro DECIMAL(10,2) DEFAULT(0.00),
            valorcredito DECIMAL(10,2) DEFAULT(0.00),
            valordebito DECIMAL(10,2) DEFAULT(0.00),
            valorpix DECIMAL(10,2) DEFAULT(0.00),
            valortaxa DECIMAL(10,2) DEFAULT(0.00),
            valortotal DECIMAL(10,2) DEFAULT(0.00),            
            agendado VARCHAR(5) NOT NULL,
            situacao VARCHAR(30) NOT NULL,
            usuariocad INT(255) UNSIGNED NOT NULL,
            datacad TIMESTAMP NULL,
            dataalt TIMESTAMP NULL
            )");
        
            if (!$query) {
                echo 'Error: ' . mysqli_error($conexao);
                exit;
            }else{
                echo'Tabela '.$tabela.' criado com sucesso';
            }
    }else{
        return 'Tabela '.$tabela.' já existente verificar as colunas';
    }
}

//verifica tabelas
echo verificaTabela('atendimento'); echo'<br />';
echo verificaTabelaClienteProduto('cliente_produto');