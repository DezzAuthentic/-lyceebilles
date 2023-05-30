<div class="titre">
    <span>Liste des classes</span>
    <!--a id="ajout_btn" href="/finance/inscriptions/nouvelle" class="btn btn-default btn-sm pull-right" >
        <span class="glyphicon glyphicon-pencil"></span> inscrire un élève
    </a-->
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="classes_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Effectif</th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($groupes as $groupe): ?>
                <tr onclick="document.location = '/academie/groupes/gestion/<?=$groupe->id?>';">
                    <td><?=$groupe->nom?></td>
                    <td><?=sizeof($groupe->affectations)?> élève(s)</td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
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
            "searching": true,
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