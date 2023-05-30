<div class="titre">
    <span>Gestion de la classe <?=$groupe->nom?></span>
    <a id="ajout_btn" href="/suivi/edt/classe/<?=$groupe->id?>" class="btn btn-default pull-right btn-sm">
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
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Cours','action' => 'fiche', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
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
                    $hr=(int)$seance->duree;
                    $mn=$seance->duree - $hr;
                    ?>
                    <td><?=$hr?>H <?php if($mn>0) echo '30MN'?></td>
                    <td class="actions">
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Seances','action'=>"fiche",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
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
    $('#seances_table').DataTable({
        "info": false,
        "paging": true,
        "ordering": false,
        "searching": true,
        "language": {
            "lengthMenu": "Afficher _MENU_ par page",
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
    $('#cours_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
        "language": {
            "lengthMenu": "Afficher _MENU_ par page",
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
});
</script>
<?php $this->end(); ?>