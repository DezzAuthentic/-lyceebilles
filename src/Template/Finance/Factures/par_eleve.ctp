<div class="titre">
    Facturation
    <div class="pull-right"><?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?></div>
</div>

<section class="row">

    <?php foreach($types as $type):?>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="text-center panel-heading"><span class="soustitre2"><?=$type->nom?></span></div>
                <table id="factures_table" class="table datatable hover compact" >
                    <thead>
                        <tr>
                            <?php if($type->recurrence):?>
                                <th title="Mois">Mois</th>
                            <?php else:?>
                                <th title="Libellé">Libellé</th>
                            <?php endif;?>
                            <th title="Montant">Montant</th>
                            <th title="Payé">Payé</th>
                            <th title="Restant">Restant</th>
                            <th class="actions" >   
                            </th>
                        </tr>
                    </thead>
                    <tbody>            
                    <?php $i=0; foreach($type->factures as $facture): ?>
                        <tr>
                            <?php if($type->recurrence): $mois = $facture->mois->nom;?>
                                <td><?=$facture->mois->nom?></td>
                            <?php else: $mois = "";?>
                                <td><?=$type->nom?></td>
                            <?php endif;?>
                            <td><?=$facture->montant?></td>
                            <td><?=$facture->paye?></td>
                            <td><?=$facture->restant?></td>
                            <td class="actions">
                                <span class="icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                                data-target="#factureModal" >
                                    <input type="hidden" value="<?=$facture->id.'*'.$type->nom.'*'.$mois.'*'.$facture->restant?>">
                                </span>
                                <a class="icone glyphicon glyphicon-chevron-right hover" href="/administration/factures/details/<?=$facture->id?>" >
                                </a>
                            </td>
                        </tr>
                    <?php $i++; endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
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
</script>
<?php $this->end(); ?>