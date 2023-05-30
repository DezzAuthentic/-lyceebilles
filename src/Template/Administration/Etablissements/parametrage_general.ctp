<?php
//dd($etablissement);
?>

<ul class="nav nav-tabs">
    <li id="niveaux_tmenu" class="active tmenu"><a href="#">Niveaux</a></li>
    <li id="series_tmenu" class="tmenu"><a href="#">Series</a></li>
    <!--li id="salles_tmenu" class="tmenu"><a href="#">Salles</a></li-->
    <li id="matieres_tmenu" class="tmenu"><a href="#">Matières</a></li>
    <!--li id="promotions_tmenu" class="tmenu"><a href="#">Promotions</a></li-->
    
    <a href="<?=$this->Url->build(['controller'=>'Annees','action'=>'configuration'])?>" class="btn btn-default pull-right btn-sm mt1
        <span class="glyphicon glyphicon-log-in pr1"></span> Paramétrage des années
    </a>
    <a href="<?=$this->Url->build(['controller'=>'Coefficients','action'=>'configuration'])?>" class="btn btn-default pull-right btn-sm mt1 mr1
        <span class="glyphicon glyphicon-log-in pr1"></span> Paramétrage des coefficients
    </a>
</ul>


<!--********************************************************************************
Onglet des niveaux
*********************************************************************************-->

<div id="niveaux_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Niveaux', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="niveaux_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Ordre"></th>
                    <th title="Nom">Nom</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_niveaux" name="select_all_niveaux" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($niveaux as $niveau): ?>
                <tr>
                    <td><?=$niveau->ordre?></td>
                    <td><?=$niveau->nom?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editNiveau hover" data-toggle="modal"
                        data-target="#editNiveauModal" >
                            <input type="hidden" value="<?=$niveau->id.'*'.$niveau->ordre.'*'.$niveau->nom?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprNiveau hover" data-toggle="modal"
                        data-target="#supprNiveauModal">
                            <input type="hidden" value="<?=$niveau->id.'*'.$niveau->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$niveau->id?>" type="checkbox" class="select_niveau" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterNiveauModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_niveaux_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout Niveau-->
<div class="modal fade" id="ajouterNiveauModal" tabindex="-1" role="dialog" aria-labelledby="ajouterNiveauModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Niveaux', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterNiveauModalLabel">Ajout d'un niveau</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterNiveauNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterNiveauNom" class="form-control" placeholder="Ex: SIXIEME" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterNiveauOrdre" class="col-sm-4 col-form-label">Ordre</label>
                <div class="col-sm-8">
                    <input type="number" min="1" placeholder='<?=$niveaux->count()+1?>' name="ordre" class="form-control" id="ajouterNiveauOrdre" required>
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

<!-- Modal édition Niveau-->
<div class="modal fade" id="editNiveauModal" tabindex="-1" role="dialog" aria-labelledby="editNiveauModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Niveaux', 'action' => 'editer']) ?>" method="post">
        <input id="editNiveauId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editNiveauModalLabel">Edition du niveau</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editNiveauNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editNiveauNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editNiveauNom" class="col-sm-4 col-form-label">Ordre</label>
                <div class="col-sm-8">
                    <input type="text" name="ordre" class="form-control" id="editNiveauOrdre" required>
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

<!-- Modal suppression niveau-->
<div class="modal fade" id="supprNiveauModal" tabindex="-1" role="dialog" aria-labelledby="supprNiveauModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Niveaux', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprNiveauId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprNiveauModalLabel">Supression du niveau : <span id="supprNiveauNom"></span> <span id="supprNiveauNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer ce niveau?
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
Onglet des series
*********************************************************************************-->

