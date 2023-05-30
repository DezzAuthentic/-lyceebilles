<?php
$jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
?>

<div class="titre">
    <span>Menus de la cantine</span>
</div>

<div class="row">
    <div class="col-xs-12"> 
        <div class="table-responsive">
            <table id="menus_table" class="menus_table table table-bordered" >
                <thead>
                    <tr>
                        <th class="edt_jour"></th>
                        <th class="edt_jour">Petit déjeuner</th>
                        <th class="edt_jour">Déjeuner</th>
                        <th class="edt_jour">Gouter</th>
                        <th class="edt_jour">Diner</th>
                    </tr>
                </thead>
                <tbody>            
                <?php foreach($jours as $i=>$jour):?>
                    <tr>
                        <th class="text-left"><?=$jour?></th>
                    <?php for($j=1;$j<=4;$j++):?>
                        <td>
                            <?php if(isset($menus[$jour][$j]["plat"]) or isset($menus[$jour][$j]["dessert"])):?>
                                <div class="menu-td">
                                <?php if(isset($menus[$jour][$j]["plat"])):?>
                                    <b>Plat: </b> <?=$menus[$jour][$j]["plat"]?><br>
                                <?php endif; if(isset($menus[$jour][$j]["dessert"])):?>
                                    <b>Dessert: </b> <?=$menus[$jour][$j]["dessert"]?>
                                <?php endif;?>
                                </div>
                            <?php endif;?>
                        </td>
                    <?php endfor;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

