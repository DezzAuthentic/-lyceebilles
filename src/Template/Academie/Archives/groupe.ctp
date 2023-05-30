<div class="titre">
    <span class="text-primary">Année: <?=$groupe->promotion->annee->nom?></span> 
    <span>Classe <?=$groupe->nom?></span> 

    <a id="ajout_btn" href="<?=$this->Url->build(['action'=>'edt',$groupe->id])?>" class="btn btn-default pull-right btn-sm">
        <span class="glyphicon glyphicon-calendar"></span> Emploi du temps
    </a>

</div>

<div class="row">

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des cours
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Matiere">Matière</th>
                        <th title="Professeur">Professeur</th>
                        <th title="heures par semaine">Heures par semaine</th>
                        <th class="actions" style="min-width:150px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->cours as $cour): ?>
                    <tr>
                        <td><?=$cour->matiere->nom?></td>
                        <td>Pr. <?=$cour->professeur->nom?> <?=$cour->professeur->prenom?></td>
                        <?php
                        $heures=0;
                        foreach($cour->edt as $seance){
                            $heures += $seance->duree;
                        }
                        $hr = (int) $heures;
                        $mn = ($heures - $hr) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr.'H '.$mn?></td>
                        <td class="actions">
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['action' => 'cours', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Liste des élèves</div>
            <table id="affectations_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Date de naissance">Date de naissance</th>
                        <th class="actions" style="min-width:180px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->affectations as $affectation): ?>
                    <tr>
                        <td><?=$affectation->inscription->elef->matricule?></td>
                        <td><?=$affectation->inscription->elef->nom?></td>
                        <td><?=$affectation->inscription->elef->prenom?></td>
                        <td><?=$affectation->inscription->elef->date_naissance?></td>
                        <td class="actions">
                            <?=$this->Html->link('Voir la fiche',['controller'=>'Eleves','action'=>'fiche',$affectation->inscription->elef->id],['class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des séances
            </div>
            <table id="seances_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Matière">Matière</th>
                    <th title="retards">Retards</th>
                    <th title="absences">Absences</th>
                    <th title="renvois">Renvois</th>
                    <th title="Durée">Statut</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($seances as $seance): ?>
                <tr>
                    <td><?=$seance->date?></td>
                    <td><?=$seance->cour->matiere->nom?></td>
                    <?php
                    $retards=0;
                    $absences=0;
                    $renvois=0;
                    foreach($seance->presences as $presence){
                        if($presence->type=='retard') $retards++;
                        elseif($presence->type=='absence') $absences++;
                        elseif($presence->type=='renvois') $renvois++;
                    }
                    ?>
                    <td><?=$retards?></td>
                    <td><?=$absences?></td>
                    <td><?=$renvois?></td>
                    <td><?=$seance->etat?></td>
                    <td class="actions">
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['action'=>"seance",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
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
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('#cours_table,#affectations_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
        "language": {
            "lengthMenu": "&nbsp; Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé!",
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
    $('#seances_table').DataTable({
        "info": false,
        "paging": true,
        "ordering": false,
        "searching": false,
        "language": {
            "lengthMenu": "&nbsp; Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé!",
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
    $('.matiere').hide();
    <?php if ($matieres->count() > 0):?>
    $('.matiere-<?=$matieres->toArray()[0]->id?>').show();
    <?php endif;?>
});
$("#ajout_matiere").change( function() {
    console.log("La matière a changé.");
    id = $("#ajout_matiere option:selected").val();
    $('.matiere').hide();
    console.log('.matiere-'+id);
    $('.matiere-'+id).show();
});
</script>
<?php $this->end(); ?>