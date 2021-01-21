<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="imagens/nave.png" type="image/x-icon">
        <title>Space Impact 2</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="jogo.css">
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet"> 
        <style>
            #tabela{
                text-align: center;
            }
            #tabela thead{
                font-size: 1.5rem;
            }
        </style>
    </head>
    <body>
        <div id="menu">
            <h1>FIM DE JOGO</h1>
            <div id="tabela">
                <?php
                    $nome = [];
                    $pontos = [];
                    $nome = $_GET['nome'];
                    $pontos = (int)$_GET['pontos'];
                    echo "  <table class='table table-sm table-striped table-hover text-light col-4 m-auto'>
                            <thead class='thead-dark text-uppercase'>
                                <tr>
                                    <th scope='col'>#</th>
                                    <th scope='col'>Nome</th>
                                    <th scope='col'>Pontos</th>
                                </tr>
                            </thead>";

                    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

                    $servername = $url["host"];
                    $username = $url["user"];
                    $password = $url["pass"];
                    $database = substr($url["path"], 1);

                    try {

                        $conn = new PDO("mysql:host=$servername", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "CREATE DATABASE IF NOT EXISTS $database;";
                        $conn->exec($sql);
                        $conn = null;
                    
                        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sql = 'CREATE TABLE IF NOT EXISTS Ranking (
                            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            Nome VARCHAR(30) NOT NULL,
                            Pontos int(50) NOT NULL
                        )';

                        $conn->exec($sql);
                    
                        $stmt = $conn->prepare("INSERT INTO Ranking (Nome, Pontos)
                                                VALUES (:nome, :pontos)");
                        $stmt->bindParam(':nome', $nome);
                        $stmt->bindParam(':pontos', $pontos);
                        $stmt->execute();

                        $stmt = $conn->prepare("SELECT id FROM Ranking ORDER BY id DESC LIMIT 1");
                        $stmt->execute();
                        $result = $stmt->fetch();
                        $idAtual= $result['id'];

                        $stmt = $conn->prepare("SELECT id, Nome, Pontos FROM Ranking ORDER BY Pontos DESC LIMIT 10");
                        $stmt->execute();

                        $result = $stmt->fetchAll();
                        if($result){
                            $n = 1;
                            foreach($result as $linha){
                                if($idAtual == $linha["id"]){
                                    echo "<tr class='table-light text-dark'>
                                        <th>".$n."</th>
                                        <th>".$linha["Nome"]."</th>
                                        <th>".$linha["Pontos"]." </th>
                                    </tr>";
                                } else{
                                    echo "<tr>
                                        <th>".$n."</th>
                                        <th>".$linha["Nome"]."</th>
                                        <th>".$linha["Pontos"]." </th>
                                    </tr>";
                                }
                                $n++;
                            }
                        }             

                    } catch(PDOException $e) {
                        echo $stmt . '<br>' . $e->getMessage();
                    }
                    $conn = null;
                ?>
            </div>
            <div>
                <?php
                    echo "<a class='btn btn-secondary fixed-bottom col-2 m-auto mb-5' href='index.php' role='button'>Reiniciar</a>";
                ?>
            </div>
        </div>        
    </body>
</html>