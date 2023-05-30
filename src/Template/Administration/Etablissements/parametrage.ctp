<?php
//dd($etablissement);
?>

<ul class="nav nav-tabs">
    <li id="etablissement_smenu" class="active"><a href="#">Paramètres de l'établissement</a></li>
    <li id="administrateur_smenu"><a href="#">Compte administrateur</a></li>
    <!--li id="acces_smenu"><a href="#">Paramètres d'accès</a></li-->
</ul>

<div id="etablissement_tab">
    <br>
    <form action="<?= $this->Url->Build(['controller' => 'Etablissements', 'action' => 'editer']) ?>" method="post">
        <input type="hidden" name="id" value="<?=$etablissement->id?>" >
        <div class="form-group row vertical-align">
            <div class="col-sm-4">
                <div class="logo-container vertical-align">
                    <button type="button" class="btn btn-default logo-btn" data-toggle="modal" data-target="#logoModal">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <?php if(!empty($etablissement->logo)):?>
                        <img class="logo" src="<?= $etablissement->logo?>" height="140px;" >
                    <?php 
                    else:
                        echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'140px']);
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="h3">
                    <input style="margin-left:0;" type="text" name="nom" class="form-control titre" id="nom" placeholder="Nom de l'établissement" required value="<?=$etablissement->nom?>">
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="adresse" class="col-sm-2 col-form-label col-sm-offset-2">Domicile</label>
            <div class="col-sm-6">
            <input type="text" name="adresse" class="form-control" id="adresse" required value="<?=$etablissement->adresse?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="telephone" class="col-sm-2 col-form-label col-sm-offset-2">Téléphone</label>
            <div class="col-sm-4">
            <input type="text" name="tel" class="form-control" id="telephone"  required value="<?=$etablissement->tel?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label col-sm-offset-2">Email</label>
            <div class="col-sm-4">
            <input type="email" name="email" class="form-control" id="email" required value="<?=$etablissement->email?>">
            </div>
        </div>
        <br>

        <div class="form-group row ">
            <div class="col-sm-3 col-sm-offset-3 valider_div">
                <button id="annuler_btn" type="button" class="btn btn-danger btn-block btn-lg">Annuler</button>
            </div>
            <div class="col-sm-3 valider_div" >
                <button id="valider_btn" type="submit" class="btn btn-success btn-block btn-lg">Valider</button>
            </div>
            <div class="col-sm-4 editer_div col-sm-offset-4" >
                <button id="editer_btn" type="button" class="btn btn-default btn-block btn-lg">Editer</button>
            </div>
            
        </div>
        
    </form>

</div>

<div id="administrateur_tab">
    <br>
    <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'editer_admin']) ?>" method="post">
        <input type="hidden" name="id" value="<?=$admin->id?>" >
        <div class="form-group row vertical-align">
            <div class="col-sm-4">
                <div class="logo-container vertical-align">
                    <button type="button" class="btn btn-default logo-btn" data-toggle="modal" data-target="#photoModal">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <?php if(!empty($admin->photo)):?>
                        <img class="logo" src="<?= $admin->photo?>" height="140px" >
                    <?php 
                    else:
                        echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'140px']);
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="h3" id="prenom_nom">
                    <?=$admin->prenom?> <?=$admin->nom?> 
                </div>
                <div id="prenom_nom_input">
                    <div class="form-group row">
                        <label for="admin_prenom" class="col-sm-3 col-form-label">Prénom</label>
                        <div class="col-sm-9">
                        <input type="text" name="prenom" class="form-control" id="admin_prenom" required value="<?=$admin->prenom?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="admin_nom" class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                        <input type="text" name="nom" class="form-control" id="admin_enom" required value="<?=$admin->nom?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="admin_adresse" class="col-sm-2 col-form-label col-sm-offset-2">Adresse</label>
            <div class="col-sm-6">
            <input type="text" name="adresse" class="form-control" id="admin_adresse" value="<?=$admin->adresse?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="admin_telephone" class="col-sm-2 col-form-label col-sm-offset-2">Téléphone</label>
            <div class="col-sm-4">
            <input type="text" name="telephone" class="form-control" id="admin_telephone"  value="<?=$admin->telephone?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="admin_email" class="col-sm-2 col-form-label col-sm-offset-2">Email</label>
            <div class="col-sm-4">
            <input type="email" name="user[email]" class="form-control" id="admin_email" required value="<?=$admin->user->email?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="admin_password" class="col-sm-2 col-form-label col-sm-offset-2">Mot de passe</label>
            <div class="col-sm-4">
            <input type="password" name="user[password]" class="form-control" id="admin_password" required value="<?=$admin->user->password?>">
            </div>
        </div>
        <br>

        <div class="form-group row ">
            <div class="col-sm-3 col-sm-offset-3 valider_div">
                <button id="annuler_btn" type="button" class="btn btn-danger btn-block btn-lg">Annuler</button>
            </div>
            <div class="col-sm-3 valider_div" >
                <button id="valider_btn" type="submit" class="btn btn-success btn-block btn-lg">Valider</button>
            </div>
            <div class="col-sm-4 editer_div col-sm-offset-4" >
                <button id="editer_btn" type="button" class="btn btn-default btn-block btn-lg">Editer</button>
            </div>
            
        </div>
        
    </form>