<div id="series_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Series', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="series_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Description">Description</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_series" name="select_all_series" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($series as $serie): ?>
                <tr>
                    <td><?=$serie->nom?></td>
                    <td><?=$serie->description?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editSerie hover" data-toggle="modal"
                        data-target="#editSerieModal" >
                            <input type="hidden" value="<?=$serie->id.'*'.$serie->nom.'*'.$serie->description?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprSerie hover" data-toggle="modal"
                        data-target="#supprSerieModal">
                            <input type="hidden" value="<?=$serie->id.'*'.$serie->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$serie->id?>" type="checkbox" class="select_serie" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterSerieModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_series_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout Serie-->
<div class="modal fade" id="ajouterSerieModal" tabindex="-1" role="dialog" aria-labelledby="ajouterSerieModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Series', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterSerieModalLabel">Ajout d'une série</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterSerieNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterSerieNom" class="form-control" placeholder='Ex: S1' required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterSerieDescription" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea rows="4" name="description" class="form-control" id="ajouterSerieDescription" required></textarea>
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

<!-- Modal édition Serie-->
<div class="modal fade" id="editSerieModal" tabindex="-1" role="dialog" aria-labelledby="editSerieModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Series', 'action' => 'editer']) ?>" method="post">
        <input id="editSerieId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editSerieModalLabel">Edition de la série</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editSerieNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editSerieNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editSerieDescription" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" class="form-control" id="editSerieDescription" required></textarea>
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

<!-- Modal suppression serie-->
<div class="modal fade" id="supprSerieModal" tabindex="-1" role="dialog" aria-labelledby="supprSerieModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Series', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprSerieId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprSerieModalLabel">Supression de la série : <span id="supprSerieNom"></span> <span id="supprSerieNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cette série?
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
Onglet des salles
*********************************************************************************-->

<div id="salles_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Salles', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="salles_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Pavillon">Pavillon</th>
                    <th title="Etage">Etage</th>
                    <th title="Capacité">Capacité</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_salles" name="select_all_salles" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($salles as $salle): ?>
                <tr>
                    <td><?=$salle->nom?></td>
                    <td><?=$salle->pavillon?></td>
                    <td><?=$salle->etage?></td>
                    <td><?=$salle->capacite?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editSalle hover" data-toggle="modal"
                        data-target="#editSalleModal" >
                            <input type="hidden" value="<?=$salle->id.'*'.$salle->nom.'*'.$salle->pavillon.'*'.$salle->etage.'*'.$salle->capacite?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprSalle hover" data-toggle="modal"
                        data-target="#supprSalleModal">
                            <input type="hidden" value="<?=$salle->id.'*'.$salle->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$salle->id?>" type="checkbox" class="select_salle" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterSalleModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_Salles_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout Salle-->
<div class="modal fade" id="ajouterSalleModal" tabindex="-1" role="dialog" aria-labelledby="ajouterSalleModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Salles', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterSalleModalLabel">Ajout d'une série</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterSalleNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterSalleNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterSallePavillon" class="col-sm-4 col-form-label">Pavillon</label>
                <div class="col-sm-8">
                    <input type="text" name="pavillon" class="form-control" id="ajouterSallePavillon" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterSalleEtage" class="col-sm-4 col-form-label">Etage</label>
                <div class="col-sm-8">
                    <input type="text" name="etage" class="form-control" id="ajouterSalleEtage" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterSalleCapacite" class="col-sm-4 col-form-label">Capacité</label>
                <div class="col-sm-8">
                    <input type="number" name="capacite" class="form-control" id="ajouterSalleCapacite" required>
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

<!-- Modal édition Salle-->
<div class="modal fade" id="editSalleModal" tabindex="-1" role="dialog" aria-labelledby="editSalleModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Salles', 'action' => 'editer']) ?>" method="post">
        <input id="editSalleId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editSalleModalLabel">Edition de la série</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editSalleNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editSalleNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editSallePavillon" class="col-sm-4 col-form-label">Pavillon</label>
                <div class="col-sm-8">
                    <input type="textarea" name="pavillon" class="form-control" id="editSallePavillon" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editSalleEtage" class="col-sm-4 col-form-label">Etage</label>
                <div class="col-sm-8">
                    <input type="textarea" name="Etage" class="form-control" id="editSalleEtage" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editSalleCapacite" class="col-sm-4 col-form-label">Capacite</label>
                <div class="col-sm-8">
                    <input type="textarea" name="capacite" class="form-control" id="editSalleCapacite" required>
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

