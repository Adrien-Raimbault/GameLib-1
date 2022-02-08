<h1>Studios</h1>
<?php
if (isset($_POST['studio'])) {
    $name = htmlentities(mb_strtoupper(trim($_POST['name']))) ?? '';
    $country = htmlentities(ucfirst(mb_strtolower(trim($_POST['country'])))) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($name)) !== 1)
        array_push($erreur, "Veuillez saisir Le nom du studio");
    else
        $name = html_entity_decode($name);

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($country)) !== 1)
        array_push($erreur, "Veuillez saisir le pays d'origine du studio");
    else
        $country = html_entity_decode($country);

    if (count($erreur) === 0) {
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "";

        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
                $query = $conn->prepare("
                INSERT INTO studios(name, country)
                VALUES (:name, :country)
                ");

                $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
                $query->bindParam(':country', $country, PDO::PARAM_STR_CHAR);

                $query->execute();
                
                echo "<p>Insertions effectuées</p>";
            }
         catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
    } else {
        $messageErreur = "<ul>";
        $i = 0;
        do {
            $messageErreur .= "<li>" . $erreur[$i] . "</li>";
            $i++;
        } while ($i < count($erreur));

        $messageErreur .= "</ul>";

        echo $messageErreur;
        include 'frmStudio.php';
    }
} else {
    echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
    $name = $country = '';

    include 'frmStudio.php';
}
