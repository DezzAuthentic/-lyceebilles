<div class="titre">
    <span>Elève: <?=$eleve->prenom?> <?=$eleve->nom?> - <?=$eleve->matricule?></span>
</div>

<div class="row">
    <div id="profil" class="col-xs-12 col-md-6">
        <a href="#" class="thumbnail">
            <button type="button" class="btn btn-default logo-btn" data-toggle="modal" data-target="#logoModal">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <?php if(!empty($eleve->photo)):?>
                <img class="logo" style='height:325px;border-radius:5px;' src="<?= $eleve->photo?>">
            <?php 
            else:
                echo $this->Html->image('profil_default.png', ['alt' => 'photo de profil','class'=>"logo",'style'=>"height:325px;border-radius:5px;"]);
            endif;
            ?>
        </a>
        <div class="panel panel-default magintop-10">
            <div class="panel-heading">
                <div class="text-center">
                    <span class="titre"><?=$eleve->prenom?> <?=$eleve->nom?></span><br>
                    <span class="soustitre"><?=$eleve->matricule?></span>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->create($eleve,['url'=>['controller'=>'Eleves','action'=>'modifier',$eleve->id]])?>
    <div id="details" class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="prenom">Prénom:</label>
                        <div class="col-sm-7">
                            <input type="text" name="prenom" value="<?=$eleve->prenom?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="prenom">Nom:</label>
                        <div class="col-sm-7">
                            <input type="text" name="nom" value="<?=$eleve->nom?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="genre">Genre:</label>
                        <div class="col-sm-7">
                            <select name="genre" class="form-control">
                                <option value="f" <?php if($eleve->genre=='f') echo "selected"?>>Fille</option>
                                <option value="g" <?php if($eleve->genre=='g') echo "selected"?>>Garçon</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="date_naissance">Date de Naissance:</label>
                        <div class="col-sm-7">
                            <input type="date" name="date_naissance" value="<?php if ($eleve->date_naissance) echo $eleve->date_naissance->format("Y-m-d");?>" class="form-control" style='line-height:15px;'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="lieu">Lieu de Naissance:</label>
                        <div class="col-sm-7">
                            <input type="text" name="lieu_naissance" value="<?=$eleve->lieu_naissance?>" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="telephone">Téléphone:</label>
                        <div class="col-sm-7">
                            <input type="tel" name="telephone" value="<?=$eleve->telephone?>" class="form-control" placeholder="00221750000000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="adresse">Domicile:</label>
                        <div class="col-sm-7">
                            <textarea type="text" name="adresse" rows="2" value="" class="form-control"><?=$eleve->adresse?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="religion">Religion:</label>
                        <div class="col-sm-7">
                            <select name="religion" value="<?=$eleve->religion?>" class="form-control">
                                <option value="Musulman" <?php if($eleve->religion=='Musulman') echo "selected"?>>Musulman</option>
                                <option value="Chrétien" <?php if($eleve->religion=='Chrétien') echo "selected"?>>Chrétien</option>
                                <option value="Autre" <?php if($eleve->religion=='Autre') echo "selected"?>>Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="cours_religion">Cours de religion:</label>
                        <div class="col-sm-7">
                            <select name="cours_religion" value="<?=$eleve->cours_religion?>" class="form-control">
                                <option value="0">Non</option>
                                <option value="1">Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="pere">Père:</label>
                        <div class="col-sm-7">
                            <input type="text" name="pere" value="<?=$eleve->pere?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="mere">Mère:</label>
                        <div class="col-sm-7">
                            <input type="text" name="mere" value="<?=$eleve->mere?>" class="form-control">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    <div class="col-xs-12 text-center">
        <a class="btn btn-lg btn-default" href="<?=$this->Url->Build(["controller"=>"Eleves","action"=>"fiche",$eleve->id])?>" style="width:150px;">Annuler</a>
        <button class="btn btn-lg btn-default" type="submit" style="width:150px;">Valider</button>
    </div>
    <?=$this->Form->end()?>

    
</div>

<!-- Modal photo-->
<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Eleves', 'action' => 'editer_photo']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$eleve->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="logoModalLabel">Chargement de la photo</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="eleves_acces_check" class="col-sm-2 col-xs-12">Photo</label>
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
