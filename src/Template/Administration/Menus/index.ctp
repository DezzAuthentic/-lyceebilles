<?php
$jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}
?>

<div class="titre">
    <span>Menus de la cantine</span>
    <a id="modif_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#modifMenuModal">
        <span class="glyphicon glyphicon-calendar"></span> Modifier
    </a>
    <a type="button" class="btn btn-default pull-right btn-sm mr1" href="<?=$this->Url->Build(['controller'=>'Menus','action'=>'liste'])?>">Plats et desserts</a>
    <a type="button" class="btn btn-default pull-right btn-sm mr1" href="<?=$this->Url->Build(['controller'=>'Menus','action'=>'init'])?>" onclick="return confirm('Voulez-vous réinitialiser tout le menu?')">Réinitialiser</a>
</div>

<div class="row">
    <div class="col-xs-12"> 
        <div class="soustitre">Modèle 1</div>
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
                <?php $check = 0; foreach($jours as $i=>$jour):?>
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
                    <?php 
                        if(isset($menus[$jour][$j]["status"])) $check = ($check OR $menus[$jour][$j]["status"]);
                        endfor;
                    ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr >
                        <th></th>
                        <th colspan="3" class="text-center">
                            <?php if($check):?>
                                <span class="text-success">Menu en vigueur actuellement</span>
                            <?php else:?>
                                <span class="text-danger">Menu non choisi</span>
                            <?php endif;?>
                        </th>
                        <th class="text-center">
                            <?php if(!$check):?>
                                <a type="button" class="btn btn-default btn-xs" href="<?=$this->Url->Build(['controller'=>'Menus','action'=>'choisirModele',1])?>">Choisir</a>
                            <?php endif;?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="col-xs-12"> 
        <div class="soustitre">Modèle 2</div>
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
                <?php $check = 0; foreach($jours as $i=>$jour):?>
                    <tr>
                        <th class="text-left"><?=$jour?></th>
                    <?php for($j=1;$j<=4;$j++):?>
                        <td>
                            <?php if(isset($menus2[$jour][$j]["plat"]) or isset($menus2[$jour][$j]["dessert"])):?>
                                <div class="menu-td">
                                <?php if(isset($menus2[$jour][$j]["plat"])):?>
                                    <b>Plat: </b> <?=$menus2[$jour][$j]["plat"]?><br>
                                <?php endif; if(isset($menus2[$jour][$j]["dessert"])):?>
                                    <b>Dessert: </b> <?=$menus2[$jour][$j]["dessert"]?>
                                <?php endif;?>
                                </div>
                            <?php endif;?>
                        </td>
                    <?php 
                        if(isset($menus2[$jour][$j]["status"])) $check = ($check OR $menus2[$jour][$j]["status"]);
                        endfor;
                    ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr >
                        <th></th>
                        <th colspan="3" class="text-center">
                            <?php if($check):?>
                                <span class="text-success">Menu en vigueur actuellement</span>
                            <?php else:?>
                                <span class="text-danger">Menu non choisi</span>
                            <?php endif;?>
                        </th>
                        <th class="text-center">
                            <?php if(!$check):?>
                                <a type="button" class="btn btn-default btn-xs" href="<?=$this->Url->Build(['controller'=>'Menus','action'=>'choisirModele',2])?>">Choisir</a>
                            <?php endif;?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Modif Menu-->
<div class="modal fade" id="modifMenuModal" tabindex="-1" role="dialog" aria-labelledby="modifMenuModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Menus', 'action' => 'editer']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modifMenuModalLabel">Edition du menu</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editMenuModele" class="col-sm-3 col-form-label">Modèle</label>
                <div class="col-sm-9">
                    <select name="template_id" id="editMenuModele" class="form-control">
                            <option value="1">Modèle 1</option>
                            <option value="2">Modèle 2</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMenuJour" class="col-sm-3 col-form-label">Jour</label>
                <div class="col-sm-9">
                    <select name="jour" id="editMenuJour" class="form-control">
                        <?php foreach($jours as $jour): ?>
                            <option value="<?=$jour?>"><?=$jour?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMenuType" class="col-sm-3 col-form-label">Type</label>
                <div class="col-sm-9">
                    <select name="type" id="editMenuType" class="form-control">
                            <option value="1">Petit déjeuner</option>
                            <option value="2">Déjeuner</option>
                            <option value="3">Gouter</option>
                            <option value="4">Diner</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMenuPlat" class="col-sm-3 col-form-label">Plat</label>
                <div class="col-sm-9">
                    <?= $this->Form->select("plat_id",$plats,['id'=>'editMenuPlat','empty'=>true])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMenuDessert" class="col-sm-3 col-form-label">Dessert</label>
                <div class="col-sm-9">
                    <?= $this->Form->select("dessert_id",$desserts,['id'=>'editMenuDessert','empty'=>true])?>
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


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    
});
</script>
<?php $this->end(); ?>