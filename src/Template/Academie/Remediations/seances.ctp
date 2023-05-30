<?php
use Cake\I18n\Time;

$auj = Time::now();
$jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}
?>
<div class="titre">
    <span>Séances de remédiation: <?=$remediation->matiere->nom?></span> 

    <span id="ajout_btn" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#ajouterSeanceModal">
        <i class="glyphicon glyphicon-plus"></i> Ajouter une séance
    </span>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Elève </label> <br>
                <?=$remediation->inscription->elef->prenom?> <?=$remediation->inscription->elef->nom?> - <?=$remediation->inscription->elef->matricule?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Professeur </label> <br>
                <?=$remediation->professeur->prenom?> <?=$remediation->professeur->nom?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <ul class="timeline">
            <?php foreach($remediation->remediation_seances as $seance):?>
                <?php 
                    $hr_debut = (int) $seance->debut;
                    $mn_debut = ($seance->debut - $hr_debut) > 0 ?'30MN':'';
                    $hr_duree = (int) $seance->duree;
                    $mn_duree = ($seance->duree - $hr_duree) > 0 ?'30MN':'';
                ?>
                <li>
                    <a href="#" class=""><?=$seance->date?> <?=$hr_debut.'H'.$mn_debut?></a>
                    <a href="#" class="pull-right">Durée: <?=$hr_duree.'H'.$mn_duree?></a>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contenu de la séance
                            <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ["controller"=>"RemediationSeances",'action' => 'supprimer', $seance->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer cette séance # {0}?', $remediation->id),'class'=>"btn btn-xs btn-default pull-right ml1"]); ?>
                            <span class="pull-right btn btn-xs btn-default ml3 modifierSeance" data-toggle="modal" data-target="#modifierSeanceModal">
                                <i class="glyphicon glyphicon-pencil icone"></i>
                                <input type="hidden" value="<?=$seance->id."*".$seance->date."*".$seance->debut."*".$seance->duree."*".$seance->contenu."*".$seance->note?>">
                            </span>
                            <span class="pull-right">Note: <?=$seance->note?>/20</span>
                        </div>
                        <div class="panel-body"><?=$seance->contenu?></div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
        <?php if(sizeof($remediation->remediation_seances) == 0): ?>
            <div class="panel panel-default bg-gris">
                <div class="panel-body text-center">
                    <span class="soustitre2">Pas encore de séance enregistrée!</span>
                </div>
            </div>
        <?php endif;?>
    </div>
    
</div>

<!-- Modal ajout-->
<div class="modal fade" id="ajouterSeanceModal" tabindex="-1" role="dialog" aria-labelledby="ajouterSeanceModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form action="<?= $this->Url->Build(['controller' => 'RemediationSeances', 'action' => 'ajouter']) ?>" method="post">
                <input type="hidden" name="remediation_id" value="<?=$remediation->id?>">
                <div class="modal-header">
                    <h4 class="modal-title pull-left" id="ajouterSeanceModalLabel">Nouvelle séance de remédiation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label for="date" class="col-sm-4">Date</label>
                        <div class="col-sm-8">
                            <input name="date" type="date" class="form-control" style="line-height:inherit;" value="<?= $auj->format('Y-m-d');?>" required>
                        </div>
                    </div> 
                    <div class="form-group row ">
                        <label for="nom" class="col-sm-4">Début</label>
                        <div class="col-sm-8">
                            <select name="debut" class="form-control" required>
                                <?php foreach($heures as $heure):?>
                                    <option value="<?=$heure?>">
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
                            <select name="duree" class="form-control" required>
                                    <option value="1"> 1H </option>
                                    <option value="1.5"> 1H 30MN </option>
                                    <option value="2"> 2H </option>
                                    <option value="2.5"> 2H 30MN </option>
                                    <option value="3"> 3H </option>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row ">
                        <label for="contenu" class="col-xs-12">Contenu</label>
                        <div class="col-xs-12">
                            <textarea name="contenu" id="contenu" rows="10" class="form-control"></textarea>
                        </div>
                    </div>   
                    <div class="form-group row ">
                        <label for="note" class="col-sm-4">Note</label>
                        <div class="col-sm-8">
                            <input name="note" type="number" min="0" max="20" class="form-control" style="line-height:inherit;" value="<?= $auj->format('Y-m-d');?>" required>
                        </div>
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>  
</div>

<!-- Modal modification-->
<div class="modal fade" id="modifierSeanceModal" tabindex="-1" role="dialog" aria-labelledby="modifierSeanceModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form action="<?= $this->Url->Build(['controller' => 'RemediationSeances', 'action' => 'modifier']) ?>" method="post">
                <input type="hidden" name="seance_id" id="modifier_id">
                <div class="modal-header">
                    <h4 class="modal-title pull-left" id="modifierSeanceModalLabel">Modifcation de la séance de remédiation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label for="date" class="col-sm-4">Date</label>
                        <div class="col-sm-8">
                            <input id="modifier_date" name="date" type="date" class="form-control" style="line-height:inherit;" required>
                        </div>
                    </div> 
                    <div class="form-group row ">
                        <label for="nom" class="col-sm-4">Début</label>
                        <div class="col-sm-8">
                            <select id="modifier_debut" name="debut" class="form-control" required>
                                <?php foreach($heures as $heure):?>
                                <option id="modifier_debut_<?=$heure?>" value="<?=$heure?>">
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
                            <select id="modifier_duree" name="duree" class="form-control" required>
                                    <option value="1"> 1H </option>
                                    <option value="1.5"> 1H 30MN </option>
                                    <option value="2"> 2H </option>
                                    <option value="2.5"> 2H 30MN </option>
                                    <option value="3"> 3H </option>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row ">
                        <label for="contenu" class="col-xs-12">Contenu</label>
                        <div class="col-xs-12">
                            <textarea name="contenu" id="modifier_contenu" rows="10" class="form-control"></textarea>
                        </div>
                    </div>   
                    <div class="form-group row ">
                        <label for="note" class="col-sm-4">Note</label>
                        <div class="col-sm-8">
                            <input id="modifier_note" name="note" type="number" min="0" max="20" class="form-control" style="line-height:inherit;" >
                        </div>
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>  
</div>

<?php

$this->Html->script([
    "https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js",
],
['block' => 'script']);

$this->Html->css([
    "timeline.css",
],
['block' => 'css']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    CKEDITOR.replace( 'contenu' );
    CKEDITOR.replace( 'modifier_contenu' );
});

$(".modifierSeance").click(function() {
    data = $(this).children("input").val().split("*");
    console.log($(this).children("input").val());
    $("#modifier_id").val(data[0]);
    date = data[1].split("/");
    $("#modifier_date").val(date[2]+"-"+date[1]+"-"+date[0]);
    $("#modier_debut_"+data[2]).prop('selected',true);
    $("#modifier_duree").val(data[3]);
    //$("#modifier_contenu").html(data[4]);
    CKEDITOR.instances['modifier_contenu'].setData(data[4]);
    $("#modifier_note").val(data[5]);
});

</script>
<?php $this->end(); ?>