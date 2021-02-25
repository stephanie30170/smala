<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Title -->
    <meta name="description" content="Home description.">
    <title>Titre site</title>
    <meta charset="UTF-8"/>
    <!-- Robots -->
    <meta name="robots" content="index, follow">
    <!-- Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- Links -->
    <link rel="stylesheet" type="text/css" href="src/css/style.css"/>
</head>
 <body>
    <nav>
        <h1>SMALA</h1>
        <div id="btn_menu"></div>
    </nav>
    <main>
    <?php
include "connectDB.php";
try {
    // instancie un objet $connexion à partir de la classe PDO
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
} catch (PDOException $e) {
    // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
    exit("❌🙀💀 OOPS :\n" . $e->getMessage());

}
//modifier un titre
if (isset($_POST['modifier'])) {
    $img_id = $_POST['img_id'];
    $img_titre = $_POST['img_titre'];
    $img_url = $_POST['img_url'];
    $img_user_id = $_POST['img_user_id'];

    $requete = "UPDATE `img` SET `img_titre` =:img_titre, `img_url` =:img_url, `img_user_id` =:img_user_id WHERE `img_id` =:img_id ;";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ':img_id' => $img_id,
        ':img_titre' => $img_titre,
        ':img_url' => $img_url,
        ':img_user_id' => $img_user_id,

    ));
}
//supprimer une image :
if (isset($_GET['supprimer'])) {
    $img_id = $_GET['id'];
    $requete = "DELETE FROM `img` WHERE `img_id` =:img_id;";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ':img_id' => $img_id,
    ));
}
//requete selection
$requete = 'SELECT * FROM `img` ';
$prepare = $connexion->prepare($requete);
$prepare->execute();
$resultat = $prepare->fetchAll();
foreach ($resultat as $img) {
    $img_user_id = $img['img_user_id'];

    ?>
                <p><?=$img['img_titre']?></p>
                <p> <img src="<?=$img['img_url']?>"width=150px/></p>
    <?php
//requete pour aller chercher l'utilisateur :
    $requete = "SELECT * FROM `user` WHERE `user_id` = $img_user_id";
    $prepare = $connexion->prepare($requete);
    $prepare->execute();
    $resultatuser = $prepare->fetchAll();
    foreach ($resultatuser as $user) {
        ?>
                <p>photo déposée par <?=$user['user_pseudo']?></p>
                <button type="submit" ><a href="essai.php?supprimer=<?=$img['img_id']?>">Supprimer</a></button>
                <button type="submit" ><a href="essai.php?img_id=<?=$img['img_id']?>">Modifier</a></button>
<?php
}}
if (isset($_GET['img_id'])) {
    $requete = 'SELECT * FROM `img` WHERE `img_id` =:img_id;';
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ":img_id" => $_GET['img_id'],
    ));
    $resultat = $prepare->fetch();
    ?>
<form action="essai.php" method="post" >
        <td>modifier le Titre ici</td>
        <td><input type="text" name="img_titre" value="<?=$resultat['img_titre']?>"></td>
        <input type="hidden" name="img_id" value="<?=$resultat['img_id']?>">
        <input type="hidden" name="img_url" value="<?=$resultat['img_url']?>">
        <input type="hidden" name="img_user_id" value="<?=$resultat['img_user_id']?>">
        <button name="modifier">Enregistrer</button>
</form>
<?php
}
?>
</main>
</body>
</html>