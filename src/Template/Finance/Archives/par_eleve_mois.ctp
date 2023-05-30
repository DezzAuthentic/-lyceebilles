<div class="titre">
    <span class="text-primary">Archives <?=$inscription->promotion->annee->nom?></span> 
    Facturation - 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>
    <span class="btn btn-default btn-sm pull-right margin-g-5" data-toggle="modal" data-target="#printModal" >
        <span class="glyphicon glyphicon-print"></span> Imprimer
    </span>
</div>

<div id="print">
    <section class="row">
        <?php if($total_parrain>0):?>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Montant total réglé par le parrain: <b><?= $total_parrain?> Fcfa</b></div>
                </div>
            </div>
        <?php endif;?>
        <?php if(sizeof($factures)>0):?>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <!--div class="text-center panel-heading"><span class="soustitre2">Inscription</span></div-->
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
                    <?php 
                    $total_montant=0;
                    $total_paye=0;
                    $total_restant=0;
                    foreach($factures as $facture):
                        $total_montant += $facture->montant; 
                        $total_paye += $facture->paye; 
                        $total_restant += $facture->restant;   
                    ?>
                        <tr>
                            <td><?=$facture->frai->nom?></td>
                            <td><?=$facture->montant?></td>
                            <td><?=$facture->paye?></td>
                            <td><?=$facture->restant?></td>
                            <td class="actions text-left">
                                <?=$this->Html->link('<i class="glyphicon glyphicon-chevron-right icone"></i>',['action'=>'details',$facture->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                        <tr >
                            <th></th>
                            <th class="text-primary"><?=$total_montant?></th>
                            <th class="text-primary"><?=$total_paye?></th>
                            <th class="text-primary"><?=$total_restant?></th>
                            <td class="actions text-left">
                                <?=$this->Html->link('<i class="glyphicon glyphicon-chevron-right icone"></i>',['action'=>'detailsMois',$inscription->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif;?>

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
                                    <td><?=$facture->frai->nom?></td>
                                    <td><?=$facture->montant?></td>
                                    <td><?=$facture->paye?></td>
                                    <td><?=$facture->restant?></td>
                                    <td class="actions text-left">
                                        <?=$this->Html->link('<i class="glyphicon glyphicon-chevron-right icone"></i>',['action'=>'details',$facture->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                                    </td>
                                </tr>
                            <?php $i++; endforeach;?>
                                <tr >
                                    <th></th>
                                    <th class="text-primary"><?=$total_montant?></th>
                                    <th class="text-primary"><?=$total_paye?></th>
                                    <th class="text-primary"><?=$total_restant?></th>
                                    <td class="actions text-left">
                                        <?=$this->Html->link('<i class="glyphicon glyphicon-chevron-right icone"></i>',['action'=>'detailsMois',$inscription->id,$moi->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>

    </section>
</div>

<!-- Modal print -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Factures', 'action' => 'imprimer',$inscription->id]) ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ajoutFactureModalLabel">Impression de la facturation</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for='debut' class="col-sm-4 col-form-label">Premier mois</label>
                        <div class="col-sm-8">
                            <select name="debut" class="form-control select2" id="debut" required>
                                <option>Choisissez un mois</option>
                                <option value="0">Inscription</option>
                                <?php foreach($mois as $moi):?>
                                    <option value="<?=$moi->ordre?>"><?=$moi->nom?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='debut' class="col-sm-4 col-form-label">Dernier mois</label>
                        <div class="col-sm-8">
                            <select name="fin" class="form-control select2" id="fin" required>
                                <option>Choisissez un mois</option>
                                <option value="0">Inscription</option>
                                <?php foreach($mois as $moi):?>
                                    <option value="<?=$moi->ordre?>"><?=$moi->nom?></option>
                                <?php endforeach;?>
                            </select>
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
    
    $("#printer").click(function() {
        printJS({ 
            printable: 'print', 
            type: 'html', 
            header: 'Etat facturation',
            showModal:true,
            css:'/css/bootstrap/bootstrap.min.css',
            ignoreElements:['']
        });
    });
</script>
<?php $this->end(); ?>