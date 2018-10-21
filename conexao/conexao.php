<?php 
    // Passo 1 - Abrir conexão
    $servidor = "localhost";
    $usuario = "root";
    $senha = "root";
    $banco = "andes";
    $conecta = mysqli_connect($servidor,$usuario,$senha,$banco);

    // Passo 2 - Testar conexão
    if (mysqli_connect_errno()) {// erro e no de numero
        die("Conexão falhou: " + mysqli_connect_errno()); // Se deu erro vou mandar matar a conexão
    }
?>