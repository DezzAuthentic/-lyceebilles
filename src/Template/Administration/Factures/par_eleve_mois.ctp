<div class="titre">
    Facturation - 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>
    <span class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#ajoutFactureModal" >
        <span class="glyphicon glyphicon-credit-card"></span> Ajouter une facture
    </span>
</div>

<section class="row">

    <div class="col-xs-12">
        <div class="panel panel-default">
            <table id="factures_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Mois">Libellé</th>
                        <th title="Montant">Montant</th>
                        <th title="Payé">Payé</th>
                        <th title="Restant">Restant</th>
                        <th class="actions" >   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($factures as $facture): ?>
                    <tr>
                        <td><?=$facture->type->nom?></td>
                        <td><?=$facture->montant?></td>
                        <td><?=$facture->paye?></td>
                        <td><?=$facture->restant?></td>
                        <td class="actions text-left">
                            <a class="icone glyphicon glyphicon-chevron-right hover" href="/administration/factures/details/<?=$facture->id?>" >
                            </a>
                            <span class="<?php if($facture->restant<=0) echo 'hidden';?> icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                            data-target="#factureModal" >
                                <input type="hidden" value="<?=$facture->id.'*'.$facture->type->nom.'* *'.$facture->restant?>">
                            </span>
                            <?php if($facture->paye==0) echo $this->Form->postLink('Suppr.', ['action' => 'supprimer', $facture->id], ['confirm' => __('Voulez-vous supprimer cette facture # {0}?', $facture->id),'class'=>"btn btn-xs btn-danger"]); ?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>


    <?php foreach($mois as $moi):
        $total_montant=0;
        $total_paye=0;
        $total_restant=0;
    ?>
        <?php if(sizeof($moi->factures) > 0):?>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="text-center panel-heading"><span class="soustitre2"><?=$moi->nom?></span></div>
                    <table id="factures_table" class="table datatable hover compact" >
                        <thead>
                            <tr>
                                <th title="Mois">Libellé</th>
                                <th title="Montant">Montant</th>
                                <th title="Payé">Payé</th>
                                <th title="Restant">Restant</th>
                                <th class="actions" >   
                                </th>
                            </tr>
                        </thead>
                        <tbody>            
                        <?php $i=0; foreach($moi->factures as $facture): 
                            $total_montant += $facture->montant; 
                            $total_paye += $facture->paye; 
                            $total_restant += $facture->restant;     
                        ?>
                            <tr>
                                <td><?=$facture->type->nom?></td>
                                <td><?=$facture->montant?></td>
                                <td><?=$facture->paye?></td>
                                <td><?=$facture->restant?></td>
                                <td class="actions text-left">
                                    <a class="icone glyphicon glyphicon-chevron-right hover" href="/administration/factures/details/<?=$facture->id?>" >
                                    </a>
                                    <span class="<?php if($facture->restant<=0) echo 'hidden';?> icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                                    data-target="#factureModal" >
                                        <input type="hidden" value="<?=$facture->id.'*'.$facture->type->nom.'*'.$moi->nom.'*'.$facture->restant?>">
                                    </span>
                                    <?php if($facture->paye==0) echo $this->Form->postLink('Suppr.', ['action' => 'supprimer', $facture->id], ['confirm' => __('Voulez-vous supprimer cette facture # {0}?', $facture->id),'class'=>"btn btn-xs btn-danger"]); ?>
                                </td>
                            </tr>
                        <?php $i++; endforeach;?>
                            <tr >
                                <th></th>
                                <th class="text-primary"><?=$total_montant?></th>
                                <th class="text-primary"><?=$total_paye?></th>
                                <th class="text-primary"><?=$total_restant?></th>
                                <td class="actions text-left">
                                    <a class="icone glyphicon glyphicon-chevron-right hover" href="/administration/factures/detailsMois/<?=$inscription->id?>/<?=$moi->id?>" >
                                    </a>
                                    <span class="<?php if($total_restant<=0) echo 'hidden';?> icone glyphicon glyphicon-credit-card reglementFacturesMois hover" data-toggle="modal"
                                    data-target="#facturesMoisModal" >
                                        <input type="hidden" value="<?=$inscription->id.'*'.$moi->id.'*'.$moi->nom.'*'.$total_restant?>">
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>

</section>

