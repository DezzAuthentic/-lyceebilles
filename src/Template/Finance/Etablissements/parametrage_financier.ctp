
<ul class="nav nav-tabs">
    <li id="types_tmenu" class="tmenu"><a href="#">Types de frais</a></li>
    <!--li id="mois_tmenu" class="tmenu"><a href="#">Mois</a></li-->
    <li id="frais_tmenu" class="active tmenu"><a href="#">Frais</a></li>
</ul>


<!--********************************************************************************
Onglet des types
*********************************************************************************-->

<div id="types_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <button id="ajout_type_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#ajouterTypeModal">
            <span class="glyphicon glyphicon-pencil"></span> Ajouter un type
        </button>

        <form action="<?= $this->Url->Build(['controller' => 'Types', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="types_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Mensuel">Mensuel</th>
                    <th title="Obligatoire">Obligatoire</th>
                    <th title="Sélection">Sélection</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_types" name="select_all_types" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($types as $type): ?>
                <tr>
                    <td><?=$type->nom?></td>
                    <td><?php if($type->recurrence) echo "OUI"; else echo "NON";?></td>
                    <td><?php if($type->obligatoire) echo "OUI"; else echo "NON";?></td>
                    <td><?php if($type->selection==0) echo "Tous"; elseif($type->selection==1) echo "Un seul"; elseif($type->selection==2) echo "Multiple";?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editType hover" data-toggle="modal"
                        data-target="#editTypeModal" >
                            <input type="hidden" value="<?=$type->id.'*'.$type->nom.'*'.$type->recurrence.'*'.$type->obligatoire.'*'.$type->selection?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprType hover" data-toggle="modal"
                        data-target="#supprTypeModal">
                            <input type="hidden" value="<?=$type->id.'*'.$type->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$type->id?>" type="checkbox" class="select_type" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterTypeModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_types_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout type de frais-->
<div class="modal fade" id="ajouterTypeModal" tabindex="-1" role="dialog" aria-labelledby="ajouterTypeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Types', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterTypeModalLabel">Ajout d'un type de frais</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterTypeNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterTypeNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterTypeRecurrence" class="col-sm-4 col-form-label">Récurrence</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('recurrence',['1'=>'OUI','0'=>'NON'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"ajouterTypeRecurrence","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterTypeObligatoire" class="col-sm-4 col-form-label">Obligatoire</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('obligatoire',['1'=>'OUI','0'=>'NON'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"ajouterTypeObligatoire","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterTypeSelection" class="col-sm-4 col-form-label">Sélection</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('selection',['1'=>'Un seul','2'=>'Multiple','0'=>'Tous'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"ajouterTypeObligatoire","required"])?>
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

<!-- Modal édition type de frais-->
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-labelledby="editTypeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Types', 'action' => 'editer']) ?>" method="post">
        <input id="editTypeId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editTypeModalLabel">Edition du type de frais</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editTypeNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editTypeNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editTypeRecurrence" class="col-sm-4 col-form-label">Recurrence</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('recurrence',['1'=>'OUI','0'=>'NON'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"editTypeRecurrence","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editTypeObligatoire" class="col-sm-4 col-form-label">Obligatoire</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('obligatoire',['1'=>'OUI','0'=>'NON'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"editTypeObligatoire","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editTypeSelection" class="col-sm-4 col-form-label">Sélection</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('selection',['1'=>'Un seul','2'=>'Multiple','0'=>'Tous'],['class'=>'form-control',/*'empty'=>" ",*/"id"=>"editTypeSelection","required"])?>
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

<!-- Modal suppression type-->
<div class="modal fade" id="supprTypeModal" tabindex="-1" role="dialog" aria-labelledby="supprTypeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Types', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprTypeId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprTypeModalLabel">Supression du type : <span id="supprTypeNom"></span> <span id="supprTypeNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce type de frais?
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary">Oui</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!--********************************************************************************
Onglet des mois
*********************************************************************************-->

