<div class="titre">
    <span>Paramétrage des classes</span>
    <button id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutGroupeModal">
        <span class="glyphicon glyphicon-pencil"></span> Ajouter une classe
    </button>
</div>

<section class="row">
    <div class="col-xs-12">
        <div class="row">
        <?php 
        $niveau_id=null;
        $i=0; foreach($groupes as $groupe):
            if($i==0){
                $niveau_id = $groupe->promotion->niveau_id;
                echo '
                <div class="col-xs-12 panel-heading"><span class="soustitre">'.$groupe->promotion->niveaux->nom.': '.$effectifs[$groupe->promotion->niveau_id].' élève(s) inscrit(s)</span></div>
                                
                ';    
            }

            else{
                if($niveau_id!=$groupe->promotion->niveau_id){
                    echo '      
                    <div class="col-xs-12 panel-heading"><span class="soustitre">'.$groupe->promotion->niveaux->nom.': '.$effectifs[$groupe->promotion->niveau_id].' élève(s) inscrit(s)</span></div>
                    ';
                }
            }
            echo '
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="panel panel-default">
                    <div class="text-center panel-heading">
                        <span class="soustitre2">
                            '.$groupe->nom.': '.sizeof($groupe->affectations).' élèves(s)
                            '.$this->Form->postLink(__('<span class="icone glyphicon glyphicon-remove supprEmploye hover"></span>'), ["action" => "supprimer"],['class'=>'pull-right','escape'=>false,"data"=>["id"=>$groupe->id]]).'
                            <span class="icone glyphicon glyphicon-pencil editGroupe hover pull-right" data-toggle="modal" data-target="#editGroupeModal" >
                                <input type="hidden" value="'.$groupe->id.'*'.$groupe->promotion_id.'*'.$groupe->nom.'*'.'">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            ';
            $niveau_id = $groupe->promotion->niveau_id;
        $i++; endforeach;
        ?>
         
            </div>
        </div>
    </div>
</section>

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
            <div class="form-group row ">
                <label for="promotion_id" class="col-sm-5">Promotion</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('promotion_id',$promotions,['class'=>'form-control',"id"=>"promotion_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="nom" class="col-sm-5">Nom</label>
                <div class="col-sm-4">
                    <input required type="text" name="nom" class="form-control" id="nom" readonly>
                </div>
                <div class="col-sm-3 row">
                    <input required type="text" name="nom_cmpl" class="form-control" id="nom_cmpl"  placeholder="complément">
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

<!-- Modal édition Groupe-->
<div class="modal fade" id="editGroupeModal" tabindex="-1" role="dialog" aria-labelledby="editGroupeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Groupes', 'action' => 'editer']) ?>" method="post">
        <input id="edit_groupe_id" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editGroupeModalLabel">Modification du groupe</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="promotion_id" class="col-sm-5">Promotion</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('promotion_id',$promotions,['class'=>'form-control',"id"=>"edit_promotion_select"])?>
                </div>
            </div>
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
    });
} );

$("#ajout_btn").click(function() {
    var promo = $("#promotion_select option:selected").text();
    $("#nom").val(promo);
});
$("#nom_cmpl, #promotion_select").bind('change keyup', function() {
    console.log("la valeur a changé");
    var promo = $("#promotion_select option:selected").text();
    promo += ' '+$("#nom_cmpl").val();
    $("#nom").val(promo);
});
$(".editGroupe").click(function() {
    data = $(this).children("input").val().split("*");
    console.log($(".editEmploye input").val());
    $("#edit_groupe_id").val(data[0]);
    $("#edit_promotion_select").val(data[1]);
    $("#edit_nom").val(data[2]);
    var promo = $("#edit_promotion_select option:selected").text();
    console.log(promo);
    $("#edit_nom_cmpl").val(data[2].slice(promo.length));
});
$("#edit_nom_cmpl, #edit_promotion_select").bind('change keyup', function() {
    console.log("la valeur a changé");
    var promo = $("#edit_promotion_select option:selected").text();
    promo += ' '+$("#edit_nom_cmpl").val();
    $("#edit_nom").val(promo);
});


</script>
<?php $this->end(); ?>