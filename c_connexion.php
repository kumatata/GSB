<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':
            {
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$utilisateur = $pdo->getInfosVisiteur($login,$mdp);
                 $type = $utilisateur['idtype'];
                if ($type == 0)
                    {
                     $utilisateur = $pdo->getInfosComptable($login,$mdp);
                     $type = $utilisateur['idtype'];
                     echo $type;
                     $id = $utilisateur['id'];
                     $nom =  $utilisateur['nom'];
                     connecterC($id,$nom);
                     include("vues/v_sommaireC.php");
                     
                      }
		elseif(!is_array( $utilisateur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else{
                     
                        echo $type;
			$id = $utilisateur['id'];
			$nom =  $utilisateur['nom'];
			$prenom = $utilisateur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>