<div class="titre">
    Discipline
</div>

<div class="row">
    <?php foreach($affectations as $affectation):?>
    <div class="col-xs-12">
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <?=$affectation->prenom." ".$affectation->nom?>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=sizeof($affectation->retards)?> retard(s)</div>
                </div>
            </div>
        <div class="col-md-2 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=sizeof($affectation->absences)?> absence(s)
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=sizeof($affectation->renvois)?> renvoi(s)
                </div>
            </div>
        </div>
    </div>  
    <?php endforeach;?>

    <div class="col-xs-12">
    <div class="panel panel-default">
            <div class="panel-heading">
                Liste
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Elève">Elève</th>
                        <th title="Type">Type</th>
                        <th title="Cours">Cours</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach($presences as $presence):?>
                        <tr>
                            <td><?= $presence->seance->date?></td>
                            <td><?= $presence->elef->prenom?> <?= $presence->elef->nom?></td>
                            <td><?= $presence->type?></td>
                            <td><?= $presence->seance->cour->matiere->nom?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
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
            "paging": true,
            "ordering": false,
            "searching": true,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "&nbsp; Afficher _MENU_ par page",
                "zeroRecords": "Pas d'enregistrement trouvé!",
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