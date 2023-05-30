<div class="titre">
    <span>Gestion des professeurs</span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutProfModal">
        <span class="glyphicon glyphicon-plus"></span> Ajouter un professeur
    </a>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm mr1" href="<?=$this->Url->Build('/academie/professeurs/principaux')?>">
        <span class="glyphicon glyphicon-user"></span> Professeurs principaux
    </a>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="professeurs_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Matières enseignées">Matières enseignées</th>
                    <th class="actions" style="min-width:150px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($professeurs as $professeur): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$professeur->nom?></td>
                    <td><?=$professeur->prenom?></td>
                    <td>
                        <?php $matieres_liste=""; foreach($professeur->enseignees as $ens): $matieres_liste.='*'.$ens->matiere->id;?>
                            <span class="btn btn-xs btn-default"><?=$ens->matiere->nom?></span>
                        <?php endforeach;?>
                    </td>
                    <td class="actions">
                        <?php //$this->Html->link('Voir la fiche',[],['class' => 'btn btn-xs btn-warning'])?>
                        <span class="btn btn-xs btn-default modifierProf" data-toggle="modal" data-target="#modifierProfModal" >
                            <i class="glyphicon glyphicon-pencil icone"></i>
                            <input type="hidden" value="<?=$professeur->id.'*'.$professeur->nom.'*'.$professeur->prenom.$matieres_liste?>">
                        </span>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'supprimer', $professeur->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer ce professeur # {0}?', $professeur->id),'class'=>"btn btn-xs btn-default"]); ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Ajout groupe-->
<div class="modal fade" id="AjoutProfModal" tabindex="-1" role="dialog" aria-labelledby="ajoutProfModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Professeurs', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutGroupeModalLabel">Ajouter un professeur</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Nom</label>
                <div class="col-sm-8">
                    <input required type="text" name="nom" class="form-control" id="nom">
                </div>
            </div>
            <div class="form-group row ">
                <label for="prenom" class="col-sm-4">Prénom</label>
                <div class="col-sm-8">
                    <input required type="text" name="prenom" class="form-control" id="prenom">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-xs-12">Sélectionnez les matières enseignées</label>
                <div class="col-xs-12">
                    <?php $i=0; foreach($matieres as $mat):?>
                        <span class="btn btn-default"><?=$mat->nom?> <input type="checkbox" name="matieres[<?=$i?>]" value="<?=$mat->id?>"></span> 
                    <?php $i++; endforeach?>
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

<!-- Modal Modifier un prof-->
<div class="modal fade" id="modifierProfModal" tabindex="-1" role="dialog" aria-labelledby="modifierProfModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Professeurs', 'action' => 'modifier']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <input type="hidden" name="id" id="modifier_id" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modifierProfModalLabel">Modifier le professeur</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Nom</label>
                <div class="col-sm-8">
                    <input required type="text" name="nom" class="form-control" id="modifier_nom">
                </div>
            </div>
            <div class="form-group row ">
                <label for="prenom" class="col-sm-4">Prénom</label>
                <div class="col-sm-8">
                    <input required type="text" name="prenom" class="form-control" id="modifier_prenom">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-xs-12">Sélectionnez les matières enseignées</label>
                <div class="col-xs-12">
                    <?php $i=0; foreach($matieres as $mat):?>
                        <span class="btn btn-default"><?=$mat->nom?> <input type="checkbox" name="matieres[<?=$i?>]" value="<?=$mat->id?>" id="mat_<?=$mat->id?>"></span> 
                    <?php $i++; endforeach?>
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
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
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
            },
            "columnDefs": [ {
                "targets": 3,
                "orderable": false
                },{
                "targets": 4,
                "orderable": false
                }
            ]
        });
        table.buttons().container().appendTo( '#professeurs_table_wrapper .col-sm-6:eq(0)' );        
    });

    $(".modifierProf").click(function() {
        $("[id^='mat_']").removeAttr("checked");
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#modifier_id").val(data[0]);
        $("#modifier_nom").val(data[1]);
        $("#modifier_prenom").val(data[2]);
        i = 3;
        while(data[i]){
            console.log(data[i]);
            $("#mat_"+data[i]).attr("checked","checked");
            i++;
        }
    });
    
</script>
<?php $this->end(); ?>