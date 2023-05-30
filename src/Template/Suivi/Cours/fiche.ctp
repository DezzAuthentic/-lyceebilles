<?php
use Cake\I18n\Time;

$auj = Time::now();

$heures= Array();
for($i=8;$i<18;$i++){
    $heures[] = $i;
    $heures[] = $i+0.5;
}

?>

<div class="titre">
    <span>Fiche de cours: <?=$cours->matiere->nom?></span>
    <span class="btn btn-md btn-default" ><?=$cours->groupe->nom?></span>
    <span class="btn btn-md btn-default" >Pr. <?=$cours->professeur->nom?> <?=$cours->professeur->prenom?></span>
    
    <a class="btn btn-md btn-primary pull-right" href="/suivi/cours/cahier-de-texte/<?=$cours->id?>" >Cahier de texte</a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Présentation du cours
            </div>
            <div class="panel-body">
                <?php if($cours->contenu) echo $cours->contenu;
                else echo '<div class="text-center soustitre">Pas de description</div>'; 
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if($cours->pj):?>
                    <a class="btn btn-sm btn-default" href="<?=$this->Url->Build($cours->pj)?>" target='_blank'> Voir le document de présentation</a>
                <?php else:?>
                Pas de document de présentation du cours
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des devoirs
            </div>
            <table id="devoirs_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="retards">Durée</th>
                        <th title="absences">Periode</th>
                        <th class="actions" style="min-width:100px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($cours->devoirs as $devoir): ?>
                    <tr>
                        <td><?=$devoir->date?></td>
                        <?php 
                            $hr_duree = (int) $devoir->duree;
                            $mn_duree = ($devoir->duree - $hr_duree) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr_duree.'H '.$mn_duree?></td>
                        <td><?=$devoir->periode->nom?></td>
                        <td class="actions">
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Devoirs','action'=>"fiche",$devoir->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des séances
            </div>
                <table id="seances_table" class="table datatable hover compact" >
                    <thead>
                        <tr>
                            <th title="Date">Date</th>
                            <th title="Durée">Statut</th>
                            <th class="actions" style="min-width:100px;">   
                            </th>
                        </tr>
                    </thead>
                    <tbody>            
                    <?php $i=0; foreach($seances as $seance): ?>
                        <tr>
                            <td><?=$seance->date?></td>
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
</div>


<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
],
['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('.datatable').DataTable({
        "info": false,
        "paging": true,
        "ordering": false,
        "searching": true,
        "buttons": [
            'copy', 'excel', 'pdf'
        ],
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