<div class="titre">
    <span>Liste des inscrits</span>
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="inscriptions_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Promotion">Classe</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($affectations as $affectation): ?>
                <tr>
                    <td><?=$affectation->inscription->elef->nom?></td>
                    <td><?=$affectation->inscription->elef->prenom?></td>
                    <td><?=$affectation->groupe->nom?></td>
                    <td class="actions">
                        <?php foreach($periodes as $periode):?>
                            <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>'.$periode->nom,['action'=>"periode",$periode->id,$affectation->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        <?php endforeach;?>
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