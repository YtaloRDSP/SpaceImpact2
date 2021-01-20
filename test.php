<?php
    try{
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

        $conn = new mysqli($server, $username, $password, $db);
    }

    catch(PDOException $e) {
        echo $stmt . '<br>' . $e->getMessage();
    }
    $conn = null;
?>
