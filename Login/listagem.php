<?php require_once("../../conexao/conexao.php"); ?>

<?php
    session_start();

    // Protegendo página interna
    if ( !isset($_SESSION["user_portal"]) ) { // Se não tiver definido
        header("location:login.php");         // Mandarei de volta para a tela de login
    }

    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    // Consulta ao banco de dados
    $produtos = "SELECT produtoID, nomeproduto, tempoentrega, precounitario, imagempequena ";
    $produtos .= "FROM produtos ";

    // Faz funcionar a pesquisa de nomes / filtro em um banco de dados
    if ( isset($_GET["produto"]) ) { // Pergunto se está configurado o parâmetro produto
        $nome_produto = $_GET["produto"]; // Se está configurado faremos o filtro, senao para
        $produtos .= "WHERE nomeproduto LIKE '%{$nome_produto}%' ";
    }
    
    // Conectando banco de dados
    $resultado = mysqli_query($conecta, $produtos);
    if(!$resultado) {
        die("Falha na consulta ao banco");   
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP FUNDAMENTAL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        
        <main>      
            
            <?php
                if ( isset($_SESSION["user_portal"]) ) {
                    echo $_SESSION["user_portal"];
                }
            ?>

            <!-- Área de pesquisa de dados -->  
            <div id="janela_pesquisa">
                <form action="inicial.php" method="get">
                    <input type="text" name="produto" placeholder="Pesquisa">
                    <input type="image" name="pesquisa" src="assets/botao_search.png">
                </form>
            </div>
            
            <div id="listagem_produtos"> 
            <?php
                while($linha = mysqli_fetch_assoc($resultado)) {
            ?>
                <ul>
                    <li class="imagem">
                        <a href="detalhe.php?codigo=<?php echo $linha['produtoID'] ?>"> <!-- Coloquei o 'produtoID' para aparecer como parâmetro neste meu link -->
                            <img src="<?php echo $linha["imagempequena"] ?>">
                        </a>
                    </li>
                    <li><h3><?php echo $linha["nomeproduto"] ?></h3></li>
                    <li>Tempo de Entrega : <?php echo $linha["tempoentrega"] ?></li>
                    <li>Pre&ccedil;o unit&aacute;rio: <?php echo $linha["precounitario"] ?></li>    

                </ul>
             <?php
                }
            ?>           
            </div>
            
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>