</div>

<div id="acces_tab">
    <br>
    <form action="<?= $this->Url->Build(['controller' => 'Configurations', 'action' => 'editer']) ?>" method="post">
        <input type="hidden" name="id" value="<?=$etablissement->configuration->id?>" >
        <div class="form-group row ">
            <label for="profs_acces_check" class="col-sm-5 col-form-label col-sm-offset-2">Autoriser les accès professeurs</label>
            <div class="col-sm-3">
                off <input value="1" name="professeur_acces" <?php if($etablissement->configuration->professeur_acces) echo "checked";?> class="switch" id="profs_acces_check" type="checkbox" ><label for="profs_acces_check">&nbsp;</label> on
            </div>
        </div>
        <div class="form-group row ">
            <label for="tuteurs_acces_check" class="col-sm-5 col-form-label col-sm-offset-2">Autoriser les accès tuteurs</label>
            <div class="col-sm-3">
                off <input value="1" name="tuteur_acces" <?php if($etablissement->configuration->tuteur_acces) echo "checked";?> class="switch" id="tuteurs_acces_check" type="checkbox" ><label for="tuteurs_acces_check">&nbsp;</label> on
            </div>
        </div>
        <div class="form-group row ">
            <label for="eleves_acces_check" class="col-sm-5 col-form-label col-sm-offset-2">Autoriser les accès élèves</label>
            <div class="col-sm-3">
                off <input value="1" name="eleve_acces" <?php if($etablissement->configuration->eleve_acces) echo "checked";?> class="switch" id="eleves_acces_check" type="checkbox" ><label for="eleves_acces_check">&nbsp;</label> on
            </div>
        </div>
        <div class="form-group row ">
            <label for="notifications_email_check" class="col-sm-5 col-form-label col-sm-offset-2">Autoriser les notifications email</label>
            <div class="col-sm-3">
                off <input value="1" name="notification_email" <?php if($etablissement->configuration->notification_email) echo "checked";?> class="switch" id="notifications_email_check" type="checkbox" ><label for="notifications_email_check">&nbsp;</label> on
            </div>
        </div>
        <div class="form-group row ">
            <label for="notifications_sms_check" class="col-sm-5 col-form-label col-sm-offset-2">Autoriser les notifications sms <small>(non encore disponible)</small></label>
            <div class="col-sm-3">
                off <input value="1" name="notification_sms" disabled class="switch" id="notifications_sms_check" type="checkbox" ><label for="notifications_sms_check">&nbsp;</label> on
            </div>
        </div>
        <br>
        <div class="form-group row ">
            <div class="col-sm-3 col-sm-offset-3 valider_div">
                <button id="annuler_btn" type="button" class="btn btn-danger btn-block btn-lg">Annuler</button>
            </div>
            <div class="col-sm-3 valider_div" >
                <button id="valider_btn" type="submit" class="btn btn-success btn-block btn-lg">Valider</button>
            </div>
            <div class="col-sm-4 editer_div col-sm-offset-4" >
                <button id="editer_btn" type="button" class="btn btn-default btn-block btn-lg">Editer</button>
            </div>
            
        </div>
    </form>

