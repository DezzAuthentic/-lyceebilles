<div class="titre">
    <span>Tuteur: <?=$tuteur->prenom?> <?=$tuteur->nom?>
    <a href="/secretariat/tuteurs/modifier/<?=$tuteur->id?>" class="pull-right btn btn-sm btn-default">Modifier</a>
</div>

<div class="row">
    <div id="profil" class="col-xs-12 col-md-6">
        <a href="#" class="thumbnail">
            <?php if(!empty($tuteur->photo)):?>
                <img class="logo" style='height:294px;border-radius:5px;' src="<?= $tuteur->photo?>">
            <?php 
            else:
                echo $this->Html->image('profil_default.png', ['alt' => 'photo de profil','class'=>"logo",'style'=>"height:294px;border-radius:5px;"]);
            endif;
            ?>
        </a>
        
    </div>
    <div id="details" class="col-xs-12 col-md-6">
            
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="text-center">
                    <span class="titre"><?=$tuteur->prenom?> <?=$tuteur->nom?></span><br>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="date_naissance">Date de Naissance:</label>
                        <div class="col-sm-7">
                            <p id="date_naissance" class="form-control-static"><?=$tuteur->date_naissance?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="telephone">Téléphone:</label>
                        <div class="col-sm-7">
                            <p id="telephone" class="form-control-static"><?=$tuteur->telephone?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="adresse">Domicile:</label>
                        <div class="col-sm-7">
                            <p id="adresse" class="form-control-static"><?=$tuteur->adresse?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="situation_matrimoniale">Situation matimoniale:</label>
                        <div class="col-sm-7">
                            <p id="situation_matrimoniale" class="form-control-static"><?=$tuteur->situation_matrimoniale?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="entreprise">Entreprise:</label>
                        <div class="col-sm-7">
                            <p id="entreprise" class="form-control-static"><?=$tuteur->entreprise?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="fonction">Fonction:</label>
                        <div class="col-sm-7">
                            <p id="fonction" class="form-control-static"><?=$tuteur->fonction?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

    <div class="col-xs-12">
        <b class="soustitre">Elèves</b>
    </div>
    
    <div class="col-xs-12">
        <div class="panel panel-default">
            
            <table id="seances_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title=""></th>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=1; foreach($tuteur->eleves as $elef): ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$elef->matricule?></td>
                        <td><?=$elef->nom?></td>
                        <td><?=$elef->prenom?></td>
                        <td class="actions">
                            <?= $this->Html->link("<span class='glyphicon glyphicon-eye-open icone'></span> Fiche de l'élève",'/secretariat/eleves/fiche/'.$elef->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-xs-12">
        <b class="soustitre mt2">Tuteurs secondaires</b>
        <span class="btn btn-xs btn-default pull-right mb1" data-toggle="modal" data-target="#ajouterTuteurModal">Ajouter</span>
    </div>

    <div class="col-xs-12">
        <div class="panel panel-default">
            <table id="seances_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title=""></th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=1; foreach($tuteur->tuteur_secondaires as $secondaire): ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$secondaire->nom?></td>
                        <td><?=$secondaire->prenom?></td>
                        <td class="actions">
                            <span class="btn btn-default btn-xs modifierTuteur" data-toggle="modal" data-target="#modifierTuteurModal" > <i class="glyphicon glyphicon-pencil "></i>
                                <input type="hidden" value="<?=$secondaire->id.'*'.$secondaire->tuteur_id.'*'.$secondaire->nom.'*'.$secondaire->prenom.'*'.$secondaire->user->email?>">
                            </span>
                            <?=$this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['controller'=>'Tuteurs','action' => 'supprimerSecondaire', $secondaire->id], ['escape'=>false,'confirm' => __('Voulez-vous supprimer ce tuteur # {0}?', $secondaire->id),'class'=>"btn btn-xs btn-default"]); ?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="ajouterTuteurModal" tabindex="-1" role="dialog" aria-labelledby="ajouterTuteurModalLabel">
        <div class="modal-dialog" role="document">
            <form id="ajouterForm" action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'ajouterSecondaire']) ?>" method="post">
                <input type="hidden" name="tuteur_id" value="<?=$tuteur->id?>" >
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ajouterTuteurModalLabel">Ajout d'un tuteur secondaire</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="ajouterNom" class="col-sm-4 col-form-label">Nom</label>
                        <div class="col-sm-8">
                            <input type="text" name="nom" id="ajouterNom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajouterPrenom" class="col-sm-4 col-form-label">Prénom</label>
                        <div class="col-sm-8">
                            <input type="text" name="prenom" id="ajouterPrenom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajouterEmail" class="col-sm-4 col-form-label">E-mail</label>
                        <div class="col-sm-8">
                            <input type="text" name="user[email]" id="ajouterEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajouterMdp" class="col-sm-4 col-form-label">Mot de passe</label>
                        <div class="col-sm-8">
                            <input type="password" name="user[password]" id="ajouterMdp" class="form-control" required>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4 mt1">
                            <input type="password" id="ajouterMdp2" class="form-control" required placeholder="Tapez à nouveau le mot de passe">
                            <span id="error_password" class="text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" name="user[profil]" value="tuteur">
                    <input type="hidden" name="user[etat]" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modifierTuteurModal" tabindex="-1" role="dialog" aria-labelledby="modifierTuteurModalLabel">
        <div class="modal-dialog" role="document">
            <form id="modifierForm" action="<?= $this->Url->Build(['controller' => 'Tuteurs', 'action' => 'modifierSecondaire']) ?>" method="post">
                <input type="hidden" id="modifierTuteurId" name="tuteur_id" >
                <input type="hidden" id="modifierId" name="id" >
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modifierTuteurModalLabel">Modification du tuteur secondaire</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="modifierNom" class="col-sm-4 col-form-label">Nom</label>
                        <div class="col-sm-8">
                            <input type="text" name="nom" id="modifierNom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modifierPrenom" class="col-sm-4 col-form-label">Prénom</label>
                        <div class="col-sm-8">
                            <input type="text" name="prenom" id="modifierPrenom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modifierEmail" class="col-sm-4 col-form-label">E-mail</label>
                        <div class="col-sm-8">
                            <input type="text" name="user[email]" id="modifierEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modifierMdp" class="col-sm-4 col-form-label">Mot de passe</label>
                        <div class="col-sm-8">
                            <input type="password" name="user[password]" id="modifierMdp" class="form-control">
                        </div>
                        <div class="col-sm-8 col-sm-offset-4 mt1">
                            <input type="password" id="modifierMdp2" class="form-control" placeholder="Tapez à nouveau le mot de passe">
                            <span id="error_password2" class="text-danger"></span>
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
    "https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        var table = $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
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
            }
        });
    });

    $("#ajouterForm").submit(function(event) {
        if($("#ajouterMdp").val() != $("#ajouterMdp2").val()){
            $("#error_password").html("Les 2 mots de passe ne sont pas identiques.");
            event.preventDefault();
        }else $("#error_password").html("");
    }); 
    $("form").submit(function(event) {
        if($("#modifierMdp").val() != $("#modifierMdp2").val()){
            $("#error_password2").html("Les 2 mots de passe ne sont pas identiques.");
            event.preventDefault();
        }else $("#error_password2").html("");
    });   

    $(".modifierTuteur").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".modifierTuteur input").val());
        $("#modifierId").val(data[0]);
        $("#modifierTuteurId").val(data[1]);
        $("#modifierNom").val(data[2]);
        $("#modifierPrenom").val(data[3]);
        $("#modifierEmail").val(data[4]);
    });
    
</script>
<?php $this->end(); ?>