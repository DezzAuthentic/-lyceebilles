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
    <span>Fiche de la séance </span> <small>(Etat: <?= $seance->etat ?>)</small>
    
    <?php if($seance->etat=='brouillon'):?>
        <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#validerSeanceModal">
            <span class="glyphicon glyphicon-calendar"></span> Valider la séance
        </a>
        <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#supprSeanceModal">
            <span class="glyphicon glyphicon-trash"></span> Supprimer la séance
        </a>
    <?php else: ?>
        <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#retSeanceModal">
            <span class="glyphicon glyphicon-calendar"></span> Retourner en brouillon
        </a>
    <?php endif; ?>
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
                <?php if($seance->etat=='brouillon'):?>
                    <span class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#editContenuModal"><span class="glyphicon glyphicon-pencil"></span></span>
                <?php endif; ?>
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
                <button type="button" class="btn btn-default btn-xs icone pull-right" data-toggle="modal" data-target="#pjModal">
                    <span class="glyphicon glyphicon-pencil icone"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'editerPresences',$seance->id]) ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des élèves
                    <?php if($seance->etat=='brouillon'):?>
                        <button type="submit" class="btn btn-xs btn-default pull-right"><span class="glyphicon glyphicon-ok"></span></button>
                    <?php endif; ?>
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
                                if($seance->etat=='brouillon'):
                            ?>
                                <input type="hidden" name="presences[<?=$i?>][eleve_id]" value="<?=$affectation->inscription->elef->id?>">

                                <label class="radio-inline">
                                <input type="radio" name="presences[<?=$i?>][type]" value="presence" <?php if($presence==null) echo "checked"?>> P
                                </label>
                                <label class="radio-inline">
                                <input type="radio" name="presences[<?=$i?>][type]" value="retard" <?php if($presence == "retard") echo "checked"?>> R
                                </label>
                                <label class="radio-inline">
                                <input type="radio" name="presences[<?=$i?>][type]" value="absence" <?php if($presence == "absence") echo "checked"?>> A
                                </label>
                            <?php else: ?>
                                <?php
                                if($presence == 'retard') echo "en retard";
                                elseif($presence == 'absence') echo "absent(e)";
                                elseif($presence == 'renvoi') echo "renvoyé(e)";
                                else echo "présent(e)";
                                ?>
                            <?php endif; ?>
                            </td>
                        </tr>
                    <?php $i++; endforeach;?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Modal contenu séance-->
<div class="modal fade" id="editContenuModal" tabindex="-1" role="dialog" aria-labelledby="editContenuModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'editerContenu',$seance->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editContenuModalLabel">Editer le contenu de la séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    <textarea name="contenu" class="form-control" rows='10'><?=$seance->contenu?></textarea>
                </div>
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" >Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal suppr séance-->
<div class="modal fade" id="supprSeanceModal" tabindex="-1" role="dialog" aria-labelledby="supprSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'supprimer',$seance->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprSeanceModalLabel">Suppression de la séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    Voulez-vous vraiment supprimer la séance?
                </div>
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary" >Oui</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal valider séance-->
<div class="modal fade" id="validerSeanceModal" tabindex="-1" role="dialog" aria-labelledby="validerSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'valider',$seance->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="validerSeanceModalLabel">Validation de la séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    Voulez-vous valider la séance?
                </div>
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary" >Oui</button>
        </div>
        </div>
    </form>
  </div>
</div>
<!-- Modal retourner en brouillon -->
<div class="modal fade" id="retSeanceModal" tabindex="-1" role="dialog" aria-labelledby="retSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'retournerEnBrouillon',$seance->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="retSeanceModalLabel">Retour en brouillon</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    Souhaitez-vous retourner l'état de la séance en brouillon?
                </div>
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary" >Oui</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal détails séance-->
<div class="modal fade" id="detailsSeanceModal" tabindex="-1" role="dialog" aria-labelledby="detailsSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'modifierDetails',$seance->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="detailsSeanceModalLabel">Modification des détails de la séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="date" class="col-sm-4">Date</label>
                <div class="col-sm-8">
                    <input name="date" type="date" class="form-control" style="line-height:inherit;" value="<?=$seance->date->format('Y-m-d')?>" required>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Début</label>
                <div class="col-sm-8">
                    <select name="debut" class="form-control" required value="<?= $seance->debut?>">
                        <?php foreach($heures as $heure):?>
                            <option value="<?=$heure?>" <?php if($seance->debut==$heure) echo 'selected';?>>
                            <?php
                                $hr= (int)($heure);
                                $reste = $heure-$hr;
                                echo $hr."H ";
                                if($reste>0) echo "30MN";
                            ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Durée</label>
                <div class="col-sm-8">
                    <select name="duree" class="form-control" required value="<?= $seance->duree?>">
                            <option value="1" <?php if($seance->duree==1) echo 'selected';?>> 1H </option>
                            <option value="1.5" <?php if($seance->duree==1.5) echo 'selected';?>> 1H 30MN </option>
                            <option value="2" <?php if($seance->duree==2) echo 'selected';?>> 2H </option>
                            <option value="2.5" <?php if($seance->duree==2.5) echo 'selected';?>> 2H 30MN </option>
                            <option value="3"> <?php if($seance->duree==3) echo 'selected';?> 3H </option>
                    </select>
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal pj-->
<div class="modal fade" id="pjModal" tabindex="-1" role="dialog" aria-labelledby="pjModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'editer_pj']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$seance->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="pjModalLabel">Chargement du document</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="eleves_acces_check" class="col-sm-2 col-xs-12">Document</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="file" name="pj" id="pj">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
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
        
        CKEDITOR.replace( 'contenu' );

    });
    
    
</script>
<?php $this->end(); ?>