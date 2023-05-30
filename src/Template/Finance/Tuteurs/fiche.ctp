<div class="titre">
    <span>Tuteur: <?=$tuteur->prenom?> <?=$tuteur->nom?>
    <a href="/finance/tuteurs/modifier/<?=$tuteur->id?>" class="pull-right btn btn-sm btn-default">Modifier</a>
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
                            <?= $this->Html->link("<span class='glyphicon glyphicon-eye-open icone'></span> Fiche de l'élève",'/finance/eleves/fiche/'.$elef->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
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