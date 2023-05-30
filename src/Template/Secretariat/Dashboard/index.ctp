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
    <div class="col-xs-12 col-md-6 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= sizeof($promotions) ?></span> promotions
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $classes ?></span> classes
            </div>
        </div>
    </div>
    <!--div class="col-xs-12 col-sm-4 col-md-4 text-center">
        <div class="panel panel-default">
            <div class="panel-heading panel-stats" >
                <span class="panel-chiffres"><?= $eleves ?></span> élèves
            </div>
        </div>
    </div-->

    <div class="col-xs-12 col-md-4 text-center">
        <div class="text-center titre-stats text-primary">Effectif total</div>
        <?php $effectif=0; foreach($promotions as $promotion){
            $effectif += sizeof($promotion->inscriptions);
        }
        ?>
        <span class="stats"><?=$effectif?></span> élève(s)
    </div>
    <div class="col-xs-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                Effectifs
            </div>
            <table id="abonnements_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Effectif</th>
                    <?php foreach($types as $type):?>
                        <th title="<?=$type->nom?>"><?=$type->nom?></th>
                    <?php endforeach;?>
                        <th>Abandons</th>
                    </tr>
                </thead>
                <tbody>            
                <?php $abandons=0; foreach($promotions as $k => $promotion): ?>
                    <tr>
                        <th><?=$promotion->nom?></th>
                        <td><?=sizeof($promotion->inscriptions)?></td>
                    <?php foreach($types as $type):?>
                        <?php
                            $nombre=0;
                            foreach($promotion->inscriptions as $inscription){
                                foreach($inscription->engagements as $engagement){
                                    if($engagement->frai->type_id == $type->id) $nombre++;
                                }
                            }
                            $type->total += $nombre;
                        ?>
                        <td><?=$nombre?></td>
                    <?php endforeach;?>
                        <td><?=sizeof($promotions_abandons[$k]->inscriptions)?></td>
                    </tr>
                <?php $abandons+=sizeof($promotions_abandons[$k]->inscriptions); endforeach;?>
                <tr>
                    <th>Total</th>
                    <td><?=$effectif?></td>
                    <?php foreach($types as $type):?>
                        <td><?=$type->total?></td>
                    <?php endforeach;?>
                    <td><?=$abandons?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>