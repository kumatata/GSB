<?php
include("vues/v_sommaireC.php");
$idUtilisateur = $_SESSION['idUtilisateur'];
$action = $_REQUEST['action'];
$anneeC = substr($_SESSION['moisannee'], -4);
$moisC = substr($_SESSION['moisannee'], 0, -4);




switch($action){
	case 'validerFicheFrais':
            {
		$lesFichesFrais=$pdo->getLesInfosFicheFraisMoisAnnee();
                include("vues/v_listeFicheC.php");
		break;
	}
        
        case 'listeVisiteur':
            {
                    	$lesFichesFrais=$pdo->getLesInfosFicheFraisMoisAnnee();
                        include("vues/v_listeFicheC.php");
                        $moisannee = $_REQUEST['moisannee'] ;
                        $_SESSION['moisannee'] = $moisannee ;
                        $lesVisiteurs=$pdo->getLesInfosFicheFraisVisiteurs($moisC,$anneeC) ;       
                        include("vues/v_listeVisiteur.php");
                  break ;    
                   
                    } 
        
            case 'detailFicheVisiteur':
            {
                  $idVisiteur = $_REQUEST['Visiteur'] ;
                  $moisannee = $_REQUEST['moisannee'] ;
                  $_SESSION['moisannee'] = $moisannee ;
                  $detailVisiteur =$pdo->getDetailFicheFrais($idVisiteur,$moisC,$anneeC);
                  include("vues/v_detailFicheFrais.php");
                  break;
            }
}
?>