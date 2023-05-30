<ul class="nav nav-tabs">
    <li id="administration_tmenu" class="active tmenu"><a href="#">Personnel administratif : <?=$personnel->count()?></a></li>
    <li id="professeurs_tmenu" class="tmenu"><a href="#">Professeurs</a></li>
    <li id="tuteurs_tmenu" class="tmenu"><a href="#">Tuteurs</a></li>
    <li id="secondaires_tmenu" class="tmenu"><a href="#">Tuteurs Secondaires</a></li>
    <!--li id="eleves_tmenu" class="tmenu"><a href="#">Eleves</a></li-->
</ul>

<!--********************************************************************************
Onglet du personnel administratif
*********************************************************************************-->

<section id="administration_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="personnel_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="prenom">Prénom</th>
                    <th title="email">Email</th>
                    <th title="profil">Profil</th>
                    <th title="profil">Status Compte</th>
                    <th class="actions" >
                        
                    </th>
                    <th class="select_col"><input id="select_all_agents" name="select_all_agents" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($personnel as $agent): ?>
                <tr>
                    <td><?=$agent->nom?></td>
                    <td><?=$agent->prenom?></td>
                    <td><?=$agent->user->email?></td>
                    <td><?=$agent->user->profil?> <?php if($agent->user->profil == "surveillant") echo "général";?></td>
                    <td>
                        <?php if($agent->user->etat == 1){ ?>
                            <button type="button" class="btn btn-sm btn-success">Activé</button>
                        <?php } else{?>
                            <button type="button" class="btn btn-sm btn-danger">Désactivé</button>
                        <?php }?>
                    </td>
                    <?php if($agent->id!=$admin->id):?>
                    <td class="actions">
                     
                                                                                                   
                        <span class="icone glyphicon glyphicon-pencil editEmploye hover" data-toggle="modal"
                        data-target="#editEmployeModal" >
                            <input type="hidden" value="<?=$agent->id.'*'.$agent->prenom.'*'.$agent->nom.'*'
                            .$agent->user->profil.'*'.$agent->user->email?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprEmploye hover" data-toggle="modal"
                        data-target="#supprEmployeModal">
                            <input type="hidden" value="<?=$agent->id.'*'.$agent->prenom.'*'.$agent->nom?>">
                        </span>
                        <?php $icone=$agent->user->etat==1?"ban":"ok";?>
                        <a href="/administration/users/changer_etat/<?=$agent->user_id?>"><span class="icone glyphicon glyphicon-<?=$icone?>-circle supprEmploye hover" data-toggle="modal"></span></a>
                    
                    </td>
                    <td><input name="select[<?=$i?>]" value="<?=$agent->id?>" type="checkbox" class="select_agent" ></td>
                    <?php else:?>
                    <td class="text-center">(admin)</td>
                    <td></td>
                    <?php endif;?>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajouterEmployeModal"><span class="icone glyphicon glyphicon-plus hover"></span></button>
                <button name="action" value="supprimer" type="submit" class="btn btn-default select_agents_action"><span class="icone glyphicon glyphicon-remove hover"></button>
                <button name="action" value="activer" type="submit" class="btn btn-default select_agents_action"><span class="icone glyphicon glyphicon-ok-circle hover"></span></button>
                <button name="action" value="desactiver" type="submit" class="btn btn-default select_agents_action"><span class="icone glyphicon glyphicon-ban-circle hover"></button>
            </div>
        </div>
        </form>
    </div>
</section>

<!-- Modal ajout Employé-->
<div class="modal fade" id="ajouterEmployeModal" tabindex="-1" role="dialog" aria-labelledby="ajouterEmployeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterEmployeModalLabel">Ajout d'un employé</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterEmployePrenom" class="col-sm-4 col-form-label">Prénom</label>
                <div class="col-sm-8">
                    <input type="text" name="prenom" id="ajouterEmployePrenom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterEmployeNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="ajouterEmployeNom" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterEmployeProfil" class="col-sm-4 col-form-label">Profil</label>
                <div class="col-sm-8">
                    <select name="user[profil]" class="form-control" id="ajouterEmployeProfil">
                        <option value="admin">Administrateur</option>
                        <option value="boutiquier">Boutiquier</option>
                        <option value="comptable">Comptable</option>
                        <option value="infirmier">Infirmier</option>
                        <option value="secretaire">Secretaire</option>
                        <option value="surveillant">Surveillant général</option>
                        <option value="surveillant2">Surveillant</option>
                        <option value="secretaire">Secrétaire</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterEmployeEmail" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" name="user[email]" class="form-control" id="ajouterEmployeEmail" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterEmployePassword" class="col-sm-4 col-form-label">Mot de passe</label>
                <div class="col-sm-8">
                    <input type="password" name="user[password]" class="form-control" id="ajouterEmployePassword" required>
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

