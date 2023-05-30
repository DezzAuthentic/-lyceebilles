<div class="titre">
    <span>Liste des cours <?php if($groupe) echo "de la classe ".$groupe->nom;?></span>
</div>

<div class="row">
    <table id="cours_table" class="table datatable hover compact" >
        <thead>
            <tr>
                <th title="Matiere">Matière</th>
                <?php if(!$groupe) echo '<th title="Classe">Classe</th>';?>
                <th title="heures par semaine">Heures par semaine</th>
                <th class="actions" style="min-width:170px;">   
                </th>
            </tr>
        </thead>
        <tbody>            
        <?php $i=0; foreach($cours as $cour): ?>
            <tr>
                <td><?=$cour->matiere->nom?></td>
                <?php if(!$groupe) echo '<td>'.$cour->groupe->nom.'</td>';?>
                <?php
                $heures=0;
                foreach($cour->edt as $seance){
                    $heures += $seance->duree;
                }
                $hr = (int) $heures;
                $mn = ($heures - $hr) > 0 ?'30MN':'';
                ?>
                <td><?=$hr.'H '.$mn?></td>
                <td class="actions">
                    <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['controller'=>'Cours','action' => 'fiche', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                    <?=$this->Html->link('Cahier de texte',['controller'=>'Cours','action' => 'cahierDeTexte', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                    <?=$this->Form->postLink('<i class="glyphicon glyphicon-trash icone"></i>', ['controller'=>'Cours','action' => 'supprimer', $cour->id], ['escape'=>false,'confirm' => __('Voulez-vous supprimer cette matiere # {0}?', $cour->id),'class'=>"btn btn-xs btn-default"]); ?>
                </td>
            </tr>
        <?php $i++; endforeach;?>
        </tbody>
    </table>

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
        table = $('.datatable').DataTable({
            "info": false,  
            "paging": false,
            "ordering": true,
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
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
            },
            /*"columnDefs": [ {
                "targets": 3,
                "orderable": false
                }
            ]*/
        });
        table.buttons().container().appendTo( '#cours_table_wrapper .col-sm-6:eq(0)' );      
    });
    
</script>
<?php $this->end(); ?>