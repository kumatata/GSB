<?php

namespace mtBundle\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use mtBundle\Entity\VisiteurRepository;
use DateTime;
use DateInterval;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        
        return $this->render('@mt/Default/index.html.twig');
    }
    
    public function saisieAction(Request $request)
    {
        
           $session = $request->getSession();
         /*$idVisiteur = $session->get('visiteur')->getIdvisiteur();
        $anneeCourante = date('Y');
        $moisCourant = date('m');
        $em = $this->getDoctrine()->getManager();
        $repository_fichefrais = $em->getRepository('mtBundle:Fichefrais');
        $fichefrais= $repository_fichefrais->findBy(array('idvisiteur'=>$idVisiteur,'mois'=>$moisCourant,'annee'=>$anneeCourante));
        if($fichefrais != NULL){
        $session->set('idfichefrais', $fichefrais->getIdfichefrais());
        }*/
        
        //on récupère l'id du visiteur
        $idVisiteur = $session->get('visiteur')->getIdvisiteur();
        //on crée un nouvel objet ligne frais forfait
        $ligneFF = new \mtBundle\Entity\Lignefraisforfait();

         //on crée un formulaire pour une frais forfait pour cette fiche
        $form = $this->createForm(\mtBundle\Form\LignefraisforfaitType::class ,$ligneFF);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            $mois = $form->get('mois')->getData();
        $annee = $form->get('annee')->getData();
        $em = $this->getDoctrine()->getManager();
        
       // $idFichefrais = $session->get('idfichefrais');
    
            //on cherche la fiche frais du mois correspondant avec le mois et l'année
            $repository_fichefrais = $this->getDoctrine()->getManager()->getRepository('mtBundle:Fichefrais');
              $fichefrais = $repository_fichefrais->findOneBy(array('mois'=>$mois,'annee'=>$annee,'idvisiteur'=>$idVisiteur));
              
              if($fichefrais == NULL){
                  //on crée la fiche frais correspondante
                   $fichefrais = new \mtBundle\Entity\Fichefrais();
                   $fichefrais->setAnnee($annee);
      $fichefrais->setMois($mois);
      $fichefrais->setIdvisiteur($idVisiteur);
       $today = new DateTime('now');
      $fichefrais->setDatemodif($today);
        $em->persist($fichefrais);
        $em->flush();
      
       
              }
              else{
                  //si la fiche de frais est en session alors on modifie ses champs
               $today = new DateTime('now');
      $fichefrais->setDatemodif($today);
              $idFichefrais= $fichefrais->getIdfichefrais();
               $em->persist($fichefrais);
        $em->flush();
              }
      
      
        //on recherche toutes les lignes frais forfaits et frais hors forfaits correspondant à cette fiche frais
              $repository_lignefraisforfait = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraisforfait');
              $lignefraisforfait = $repository_lignefraisforfait->findBy(array('idfichefrais' => $idFichefrais));
              $session->set('lignefraisforfait', $lignefraisforfait);
              
              $repository_lignefraishf = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraishorsforfait');
              $lignefraishorsforfait = $repository_lignefraishf->findBy(array('idfichefrais'=>$idFichefrais)); 
              $session->set('lignefraishorsforfait',$lignefraishorsforfait);
//on rempli le frais forfait        
$ligneFF->setAnnee($annee);
$ligneFF->setMois($mois);
$ligneFF->setIdfraisforfait($form->get('idfraisforfait')->getData());
$ligneFF->setIdvisiteur($idVisiteur);

              
                $ligneFF->setIdfichefrais($idFichefrais);

              $em->persist($ligneFF);
              
              $em->flush();
        }
        return $this->render('@mt/Saisie/saisie.html.twig',array('form'=>$form->createView()));
    }
    
    public function connexionAction(Request $request){
         $connexion = new \mtBundle\Entity\Connexion();
 $form = $this->createForm(\mtBundle\Form\ConnexionType::class ,$connexion
         );
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $login= $form->get('login')->getData();
              $mdp= $form->get('mdp')->getData();
                  $mdp = md5($mdp);
              $repository_visiteur= $this->getDoctrine()->getManager()->getRepository('mtBundle:Visiteur');
              $visiteur = $repository_visiteur->findOneBy(array('login'=>$login,'mdp'=>$mdp));
              if ($visiteur === NULL) {
throw $this->createNotFoundException('Visiteur non trouvé');
}
else {
    $session = $request->getSession();
    $session->set('visiteur', $visiteur);

return $this->render('@mt/Default/index.html.twig',
array('visiteur'=>$visiteur));
}
              
              
        }
        return $this->render('@mt/Connexion/connexion.html.twig',array('form'=>$form->createView()));
    }
    
    public function consultationAction(Request $request){
  
         $session = $request->getSession();
            $idVisiteur = $session->get('visiteur')->getIdvisiteur();
        $em = $this->getDoctrine()->getManager();
   
    
        $from = new DateTime('2019-04-01'); 
     $to = new DateTime('2019-04-01');
$interval = new DateInterval('P11M');
$from->sub($interval);
$fromAnnee = $from->format('Y');
$toAnnee = $to->format('Y');
$fromMois = $from->format('m');
$toMois= $to->format('m');

    
    
 
/*$qb = $em->createQueryBuilder();
    $qb->select('f')
        ->from('mtBundle:Fichefrais', 'f')
        ->andWhere('f.annee BETWEEN :fromAnnee AND :toAnnee and f.mois BETWEEN :fromMois AND :toMois')
        ->setParameter('fromAnnee', $fromAnnee )
        ->setParameter('toAnnee', $toAnnee)
            ->setParameter('fromMois', $fromMois )
        ->setParameter('toMois', $toMois)
    ;
    $result = $qb->getQuery()->getResult();
    var_dump($result);*/
        /*
        $repository_fichefrais = $em->getRepository('mtBundle:Fichefrais');
        $fichefraisa = $repository_fichefrais->findBy(array('idvisiteur'=>$idVisiteur));
       
        foreach($fichefraisa as $ffannee){
            $ffannee = $ffannee->getAnnee();
           
            $fichefrais_annee[$ffannee] = $ffannee ;
           
        }
        $session->set('fichefrais_annee', $fichefrais_annee);

        $form = $this->createFormBuilder()
              ->add('annee', ChoiceType::class, array(
                   'choices' => $fichefrais_annee))
                ->add('Valider', SubmitType::class)
                ->add('Annuler', ResetType::class)
                ->getForm();
        $form->handleRequest($request);
        $annee = $form->get('annee')->getData();
      
        if(isset($annee))
            {
    $fichefraism = $repository_fichefrais->findBy(array('idvisiteur'=>$idVisiteur,'annee'=>$annee));  
         
        foreach($fichefraism as $ffmois)
            {
            $ffmois  = $ffmois->getMois();
            $fichefrais_mois[$ffmois] = $ffmois;
          
            }
        
        
             $form2 = $this->createFormBuilder()
                    ->add('mois', ChoiceType::class,array('choices'=>$fichefrais_mois))
                    ->add('Valider', SubmitType::class)
                    ->add('Annuler', ResetType::class)
                    ->getForm();
        
        
         $form2->handleRequest($request);
         
        if($form2->isSubmitted()){
            $mois = $form->get('mois')->getData();
             $repository_lignefraisforfait = $em->getRepository('mtBundle:Lignefraisforfait');
             $fraisforfait = $repository_lignefraisforfait->findBy(array('idvisiteur'=>$idVisiteur,'annee'=>$annee,'mois'=>$mois));
             $session->set('fraisforfait', $fraisforfait);
             return $this->render('@mt/Saisie/saisie.html.twig');
             
        
            // return $this->render('@mt/Consultation/consultation.html.twig',array('form'=>$form2->createView()));
        }
            }
        */return $this->render('@mt/Consultation/consultation.html.twig');
    }
    
    
    
    
}
