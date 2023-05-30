
<div class="titre">
    <span>Champs des Fiches médicales</span>
    <button id="ajout_btn" type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#ajouterRenseignementModal">
        <span class="glyphicon glyphicon-pencil"></span> Ajouter un champ
    </button>
</div>

<div id="renseignements_tab" class="row tab">
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Renseignements', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="renseignements_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="#">#</th>
                    <th title="Libelle">Libellé</th>
                    <th class="Type" >Type</th> 
                    <th class="Statut" >Statut</th>
                    <th class="Actions" ></th>
                    <th class="select_col"><input id="select_all_renseignements" name="select_all_renseignements" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=1; foreach($renseignements as $renseignement): ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$renseignement->libelle?></td>
                    <td><?=$renseignement->renseignement_type->libelle?></td>
                    <td>
                        <?php 
                            if($renseignement->status) echo '<i class="glyphicon glyphicon-ok-sign text-success"></i>'; 
                            else echo '<i class="glyphicon glyphicon-remove-sign text-danger"></i>'
                        ?>
                    </td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editRenseignement hover" data-toggle="modal"
                        data-target="#editRenseignementModal" >
                            <input type="hidden" value="<?=$renseignement->id.'*'.$renseignement->libelle.'*'.$renseignement->renseignement_type_id.'*'.$renseignement->status?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprRenseignement hover" data-toggle="modal"
                        data-target="#supprRenseignementModal">
                            <input type="hidden" value="<?=$renseignement->id.'*'.$renseignement->libelle?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$renseignement->id?>" type="checkbox" class="select_renseignement" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody> 
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterRenseignementModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_renseignements_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout Renseignement-->
<div class="modal fade" id="ajouterRenseignementModal" tabindex="-1" role="dialog" aria-labelledby="ajouterRenseignementModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Renseignements', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterRenseignementModalLabel">Ajout d'un champ</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterRenseignementLibelle" class="col-sm-4 col-form-label">Libellé</label>
                <div class="col-sm-8">
                    <input type="text" name="libelle" id="ajouterRenseignementLibelle" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterRenseignementType" class="col-sm-4 col-form-label">Type</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('renseignement_type_id',$types,['class'=>'Form-control','id'=>'ajouterRenseignementType'])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterRenseignementStatus" class="col-sm-4 col-form-label">Actif?</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('status',['1'=>'oui','0'=>'non'],['class'=>'Form-control','id'=>'ajouterRenseignementStatus',"required"])?>
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

<!-- Modal édition Renseignement-->
<div class="modal fade" id="editRenseignementModal" tabindex="-1" role="dialog" aria-labelledby="editRenseignementModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Renseignements', 'action' => 'editer']) ?>" method="post">
        <input id="editRenseignementId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editRenseignementModalLabel">Edition du renseignement</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editRenseignementLibelle" class="col-sm-4 col-form-label">Libellé</label>
                <div class="col-sm-8">
                    <input type="text" name="libelle" id="editRenseignementLibelle" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editRenseignementType" class="col-sm-4 col-form-label">Type</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('renseignement_type_id',$types,['class'=>'Form-control','id'=>'editRenseignementType'])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editRenseignementStatus" class="col-sm-4 col-form-label">Actif?</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('status',['1'=>'oui','0'=>'non'],['class'=>'Form-control','id'=>'editRenseignementStatus'])?>
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

<!-- Modal suppression renseignement-->
<div class="modal fade" id="supprRenseignementModal" tabindex="-1" role="dialog" aria-labelledby="supprRenseignementModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Renseignements', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprRenseignementId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprRenseignementModalLabel">Supression du champ : <span id="supprRenseignementLibelle"></span> <span id="supprRenseignementNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce champ?
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary">Oui</button>
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
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": false,
            "searching": true,
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
 
    $(".editRenseignement").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#editRenseignementId").val(data[0]);
        $("#editRenseignementLibelle").val(data[1]);
        $("#editRenseignementType").val(data[2]);
        $("#editRenseignementStatus").val(data[3]);
    });
    $(".supprRenseignement").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprRenseignement input").val());
        $("#supprRenseignementId").val(data[0]);
        $("#supprRenseignementLibelle").html(data[1]);
    });

    $("#select_all_renseignements").click(function() {
        if ($(this).prop("checked")){
            $(".select_renseignement").prop("checked","checked");
            console.log("Sélection de tous les renseignements");
        }else{
            $(".select_renseignement").prop("checked",null);
            console.log("déselection de tous les renseignements");
        }
    });
    $(".select_renseignements_action").click(function() {
        if (!$("input[class='select_renseignement']:checked").val()) {
            alert("Vous n'avez sélectionné aucun renseignement.");
            $("form").submit(function(e){
                e.preventDefault();
            });
        }else{
            var r = confirm("Confirmez-vous cette action en masse?");
            if(r==true){
                $("form").submit(function(e){
                    $(this).unbind('submit').submit();
                });
            }else{
                $("form").submit(function(e){
                    e.preventDefault();
                });
                $(".select_renseignement").prop("checked",null);
            }
        }
    });
        
</script>
<?php $this->end(); ?>