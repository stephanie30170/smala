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
//session_start();
//$_SESSION['user_id'];
include "connectDB.php";

try {
    // instancie un objet $connexion à partir de la classe PDO
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
} catch (PDOException $e) {
    // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
    exit("❌🙀💀 OOPS :\n" . $e->getMessage());

}
//modifier un utlisateur
if (isset($_POST['modifier'])) {
    $user_id = $_POST['user_id'];
    $user_pseudo = $_POST['user_pseudo'];
    $user_mail = $_POST['user_mail'];
    $user_mdp = $_POST['user_mdp'];
    $user_role = $_POST['user_role'];

    $requete = "UPDATE `user` SET `user_pseudo` =:user_pseudo, `user_mail` =:user_mail, `user_mdp` =:user_mdp, `user_role` =:user_role WHERE `user_id` =:user_id;";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ':user_id' => $user_id,
        ':user_pseudo' => $user_pseudo,
        ':user_mail' => $user_mail,
        ':user_mdp' => $user_mdp,
        ':user_role' => $user_role,
    ));
}

if (isset($_GET['user_id'])) {
    $requete = 'SELECT * FROM `user` WHERE `user_id` =:user_id;';
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ":user_id" => $_GET['user_id'],
    ));
    $resultat = $prepare->fetch();
    echo " <h3>Bonjour " . $resultat['user_pseudo'] . "</h3><h3> Mon profil </h3></br> Mon pseudo : " . $resultat['user_pseudo'] . "</br> Mon e-mail : " . $resultat['user_mail'] . "</br>
Mon Mot de passe : " . $resultat['user_mdp'] . "</br>";
if($resultat['user_role'] == 0) {
    echo " je suis un d'utilisateur";
}else{
    echo "je suis un administrateur";
}
?>
 </br>
        <button type="submit"><a href="util.php?user_id=<?=$resultat['user_id']?>">Modifier</a></button>
 </br>
<h3>Modifier mon profil</h3>
<form action="util.php" method="post" >
    <table>
        <tr>
        <td>Pseudo</td>
        <td><input type="text" name="user_pseudo" value="<?=$resultat['user_pseudo']?>"></td>
        </tr>
        <tr>
        <td>Mail</td>
        <td><input type="mail" name="user_mail" value="<?=$resultat['user_mail']?>"></td>
        </tr>
        <tr>
        <td>Mot de passe</td>
        <td><input type="text" name="user_mdp" value="<?=$resultat['user_mdp']?>"></td>
        </tr>
        <input type="hidden" name="user_role" value="<?=$resultat['user_role']?>">
        <input type="hidden" name="user_id" value="<?=$resultat['user_id']?>">
    </table>
    <button name="modifier">Enregistrer</button>
</form>
<?php
}
?>
</main>
</body>
</html>
