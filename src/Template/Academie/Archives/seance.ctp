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
    <span class="text-primary">Archives <?=$seance->cour->groupe->promotion->annee->nom?></span> 
    <span>Fiche de la séance </span> <small>(Etat: <?= $seance->etat ?>)</small>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Détails de la séance
                <?php if($seance->etat=='brouillon'):?>
                    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-xs" data-toggle="modal" data-target="#detailsSeanceModal">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                <?php endif; ?>
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
                Pas de document
                <?php endif;?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des élèves
                </div>
                <table id="affectations_table" class="table datatable hover compact" >
                    <thead>
                        <tr>
                            <th title="Matricule">Matricule</th>
                            <th title="Nom">Nom</th>
                            <th title="Prénom">Prénom</th>
                            <th title="Date de naissance">Date de naissance</th>
                            <th title="Presence">Présence</th>
                        </tr>
                    </thead>
                    <tbody>            
                    <?php $i=0; foreach($seance->cour->groupe->affectations as $affectation): ?>
                        <tr>
                            <td><?=$affectation->inscription->elef->matricule?></td>
                            <td><?=$affectation->inscription->elef->nom?></td>
                            <td><?=$affectation->inscription->elef->prenom?></td>
                            <td><?=$affectation->inscription->elef->date_naissance?></td>
                            <td>
                                <?php 
                                    $presence = null;
                                    foreach($seance->presences as $pres){
                                        if($pres->eleve_id == $affectation->inscription->elef->id){
                                            $presence = $pres->type;
                                            break;
                                        }
                                    }
                                    if($presence == 'retard') echo "en retard";
                                    elseif($presence == 'absence') echo "absent(e)";
                                    elseif($presence == 'renvoi') echo "renvoyé(e)";
                                    else echo "présent(e)";
                                ?>
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
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js",
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
        
        CKEDITOR.replace( 'contenu' );

    });
    
    
</script>
<?php $this->end(); ?>