<!-- Modal suppression Salle-->
<div class="modal fade" id="supprSalleModal" tabindex="-1" role="dialog" aria-labelledby="supprSalleModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Salles', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprSalleId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprSalleModalLabel">Supression de la série : <span id="supprSalleNom"></span> <span id="supprSalleNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cette série?
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
Onglet des matieres
*********************************************************************************-->

<div id="matieres_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Matieres', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="matieres_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Description">Description</th>
                    <th class="actions" >   
                    </th>
                    <th class="select_col"><input id="select_all_matieres" name="select_all_matieres" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($matieres as $matiere): ?>
                <tr>
                    <td><?=$matiere->nom?></td>
                    <td><?=$matiere->description?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editMatiere hover" data-toggle="modal"
                        data-target="#editMatiereModal" >
                            <input type="hidden" value="<?=$matiere->id.'*'.$matiere->nom.'*'.$matiere->description?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprMatiere hover" data-toggle="modal"
                        data-target="#supprMatiereModal">
                            <input type="hidden" value="<?=$matiere->id.'*'.$matiere->nom?>">
                        </span>
                    </td>
                    <td class="text-center"><input name="select[<?=$i?>]" value="<?=$matiere->id?>" type="checkbox" class="select_matiere" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterMatiereModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_matieres_action"><span class="icone glyphicon glyphicon-remove hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal ajout matiere-->
<div class="modal fade" id="ajouterMatiereModal" tabindex="-1" role="dialog" aria-labelledby="ajouterMatiereModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Matieres', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterMatiereModalLabel">Ajout d'une matière</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterMatiereNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="ajouterMatiereNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterMatiereDescription" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea rows="4" name="description" class="form-control" id="ajouterMatiereDescription" required></textarea>
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

<!-- Modal édition Matiere-->
<div class="modal fade" id="editMatiereModal" tabindex="-1" role="dialog" aria-labelledby="editMatiereModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Matieres', 'action' => 'editer']) ?>" method="post">
        <input id="editMatiereId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editMatiereModalLabel">Edition de la matière</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editMatiereNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" id="editMatiereNom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editMatiereDescription" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" class="form-control" id="editMatiereDescription" required></textarea>
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

<!-- Modal suppression Matiere-->
<div class="modal fade" id="supprMatiereModal" tabindex="-1" role="dialog" aria-labelledby="supprMatiereModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Matieres', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprMatiereId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprMatiereModalLabel">Supression de la matière : <span id="supprMatiereNom"></span> <span id="supprMatiereNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cette série?
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
Onglet des promotions
*********************************************************************************-->
<section id="promotions_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'actionEnMasse']) ?>" method="post">        
            <table id="promotions_table" class="table datatable hover" >
                <thead>
                    <tr>
                        <th title="Nom">Nom</th>
                        <th class="actions" >                            
                        </th>
                        <th class="select_col"><input id="select_all_promotions" name="select_all_promotions" type="checkbox" ></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($promotions as $promotion): ?>
                    <tr>
                        <td><?=$promotion->nom?></td>
                        <td class="actions">
                            <span class="icone glyphicon glyphicon-pencil editPromotion hover" data-toggle="modal"
                            data-target="#editPromotionModal" >
                                <input type="hidden" value="<?=$promotion->id.'*'.$promotion->niveau_id.'*'.$promotion->serie_id.'*'.$promotion->nom?>">
                            </span>
                            <span class="icone glyphicon glyphicon-remove supprPromotion hover" data-toggle="modal"
                            data-target="#supprPromotionModal">
                                <input type="hidden" value="<?=$promotion->id.'*'.$promotion->nom?>">
                            </span>
                        </td>
                        <td class="text-center"><input name="select[<?=$i?>]" value="<?=$promotion->id?>" type="checkbox" class="select_promotion" ></td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
            <br>
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterPromotionModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                    <button name="action" value="supprimer" type="submit" class="btn btn-default select_promotions_action"><span class="icone glyphicon glyphicon-remove hover"></button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Modal ajout Promotion-->
<div class="modal fade" id="ajouterPromotionModal" tabindex="-1" role="dialog" aria-labelledby="ajouterPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="annee_id" value="<?=$etablissement->annee_id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterPromotionModalLabel">Ajout d'une promotion</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterPromotionNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="ajouterPromotionNom" required readonly >
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionNiveau" class="col-sm-4 col-form-label">Niveau</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('niveau_id',$list_niveaux,['class'=>'form-control',"id"=>"ajouterPromotionNiveau","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionSerie" class="col-sm-4 col-form-label">Série</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('serie_id',$list_series,['class'=>'form-control','empty'=>" ","id"=>"ajouterPromotionSerie"])?>
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