</div>


<!-- Modal Logo Etablissement-->
<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Etablissements', 'action' => 'editer_image']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="logoModalLabel">Chargement du logo de l'établissement</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="eleves_acces_check" class="col-sm-2">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="image" id="employe_image">
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

<!-- Modal Photo Employe-->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Employes', 'action' => 'editer_image']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$admin->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="photoModalLabel">Chargement du photo de l'administrateur</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="eleves_acces_check" class="col-sm-2">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="image" id="employe_image">
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

<?php
$this->Html->css([
    //"https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    //"https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $("input").addClass('input-disabled');
        $("input").prop('readonly','true');
        $(".valider_div").hide();
        $("#administrateur_tab").hide();
        $("#acces_tab").hide();
        $("#prenom_nom_input").hide();
        $("#acces_tab input").prop('disabled','true');
    });
    $("#etablissement_smenu").click(function() {
        $("#etablissement_tab").show();
        $("#administrateur_tab").hide();
        $("#acces_tab").hide();
        $(this).addClass('active');
        $("#administrateur_smenu").removeClass('active');
        $("#acces_smenu").removeClass('active');
    });
    $("#administrateur_smenu").click(function() {
        $("#etablissement_tab").hide();
        $("#administrateur_tab").show();
        $("#acces_tab").hide();
        $(this).addClass('active');
        $("#etablissement_smenu").removeClass('active');
        $("#acces_smenu").removeClass('active');
    });
    $("#acces_smenu").click(function() {
        $("#etablissement_tab").hide();
        $("#administrateur_tab").hide();
        $("#acces_tab").show();
        $(this).addClass('active');
        $("#etablissement_smenu").removeClass('active');
        $("#administrateur_smenu").removeClass('active');
    });
    // gestion des boutons
    //etablissement tab
    $("#etablissement_tab #editer_btn").click(function() {
        $("#etablissement_tab .editer_div").hide();
        $("#etablissement_tab .valider_div").show();
        $("#etablissement_tab input").removeClass('input-disabled');
        $("#etablissement_tab input").removeAttr('readonly');
    });
    $("#etablissement_tab #annuler_btn").click(function() {
        $("#etablissement_tab .editer_div").show();
        $("#etablissement_tab .valider_div").hide();
        $("#etablissement_tab input").addClass('input-disabled');
        $("#etablissement_tab input").prop('readonly','true');
    });
    //administrateur tab
    $("#administrateur_tab #editer_btn").click(function() {
        $("#administrateur_tab .editer_div").hide();
        $("#administrateur_tab .valider_div").show();
        $("#administrateur_tab input").removeClass('input-disabled');
        $("#prenom_nom").hide();
        $("#prenom_nom_input").show();
        $("#administrateur_tab input").removeAttr('readonly');
    });
    $("#administrateur_tab #annuler_btn").click(function() {
        $("#administrateur_tab .editer_div").show();
        $("#administrateur_tab .valider_div").hide();
        $("#administrateur_tab input").addClass('input-disabled');
        $("#prenom_nom").show();
        $("#prenom_nom_input").hide();
        $("#administrateur_tab input").prop('readonly','true');
    });
    //////////////////////

    //Accès tab
    $("#acces_tab #editer_btn").click(function() {
        $("#acces_tab .editer_div").hide();
        $("#acces_tab .valider_div").show();
        $("#acces_tab input").removeClass('input-disabled');
        $("#acces_tab input").removeAttr('disabled');
    });
    $("#acces_tab #annuler_btn").click(function() {
        $("#acces_tab .editer_div").show();
        $("#acces_tab .valider_div").hide();
        $("#acces_tab input").addClass('input-disabled');
        $("#acces_tab input").prop('disabled','true');
    });
    //////////////////////
</script>
<?php $this->end(); ?>