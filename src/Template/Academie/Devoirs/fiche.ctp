<?php
use Cake\I18n\Time;

$auj = Time::now();
?>

<div class="titre">
    <span>Fiche du devoir </span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#supprDevoirModal">
        <span class="glyphicon glyphicon-trash"></span> Supprimer le devoir
    </a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Détails du devoir
                <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-xs" data-toggle="modal" data-target="#detailsDevoirModal">
                    <span class="glyphicon glyphicon-pencil"></span> Editer
                </a>
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
                <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-xs" data-toggle="modal" data-target="#editContenuModal">
                    <span class="glyphicon glyphicon-pencil"></span> Editer
                </a>
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
                <button type="button" class="btn btn-default btn-xs icone pull-right" data-toggle="modal" data-target="#pjModal">
                    <span class="glyphicon glyphicon-pencil icone"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'editerNotes',$devoir->id]) ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des élèves
                    <button type="submit" class="btn btn-xs btn-default pull-right"><span class="glyphicon glyphicon-ok"></span> Valider</button>
                </div>
                <table id="affectations_table" class="table datatable hover compact" >
                    <thead>
                        <tr>
                            <th title="Matricule">Matricule</th>
                            <th title="Nom">Nom</th>
                            <th title="Prénom">Prénom</th>
                            <th title="Date de naissance">Date de naissance</th>
                            <th title="Note">Note</th>
                            <th></th>
                            <th></th>
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
                            <td><?php if($note!=null) echo '<a class="btn btn-xs btn-default" href="/professorat/devoir-notes/supprimer/'.$id.'"><i class="glyphicon glyphicon-remove"></i></a>'; ?></td>
                            <td style="max-width:40px">
                                <input type="hidden" name="notes[<?=$i?>][eleve_id]" value="<?=$affectation->inscription->elef->id?>">
                                <input type="number" step="0.01" name="notes[<?=$i?>][note]" class="form-control" >
                            </td>
                        </tr>
                    <?php $i++; endforeach;?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Modal contenu devoir-->
<div class="modal fade" id="editContenuModal" tabindex="-1" role="dialog" aria-labelledby="editContenuModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'editerContenu',$devoir->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editContenuModalLabel">Editer le contenu du devoir</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    <textarea name="description" class="form-control" rows='10'><?=$devoir->description?></textarea>
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


<!-- Modal détails devoir-->
<div class="modal fade" id="detailsDevoirModal" tabindex="-1" role="dialog" aria-labelledby="detailsDevoirModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'modifierDetails',$devoir->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="detailsDevoirModalLabel">Modification des détails du devoir</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="date" class="col-sm-4">Date</label>
                <div class="col-sm-5">
                    <input name="date" type="date" class="form-control" style="line-height:inherit;" value="<?=$devoir->date->format('Y-m-d')?>" required>
                </div>
                <div class="col-sm-3">
                    <input name="heure" type="time" class="form-control" style="line-height:inherit;" value="<?=$devoir->date->format('H:i')?>" required>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Heure</label>
                <div class="col-sm-8">
                    <select name="duree" class="form-control" required value="<?= $devoir->duree?>">
                            <option value="1" <?php if($devoir->duree==1) echo 'selected';?>> 1H </option>
                            <option value="1.5" <?php if($devoir->duree==1.5) echo 'selected';?>> 1H 30MN </option>
                            <option value="2" <?php if($devoir->duree==2) echo 'selected';?>> 2H </option>
                            <option value="2.5" <?php if($devoir->duree==2.5) echo 'selected';?>> 2H 30MN </option>
                            <option value="3"> <?php if($devoir->duree==3) echo 'selected';?> 3H </option>
                            <option value="3.5" <?php if($devoir->duree==3.5) echo 'selected';?>> 3H 30MN </option>
                            <option value="4"> <?php if($devoir->duree==4) echo 'selected';?> 4H </option>
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

<!-- Modal suppr devoir-->
<div class="modal fade" id="supprDevoirModal" tabindex="-1" role="dialog" aria-labelledby="supprDevoirModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'supprimer',$devoir->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprDevoirModalLabel">Suppression du devoir</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    Voulez-vous vraiment supprimer le devoir ainsi que toutes les notes?
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

<!-- Modal pj-->
<div class="modal fade" id="pjModal" tabindex="-1" role="dialog" aria-labelledby="pjModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'editer_pj']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$devoir->id?>" >
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
            "order": [[1, "asc"]],
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