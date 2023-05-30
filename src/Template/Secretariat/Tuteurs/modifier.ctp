<div class="titre">
    <span>Tuteur: <?=$tuteur->prenom?> <?=$tuteur->nom?>
</div>

<div class="row">
    <div id="profil" class="col-xs-12 col-md-6">
        <a href="#" class="thumbnail">
            <button type="button" class="btn btn-default logo-btn" data-toggle="modal" data-target="#logoModal">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <?php if(!empty($tuteur->photo)):?>
                <img class="logo" style='height:245px;border-radius:5px;' src="<?= $tuteur->photo?>">
            <?php 
            else:
                echo $this->Html->image('profil_default.png', ['alt' => 'photo de profil','class'=>"logo",'style'=>"height:245px;border-radius:5px;"]);
            endif;
            ?>
        </a>
        <div class="panel panel-default magintop-10">
            <div class="panel-heading">
                <div class="text-center">
                    <span class="titre"><?=$tuteur->prenom?> <?=$tuteur->nom?></span><br>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->create($tuteur,['url'=>['controller'=>'Tuteurs','action'=>'modifier',$tuteur->id]])?>
    <div id="details" class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="prenom">Prénom:</label>
                        <div class="col-sm-7">
                            <input type="text" name="prenom" value="<?=$tuteur->prenom?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="prenom">Nom:</label>
                        <div class="col-sm-7">
                            <input type="text" name="nom" value="<?=$tuteur->nom?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="date_naissance">Date de Naissance:</label>
                        <div class="col-sm-7">
                            <input type="date" name="date_naissance" value="<?php if ($tuteur->date_naissance) echo $tuteur->date_naissance->format("Y-m-d");?>" class="form-control" style='line-height:15px;'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="telephone">Téléphone:</label>
                        <div class="col-sm-7">
                            <input type="tel" name="telephone" value="<?=$tuteur->telephone?>" class="form-control" placeholder="00221750000000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="adresse">Domicile:</label>
                        <div class="col-sm-7">
                            <textarea type="text" name="adresse" rows="2" value="" class="form-control"><?=$tuteur->adresse?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="religion">Situation matrimoniale:</label>
                        <div class="col-sm-7">
                            <select name="situation_matrimoniale" value="<?=$tuteur->situation_matrimoniale?>" class="form-control">
                                <option value="Célibataire" <?php if($tuteur->situation_matrimoniale == 'Célibataire') echo 'selected';?>>Célibataire</option>
                                <option value="Marié" <?php if($tuteur->situation_matrimoniale == 'Marié') echo 'selected';?>>Marié(e)</option>
                                <option value="Divorcé" <?php if($tuteur->situation_matrimoniale == 'Divorcé') echo 'selected';?>>Divorcé(e)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="entreprise">Entreprise:</label>
                        <div class="col-sm-7">
                            <input type="text" name="entreprise" value="<?=$tuteur->entreprise?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="fonction">Fonction:</label>
                        <div class="col-sm-7">
                            <input type="text" name="fonction" value="<?=$tuteur->fonction?>" class="form-control">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    <div class="col-xs-12 text-center">
        <a class="btn btn-lg btn-default" href="<?=$this->Url->Build(["controller"=>"Tuteurs","action"=>"fiche",$tuteur->id])?>" style="width:150px;">Annuler</a>
        <button class="btn btn-lg btn-default" type="submit" style="width:150px;">Valider</button>
    </div>
    <?=$this->Form->end()?>

    
</div>

<!-- Modal photo-->
<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'editer_photo']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$tuteur->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="logoModalLabel">Chargement de la photo</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="tuteurs_acces_check" class="col-sm-2 col-xs-12">Photo</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="file" name="image" id="photo">
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
