<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="imagens/mosquito.png" type="image/x-icon">
        <title>Space Impact 2</title>
        <link rel="stylesheet" href="jogo.css">
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet"> 
        <script>
            function play(){
                var nome = document.forms["Form"]["nome"].value;
                window.location.href = "jogo.php?nome="+nome;
            }            
        </script>
    </head>
    <body>
        <div id="menu">
            <h1>SPACE IMPACT 2</h1>
			<form name="Form" action="/action_page.php" method="post">
				<h2>Nome: <input type="text" name="nome"></h2>
			</form>
			<button type="button" onclick="play()">Jogar</button>
            <p>
                Setas movimentam <br>
                Tecla Espaço atira <br>
                Algum bug ainda não resolvido faz os inimigos demorarem uns 22 segundos para aparecer
                depois que o jogo inicia.
            </p>
        </div>        
    </body>
</html>