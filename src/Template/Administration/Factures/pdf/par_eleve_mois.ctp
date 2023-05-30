<div class="titre">
    Facturation
    <div class="pull-right"><?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?></div>
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
                        <td class="actions">
                            <span class="icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                            data-target="#factureModal" >
                                <input type="hidden" value="<?=$facture->id.'*'.$facture->type->nom.'* *'.$facture->restant?>">
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
                                <td class="actions">
                                    <span class="icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                                    data-target="#factureModal" >
                                        <input type="hidden" value="<?=$facture->id.'*'.$facture->type->nom.'*'.$moi->nom.'*'.$facture->restant?>">
                                    </span>
                                    <a class="icone glyphicon glyphicon-chevron-right hover" href="/administration/factures/details/<?=$facture->id?>" >
                                    </a>
                                </td>
                            </tr>
                        <?php $i++; endforeach;?>
                            <tr >
                                <th></th>
                                <th class="text-primary"><?=$total_montant?></th>
                                <th class="text-primary"><?=$total_paye?></th>
                                <th class="text-primary"><?=$total_restant?></th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>

</section>


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
</script>
<?php $this->end(); ?>