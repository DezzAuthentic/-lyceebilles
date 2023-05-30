<?php
use Cake\I18n\Time;

$auj = Time::now();
?>

<div class="titre">
    <span class="text-primary">Année: <?=$devoir->cour->groupe->promotion->annee->nom?></span> <span>Fiche du devoir </span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Détails du devoir
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Matiere">Matière</th>
                        <th title="Durée">Durée</th>
                    </tr>
                </thead>
                <tbody>            
                    <tr>
                        <td><?= $devoir->date?></td>
                        <td><?= $devoir->cour->matiere->nom?></td>
                        <?php 
                            $hr_duree = (int) $devoir->duree;
                            $mn_duree = ($devoir->duree - $hr_duree) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr_duree.'H '.$mn_duree?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Contenu du devoir
            </div>
            <div class="panel-body">
                <?php if($devoir->description) echo $devoir->description;
                else echo '<div class="text-center soustitre">Pas de contenu</div>'; 
                ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if($devoir->pj):?>
                    <a class="btn btn-sm btn-default" href="<?=$this->Url->Build($devoir->pj)?>" target='_blank'> Voir le document</a>
                <?php else:?>
                Document
                <?php endif;?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'editerNotes',$devoir->id]) ?>" method="post">
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
                            <th title="Note">Note</th>
                        </tr>
                    </thead>
                    <tbody>            
                    <?php $i=0; foreach($devoir->cour->groupe->affectations as $affectation): ?>
                        <tr>
                            <td><?=$affectation->inscription->elef->matricule?></td>
                            <td><?=$affectation->inscription->elef->nom?></td>
                            <td><?=$affectation->inscription->elef->prenom?></td>
                            <td><?=$affectation->inscription->elef->date_naissance?></td>
                            <td>
                            <?php 
                                $note = null;
                                foreach($devoir->devoir_notes as $not){
                                    if($not->eleve_id == $affectation->inscription->elef->id){
                                        $note = $not->note;
                                        $id = $not->id;
                                        break;
                                    }
                                }
                                echo $note;
                            ?>
                            </td>
                            
                        </tr>
                    <?php $i++; endforeach;?>
                    </tbody>
                </table>
            </div>
        </form>
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
        
        CKEDITOR.replace( 'description' );
        
    });
    
</script>
<?php $this->end(); ?>