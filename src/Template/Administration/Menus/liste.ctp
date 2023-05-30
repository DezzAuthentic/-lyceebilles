<div class="titre">
    <span>Menus de la cantine</span>
    <a class="btn btn-default pull-right btn-sm" href="<?=$this->Url->Build(['controller'=>'Menus','action'=>'index'])?>">
        <span class="glyphicon glyphicon-calendar"></span> Menu cantine
    </a>
</div>

<div class="row">
    <br>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="text-center panel-heading"> Plats
            </div>
            <form action="<?= $this->Url->Build(['controller' => 'Plats', 'action' => 'actionEnMasse']) ?>" method="post">        
            <table id="plats_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Ordre"></th>
                        <th title="Nom">Nom</th>
                        <th class="actions" >   
                        </th>
                        <th class="select_col"><input id="select_all_plats" name="select_all_plats" type="checkbox" ></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($plats as $plat): ?>
                    <tr>
                        <td><?=$plat->id?></td>
                        <td><?=$plat->nom?></td>
                        <td class="actions">
                            <span class="icone glyphicon glyphicon-pencil editPlat hover" data-toggle="modal"
                            data-target="#editPlatModal" >
                                <input type="hidden" value="<?=$plat->id.'*'.$plat->nom?>">
                            </span>
                            <span class="icone glyphicon glyphicon-remove supprPlat hover" data-toggle="modal"
                            data-target="#supprPlatModal">
                                <input type="hidden" value="<?=$plat->id.'*'.$plat->nom?>">
                            </span>
                        </td>
                        <td class="text-center"><input name="select[<?=$i?>]" value="<?=$plat->id?>" type="checkbox" class="select_plat" ></td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
            <br>
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterPlatModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                    <button name="action" value="supprimer" type="submit" class="btn btn-default select_plats_action"><span class="icone glyphicon glyphicon-remove hover"></button>
                </div>
            </div>
            </form>
            <br>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="text-center panel-heading"> Desserts
            </div>
            <form action="<?= $this->Url->Build(['controller' => 'Desserts', 'action' => 'actionEnMasse']) ?>" method="post">        
            <table id="desserts_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Id"></th>
                        <th title="Nom">Nom</th>
                        <th class="actions" >   
                        </th>
                        <th class="select_col"><input id="select_all_desserts" name="select_all_desserts" type="checkbox" ></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($desserts as $dessert): ?>
                    <tr>
                        <td><?=$dessert->id?></td>
                        <td><?=$dessert->nom?></td>
                        <td class="actions">
                            <span class="icone glyphicon glyphicon-pencil editDessert hover" data-toggle="modal"
                            data-target="#editDessertModal" >
                                <input type="hidden" value="<?=$dessert->id.'*'.$dessert->nom?>">
                            </span>
                            <span class="icone glyphicon glyphicon-remove supprDessert hover" data-toggle="modal"
                            data-target="#supprDessertModal">
                                <input type="hidden" value="<?=$dessert->id.'*'.$dessert->nom?>">
                            </span>
                        </td>
                        <td class="text-center"><input name="select[<?=$i?>]" value="<?=$dessert->id?>" type="checkbox" class="select_dessert" ></td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
            <br>
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterDessertModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                    <button name="action" value="supprimer" type="submit" class="btn btn-default select_desserts_action"><span class="icone glyphicon glyphicon-remove hover"></button>
                </div>
            </div>
            </form>
            <br>
        </div>
    </div>
</div>

<!-- **************************************** Modals pour les plats *********************************************-->
<!-- Modal ajout Plat-->
<div class="modal fade" id="ajouterPlatModal" tabindex="-1" role="dialog" aria-labelledby="ajouterPlatModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Plats', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterPlatModalLabel">Ajout d'un plat</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterPlatNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterPlatNom" class="form-control" required>
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

<!-- Modal édition Plat-->
<div class="modal fade" id="editPlatModal" tabindex="-1" role="dialog" aria-labelledby="editPlatModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Plats', 'action' => 'editer']) ?>" method="post">
        <input id="editPlatId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editPlatModalLabel">Edition du plat</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editPlatNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editPlatNom" class="form-control" required>
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

<!-- Modal suppression plat-->
<div class="modal fade" id="supprPlatModal" tabindex="-1" role="dialog" aria-labelledby="supprPlatModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Plats', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprPlatId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprPlatModalLabel">Supression du plat : <span id="supprPlatNom"></span> <span id="supprPlatNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce plat?
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

<!-- ************************************************** FIn ***************************************************-->
<!-- **************************************** Modals pour les Deserts *********************************************-->
<!-- Modal ajout Dessert-->
<div class="modal fade" id="ajouterDessertModal" tabindex="-1" role="dialog" aria-labelledby="ajouterDessertModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Desserts', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterDessertModalLabel">Ajout d'un dessert</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterDessertNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterDessertNom" class="form-control" required>
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

<!-- Modal édition Dessert-->
<div class="modal fade" id="editDessertModal" tabindex="-1" role="dialog" aria-labelledby="editDessertModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Desserts', 'action' => 'editer']) ?>" method="post">
        <input id="editDessertId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editDessertModalLabel">Edition du dessert</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editDessertNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editDessertNom" class="form-control" required>
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

<!-- Modal suppression dessert-->
<div class="modal fade" id="supprDessertModal" tabindex="-1" role="dialog" aria-labelledby="supprDessertModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Desserts', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprDessertId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprDessertModalLabel">Supression du dessert : <span id="supprDessertNom"></span> <span id="supprDessertNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce dessert?
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
<!-- ************************************************** FIn ***************************************************-->

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
    /******************** fonction pour les plats *********************/
    $(".editPlat").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editPlat input").val());
        $("#editPlatId").val(data[0]);
        $("#editPlatNom").val(data[1]);
    });
    $(".supprPlat").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprPlat input").val());
        $("#supprPlatId").val(data[0]);
        $("#supprPlatNom").html(data[1]);
    });

    $("#select_all_plats").click(function() {
        if ($(this).prop("checked")){
            $(".select_plat").prop("checked","checked");
            console.log("Sélection de tous les plats");
        }else{
            $(".select_plat").prop("checked",null);
            console.log("déselection de tous les plats");
        }
    });
    $(".select_plats_action").click(function() {
        if (!$("input[class='select_plat']:checked").val()) {
            alert("Vous n'avez sélectionné aucun plat.");
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
                $(".select_plat").prop("checked",null);
            }
        }
    });
    /****************************** fin *******************************/
    /******************** fonction pour les desserts *********************/
    $(".editDessert").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editDessert input").val());
        $("#editDessertId").val(data[0]);
        $("#editDessertNom").val(data[1]);
    });
    $(".supprDessert").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprDessert input").val());
        $("#supprDessertId").val(data[0]);
        $("#supprDessertNom").html(data[1]);
    });

    $("#select_all_desserts").click(function() {
        if ($(this).prop("checked")){
            $(".select_dessert").prop("checked","checked");
            console.log("Sélection de tous les desserts");
        }else{
            $(".select_dessert").prop("checked",null);
            console.log("déselection de tous les desserts");
        }
    });
    $(".select_desserts_action").click(function() {
        if (!$("input[class='select_dessert']:checked").val()) {
            alert("Vous n'avez sélectionné aucun dessert.");
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
                $(".select_dessert").prop("checked",null);
            }
        }
    });
    /****************************** fin *******************************/
</script>
<?php $this->end(); ?>