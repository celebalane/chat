<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style/css/style.css">
        <title> Test de chat</title>
    </head>
    <body>
        <section class="container">
            <div class="row">
            <form action="traitement.php" method="post" class="form-inline col-md-9 col-md-offset-1">
                <div class="form-group">
                    <label for="pseudo" class="control-label col-md-2">Pseudo</label>
                    <input type="text" class="form-control col-md-10" name="pseudo" id="pseudo" placeholder="Bidule">
                </div>
                <div class="form-group">
                    <label for="message" class="control-label col-md-2">Message</label>
                    <input type="text" class="form-control col-md-10" name="message" id="message" placeholder="votre message">
                </div>
                <button type="submit" class="btn btn-default">Envoi</button>
            </form>
            </div>
            <?php if(array_key_exists('errors',$_SESSION)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $_SESSION['errors']); ?>
                </div>
            <?php endif; ?>
            <div class="row" id="contenuMessage">
                <h4>Messages</h4>
                <?php
                    // Connexion à la base de données
                    try{
	                   $bdd = new PDO('mysql:host=localhost;dbname=testChat;charset=utf8', 'root', '');
                    }
                    catch(Exception $e){
                        die('Erreur : '.$e->getMessage());
                    }

                    // Récupération des 10 derniers messages
                    $reponse = $bdd->query('SELECT pseudo, message FROM chat ORDER BY ID DESC LIMIT 10');

                    if(!isset($erreur)){
                    // Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
                    while ($donnees = $reponse->fetch()){
	                   echo '<p><strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> : ' . htmlspecialchars($donnees['message']) . '</p>';
                    }

                    $reponse->closeCursor();
                }else{
                    echo $erreur;
                }
                ?>
            </div>
            <div class="row">
                <a  href="index.php" role="button" class="btn btn-default actu col-md-1 col-md-offset-11">Actualiser</a>
            </div>
        </section>
    </body>
</html>
<?php
    unset($_SESSION['inputs']); // on nettoie les données précédentes
    unset($_SESSION['success']);
    unset($_SESSION['errors']);
?>