<!-- Modal reglement de facture eleve-->
<div class="modal fade" id="factureModal" tabindex="-1" role="dialog" aria-labelledby="factureModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Reglements', 'action' => 'add']) ?>" method="post">
            <input type="hidden" name="facture_id" id="factureId" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="factureModalLabel">Réglement : <span id="facture_label"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Montant à payer</label>
                    <div class="col-sm-8">
                        <div id="factureAPayer"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMontant" class="col-sm-4 col-form-label">Montant</label>
                    <div class="col-sm-8">
                        <input type="number" name="montant" id="factureMontant" min="0" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMoyen" class="col-sm-4 col-form-label">Moyen de paiement</label> 
                    <div class="col-sm-8">
                        <?=$this->Form->select("moyen", ['Especes'=>'Especes','Chèque'=>"Chèque",'Virement'=>"Virement","Transfert d'argent"=>"Transfert d'argent"], ['empty' => true,'class'=>'form-control','id'=>'factureMoyen','required']);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal reglement de factures Mois eleve-->
<div class="modal fade" id="facturesMoisModal" tabindex="-1" role="dialog" aria-labelledby="facturesMoisModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Reglements', 'action' => 'mois']) ?>" method="post">
            <input type="hidden" name="inscription_id" id="inscriptionId" >
            <input type="hidden" name="mois_id" id="moisId" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="facturesMoisModalLabel">Réglement : <span id="factures_label"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Montant à payer</label>
                    <div class="col-sm-8">
                        <div id="facturesAPayer"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMontant" class="col-sm-4 col-form-label">Montant</label>
                    <div class="col-sm-8">
                        <input type="number" name="montant" id="facturesMontant" min="0" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMoyen" class="col-sm-4 col-form-label">Moyen de paiement</label> 
                    <div class="col-sm-8">
                        <?=$this->Form->select("moyen", ['Especes'=>'Especes','Chèque'=>"Chèque",'Virement'=>"Virement","Transfert d'argent"=>"Transfert d'argent"], ['empty' => true,'class'=>'form-control','id'=>'facturesMoyen','required']);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal facturation libre-->
<div class="modal fade" id="ajoutFactureModal" tabindex="-1" role="dialog" aria-labelledby="ajoutFactureModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Factures', 'action' => 'libre']) ?>" method="post">
            <input type="hidden" name="inscription_id" id="ajoutInscriptionId" value="<?=$inscription->id?>">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ajoutFactureModalLabel">Ajout d'une facture</h4>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                    <label for='ajoutType' class="col-sm-4 col-form-label">Type de facture</label>
                    <div class="col-sm-8">
                        <?=$this->Form->select("type_id", $types_list, ['empty' => true,'class'=>'form-control','id'=>'ajoutType','required']);?>
                    </div>
                </div>
                <div for='ajoutMois' class="form-group row">
                    <label class="col-sm-4 col-form-label">Mois</label>
                    <div class="col-sm-8">
                        <?=$this->Form->select("mois_id", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'moisId']);?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ajoutMontant" class="col-sm-4 col-form-label">Montant</label>
                    <div class="col-sm-8">
                        <input type="number" name="montant" id="ajoutMontant" min="0" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </form>
    </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page",
                "zeroRecords": "Pas d'enregistrement trouvé",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Pas d'enregistrement disponible",
                "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
                "search":         "Recherche",
                "scrollX": true,
                "paginate": {
                    "first":      "<<",
                    "last":       ">>",
                    "next":       ">",
                    "previous":   "<"
                }
            }/*,
            "columnDefs": [ {
                "targets": 4,
                "orderable": false
                },{
                "targets": 5,
                "orderable": false
                }
            ]*/
        });
    });
    $(".reglementFacture").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".reglementFacture input").val());
        $("#factureId").val(data[0]);
        $("#facture_label").html(data[1]+" "+data[2]);
        $("#factureAPayer").html(data[3]);
        $("#factureMontant").attr('max',data[3]);
    });
    $(".reglementFacturesMois").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".reglementFacturesMois input").val());
        $("#inscriptionId").val(data[0]);
        $("#moisId").val(data[1]);
        $("#factures_label").html("Factures "+data[2]);
        $("#facturesAPayer").html(data[3]);
        $("#facturesMontant").attr('max',data[3]);
    });
</script>
<?php $this->end(); ?>