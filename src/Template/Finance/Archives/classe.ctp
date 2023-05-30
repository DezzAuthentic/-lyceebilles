<div class="titre">
    <span class="text-primary">Archives <?=$groupe->promotion->annee->nom?></span> 
    <span>Facturation de la classe <?=$groupe->nom?></span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Liste des élèves <span id="export" class="pull-right"></span></div>
            <table id="affectations_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Matricule">Matricule</th>
                        <th style="width:200px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->affectations as $affectation): ?>
                    <tr>
                        <td><?=$affectation->inscription->elef->nom?></td>
                        <td><?=$affectation->inscription->elef->prenom?></td>
                        <td><?=$affectation->inscription->elef->matricule?></td>
                        <td class="">
                            <?=$this->Html->link('Facturation',['action'=>"parEleveMois",$affectation->inscription->id],['class' => 'btn btn-xs btn-default'])?>
                            <?=$this->Html->link('voir la fiche',['controller'=>'Eleves','action'=>"fiche",$affectation->inscription->elef->id],['class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
    "https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    table = $('#affectations_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": true,
        "searching": false,
        "buttons": [
            'copy', 'excel'
        ],
        "language": {
            "lengthMenu": "Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
            "search": "Recherche",
            "scrollX": true,
            "paginate": {
                "first":      "<<",
                "last":       ">>",
                "next":       ">",
                "previous":   "<"
            }
        },
        "columnDefs": [ {
            "targets": 3,
            "orderable": false
            }
        ]
    });
    table.buttons().container().appendTo( '#export' );
    $("#export").css('margin-top','-7px')
});
</script>
<?php $this->end(); ?>