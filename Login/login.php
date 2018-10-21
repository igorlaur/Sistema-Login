<?php require_once("../../conexao/conexao.php"); ?>
<?php
    // Add variáveis de sessão
    session_start(); 
    if ( isset( $_POST["usuario"]) ) { // Pergunto se está configurado
        $usuario = $_POST["usuario"];
        $senha   = $_POST["senha"];

        $login = "SELECT * ";
        $login .= "FROM clientes ";
        $login .= "WHERE usuario = '{$usuario}' and senha = '{$senha}' ";

        $acesso = mysqli_query($conecta, $login); 
        if ( !$acesso ){
            die("Falha na consulta ao banco");
        }

        $informacao = mysqli_fetch_assoc($acesso);

        if( empty($informacao) ){ // Se não tiver registro no banco de dados, de usuários, será empty/vazio
            $mensagem = "Login sem sucesso";
        } else {
            $_SESSION["user_portal"] = "Seja bem-vindo(a), " . $informacao["nomecompleto"]; // Eu do um nome para a variável de sessão
            header("location:listagem.php");
        }

    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP FUNDAMENTAL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/login.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <div id="header_central">
                <img src="assets/logo_andes.gif">
                <img src="assets/text_bnwcoffee.gif">
            </div>
        </header>
        
        <main>  
            <div id="janela_login">
                <form action="login.php" method="post"> <!-- Usei post porque não quero expor o username nem a senha no navegador -->
                    <h2>Tela de Login</h2>
                    <input type="text" name="usuario" placeholder="Usuário">
                    <input type="password" name="senha" placeholder="Senha">
                    <input type="submit" value="Login">
      
                <?php
                    if ( isset($mensagem) ) { // Se está definido a variável mensagem
                ?>
                    <p><?php echo $mensagem ?></p>
                <?php
                    }
                ?>
            </div>
        </main>

        <footer>
            <div id="footer_central">
                <p>ANDES &eacute; uma empresa fict&iacute;cia, usada para o curso PHP Integra&ccedil;&atilde;o com MySQL.</p>
            </div>
        </footer>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>