<!-- Modal Edit Promotion-->
<div class="modal fade" id="editPromotionModal" tabindex="-1" role="dialog" aria-labelledby="editPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'editer']) ?>" method="post">
        <input id="editerPromotionId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editPromotionModalLabel">Ajout d'une promotion</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editerPromotionNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="editerPromotionNom" required readonly >
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionNiveau" class="col-sm-4 col-form-label">Niveau</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('niveau_id',$list_niveaux,['class'=>'form-control',"id"=>"editerPromotionNiveau","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionSerie" class="col-sm-4 col-form-label">Série</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('serie_id',$list_series,['class'=>'form-control','empty'=>" ","id"=>"editerPromotionSerie"])?>
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

<!-- Modal suppression Promotion-->
<div class="modal fade" id="supprPromotionModal" tabindex="-1" role="dialog" aria-labelledby="supprPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprPromotionId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprPromotionModalLabel">Supression de la promotion : <span id="supprPromotionNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cette promotion?
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
        $("#niveaux_tab").show();  
        console.log('ouverture tab niveaux'); 
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
    ///////////////////////////
 
    $(".editNiveau").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editNiveau input").val());
        $("#editNiveauId").val(data[0]);
        $("#editNiveauNom").val(data[2]);
        $("#editNiveauOrdre").val(data[1]);
    });
    $(".supprNiveau").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprNiveau input").val());
        $("#supprNiveauId").val(data[0]);
        $("#supprNiveauNom").html(data[1]);
    });

    $("#select_all_niveaux").click(function() {
        if ($(this).prop("checked")){
            $(".select_niveau").prop("checked","checked");
            console.log("Sélection de tous les niveaux");
        }else{
            $(".select_niveau").prop("checked",null);
            console.log("déselection de tous les niveaux");
        }
    });
    $(".select_niveaux_action").click(function() {
        if (!$("input[class='select_niveau']:checked").val()) {
            alert("Vous n'avez sélectionné aucun niveau.");
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
                $(".select_niveau").prop("checked",null);
            }
        }
    });
    $(".editSerie").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editSerie input").val());
        $("#editSerieId").val(data[0]);
        $("#editSerieNom").val(data[1]);
        $("#editSerieDescription").html(data[2]);
    });
    $(".supprSerie").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprSerie input").val());
        $("#supprSerieId").val(data[0]);
        $("#supprSerieNom").html(data[1]);
    });

    $("#select_all_series").click(function() {
        if ($(this).prop("checked")){
            $(".select_serie").prop("checked","checked");
            console.log("Sélection de toutes les series");
        }else{
            $(".select_serie").prop("checked",null);
            console.log("déselection de toutes les series");
        }
    });
    $(".select_series_action").click(function() {
        if (!$("input[class='select_serie']:checked").val()) {
            alert("Vous n'avez sélectionné aucune série.");
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
                $(".select_serie").prop("checked",null);
            }
        }
    });


    $(".editSalle").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editSalle input").val());
        $("#editSalleId").val(data[0]);
        $("#editSalleNom").val(data[1]);
        $("#editSallePavillon").val(data[2]);
        $("#editSalleEtage").val(data[3]);
        $("#editSalleCapacite").val(data[4]);
    });
    $(".supprSalle").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprSalle input").val());
        $("#supprSalleId").val(data[0]);
        $("#supprSalleNom").html(data[1]);
    });

    $("#select_all_salles").click(function() {
        if ($(this).prop("checked")){
            $(".select_salle").prop("checked","checked");
            console.log("Sélection de toutes les salles");
        }else{
            $(".select_salle").prop("checked",null);
            console.log("déselection de toutes les salles");
        }
    });
    $(".select_salles_action").click(function() {
        if (!$("input[class='select_salle']:checked").val()) {
            alert("Vous n'avez sélectionné aucun utilisateur.");
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
                $(".select_salle").prop("checked",null);
            }
        }
    });

    $(".editMatiere").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editMatiere input").val());
        $("#editMatiereId").val(data[0]);
        $("#editMatiereNom").val(data[1]);
        $("#editMatiereDescription").html(data[2]);
    });
    $(".supprMatiere").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprMatiere input").val());
        $("#supprMatiereId").val(data[0]);
        $("#supprMatiereNom").html(data[1]);
    });

    $("#select_all_matieres").click(function() {
        if ($(this).prop("checked")){
            $(".select_matiere").prop("checked","checked");
            console.log("Sélection de toutes les matieres");
        }else{
            $(".select_matiere").prop("checked",null);
            console.log("déselection de toutes les matieres");
        }
    });
    $(".select_matieres_action").click(function() {
        if (!$("input[class='select_matiere']:checked").val()) {
            alert("Vous n'avez sélectionné aucune matière.");
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
                $(".select_matiere").prop("checked",null);
            }
        }
    });

    /******************************************************* 
     * Fonctions pour les promotions
    ********************************************************/
    $("#editerPromotionNiveau, #editerPromotionSerie").change(function() {
        var nom="";
        var str = $( "#editerPromotionSerie option:selected" ).text();
        if(str==' ') serie="";
        else{
            var matches = str.match(/\b(\w)/g);
            var serie = matches.join('');
            serie = " "+serie;
        }
        var niveau = $( "#editerPromotionNiveau option:selected" ).text();
        $("#editerPromotionNom").val(niveau+serie);
    });
    $("#ajouterPromotionNiveau, #ajouterPromotionSerie").change(function() {
        var nom="";
        var str = $( "#ajouterPromotionSerie option:selected" ).text();
        console.log(str);
        if(str==' ') serie="";
        else{
            var matches = str.match(/\b(\w)/g);
            var serie = matches.join('');
            serie = " "+serie;
        }
        var niveau = $( "#ajouterPromotionNiveau option:selected" ).text();
        $("#ajouterPromotionNom").val(niveau+serie);
    });
    
    $(".editPromotion").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editPromotion input").val());
        $("#editerPromotionId").val(data[0]);
        $("#editerPromotionNiveau").val(data[1]);
        $("#editerPromotionSerie").val(data[2]);
        $("#editerPromotionNom").val(data[3]);
    });
    $(".supprPromotion").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprPromotion input").val());
        $("#supprPromotionId").val(data[0]);
        $("#supprPromotionNom").html(data[1]);
    });

    $("#select_all_promotions").click(function() {
        if ($(this).prop("checked")){
            $(".select_promotion").prop("checked","checked");
            console.log("Sélection de toutes les promotions");
        }else{
            $(".select_promotion").prop("checked",null);
            console.log("déselection de toutes les promotions");
        }
    });
    $(".select_promotions_action").click(function() {
        if (!$("input[class='select_promotion']:checked").val()) {
            alert("Vous n'avez sélectionné aucune promotion.");
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
                $(".select_promotion").prop("checked",null);
            }
        }
    });
  
    
</script>
<?php $this->end(); ?>