<div class="titre">
    <span>Suivi des séances <?php if($groupe) echo "de la classe ".$groupe->nom;?></span>
</div>

<div class="row">
    <br>
    <div class="col-xs-12">
        <table id="seances_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <?php if(!$groupe) echo '<th title="Classe">Classe</th>';?>
                    <th title="Matière">Matière</th>
                    <th title="Professeur">Professeur</th>
                    <th title="Retards">Retards</th>
                    <th title="Absences">Absences</th>
                    <th title="Renvois">Renvois</th>
                    <th title="Durée">Statut</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($seances as $seance): ?>
                <tr>
                    <td><?=$seance->date->format('Y-m-d')?></td>
                    <?php if(!$groupe) echo '<td>'.$seance->cour->groupe->nom.'</td>';?>
                    <td><?=$seance->cour->matiere->nom?></td>
                    <td>Pr. <?=$seance->cour->professeur->prenom?> <?=$seance->cour->professeur->nom?></td>
                    <?php
                    $retards=0;
                    $absences=0;
                    $renvois=0;
                    foreach($seance->presences as $presence){
                        if($presence->type=='retard') $retards++;
                        elseif($presence->type=='absence') $absences++;
                        elseif($presence->type=='renvois') $renvois++;
                    }
                    ?>
                    <td><?=$retards?></td>
                    <td><?=$absences?></td>
                    <td><?=$renvois?></td>
                    <td><?=$seance->etat?></td>
                    <td class="actions">
                        <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['controller'=>'Seances','action'=>"fiche",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
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
        table = $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": true,
            "order": [[ 0, "desc" ]],
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "&nbsp; Afficher _MENU_ par page &nbsp;",
                "zeroRecords": "Pas de séances trouvées!",
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
            }
        });
        table.buttons().container().appendTo( '#seances_table_wrapper .col-sm-6:eq(0)' );      
    });
    
</script>
<?php $this->end(); ?>