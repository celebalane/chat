<?php
	session_start();

	//Vérifications
	$errors = array();

	if(!isset($_POST['pseudo']) || ($_POST['pseudo'] == '' || !preg_match("/^[a-zA-Zéè0-9@ ]*$/",$_POST['pseudo'])) ) {// on verifie l'existence du champ et d'un contenu
  		$errors ['pseudo'] = "Veuillez entrer un pseudo valide";
  	}

  	if(!isset($_POST['message']) || $_POST['message'] == '') {
  		$errors ['message'] = "Vous n'avez pas entré votre message";
  	}

  	// Connexion à la base de données
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=testChat;charset=utf8', 'root', '');
	}
	catch(Exception $e){
        die('Erreur : '.$e->getMessage());
	}

	if(!empty($errors)){ // si erreur on renvoie vers la page précédente
  		$_SESSION['errors'] = $errors;//on stocke les erreurs
  		$_SESSION['inputs'] = $_POST;
  		header('Location: index.php');
  	}else{
  		$_SESSION['success'] = 1;
  		// Insertion du message à l'aide d'une requête préparée
		$req = $bdd->prepare('INSERT INTO chat (pseudo, message) VALUES(?, ?)');
		$req->execute(array($_POST['pseudo'], $_POST['message']));

		// Redirection du visiteur vers la page du minichat
		header('Location: index.php');
  	}
?>