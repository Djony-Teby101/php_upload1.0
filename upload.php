<?php
// verifie si un fichier a ete envoyé.

if(isset($_FILES['image']) && $_FILES['image']['error']===0){
    
    // vérification du type mime.
    $allowed=[
            "jpg"=>"image/jpeg",
            "jpeg"=>"image/jpeg",
            "png"=>"image/png"
    ];

    $filename=$_FILES['image']["name"];
    $filetype=$_FILES['image']["type"];
    $filesize=$_FILES['image']['size'];

    $extention= strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if(!array_key_exists($extention, $allowed) || !in_array($filetype,$allowed)){
        // soit l'extension soit le type est incorrect.
        die("Erreur: format de fichier incorrect");
    }

    // le type correspond.
    // limite à 1Mo
    if($filesize > 1024*1024){
        die('Fichier trop volumineux');
    }

    //  on genere un nom unique.
    $newname=md5(uniqid());
    // on genere le chemin complet.
    $newfilename=__DIR__ ."/uploads/$newname.$extention";
    // on deplace le fichier tmp à upload en le renommant.

    if(!move_uploaded_file($_FILES['image']['tmp_name'],$newfilename)){
        die("l'upload à echoué");
    }
    // On interdit l'exécution du fichier.
    chmod($newfilename, 0644);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de fichier</title>
</head>
<body>
    <h1>Ajout de fichier</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="fichier">Fichier</label>
            <input type="file" name="image" id="fichier">
        </div>
        <button type="submit">Envoyez</button>
    </form>
</body>
</html>