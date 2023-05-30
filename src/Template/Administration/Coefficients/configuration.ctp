<div class="titre">
    <span>Configuration des coefficients</span>
    <button id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutCoefModal">
        <span class="glyphicon glyphicon-pencil"></span> Ajouter un coefficient
    </button>
</div>

<section class="row">
    <div class="col-xs-12">
        <div class="row">
        <?php 
        $niveau_id=null;
        $serie_id=null;
        $serie="";
        $i=0; foreach($coefficients as $coef):
            if(!empty($coef->series)){
                $serie = $coef->series->nom;
            }
            if($i==0){
                $niveau_id = $coef->niveau_id;
                $serie_id = $coef->serie_id;
                echo '
                <div class="col-xs-12 panel-heading"><span class="soustitre">'.$coef->niveaux->nom.'</span></div>
                <div class="col-xs-12 col-sm-4">
                <div class="panel panel-default">
                <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$serie.'&nbsp;</span></div>
                <table id="" class="table datatable compact hover" >
                    <thead>
                        <tr>
                            <th title="Matiere">Matiere</th>
                            <th title="Coefficient">Coefficient</th>
                            <th class="" >
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                ';    
            }

            else{
                if($niveau_id!=$coef->niveau_id){
                    echo '
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-xs-12 panel-heading"><span class="soustitre">'.$coef->niveaux->nom.'</span></div>
                    <div class="col-xs-12 col-sm-4">
                    <div class="panel panel-default">
                    <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$serie.'&nbsp;</span></div>
                    <table id="" class="table datatable compact hover" >
                        <thead>
                            <tr>
                                <th title="Matiere">Matiere</th>
                                <th title="Coefficient">Coefficient</th>
                                <th class="" >
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                }elseif($serie_id!=$coef->serie_id){
                    echo '
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                    <div class="panel panel-default">
                    <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$serie.'&nbsp;</span></div>
                    <table id="" class="table datatable compact hover" >
                        <thead>
                            <tr>
                                <th title="Matiere">Matiere</th>
                                <th title="Coefficient">Coefficient</th>
                                <th class="" >
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                }
            }
            echo '
            <tr>
                <td>'.$coef->matiere->nom.'</td>
                <td>'.$coef->coef.'</td>
                <td class="">
                    <span class="icone glyphicon glyphicon-pencil editCoef hover" data-toggle="modal" data-target="#editCoefModal" >
                        <input type="hidden" value="'.$coef->id.'*'.$coef->niveau_id.'*'.$coef->serie_id.'*'.$coef->matiere_id.'*'.$coef->coef.'">
                    </span>
                    '.$this->Form->postLink(__('<span class="icone glyphicon glyphicon-remove supprEmploye hover"></span>'), ["action" => "supprimer"],['escape'=>false,"data"=>["id"=>$coef->id]]).'
                </td>
            </tr>
            ';
            $niveau_id = $coef->niveau_id;
            $serie_id = $coef->serie_id;
        $i++; endforeach;
        ?>
                </tbody>
            </table>
        </div>
        </div>

        </div>
    </div>
</section>

<!-- Modal Ajout Coef-->
<div class="modal fade" id="AjoutCoefModal" tabindex="-1" role="dialog" aria-labelledby="ajoutCoefModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Coefficients', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutCoefModalLabel">Ajouter un nouveau coefficient</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="niveau_id" class="col-sm-5">Niveau</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"niveau_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="serie_id" class="col-sm-5">Serie</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('serie_id',$series,['class'=>'form-control',"empty"=>" ","id"=>"serie_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="matiere_id" class="col-sm-5">Matieres</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('matiere_id',$matieres,['class'=>'form-control'])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="coef" class="col-sm-5">Coefficient</label>
                <div class="col-sm-7">
                    <input required type="number" name="coef" class="form-control" id="coef" min="1">
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

<!-- Modal édition Coef-->
<div class="modal fade" id="editCoefModal" tabindex="-1" role="dialog" aria-labelledby="editCoefModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Coefficients', 'action' => 'editer']) ?>" method="post">
        <input id="edit_coef_id" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editCoefModalLabel">Modification du coefficient</h4>
        </div>
        <div class="modal-body">
        <div class="form-group row ">
                <label for="niveau_id" class="col-sm-5">Niveau</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"edit_niveau_select","required"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="serie_id" class="col-sm-5">Serie</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('serie_id',$series,['class'=>'form-control',"empty"=>" ","id"=>"edit_serie_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="matiere_id" class="col-sm-5">Matieres</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('matiere_id',$matieres,['class'=>'form-control',"id"=>"edit_matiere_select","required"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="coef" class="col-sm-5">Coefficient</label>
                <div class="col-sm-7">
                    <input id='edit_coef' required type="number" name="coef" class="form-control" min="1">
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

$(".editCoef").click(function() {
    data = $(this).children("input").val().split("*");
    console.log($(".editEmploye input").val());
    $("#edit_coef_id").val(data[0]);
    $("#edit_niveau_select").val(data[1]);
    $("#edit_serie_select").val(data[2]);
    $("#edit_matiere_select").val(data[3]);
    $("#edit_coef").val(data[4]);
});


</script>
<?php $this->end(); ?>