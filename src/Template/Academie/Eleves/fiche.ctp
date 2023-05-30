<div class="titre">
    <span>Elève: <?=$eleve->prenom?> <?=$eleve->nom?> - <?=$eleve->matricule?></span>
    <a href="/academie/eleves/modifier/<?=$eleve->id?>" class="pull-right btn btn-sm btn-default">Modifier</a>
</div>

<div class="row">
    <div id="profil" class="col-xs-12 col-md-6">
        <a href="#" class="thumbnail">
            <?php if(!empty($eleve->photo)):?>
                <img class="logo" style='height:220px;border-radius:5px;' src="<?= $eleve->photo?>">
            <?php 
            else:
                echo $this->Html->image('profil_default.png', ['alt' => 'photo de profil','class'=>"logo",'style'=>"height:220px;border-radius:5px;"]);
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
    <div id="details" class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="genre">Genre:</label>
                        <div class="col-sm-7">
                            <p id="genre" class="form-control-static"><?php if($eleve->genre=='f') echo 'Fille'; else echo 'Garçon';?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="date_naissance">Date de Naissance:</label>
                        <div class="col-sm-7">
                            <p id="date_naissance" class="form-control-static"><?=$eleve->date_naissance?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="lieu">Lieu de Naissance:</label>
                        <div class="col-sm-7">
                            <p id="lieu" class="form-control-static"><?=$eleve->lieu_naissance?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="telephone">Téléphone:</label>
                        <div class="col-sm-7">
                            <p id="telephone" class="form-control-static"><?=$eleve->telephone?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="adresse">Domicile:</label>
                        <div class="col-sm-7">
                            <p id="adresse" class="form-control-static"><?=$eleve->adresse?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="religion">Religion:</label>
                        <div class="col-sm-7">
                            <p id="religion" class="form-control-static"><?=$eleve->religion?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="cours_religion">Cours de religion:</label>
                        <div class="col-sm-7">
                            <p id="cours_religion" class="form-control-static"><?php if($eleve->cours_religion==0) echo 'Non'; else echo 'Oui';?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="pere">Père:</label>
                        <div class="col-sm-7">
                            <p id="pere" class="form-control-static"><?=$eleve->pere?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5" for="mere">Mère:</label>
                        <div class="col-sm-7">
                            <p id="mere" class="form-control-static"><?=$eleve->mere?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

    <div class="col-xs-12">
        <b class="soustitre">Informations du tuteur</b>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <table class="table datatable compact table-striped table-bordered">
                    <thead>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <td><?=$eleve->tuteur->prenom?></td>
                        <td><?=$eleve->tuteur->nom?></td>
                        <td><?php if($eleve->tuteur->user) echo $eleve->tuteur->user->email;?></td>
                        <td>
                            <?= $this->Html->link('<i class="icone glyphicon glyphicon-eye-open"></i> Voir la fiche', ['controller'=>'Tuteurs','action' => 'fiche', $eleve->tuteur_id], ['escape'=> false,'class'=>"btn btn-xs btn-default"]) ?>
                        </td>
                    </tbody>
                </table>
                
            </div>
        </div>
        
    </div>

    <div class="col-xs-12">
        <b class="soustitre">Historique des inscriptions</b>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <table class="table datatable compact table-striped table-bordered">
                    <thead>
                        <th>Classe</th>
                        <th>Année</th>
                    </thead>
                    <tbody>
                        <?php foreach($eleve->inscriptions as $inscription):?>
                            <td><?php if(!empty($inscription->affectations)) echo $inscription->affectations[0]->groupe->nom?></td>
                            <td><?=$inscription->promotion->annee->nom?></td>
                        <?php endforeach;?>
                    </tbody>
                </table>
                
            </div>
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
    
</script>
<?php $this->end(); ?>