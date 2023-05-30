<?php
$mois = $list_mois->toArray();
?>

<div class="titre">
    <span>Configuration des années</span>
    <button id="ajout_btn" type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#AjoutAnneeModal">
        <span class="glyphicon glyphicon-pencil"></span> Démarrer une nouvelle année
    </button>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="annees_table" class="table" >
            <thead>
                <tr>
                    <th title="Libellé de l'année">Libellé</th>
                    <th title="Ouverture de l'administration">Ouverture Ad.</th>
                    <th title="Ouverture des professeurs">Ouerture Pr.</th>
                    <th title="Démarrage des inscriptions">Inscriptions</th>
                    <th title="Ouverture des classes">Ouverture Cl.</th>
                    <th title="Début">Début</th>
                    <th title="Fin">Fin</th>
                    <th ></th>
                </tr>
            </thead>
            <tbody>            
            <?php foreach($annees as $annee):?>
                <tr>
                    <td>
                        <?=$annee->nom?> 
                        <?php if($etablissement->annee_id == $annee->id) echo "(année en cours d'exploitation)";?>
                    </td>
                    <td><?=$annee->administration_ouverture?></td>
                    <td><?=$annee->professeur_ouverture?></td>
                    <td><?=$annee->inscription_ouverture?></td>
                    <td><?=$annee->classe_ouverture?></td>
                    <td><?=$mois[$annee->debut]?></td>
                    <td><?=$mois[$annee->fin]?></td>
                    <td>
                        <div class="btn-group">
                            <?php if($etablissement->annee_id == $annee->id):?>
                                <button class="btn btn-default btn-sm" disabled>Activer</button>
                            <?php else:?>                            
                                <?=$this->Html->link('Activer',['controller'=>'Etablissements','action'=>'activerAnnee',$etablissement->id,$annee->id],['class'=>"btn btn-default btn-sm",'confirm'=>"Voulez-vous vraiment activer cette année? Une fois activée, elle sera l'année exploitée sur toute la plateforme."])?>
                            <?php endif;?>                            
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="edit_btn btn-custom full-width bg-default" value="<?=$annee->id."*".$annee->nom."*".$annee->administration_ouverture->format('Y-m-d')."*".$annee->professeur_ouverture->format('Y-m-d')."*".$annee->inscription_ouverture->format('Y-m-d')."*".$annee->classe_ouverture->format('Y-m-d')."*".$annee->debut."*".$annee->fin?>" data-toggle="modal" data-target="#AjoutAnneeModal">Modifier</button></li>
                                <li>
                                    <?= $this->Form->postLink(__('Supprimer'), ['action' => 'supprimer', $annee->id], ['confirm' => __('Voulez-vous vraiment supprimer l\' année # {0}?', $annee->id),"class"=>" btn-custom full-width bg-danger"]) ?>
                                </li>
                            </ul>
                        </div>                      
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Ajout Année-->
<div class="modal fade" id="AjoutAnneeModal" tabindex="-1" role="dialog" aria-labelledby="ajoutAnneeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Annees', 'action' => 'configuration']) ?>" method="post" enctype="multipart/form-data">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutAnneeModalLabel">Ajouter une nouvelle année</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="libelle" class="col-sm-6">Libellé</label>
                <div class="col-sm-6">
                    <input type="text" name="nom" id="libelle" class="full-width" editable="false" required>
                </div>
            </div>
            <div class="form-group row ">
                <label for="administration" class="col-sm-6">Ouverture de l'administration</label>
                <div class="col-sm-6">
                    <input required type="date" name="administration_ouverture" class="full-width" id="administration">
                </div>
            </div>
            <div class="form-group row ">
                <label for="professeur" class="col-sm-6">Ouverture des professeurs</label>
                <div class="col-sm-6">
                    <input required type="date" name="professeur_ouverture" class="full-width" id="professeur">
                </div>
            </div>
            <div class="form-group row ">
                <label for="inscriptions" class="col-sm-6">Démarrage des inscriptions</label>
                <div class="col-sm-6">
                    <input required type="date" name="inscription_ouverture" class="full-width" id="inscription">
                </div>
            </div>
            <div class="form-group row ">
                <label for="classe" class="col-sm-6">Ouverture des classes</label>
                <div class="col-sm-6">
                    <input required type="date" name="classe_ouverture" class="full-width" id="classe">
                </div>
            </div>
            <div class="form-group row">
                <label for="debut" class="col-sm-6 col-form-label">Début</label>
                <div class="col-sm-6">
                    <?=$this->Form->select('debut',$list_mois,['class'=>'form-control',"id"=>"debut","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="fin" class="col-sm-6 col-form-label">Fin</label>
                <div class="col-sm-6">
                    <?=$this->Form->select('fin',$list_mois,['class'=>'form-control',"id"=>"fin","required"])?>
                </div>
            </div>
            <!--div class="form-group row ">
                <label for="debut" class="col-sm-6">Début de la scolarité</label>
                <div class="col-sm-6">
                    <input required type="date" name="debut" class="full-width" id="debut">
                </div>
            </div>
            <div class="form-group row ">
                <label for="fin" class="col-sm-6">Fin de la scolarité</label>
                <div class="col-sm-6">
                    <input required type="date" name="fin" class="full-width" id="fin">
                </div>
            </div-->
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
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('#annees_table').DataTable({
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
        }
    });
} );
$(".edit_btn").click(function() {
    data = this.value.split('*');
    $("#AjoutAnneeModalLabel").html("Modifier l'année "+data[1]+" <input type='hidden' name='id' value='"+data[0]+"'>");
    $("#libelle").val(data[1]);
    $("#administration").val(data[2]);
    $("#professeur").val(data[3]);
    $("#inscription").val(data[4]);
    $("#classe").val(data[5]);
    $("#debut").val(data[6]);
    $("#fin").val(data[7]);
});
$("#ajout_btn").click(function() {
    $("#AjoutAnneeModalLabel").html("Ajouter une nouvelle année");
});
</script>
<?php $this->end(); ?>