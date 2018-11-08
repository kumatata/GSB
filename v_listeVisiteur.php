
      <h2>Liste de Visiteurs</h2>
       <div class="corpsForm">
      <form method='POST' action="index.php?uc=gestionFrais&action=detailFicheVisiteur" >
<p>
        <select name="Visiteur">
         <?php
         foreach ($lesVisiteurs as $unVisiteur){
         ?>
             <?php echo "<option value='".$unVisiteur['idVisiteur']."'>".$unVisiteur['nom']." | ".$unVisiteur['prenom']."</option>";?>
           
         <?php }?>
        </select>                
</p>
       </div>
<input type="submit" value="Valider"  /> 

</form>
  

</div>
