<?php
    $classes=0;
    $eleves=0;
    foreach($promotions as $promotion){
        $classes += sizeof($promotion->groupes);
        $eleves += sizeof($promotion->inscriptions);
    }
?>

<div class="titre">
    Tableau de bord
</div>

<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $promotions->count() ?></span> promotions
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $classes ?></span> classes
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $eleves ?></span> élèves
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $ventes_attente->count() ?></span> ventes en attente
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $ventes_nonsoldees->count() ?></span> ventes non soldées
            </div>
        </div>
    </div>
</div>