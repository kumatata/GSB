  
<!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  Comptable :<br>
				<?php echo $_SESSION['nom']   ?>
           
			</li>
           <li class="smenu">
              <a href="index.php?uc=gestionFrais&action=validerFicheFrais" title="Valider fiche frais ">Valider fiche frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Suivre paiement fiche de frais">Suivre paiement fiche de frais</a>
           </li>
            	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
 	   
         </ul>
        
    </div>
    