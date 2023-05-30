<div class="titre">
    <span>Gestion de la promotion <?=$promotion->nom?></span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutGroupeModal">
        <span class="glyphicon glyphicon-plus"></span> Ajouter une classe
    </a>
</div>

<div class="row">
    <?php foreach($promotion->groupes as $groupe):?>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="text-center panel-heading">
                    <a href="/academie/groupes/gestion/<?=$groupe->id?>">
                        <span class="soustitre2">
                            <?=$groupe->nom?>: <?=sizeof($groupe->affectations)?> élèves(s)
                            <?php if(sizeof($groupe->affectations)==0) echo $this->Form->postLink(__('<span class="icone glyphicon glyphicon-remove supprEmploye hover"></span>'), ["controller"=>"Groupes","action" => "supprimer"],['class'=>'pull-right','escape'=>false,"data"=>["id"=>$groupe->id]]);?>
                        </span>
                        <span class="icone glyphicon glyphicon-pencil editGroupe hover pull-right" data-toggle="modal" data-target="#editGroupeModal" >
                            <input type="hidden" value="<?=$groupe->id.'*'.$groupe->nom?>">
                        </span>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach;?>

    <div class="col-xs-12 soustitre">Liste des élèves sans classe</div>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Affectations', 'action' => 'ajoutMasse']) ?>" method="post">  
            <table id="inscriptions_table" class="table datatable hover" >
                <thead>
                    <tr>
                        <th class="select_col"><input id="select_all" type="checkbox" ></th>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th class="actions" style="min-width:130px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($inscrits_non_affectes as $inscription): ?>
                    <tr>
                        <td><input class="select" type="checkbox" name="inscrits[<?=$i?>]" value="<?=$inscription->id?>"></td>
                        <td><?=$inscription->elef->matricule?></td>
                        <td><?=$inscription->elef->nom?></td>
                        <td><?=$inscription->elef->prenom?></td>
                        <td class="actions">
                            <?=$this->Html->link('Voir la fiche',['controller'=>'Eleves','action'=>'fiche',$inscription->elef->id],['class' => 'btn btn-xs btn-warning'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
            
            <div class="form-group row ">
                <label class="col-sm-3 col-xs-5 margin-top-10">Affecter à la classe</label>
                <div class="col-sm-5 col-xs-7 margin-top-10">
                    <?=$this->Form->select('groupe_id',$groupes_list,['class'=>'form-control'])?>
                </div>
                <div class="col-sm-4 col-xs-12 margin-top-10">
                    <button type="submit" class="btn btn-md btn-default btn-block">Valider</button>
                </div>
            </div> 
        </form>
    </div>

</div>

<!-- Modal Ajout groupe-->
<div class="modal fade" id="AjoutGroupeModal" tabindex="-1" role="dialog" aria-labelledby="ajoutGroupeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Groupes', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutGroupeModalLabel">Ajouter une nouvelle classe</h4>
        </div>
        <div class="modal-body">
            <input name="promotion_id" type="hidden" value="<?=$promotion->id?>"> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-3">Nom</label>
                <div class="col-sm-5">
                    <input required type="text" name="nom" class="form-control" id="nom" value="<?=$promotion->nom?>" readonly>
                </div>
                <div class="col-sm-4 row">
                    <input required type="text" name="nom_cmpl" class="form-control" id="nom_cmpl"  placeholder="complément">
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

<!-- Modal édition Groupe-->
<div class="modal fade" id="editGroupeModal" tabindex="-1" role="dialog" aria-labelledby="editGroupeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Groupes', 'action' => 'editer']) ?>" method="post">
        <input id="edit_groupe_id" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editGroupeModalLabel">Modification de la classe</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-5">Nom</label>
                <div class="col-sm-4">
                    <input required type="text" name="nom" class="form-control" id="edit_nom" readonly>
                </div>
                <div class="col-sm-3 row">
                    <input required type="text" class="form-control" id="edit_nom_cmpl"  placeholder="complément">
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
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('.datatable').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
        "language": {
            "lengthMenu": "Afficher _MENU_ par page &nbsp;",
            "zeroRecords": "Pas d'élève en attente d'affectation",
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

$("#nom_cmpl").bind('change keyup', function() {
    console.log("la valeur a changé");
    var promo = "<?=$promotion->nom?>";
    promo += ' '+$("#nom_cmpl").val();
    $("#nom").val(promo);
});
$(".editGroupe").click(function() {
    data = $(this).children("input").val().split("*");
    console.log($(".editEmploye input").val());
    $("#edit_groupe_id").val(data[0]);
    $("#edit_nom").val(data[1]);
    var promo = "<?=$promotion->nom?>";
    console.log(promo);
    $("#edit_nom_cmpl").val(data[1].slice(promo.length));
});
$("#edit_nom_cmpl").bind('change keyup', function() {
    console.log("la valeur a changé");
    var promo = "<?=$promotion->nom?>";
    promo += ' '+$("#edit_nom_cmpl").val();
    $("#edit_nom").val(promo);
});

$("#select_all").click(function() {
    if ($(this).prop("checked")){
        $(".select").prop("checked","checked");
        console.log("Sélection de tous les inscrits");
    }else{
        $(".select").prop("checked",null);
        console.log("déselection de tous inscrits");
    }
});

</script>
<?php $this->end(); ?>