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