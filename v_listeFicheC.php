<div id="contenu">
      <h2>Fiches de frais à valider</h2>
       <div class="corpsForm">

      <form method='POST' action="index.php?uc=gestionFrais&action=listeVisiteur" >
<p>
        <select name="moisannee">
         <?php
         foreach ($lesFichesFrais as $uneFicheFrais){
         ?>
             <?php echo "<option value='".$uneFicheFrais['mois']."".$uneFicheFrais['annee']."'selected>".$uneFicheFrais['mois']." | ".$uneFicheFrais['annee']."</option>";?>
           
         <?php }?>
        </select>                
</p>
       </div>
<input type="submit" value="Valider"  />

</form>
  


