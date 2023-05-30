<?php
$jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}
?>

<div class="titre">
    <span>Emploi du temps de la classe <?=$groupe->nom?></span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutSeanceModal">
        <span class="glyphicon glyphicon-calendar"></span> Ajouter une seance
    </a>
</div>

<div class="row">
    <div class="col-xs-12"> 
        <div class="table-responsive">
            <table id="cours_table" class="edt_table table table-bordered" >
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach($jours as $jour):?>
                            <th class="edt_jour" title="<?=$jour?>"><?=$jour?></th>    
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>            
                <?php foreach($heures as $heure):?>
                    <tr>
                        <?php if(($heure*2)%2==0):?>
                            <td class="edt_heure"><?=$heure?>H</td>
                        <?php else:?>
                            <td class="edt_heure"></td>
                        <?php endif;?>
                        <?php foreach($jours as $jour):?>
                            <td class="<?=$jour?>-<?=$heure?>"></td>    
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ajout seance-->
<div class="modal fade" id="AjoutSeanceModal" tabindex="-1" role="dialog" aria-labelledby="ajoutSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Edt', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutSeanceModalLabel">Ajouter une nouvelle séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Cours</label>
                <div class="col-sm-8">
                    <select name="cours_id" class="form-control" required>
                        <?php foreach($cours as $cour):?>
                            <option value="<?=$cour->id?>">  <?=$cour->matiere->nom?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Jour</label>
                <div class="col-sm-8">
                    <select name="jour" class="form-control" required>
                        <?php foreach($jours as $jour):?>
                            <option value="<?=$jour?>">  <?=$jour?></option>
                        <?php endforeach; ?>
                    </select>
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" >Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {

    <?php foreach($edts as $edt):?>
        $("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).html("<?=$edt->cour->matiere->nom?><br>Pr.<?=$edt->cour->professeur->nom.' '.$edt->cour->professeur->prenom?>").attr('rowspan',"<?=$edt->duree*2?>");
        btn = "<br><a class='btn btn-xs btn-danger' href='/academie/edt/supprimer/<?=$edt->id?>'><span class='glyphicon glyphicon-remove'></span></a>";
        $("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).append(btn);
        $("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).css('background-color',"lightblue");
        <?php for($f=0.5;$f<$edt->duree;$f+=0.5):?>
            $("."+$.escapeSelector("<?=$edt->jour.'-'.($edt->debut+$f)?>")).hide();
        <?php endfor;?>

    <?php endforeach;?>
    
});
</script>
<?php $this->end(); ?>