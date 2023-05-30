<?php
use Cake\I18n\Time;

$auj = Time::now();

$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}
?>

<div class="titre">
    <span>Fiche de la séance </span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Détails de la séance
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Matiere">Matière</th>
                        <th title="Professeur">Professeur</th>
                        <th title="Début">Début</th>
                        <th title="Durée">Durée</th>
                    </tr>
                </thead>
                <tbody>            
                    <tr>
                        <td><?= $seance->date?></td>
                        <td><?= $seance->cour->matiere->nom?></td>
                        <td>Pr. <?= $seance->cour->professeur->prenom?> <?= $seance->cour->professeur->nom?></td>
                        <?php 
                            $hr_debut = (int) $seance->debut;
                            $mn_debut = ($seance->debut - $hr_debut) > 0 ?'30MN':'';
                            $hr_duree = (int) $seance->duree;
                            $mn_duree = ($seance->duree - $hr_duree) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr_debut.'H '.$mn_debut?></td>
                        <td><?=$hr_duree.'H '.$mn_duree?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Contenu de la séance
            </div>
            <div class="panel-body">
                <?php if($seance->contenu) echo $seance->contenu;
                else echo '<div class="text-center soustitre">Pas de contenu</div>'; 
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if($seance->pj):?>
                    <a class="btn btn-sm btn-default" href="<?=$this->Url->Build($seance->pj)?>" target='_blank'> Voir le document</a>
                <?php else:?>
                Document
                <?php endif;?>
            </div>
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
            "paging": false,
            "ordering": false,
            "searching": false,
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