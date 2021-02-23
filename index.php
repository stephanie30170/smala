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
//Ajouter un nouvel utilisateur
if (isset($_POST['ajouter'])) {
    $user_pseudo = $_POST['user_pseudo'];
    $user_mail = $_POST['user_mail'];
    $user_mdp = $_POST['user_mdp'];
    $user_role = $_POST['user_role'];

    $requete = "INSERT INTO `user` (`user_pseudo`, `user_mail`, `user_mdp`, `user_role`)
                VALUES (:user_pseudo, :user_mail, :user_mdp, :user_role);";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ':user_pseudo' => $user_pseudo,
        ':user_mail' => $user_mail,
        ':user_mdp' => $user_mdp,
        ':user_role' => $user_role,
    ));
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
//supprimer un utilisateur :
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $requete = "DELETE FROM `user` WHERE `user_id`=:user_id;";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ':user_id' => $user_id,
    ));
}
?>
<table border>
    <thead>
        <th>Id</th>
        <th>Pseudo</th>
        <th>Mail</th>
        <th>Mot passe</th>
        <th>Rôle</th>
    </thead>
    <?php
//requete selection
$requete = 'SELECT * FROM `user` ';
$prepare = $connexion->prepare($requete);
$prepare->execute();
$resultat = $prepare->fetchAll();
foreach ($resultat as $user) {
    ?>
            <tr>
                <td><?=$user['user_id']?></td>
                <td><?=$user['user_pseudo']?></td>
                <td><?=$user['user_mail']?></td>
                <td><?=$user['user_mdp']?></td>
                <td><?=$user['user_role']?></td>
                <td>
                <button type="submit" ><a href="index.php?id=<?=$user['user_id']?>">Supprimer</a></button>
                <button type="submit" ><a href="index.php?user_id=<?=$user['user_id']?>">Modifier</a></button>
                </td>
            </tr>
    <?php
}
?>
</table>
    <h3>Ajouter un utilisateur</h3>
<form method="post" >
    <table>
        <tr>
        <td>Pseudo</td>
        <td><input type="text" name="user_pseudo"></td>
        </tr>
        <tr>
        <td>Mail</td>
        <td><input type="mail" name="user_mail"></td>
        </tr>
        <tr>
        <td>Mot de passe</td>
        <td><input type="text" name="user_mdp"></td>
        </tr>
        <td>Rôle</td>
        <td><input type="text" name="user_role"></td>
        </tr>
    </table>
    <button type="submit" name= "ajouter" value= "ajouter">Ajouter</button>
</form>
<?php
if (isset($_GET['user_id'])) {
    $requete = 'SELECT * FROM `user` WHERE `user_id` =:user_id;';
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        ":user_id" => $_GET['user_id'],
    ));
    $resultat = $prepare->fetch();
    ?>
 </br>
<h3>Ajouter un utilisateur</h3>
<form action="index.php" method="post" >
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
        <td>Rôle</td>
        <td><input type="text" name="user_role" value="<?=$resultat['user_role']?>"></td>
        </tr>
        <input type="hidden" name="user_id" value="<?=$resultat['user_id']?>">
    </table>
    <button name="modifier">Enregistrer</button>
</form>
<?php
}
?>
    </main>
    <script src="src/js/app.js"></script>

</body>
</html>
