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

        //on récupère l'id du visiteur
        $idVisiteur = $session->get('visiteur')->getIdvisiteur();
        
            $mois = date("m");
            $annee = date("Y");
             //on cherche la fiche frais du mois courant
            $repository_fichefrais = $this->getDoctrine()->getManager()->getRepository('mtBundle:Fichefrais');
            $fichefrais = $repository_fichefrais->findOneBy(array('mois'=>$mois,'annee'=>$annee,'idvisiteur'=>$idVisiteur));
            $em=$this->getDoctrine()->getManager();
             //Si la fiche frais n'existe pas
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
            
            //Si la fiche frais existe
            else{
               
                $today = new DateTime('now');
                $fichefrais->setDatemodif($today);
                $idFichefrais= $fichefrais->getIdfichefrais();
                $em->persist($fichefrais);
                $em->flush();
            }
            
             $idFichefrais= $fichefrais->getIdfichefrais();
            $session->set('idfichefrais',$idFichefrais);    
        
        //on crée un nouvel objet ligne frais forfait
        $ligneFF = new \mtBundle\Entity\Lignefraisforfait();

         //on crée un formulaire pour une frais forfait pour cette fiche
        $form = $this->createForm(\mtBundle\Form\LignefraisforfaitType::class ,$ligneFF);
        $form->get('mois')->setData($mois);
        $form->get('annee')->setData($annee);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
               
            $mois = date("m");
            $annee = date("Y");
            $qte = $form->get('quantite')->getData();
            $em = $this->getDoctrine()->getManager();

         
            //on vérifie si la ligne frais forfait entrée existe
             $repository_lignefraisforfait = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraisforfait');
            $ligneffexiste = $repository_lignefraisforfait->findOneBy(array('idfichefrais' => $idFichefrais,'idfraisforfait'=>$form->get('idfraisforfait')->getData()));
            if($ligneffexiste == NULL){

                $ligneFF->setAnnee($annee);
                $ligneFF->setMois($mois);
                $ligneFF->setIdfraisforfait($form->get('idfraisforfait')->getData());
                $ligneFF->setIdvisiteur($idVisiteur);
                $ligneFF->setIdfichefrais($idFichefrais);
                $ligneFF->setQuantite($qte);
                $em->persist($ligneFF);
            $em->flush();
            }
            else{
                $quantiteExistante = $ligneffexiste->getQuantite();
                $quantite = $qte+$quantiteExistante;
                $ligneffexiste->setQuantite($quantite);
                $em->persist($ligneffexiste);
            $em->flush();
                
            }
           
            //on recherche toutes les lignes frais forfaits et frais hors forfaits correspondant à cette fiche frais
            //$lignefraisforfait=null;
             
            
     
              }
              $repository_lignefraisforfait = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraisforfait');
              $lignefraisforfait = $repository_lignefraisforfait->findBy(array('idfichefrais' => $idFichefrais));
            $session->set("lignefraisforfait", $lignefraisforfait);
              //           if($lignefraisforfait == null){
                        //return $this->render('@mt/Saisie/saisie.html.twig',array('form'=>$form->createView()));
                         //else{
        
                         return $this->render('@mt/Saisie/saisie.html.twig',array('form'=>$form->createView(),'lignefraisforfait'=>$lignefraisforfait));}
    
    
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
        if($form->isSubmitted() && $form->isValid()){
           return $this->redirectToRoute('mt_consultation_annee', ['annee'=>$annee]);
        }       
        
        /*
      
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
        */return $this->render('@mt/Consultation/consultation.html.twig',array('form'=>$form->createView()));
    }
    public function consultationParAnneeAction($annee ,Request $request){
  
         $session = $request->getSession();
            $idVisiteur = $session->get('visiteur')->getIdvisiteur();
        $em = $this->getDoctrine()->getManager();
    
       $repository_fichefrais = $em->getRepository('mtBundle:Fichefrais');
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
        }
        return $this->render('@mt/Consultation/consultationAnnee.html.twig',array('form'=>$form2->createView()));
    }
    
    
    public function modificationAction($idlff,Request $request){
        $em = $this->getDoctrine()->getManager();
        $repository_lignefraisforfait = $em->getRepository('mtBundle:Lignefraisforfait');
             $fraisforfait = $repository_lignefraisforfait->findOneBy(array('id'=>$idlff));
             
             $form = $this->createForm(\mtBundle\Form\LignefraisforfaitType::class ,$fraisforfait);
             $form->handleRequest($request);
         
        if($form->isSubmitted()){
            $fraisforfait->setQuantite($form->get('quantite')->getData());
            
              $em->persist($fraisforfait);
              
              $em->flush();
   
            return $this->render('@mt/Default/index.html.twig');
        }
             
         
             return $this->render('@mt/Saisie/modification.html.twig',array('form'=>$form->createView()));
    }
    
        public function consultationParMoisAnneeAction($annee ,$mois,Request $request){
  
         $session = $request->getSession();
            $idVisiteur = $session->get('visiteur')->getIdvisiteur();
        $em = $this->getDoctrine()->getManager();
    
       $repository_fichefrais = $em->getRepository('mtBundle:Fichefrais');
            $fichefraism = $repository_fichefrais->findBy(array('idvisiteur'=>$idVisiteur,'mois'=>$mois,'annee'=>$annee)); 
            
            $idFichefrais = $fichefraism->get("idfichefrais");
         
             $repository_lignefraisforfait = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraisforfait');
              $lignefraisforfait = $repository_lignefraisforfait->findBy(array('idfichefrais' => $idFichefrais));
            $session->set('lignefraisforfait', $lignefraisforfait);
            
              $repository_lignefraishorsforfait = $this->getDoctrine()->getManager()->getRepository('mtBundle:Lignefraishorsforfait');
              $lignefraishorsforfait = $repository_lignefraishorsforfait->findBy(array('idfichefrais' => $idFichefrais));
            $session->set('lignefraisforfait', $lignefraisforfait);
        
        
         
        return $this->render('@mt/Consultation/consultationAnnee.html.twig',array("lignefraishorsforfait"=>$lignefraishorsforfait,"lignefraisforfait"=>$lignefraisforfait,"fichefraism"=>$fichefraism));
    }
    
    
    
    
}
