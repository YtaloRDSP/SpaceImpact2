<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="imagens/mosquito.png" type="image/x-icon">
        <title>Space Impact 2</title>
        <link rel="stylesheet" href="jogo.css">
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet"> 
        <style>
            #tabela{
                text-align: center;
                margin-right: auto;
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
                    echo "<table style='border: solid 1px black;'>";
                    echo "<tr><th>Nome</th><th>Pontuação</th></tr>";

                    class TableRows extends RecursiveIteratorIterator {
                        function __construct($it) {
                            parent::__construct($it, self::LEAVES_ONLY);
                        }

                        function current() {
                            return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
                        }

                        function beginChildren() {
                            echo "<tr>";
                        }

                        function endChildren() {
                            echo "</tr>" . "\n";
                        }
                    }

                    $servername = 'us-cdbr-east-03.cleardb.com';
                    $username = 'bfd45cf1c2d965';
                    $password = 'd1836119';
                    $database = 'SpaceImpact';

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

                        $stmt = $conn->prepare("SELECT Nome, Pontos FROM Ranking ORDER BY Pontos DESC LIMIT 10");
                        $stmt->execute();

                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                            echo $v;
                        }

                    } catch(PDOException $e) {
                        echo $stmt . '<br>' . $e->getMessage();
                    }
                    $conn = null;
                ?>
            </div>
            <button type="button" onclick="window.location.href = 'index.php'">Reiniciar</button>
        </div>        
    </body>
</html>