<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Space Impact 2</title>
        <link rel="shortcut icon" href="imagens/nave.png" type="image/x-icon">
        <link rel="stylesheet" href="jogo.css">
        <script src="jogo.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

        <script>
            var x = "<?php print $_GET['nome']; ?>"
            if (x == ''){
                window.alert('Insira um nome')
                window.location.href = "index.php";
            }
        </script>
        
    </head>
    <body onload="iniciar(x)">
        <div class="vidas">
            <img id="n1" src="imagens/vida.png" alt="">
            <img id="n2" src="imagens/vida.png" alt="">
            <img id="n3" src="imagens/vida.png" alt="">
        </div>
        <div class="pontuacao">PTS: <span id="pontos"></span></div>

    </body>
</html>