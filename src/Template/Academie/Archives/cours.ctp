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
    <span class="text-primary">Année: <?=$cours->groupe->promotion->annee->nom?></span> <span>Fiche de cours: <?=$cours->matiere->nom?></span> - 
    <span >Pr. <?=$cours->professeur->nom?> <?=$cours->professeur->prenom?></span>
    <a class="btn btn-sm btn-default" href="<?=$this->Url->build(['action'=>'groupe',$cours->groupe->id])?>"><?=$cours->groupe->nom?></a>
    
    <a class="btn btn-sm btn-primary pull-right" href="<?=$this->Url->Build(["action"=>"cahier-de-texte",$cours->id])?>" >Cahier de texte</a>
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
                Document de présentation du cours
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
            <table id="seances_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="retards">Durée</th>
                        <th title="absences">Periode</th>
                        <th class="actions" style="min-width:130px;">   
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
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['action'=>"devoir",$devoir->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
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
                            <th title="retards">Retards</th>
                            <th title="absences">Absences</th>
                            <th title="renvois">Renvois</th>
                            <th title="Durée">Statut</th>
                            <th class="actions" style="min-width:130px;">   
                            </th>
                        </tr>
                    </thead>
                    <tbody>            
                    <?php $i=0; foreach($cours->seances as $seance): ?>
                        <tr>
                            <td><?=$seance->date?></td>
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
    CKEDITOR.replace( 'contenu' );
});

</script>
<?php $this->end(); ?>