<!-- Modal édition Employé-->
<div class="modal fade" id="editEmployeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'editer']) ?>" method="post">
        <input id="editEmployeId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editEmployeModalLabel">Edition des accès de l'employé</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editEmployePrenom" class="col-sm-4 col-form-label">Prénom</label>
                <div class="col-sm-8">
                    <input type="text" name="prenom" id="editEmployePrenom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editEmployeNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="editEmployeNom" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editEmployeProfil" class="col-sm-4 col-form-label">Profil</label>
                <div class="col-sm-8">
                    <select name="user[profil]" class="form-control" id="editEmployeProfil">
                        <option value="comptable">Comptable</option>
                        <option value="secretaire">Secretaire</option>
                        <option value="surveillant">Surveillant</option>
                        <option value="admin" >Administrateur</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editEmployeEmail" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" name="user[email]" class="form-control" id="editEmployeEmail" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="editEmployePassword" class="col-sm-4 col-form-label">Mot de passe</label>
                <div class="col-sm-8">
                    <input type="password" name="user[passwordChange]" class="form-control" id="editEmployePassword">
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

<!-- Modal suppression Employé-->
<div class="modal fade" id="supprEmployeModal" tabindex="-1" role="dialog" aria-labelledby="supprEmployeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprEmployeId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprEmployeModalLabel">Supression de l'employé : <span id="supprEmployePrenom"></span> <span id="supprEmployeNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cet employé
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
Onglet des professeurs
*********************************************************************************-->

<section id="professeurs_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Professeurs', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="professeurs_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="prenom">Prénom</th>
                    <th title="email">Email</th>
                    <th title="etat">Status compte</th>
                    <th class="actions" >
                        
                    </th>
                    <th class="select_col"><input id="select_all_profs" name="select_all_profs" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($professeurs as $prof):
                $email = $prof->user==null?'':$prof->user->email;
                $etat = $prof->user==null?null:$prof->user->etat;
            ?>
                <tr>
                    <td><?=$prof->nom?></td>
                    <td><?=$prof->prenom?></td>
                    <td><?=$email?></td>
                    <td>
                        <?php if($etat == 1){ ?>
                            <button type="button" class="btn btn-sm btn-success">Activé</button>
                        <?php } else{?>
                            <button type="button" class="btn btn-sm btn-danger">Désactivé</button>
                        <?php }?>
                    </td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editProf hover" data-toggle="modal"
                        data-target="#editProfModal" >
                            <input type="hidden" value="<?=$prof->id.'*'.$prof->prenom.'*'.$prof->nom.'*'
                            .$email?>">
                        </span>
                        <?php if($prof->user!=null):?>
                        <?php $icone=$prof->user->etat==1?"ban":"ok";?>
                        <a href="/administration/users/changer_etat/<?=$prof->user_id?>"><span class="icone glyphicon glyphicon-<?=$icone?>-circle supprEmploye hover" data-toggle="modal"></span></a>
                        <?php endif;?>
                    </td>
                    <td><input name="select[<?=$i?>]" value="<?=$prof->id?>" type="checkbox" class="select_prof" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button name="action" value="activer" type="submit" class="btn btn-default select_profs_action"><span class="icone glyphicon glyphicon-ok-circle hover"></span></button>
                <button name="action" value="desactiver" type="submit" class="btn btn-default select_profs_action"><span class="icone glyphicon glyphicon-ban-circle hover"></button>
            </div>
        </div>
        </form>
    </div>
</section>

<!-- Modal édition Professeur-->
<div class="modal fade" id="editProfModal" tabindex="-1" role="dialog" aria-labelledby="editProfModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Professeurs', 'action' => 'editer']) ?>" method="post">
        <input id="editProfId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editProfModalLabel">Edition des accès du professeur</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editProfPrenom" class="col-sm-4 col-form-label">Prénom</label>
                <div class="col-sm-8">
                    <input type="text" name="prenom" id="editProfPrenom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editProfNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="editProfNom" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editProfEmail" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" name="user[email]" class="form-control" id="editProfEmail" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="editProfPassword" class="col-sm-4 col-form-label">Mot de passe</label>
                <div class="col-sm-8">
                    <input type="password" name="user[passwordChange]" class="form-control" id="editProfPassword">
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


