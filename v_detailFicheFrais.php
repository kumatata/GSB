<div class="contenu">
    <p>Fiche frais</p>
<table border=4 cellspacing=4 cellpadding=4 width=80%>
    <thead>
    <tr>
            <th>Id Visiteur</th>
            <th>Mois/Annee</th>
            <th>Nombre de Justificatifs</th>
            <th>Montant Validé</th>
            <th>Date de Modification</th>
            <th>Etat</th>
            <th>Validation</th>
    </tr>
    </thead>
    



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
        foreach ($detailVisiteur as $visiteur)
            {  
        ?>
         <tbody>
        <tr>
        <th>
         <?php echo $visiteur['idVisiteur'] ; ?>
        </th>
        <th>
         <?php echo $visiteur['mois'] ; echo $visiteur['annee']; ?>
        </th>
        <th>
         <?php echo $visiteur['nbJustificatifs'] ; ?>
        </th>
        <th>
         <?php echo $visiteur['montantValide'] ; ?>
        </th>
        <th>
         <?php echo $visiteur['dateModif'] ; ?>
        </th>
        <th>
         <?php echo $visiteur['idEtat'] ; ?>
        </th>
         <th>
         <input type="submit" value="Valider" name="Valider" />
        </th>
        </tr>
       
         </tbody>
            <?php } ?>
</table>
</div>