<div id="mois_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Mois', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="mois_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Ordre"></th>
                    <th title="Nom">Nom</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_mois" name="select_all_mois" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($mois as $moi): ?>
                <tr>
                    <td><?=$moi->ordre?></td>
                    <td><?=$moi->nom?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editMoi hover" data-toggle="modal"
                        data-target="#editMoiModal" >
                            <input type="hidden" value="<?=$moi->id.'*'.$moi->ordre.'*'.$moi->nom?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprMoi hover" data-toggle="modal"
                        data-target="#supprMoiModal">
                            <input type="hidden" value="<?=$moi->id.'*'.$moi->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$moi->id?>" type="checkbox" class="select_moi" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterMoiModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_mois_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout Moi-->
<div class="modal fade" id="ajouterMoiModal" tabindex="-1" role="dialog" aria-labelledby="ajouterMoiModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Mois', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterMoiModalLabel">Ajout d'un moi</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterMoiNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterMoiNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterMoiOrdre" class="col-sm-4 col-form-label">Ordre</label>
                <div class="col-sm-8">
                    <input type="text" name="ordre" class="form-control" id="ajouterMoiOrdre" required>
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

<!-- Modal édition Moi-->
<div class="modal fade" id="editMoiModal" tabindex="-1" role="dialog" aria-labelledby="editMoiModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Mois', 'action' => 'editer']) ?>" method="post">
        <input id="editMoiId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editMoiModalLabel">Edition du moi</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editMoiNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editMoiNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMoiNom" class="col-sm-4 col-form-label">Ordre</label>
                <div class="col-sm-8">
                    <input type="text" name="ordre" class="form-control" id="editMoiOrdre" required>
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

