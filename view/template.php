<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $titre ?></title>
</head>
<body>
    <header>
        <div id="navigateur">
        <img src="public/img/logo.png" alt="Logo">
            <nav>
                <a href="http://localhost/manon_CHAPELLE/cin%C3%A9ma/index.php?action=listFilms">FILMS</a>
                <a href="">AJOUTER</a>
                <a href="">ACTEURS</a>
                <a href="">REALISATEURS</a>
            </nav>
        </div>   
    </header> 
    <main>
        <div id="contenu">
            <h1><?= $titre_secondaire ?><h/1>
            <?= $contenu ?>
        </div>
    </main>    
</body>
<footer>
    <a class="contact" href="">NOUS CONTACTER</a> 
        <div class="liens">
            <i class="fa-brands fa-x-twitter fa-lg"><a href=""></a></i>
            <i class="fa-brands fa-facebook-messenger fa-lg"><a href=""></a></i>
            <i class="fa-brands fa-instagram fa-lg"><a href=""></a></i>
        </div>  
</footer>
</html>