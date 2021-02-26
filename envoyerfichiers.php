<?php
//$_FILES['image']['name']//nom
//$_FILES['image']['type']//type image/png par exemple
//$_FILES['image']['size']//taille de l'image
//$_FILES['image']['tmp_name']//emplacement temporaire
//$_FILES['image']['error']//erreur pour dire que l'image n'a pas ete receptionné correctement

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
// si existe le fichier image et qu'il a bien été receptionné, si error egal 0, c'est que c'est bon
// 1mo(megaoctet) = 1 OOO OOO octet, par défaut php n'accepte pas les fichier de+ 8mo
if($_FILES['image']['size'] <= 3000000){
    $informationsImage = pathinfo($_FILES['image']['name']);
    //capter tout les infos du fichier au cas ou hack, pathinfo est une fonction
    //cela envoyer sur notre variable, les infos sous forme de tableau: taille , type extension
    $extensionImage=$informationsImage['extension'];
    //on va recuperer puisqu'il s'agit d'un tableu l'index extension
    $extensionArray = array('png','gif', 'jpg', 'jpeg');
    //on ecrit les extensions que l'on autorise
    if(in_array($extensionImage,$extensionArray)){
// on verifie si notre extension de notre image ($extensionImage) possde une extension de notre tableau
    move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.time().rand().rand().'.'.$extensionImage);
// on va pouvoir envoyer l'image definitivement sur notre serveur,
//fonction native move_uploaded_file(2 parametres: Nom du fichier temporaire,
// destination de la image avec un nom aléatoire et unique pour eviter les doublons)
echo 'envoi bien réussi';
}
}

}

echo'<form method="post" action="index.php"
enctype="multipart/form-data">
<p>
<h1>formulaire</h1>
<input type="file" name ="image"/> <br>
<button type="submit">envoyer</button>
<p>
</form>';

?>
