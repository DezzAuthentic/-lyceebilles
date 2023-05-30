
<div class="titre">
    Détails des factures de <?=$mois->nom?>
    <div class="pull-right"></div>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="facture_table" class="table datatable hover compact" >
            <tr>
                <th title="Elève">Elève</th>
                <td><?=$mois->factures[0]->inscription->elef->prenom." ".$mois->factures[0]->inscription->elef->nom?></td>
            </tr>
            <tr>
                <th title="Promotion">Promotion</th>
                <td><?=$mois->factures[0]->inscription->promotion->nom?></td>
            </tr>
            <tr>
                <th title="Montant">Montant</th>
                <td><?=$mois->montant?> FCFA</td>
            </tr>
            <tr>
                <th title="Payé">Payé</th>
                <td><?=$mois->paye?> FCFA</td>
            </tr>
            <tr>
                <th title="Restant">Restant</th>
                <td><?=$mois->restant?> FCFA</td>
            </tr>
        </table>
    </div>
    <?php if(sizeof($mois->reglements)>0):?>
    <div class="col-xs-12">
        <div class="soustitre">Listes des réglements</div>
        <table id="facture_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Montant">Montant</th>
                    <th title="Moyen">Moyen de paiement</th>
                    <th title="User">Enregistré par</th>
                    <th class="actions" >   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php foreach($mois->reglements as $reglement): ?>
                <tr>
                    <td><?=$reglement->date?></td>
                    <td><?=$reglement->montant?> FCFA</td>
                    <td><?=$reglement->moyen?></td>
                    <td><?=$reglement->user->employes[0]->prenom." ".$reglement->user->employes[0]->nom?></td>
                    <td class="actions">
                        
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php endif;?>
</section>