<div class="titre">
    <span>Liste des tuteurs</span>
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="tuteurs_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Prénom">Eleves</th>
                    <th title="Prénom">Inscrits</th>
                    <th class="actions" style="">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($tuteurs as $tuteur): ?>
                <tr>
                    <td><?=$tuteur->nom?></td>
                    <td><?=$tuteur->prenom?></td>
                    
                    <?php 
                	$nb_el=0; 
                	$nb_ins=0; 
                	foreach($tuteur->eleves as $eleve){
                		$nb_el++;
                		if($eleve->inscriptions) $nb_ins++;
                	}
                    ?>
                    <td><?=$nb_el?> élève(s) 
                        <?php /*foreach($tuteur->eleves as $eleve):?>
                        <span class="btn btn-xs btn-default"><?=$eleve->prenom." ".$eleve->nom?></span>
                        <?php endforeach;*/?>
                    </td>
                    <td><?php if($nb_ins>0) echo $nb_ins.' inscrit(s) en cours';?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="icone glyphicon glyphicon-eye-open"></i>', ['action' => 'fiche', $tuteur->id], ['escape'=> false,'class'=>"btn btn-xs btn-default"]) ?>
                        <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>', ['action' => 'desactiver', $tuteur->id], ['escape'=> false,'confirm' => __('Voulez-vous supprimer le tuteur {0} {1}?',$tuteur->prenom,$tuteur->nom),'class'=>"btn btn-xs btn-default"]) ?>
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
    $(function () {
        var table = $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": true,
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
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
            },
            "columnDefs": [ {
                "targets": 3,
                "orderable": false
                },
            ]
        });
        table.buttons().container().appendTo( '#tuteurs_table_wrapper .col-sm-6:eq(0)' );

    });
    
</script>
<?php $this->end(); ?>