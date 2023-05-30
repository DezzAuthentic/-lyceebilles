<?php
$jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}
?>

<div class="titre">
    <span>Archives: Emploi du temps de la classe <?=$groupe->nom?></span>
    <span class="pull-right">Année: <?=$annee->nom?></span>
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


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {

    <?php foreach($edts as $edt):?>
        $("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).html("<?=$edt->cour->matiere->nom?><br>Pr.<?=$edt->cour->professeur->nom.' '.$edt->cour->professeur->prenom?>").attr('rowspan',"<?=$edt->duree*2?>");
        //btn = "<br><a class='btn btn-xs btn-danger' href='/academie/edt/supprimer/<?=$edt->id?>'><span class='glyphicon glyphicon-remove'></span></a>";
        //$("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).append(btn);
        $("."+$.escapeSelector("<?=$edt->jour.'-'.$edt->debut?>")).css('background-color',"lightblue");
        <?php for($f=0.5;$f<$edt->duree;$f+=0.5):?>
            $("."+$.escapeSelector("<?=$edt->jour.'-'.($edt->debut+$f)?>")).hide();
        <?php endfor;?>

    <?php endforeach;?>
    
});
</script>
<?php $this->end(); ?>