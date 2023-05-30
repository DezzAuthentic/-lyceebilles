
<div class="titre">
    <span>Suivi des séances de <?=$matiere->nom?></span>
</div>

<div class="row">
    <br>
    <div class="col-xs-12">
        <table id="seances_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Classe">Classe</th>
                    <th title="Professeur">Professeur</th>
                    <th title="retards">Retards</th>
                    <th title="absences">Absences</th>
                    <th title="renvois">Renvois</th>
                    <th title="Durée">Statut</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($seances as $seance): ?>
                <tr>
                    <td><?=$seance->date?></td>
                    <td><?=$seance->cour->groupe->nom?></td>
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
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Seances','action'=>"fiche",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
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
            "paging": true,
            "ordering": false,
            "searching": true,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page",
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