<!--********************************************************************************
Onglet des tuteurs
*********************************************************************************-->
<div id="tuteurs_tab" class="tab">
<br>
    <div class="col-xs-12">
        <form action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'actionEnMasse']) ?>" method="post">        
        <table id="tuteurs_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="prenom">Prénom</th>
                    <th title="email">Email</th>
                    <th title="etat">Status compte</th>
                    <th class="actions" >
                        
                    </th>
                    <th class="select_col"><input id="select_all_tuteurs" name="select_all_tuteurs" type="checkbox" ></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($tuteurs as $tuteur):
                $email = $tuteur->user==null?'':$tuteur->user->email;
                $etat = $tuteur->user==null?null:$tuteur->user->etat;
            ?>
                <tr>
                    <td><?=$tuteur->nom?></td>
                    <td><?=$tuteur->prenom?></td>
                    <td><?=$email?></td>
                    <td>
                        <?php if($etat == 1){ ?>
                            <button type="button" class="btn btn-sm btn-success">Activé</button>
                        <?php } else{?>
                            <button type="button" class="btn btn-sm btn-danger">Désactivé</button>
                        <?php }?>
                    </td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editTuteur hover" data-toggle="modal"
                        data-target="#editTuteurModal" >
                            <input type="hidden" value="<?=$tuteur->id.'*'.$tuteur->prenom.'*'.$tuteur->nom.'*'
                            .$email?>">
                        </span>
                        <?php if($tuteur->user!=null):?>
                        <?php $icone=$tuteur->user->etat==1?"ban":"ok";?>
                        <a href="/administration/users/changer_etat/<?=$tuteur->user_id?>"><span class="icone glyphicon glyphicon-<?=$icone?>-circle supprEmploye hover" data-toggle="modal"></span></a>
                        <?php endif;?>
                    </td>
                    <td><input name="select[<?=$i?>]" value="<?=$tuteur->id?>" type="checkbox" class="select_tuteur" ></td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
        <div class="text-center">
            <div class="btn-group" role="group" aria-label="...">
                <button name="action" value="activer" type="submit" class="btn btn-default select_tuteurs_action"><span class="icone glyphicon glyphicon-ok-circle hover"></span></button>
                <button name="action" value="desactiver" type="submit" class="btn btn-default select_tuteurs_action"><span class="icone glyphicon glyphicon-ban-circle hover"></button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal édition Tuteur-->
<div class="modal fade" id="editTuteurModal" tabindex="-1" role="dialog" aria-labelledby="editTuteurModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'editer']) ?>" method="post">
        <input id="editTuteurId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editTuteurModalLabel">Edition des accès du tuteur</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editTuteurPrenom" class="col-sm-4 col-form-label">Prénom</label>
                <div class="col-sm-8">
                    <input type="text" name="prenom" id="editTuteurPrenom" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editTuteurNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="editTuteurNom" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="editTuteurEmail" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" name="user[email]" class="form-control" id="editTuteurEmail" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="editTuteurPassword" class="col-sm-4 col-form-label">Mot de passe</label>
                <div class="col-sm-8">
                    <input type="password" name="user[passwordChange]" class="form-control" id="editTuteurPassword">
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

<!--********************************************************************************
Onglet des tuteurs secondaires
*********************************************************************************-->
<div id="secondaires_tab" class="tab">
<br>
    <div class="col-xs-12">
        <table id="secondaires_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="prenom">Prénom</th>
                    <th title="email">Email</th>
                    <th title="etat">Status compte</th>
                    <th class="actions" >
                        
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($t_secondaires as $tuteur):
                $email = $tuteur->user==null?'':$tuteur->user->email;
                $etat = $tuteur->user==null?null:$tuteur->user->etat;
            ?>
                <tr>
                    <td><?=$tuteur->nom?></td>
                    <td><?=$tuteur->prenom?></td>
                    <td><?=$email?></td>
                    <td>
                        <?php if($etat == 1){ ?>
                            <button type="button" class="btn btn-sm btn-success">Activé</button>
                        <?php } else{?>
                            <button type="button" class="btn btn-sm btn-danger">Désactivé</button>
                        <?php }?>
                    </td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editSecondaire hover" data-toggle="modal"
                        data-target="#editSecondaireModal" >
                            <input type="hidden" value="<?=$tuteur->id.'*'.$tuteur->prenom.'*'.$tuteur->nom.'*'
                            .$email?>">
                        </span>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal édition Tuteur-->
<div class="modal fade" id="editSecondaireModal" tabindex="-1" role="dialog" aria-labelledby="editSecondaireModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'modifierSecondaire']) ?>" method="post">
            <input id="editSecondaireId" type="hidden" name="id" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editSecondaireModalLabel">Edition des accès du tuteur secondaire</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="editSecondairePrenom" class="col-sm-4 col-form-label">Prénom</label>
                    <div class="col-sm-8">
                        <input type="text" name="prenom" id="editSecondairePrenom" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="editSecondaireNom" class="col-sm-4 col-form-label">Nom</label>
                    <div class="col-sm-8">
                        <input type="text" name="nom" class="form-control" id="editSecondaireNom" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="editSecondaireEmail" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" name="user[email]" class="form-control" id="editSecondaireEmail" required >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="editSecondairePassword" class="col-sm-4 col-form-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" name="user[password]" class="form-control" id="editSecondairePassword">
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


