<div class="titre">
    <span class="text-primary">Archives <?=$annee->nom?> </span>Liste des promotions
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="inscriptions_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Effectif</th>
                    <th title="Promotion">Nombre de classes</th>
                    <th title=""></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($promotions as $promotion): ?>
                <tr >
                    <td><?=$promotion->nom?></td>
                    <td><?=sizeof($promotion->inscriptions)?> élève(s)</td>
                    <td><?=sizeof($promotion->groupes)?></td>
                    <td>
                        <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['action'=>'promotion',$promotion->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                    </td>
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