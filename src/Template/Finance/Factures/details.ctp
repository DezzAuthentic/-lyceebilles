
<div class="titre">
    Facture n°<?=$facture->id?>
    <div class="pull-right"></div>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="facture_table" class="table datatable hover compact" >
            <tr>
                <th title="Montant">Elève</th>
                <td><?=$facture->inscription->elef->prenom." ".$facture->inscription->elef->nom?></td>
            </tr>
            <tr>
                <th title="Montant">Promotion</th>
                <td><?=$facture->inscription->promotion->nom?></td>
            </tr>
            <tr>
                <th title="Libellé">Libellé</th>
                <?php if($facture->frai->type->recurrence):?>
                    <td><?=$facture->frai->nom.' '.$facture->mois->nom?></th>
                <?php else:?>
                    <td><?=$facture->frai->nom?></th>
                <?php endif;?>
            </tr>
            <tr>
                <th title="Montant">Montant</th>
                <td><?=$facture->montant?> FCFA</td>
            </tr>
            <tr>
                <th title="Payé">Payé</th>
                <td><?=$facture->paye?> FCFA</td>
            </tr>
            <tr>
                <th title="Restant">Restant</th>
                <td><?=$facture->restant?> FCFA</td>
            </tr>
        </table>
    </div>
    <?php if(sizeof($facture->reglements)>0):?>
    <div class="col-xs-12">
        <div class="soustitre">Listes des réglements</div>
        <table id="facture_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Montant">Montant</th>
                    <th title="Type">Type</th>
                    <th title="Moyen">Moyen de paiement</th>
                    <th title="User">Enregistré par</th>
                    <th class="actions" >   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($facture->reglements as $reglement): ?>
                <tr>
                    <td><?=$reglement->date?></td>
                    <td><?=$reglement->montant?> FCFA</td>
                    <td><?php if($reglement->parrainage) echo 'Parrain'; else echo 'Tuteur';?></td>
                    <td><?=$reglement->moyen?></td>
                    <td><?=$reglement->user->employes[0]->prenom." ".$reglement->user->employes[0]->nom?></td>
                    <td class="actions">
                        <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>', ['controller'=>'Reglements','action' => 'supprimer', $reglement->id], ['confirm' => __('Voulez-vous supprimer ce réglement # {0}?', $reglement->id),'class'=>"btn btn-xs btn-default",'escape'=>false]); ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
        <span class="text-danger padding col-xs-12 text-center h3">Pas de réglement</span>
    <?php endif;?>
</section>