<!--********************************************************************************
Onglet des eleves
*********************************************************************************-->
<div id="eleves_tab" class="tab">
eleves
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
        $("#administration_tab").show();  
        console.log('ouverture tab administration'); 
        $('.datatable').DataTable({
            "info": true,
            "paging": true,
            "ordering": true,
            "searching": true,
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
            },
            /*"columnDefs": [ {
                "targets": 4,
                "orderable": false
                },{
                "targets": 5,
                "orderable": false
                }
            ]*/
        });    
    });
    $("#administration_tmenu").click(function() {
        $(".tab").hide();
        $("#administration_tab").show();       
        console.log('ouverture tab administration');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    $("#professeurs_tmenu").click(function() {
        $(".tab").hide();
        $("#professeurs_tab").show();       
        console.log('ouverture tab professeurs');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    $("#tuteurs_tmenu").click(function() {
        $(".tab").hide();
        $("#tuteurs_tab").show();       
        console.log('ouverture tab tuteurs');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    $("#secondaires_tmenu").click(function() {
        $(".tab").hide();
        $("#secondaires_tab").show();       
        console.log('ouverture tab tuteurs');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    $("#eleves_tmenu").click(function() {
        $(".tab").hide();
        $("#eleves_tab").show();       
        console.log('ouverture tab eleves');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    $(".editEmploye").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editEmploye input").val());
        $("#editEmployeId").val(data[0]);
        $("#editEmployePrenom").val(data[1]);
        $("#editEmployeNom").val(data[2]);
        $("#editEmployeProfil").val(data[3]);
        $("#editEmployeEmail").val(data[4]);
        $("#editEmployePassword").val(data[5]);
    });
    $(".supprEmploye").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprEmploye input").val());
        $("#supprEmployeId").val(data[0]);
        $("#supprEmployePrenom").html(data[1]);
        $("#supprEmployeNom").html(data[2]);
    });

    $("#select_all_agents").click(function() {
        if ($(this).prop("checked")){
            $(".select_agent").prop("checked","checked");
            console.log("Sélection de tous les agents");
        }else{
            $(".select_agent").prop("checked",null);
            console.log("déselection de tous les agents");
        }
    });
    $(".select_agents_action").click(function() {
        if (!$("input[class='select_agent']:checked").val()) {
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
                $(".select_agent").prop("checked",null);
            }
        }
    });

    /***************************************************** */
    /*                    Professeurs                      */
    /***************************************************** */
    $(".editProf").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editProf input").val());
        $("#editProfId").val(data[0]);
        $("#editProfPrenom").val(data[1]);
        $("#editProfNom").val(data[2]);
        $("#editProfEmail").val(data[3]);
        $("#editProfPassword").val(data[4]);
    });

    $("#select_all_profs").click(function() {
        if ($(this).prop("checked")){
            $(".select_prof").prop("checked","checked");
            console.log("Sélection de tous les profs");
        }else{
            $(".select_prof").prop("checked",null);
            console.log("déselection de tous les profs");
        }
    });
    $(".select_profs_action").click(function() {
        if (!$("input[class='select_prof']:checked").val()) {
            alert("Vous n'avez sélectionné aucun prof.");
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
                $(".select_prof").prop("checked",null);
            }
        }
    });
    /***************************************************** */
    /*                      Tuteurs                        */
    /***************************************************** */
    $(".editTuteur").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editTuteur input").val());
        $("#editTuteurId").val(data[0]);
        $("#editTuteurPrenom").val(data[1]);
        $("#editTuteurNom").val(data[2]);
        $("#editTuteurEmail").val(data[3]);
        $("#editTuteurPassword").val(data[4]);
    });

    $("#select_all_tuteurs").click(function() {
        if ($(this).prop("checked")){
            $(".select_tuteur").prop("checked","checked");
            console.log("Sélection de tous les tuteurs");
        }else{
            $(".select_tuteur").prop("checked",null);
            console.log("déselection de tous les tuteurs");
        }
    });
    $(".select_tuteurs_action").click(function() {
        if (!$("input[class='select_tuteur']:checked").val()) {
            alert("Vous n'avez sélectionné aucun tuteur.");
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
                $(".select_tuteur").prop("checked",null);
            }
        }
    });
    /***************************************************** */
    /*                Tuteurs secondaires                  */
    /***************************************************** */
    $(".editSecondaire").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editSecondaire input").val());
        $("#editSecondaireId").val(data[0]);
        $("#editSecondairePrenom").val(data[1]);
        $("#editSecondaireNom").val(data[2]);
        $("#editSecondaireEmail").val(data[3]);
        $("#editSecondairePassword").val(data[4]);
    });
</script>

<?php $this->end(); ?>