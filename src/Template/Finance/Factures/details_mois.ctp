
<div class="titre">
    Détails des réglements <?php if(isset($mois->nom)):?>de <?=$mois->nom?> <?php endif;?>
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
                    <th title="Date">Date de paiement</th>

                    <th title="Date"></th>

                    <th title="Montant">Montant</th>
                    <th title="Type">Type</th>
                    <th title="Moyen">Moyen de paiement</th>
                    <th title="User">Enregistré par</th>
                    <th class="actions" >
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($mois->reglements as $reglement):
                if($reglement->montant == 0) continue;
                // dd($reglement);
            ?>
                <?php if(isset($reglement->facture->mois_id) && $reglement->facture->mois_id == null): ?>
                <tr>
                    <td><?=$reglement->date?></td>
                <?php if($reglement->facture): ?>
                    <td><?=$reglement->facture->frai->nom?></td>
                <?php elseif(!$reglement->facture): ?>
                    <td></td>
                <?php endif; ?>
                    <td><?=$reglement->montant?> FCFA</td>
                    <td><?php if($reglement->parrainage) echo 'Parrain'; else echo 'Tuteur';?></td>
                    <td><?=$reglement->moyen?></td>
                    <td><?=$reglement->user->employes[0]->prenom." ".$reglement->user->employes[0]->nom?></td>
                    <td class="actions">
                        <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>', ['controller'=>'Reglements','action' => 'supprimer', $reglement->id], ['confirm' => __('Voulez-vous supprimer ce réglement # {0}?', $reglement->id),'class'=>"btn btn-xs btn-default",'escape'=>false]); ?>
                    </td>
                </tr>
                <?php elseif(!isset($reglement->facture->mois_id)): ?>
                    <tr>
                    <td><?=$reglement->date?></td>
                <?php if($reglement->facture): ?>
                    <td><?=$reglement->facture->frai->nom?></td>
                <?php elseif(!$reglement->facture): ?>
                    <td></td>
                <?php endif; ?>
                    <td><?=$reglement->montant?> FCFA</td>
                    <td><?php if($reglement->parrainage) echo 'Parrain'; else echo 'Tuteur';?></td>
                    <td><?=$reglement->moyen?></td>
                    <td><?=$reglement->user->employes[0]->prenom." ".$reglement->user->employes[0]->nom?></td>
                    <td class="actions">
                        <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>', ['controller'=>'Reglements','action' => 'supprimer', $reglement->id], ['confirm' => __('Voulez-vous supprimer ce réglement # {0}?', $reglement->id),'class'=>"btn btn-xs btn-default",'escape'=>false]); ?>
                    </td>
                </tr>
            <?php endif; endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
        <span class="text-danger padding col-xs-12 text-center h3">Pas de réglement</span>
    <?php endif;?>
</section>
