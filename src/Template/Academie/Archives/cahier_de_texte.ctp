<div class="titre">
    <span class="text-primary">Année: <?=$cours->groupe->promotion->annee->nom?></span> <span>Cahier de texte du cours: <?=$cours->matiere->nom?></span>
    <a class="btn btn-sm btn-default" href="<?=$this->Url->build(['action'=>'groupe',$cours->groupe->id])?>"><?=$cours->groupe->nom?></a>
</div>

<div class="row">
    <div class="col-xs-12">
        <ul class="timeline">
            <?php foreach($cours->seances as $seance):?>
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
                        <div class="panel-heading">Contenu de la séance</div>
                        <div class="panel-body"><?=$seance->contenu?></div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

<?php
$this->Html->css([
    "timeline.css",
],
['block' => 'css']);
?>