<!-- Modal suppression moi-->
<div class="modal fade" id="supprMoiModal" tabindex="-1" role="dialog" aria-labelledby="supprMoiModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Mois', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprMoiId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprMoiModalLabel">Supression du moi : <span id="supprMoiNom"></span> <span id="supprMoiNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce moi?
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary">Oui</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!--********************************************************************************
Onglet des frais
*********************************************************************************-->
<div id="frais_tab" class=" tab">
    <br>
    <section class="row">
        <div class="col-xs-12">
            <button id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutFraisModal">
                <span class="glyphicon glyphicon-pencil"></span> Ajouter un frais
            </button>
            <div class="row">
            <?php 
            $niveau_id=null;
            $serie_id=null;
            $serie="";
            $type_id = "";
            $i=0; foreach($frais as $frai):
                if(!empty($frai->series)){
                    $serie = ' - '.$frai->series->nom;
                }
                if($i==0){
                    $niveau_id = $frai->niveau_id;
                    $serie_id = $frai->serie_id;
                    $type_id = $frai->type_id;
                    echo '
                    <div class="col-xs-12"><button class="btn btn-default btn-md margin-tb bg-gris" data-toggle="collapse" data-target="#collapse_'.$frai->niveau_id.'_'.$frai->serie_id.'">
                        <span class="soustitre"><i class="glyphicon glyphicon-list icone"></i>'.$frai->niveaux->nom.$serie.'</span></button></div>
                    <div class="collapse" id="collapse_'.$frai->niveau_id.'_'.$frai->serie_id.'">
                    <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-default">
                    <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$frai->type->nom.'&nbsp;</span></div>
                    <table id="" class="table datatable2 compact hover" >
                        <thead>
                            <tr>
                                <th title="Frais">Frais</th>
                                <th title="Montant">Montant</th>
                                <th class="boutons" >
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    ';    
                }
                else{
                    if($niveau_id!=$frai->niveau_id or $serie_id!=$frai->serie_id){
                        echo '
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                        <div class="col-xs-12"><button class="btn btn-default btn-md margin-tb bg-gris" data-toggle="collapse" data-target="#collapse_'.$frai->niveau_id.'_'.$frai->serie_id.'">
                        <span class="soustitre"><i class="glyphicon glyphicon-list icone"></i>'.$frai->niveaux->nom.$serie.'</span></button></div>
                        <div class="collapse" id="collapse_'.$frai->niveau_id.'_'.$frai->serie_id.'">
                        <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-default">
                        <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$frai->type->nom.'&nbsp;</span></div>
                        <table id="" class="table datatable2 compact hover" >
                            <thead>
                                <tr>
                                    <th title="Frais">Frais</th>
                                    <th title="Montant">Montant</th>
                                    <th class="boutons" >
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                        ';
                    }elseif($type_id!=$frai->type_id){
                        echo '
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-default">
                        <div class="text-center panel-heading"><span class="soustitre2">&nbsp;'.$frai->type->nom.'&nbsp;</span></div>
                        <table id="" class="table datatable2 compact hover" >
                            <thead>
                                <tr>
                                    <th title="Frais">Frais</th>
                                    <th title="Montant">Montant</th>
                                    <th class="boutons" >
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                        ';
                    }
                }
                echo '
                <tr>
                    <td>'.$frai->nom.'</td>
                    <td>'.$frai->montant.'</td>
                    <td class="" style="max-width:50px;">
                        <span class="icone glyphicon glyphicon-pencil editFrais hover" data-toggle="modal" data-target="#editFraisModal" >
                            <input type="hidden" value="'.$frai->id.'*'.$frai->niveau_id.'*'.$frai->serie_id.'*'.$frai->type_id.'*'.$frai->nom.'*'.$frai->montant.'">
                        </span>
                        '.$this->Form->postLink(__('<span class="icone glyphicon glyphicon-remove supprFrai hover"></span>'), ["controller"=>"Frais","action" => "supprimer"],['escape'=>false,"data"=>["id"=>$frai->id]]).'
                    </td>
                </tr>
                ';
                $niveau_id = $frai->niveau_id;
                $serie_id = $frai->serie_id;
                $type_id = $frai->type_id;
            $i++; endforeach;
            ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
            
            </div>
        </div>
    </section>

    <!-- Modal Ajout Frais-->
    <div class="modal fade" id="AjoutFraisModal" tabindex="-1" role="dialog" aria-labelledby="ajoutFraisModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Frais', 'action' => 'ajouter']) ?>" method="post">
            <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="AjoutFraisModalLabel">Ajouter un nouveau frais</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row ">
                    <label for="niveau_id" class="col-sm-5">Niveau</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"niveau_select"])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="serie_id" class="col-sm-5">Serie</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('serie_id',$series,['class'=>'form-control',"empty"=>" ","id"=>"serie_select"])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="matiere_id" class="col-sm-5">Type</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('type_id',$liste_types,['class'=>'form-control'])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="nom" class="col-sm-5">Nom</label>
                    <div class="col-sm-7">
                        <input required type="text" name="nom" class="form-control" id="nom">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="montant" class="col-sm-5">Montant</label>
                    <div class="col-sm-7">
                        <input required type="number" name="montant" class="form-control" id="montant" min="1">
                    </div>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="dupliquer" value="1" id="dupliquer">Dupliquer le frais sur toutes les promotions</label>
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

    <!-- Modal édition Frais-->
    <div class="modal fade" id="editFraisModal" tabindex="-1" role="dialog" aria-labelledby="editFraisModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Frais', 'action' => 'editer']) ?>" method="post">
            <input id="edit_frais_id" type="hidden" name="id" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editFraisModalLabel">Modification du frais</h4>
            </div>
            <div class="modal-body">
            <div class="form-group row ">
                    <label for="niveau_id" class="col-sm-5">Niveau</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"edit_niveau_select","required"])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="serie_id" class="col-sm-5">Serie</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('serie_id',$series,['class'=>'form-control',"empty"=>" ","id"=>"edit_serie_select"])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="type_id" class="col-sm-5">Type</label>
                    <div class="col-sm-7">
                        <?=$this->Form->select('type_id',$liste_types,['class'=>'form-control',"id"=>"edit_type_select","required"])?>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="nom" class="col-sm-5">Nom</label>
                    <div class="col-sm-7">
                        <input required type="text" name="nom" class="form-control" id="edit_nom">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="montant" class="col-sm-5">Montant</label>
                    <div class="col-sm-7">
                        <input required type="number" name="montant" class="form-control" id="edit_montant" min="1">
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
</div>


<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $(".tab").hide();
        $("#frais_tab").show();  
        console.log('ouverture tab types'); 
        $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page",
                "zeroRecords": "Pas d'enregistrement trouvé",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Pas d'enregistrement disponible",
                "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
                "search":         "Recherche",
                "scrollX": true,
                "paginate": {
                    "first":      "<<",
                    "last":       ">>",
                    "next":       ">",
                    "previous":   "<"
                }
            }/*,
            "columnDefs": [ {
                "targets": 4,
                "orderable": false
                },{
                "targets": 5,
                "orderable": false
                }
            ]*/
        });    

        $('.datatable2').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });

    });

    // gérer l'affichage des tab
    $(".tmenu").click(function() {
        $(".tab").hide();
        id = $(this).attr('id');
        suffixe = id.split('_')[0];
        $("#"+suffixe+"_tab").show();       
        console.log('ouverture tab');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    /*****************************************************
    * Gestion des Types
    *******************************************************/
 
    $(".editType").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editType input").val());
        $("#editTypeId").val(data[0]);
        $("#editTypeNom").val(data[1]);
        $("#editTypeRecurrence").val(data[2]);
        $("#editTypeObligatoire").val(data[3]);
        $("#editTypeSelection").val(data[4]);
    });
    $(".supprType").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprType input").val());
        $("#supprTypeId").val(data[0]);
        $("#supprTypeNom").html(data[1]);
    });

    $("#select_all_types").click(function() {
        if ($(this).prop("checked")){
            $(".select_type").prop("checked","checked");
            console.log("Sélection de tous les types");
        }else{
            $(".select_type").prop("checked",null);
            console.log("déselection de tous les types");
        }
    });
    $(".select_type_action").click(function() {
        if (!$("input[class='select_type']:checked").val()) {
            alert("Vous n'avez sélectionné aucun type.");
            $("form").submit(function(e){
                e.preventDefault();
            });
        }else{
            var r = confirm("Confirmez-vous cette action en masse?");
            if(r==true){
                $("form").submit(function(e){
                    $(this).unbind('submit').submit();
                });
            }else{
                $("form").submit(function(e){
                    e.preventDefault();
                });
                $(".select_type").prop("checked",null);
            }
        }
    });

    /*****************************************************
    * Gestion des Mois
    *******************************************************/

    $(".editMoi").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editMoi input").val());
        $("#editMoiId").val(data[0]);
        $("#editMoiNom").val(data[2]);
        $("#editMoiOrdre").val(data[1]);
    });
    $(".supprMoi").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprMoi input").val());
        $("#supprMoiId").val(data[0]);
        $("#supprMoiNom").html(data[1]);
    });

    $("#select_all_mois").click(function() {
        if ($(this).prop("checked")){
            $(".select_moi").prop("checked","checked");
            console.log("Sélection de tous les mois");
        }else{
            $(".select_moi").prop("checked",null);
            console.log("déselection de tous les mois");
        }
    });
    $(".select_mois_action").click(function() {
        if (!$("input[class='select_moi']:checked").val()) {
            alert("Vous n'avez sélectionné aucun moi.");
            $("form").submit(function(e){
                e.preventDefault();
            });
        }else{
            var r = confirm("Confirmez-vous cette action en masse?");
            if(r==true){
                $("form").submit(function(e){
                    $(this).unbind('submit').submit();
                });
            }else{
                $("form").submit(function(e){
                    e.preventDefault();
                });
                $(".select_moi").prop("checked",null);
            }
        }
    });
    
    $(".editFrais").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editFrais input").val());
        $("#edit_frais_id").val(data[0]);
        $("#edit_niveau_select").val(data[1]);
        $("#edit_serie_select").val(data[2]);
        $("#edit_type_select").val(data[3]);
        $("#edit_nom").val(data[4]);
        $("#edit_montant").val(data[5]);
    });
    
</script>
<?php $this->end(); ?>