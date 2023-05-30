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
    <a class="btn btn-sm btn-default" href="/professorat/groupes/fiche/<?=$cours->groupe->id?>"><?=$cours->groupe->nom?></a>
    <a class="btn btn-sm btn-default" href="/professorat/professeurs/fiche/<?=$cours->professeur->id?>">Pr. <?=$cours->professeur->nom?> <?=$cours->professeur->prenom?></a>
    
    <a class="btn btn-sm btn-primary pull-right" href="/professorat/cours/cahier-de-texte/<?=$cours->id?>" >Cahier de texte</a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Présentation du cours
                <span class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#editContenuModal"><span class="glyphicon glyphicon-pencil icone"></span></span>
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
                <button type="button" class="btn btn-default btn-xs icone pull-right" data-toggle="modal" data-target="#pjModal">
                    <span class="glyphicon glyphicon-pencil icone"></span>
                </button>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des devoirs
                <a class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#ajoutDevoirModal" href="#"><i class="glyphicon glyphicon-plus"></i> Ajouter un devoir</a>
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
                <a class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#AjoutSeanceModal" href="#"><i class="glyphicon glyphicon-calendar"></i> Démarrer une séance</a>
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
                                elseif($presence->type=='renvoi') $renvois++;
                            }
                            ?>
                            <td><?=$retards?></td>
                            <td><?=$absences?></td>
                            <td><?=$renvois?></td>
                            <td><?=$seance->etat?></td>
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

<!-- Modal contenu cours-->
<div class="modal fade" id="editContenuModal" tabindex="-1" role="dialog" aria-labelledby="editContenuModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Cours', 'action' => 'fiche',$cours->id]) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editContenuModalLabel">Modifier la présentation</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <div class="col-xs-12">
                    <textarea name="contenu" class="form-control" rows='10'><?=$cours->contenu?></textarea>
                </div>
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" >Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal Ajout devoir -->
<div class="modal fade" id="ajoutDevoirModal" tabindex="-1" role="dialog" aria-labelledby="ajoutDevoirModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="cours_id" value="<?=$cours->id?>" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajoutdevoirModalLabel">Ajouter un devoir</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="periode" class="col-sm-4">Période</label>
                <div class="col-sm-8">
                    <?=$this->Form->select("periode_id",$periodes,['class'=>'form-control','id'=>'periode'])?>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="date" class="col-sm-4">Date</label>
                <div class="col-sm-5">
                    <input name="date" type="date" class="form-control" style="line-height:inherit;" value="<?= $auj->format('Y-m-d');?>" required>
                </div>
                <div class="col-sm-3">
                    <input name="heure" type="time" class="form-control" style="line-height:inherit;" value="08:00" required>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Durée</label>
                <div class="col-sm-8">
                    <select name="duree" class="form-control" required>
                            <option value="1"> 1H </option>
                            <option value="1.5"> 1H 30MN </option>
                            <option value="2"> 2H </option>
                            <option value="2.5"> 2H 30MN </option>
                            <option value="3"> 3H </option>
                            <option value="3.5"> 2H 30MN </option>
                            <option value="4"> 3H </option>
                    </select>
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

<!-- Modal Démarrage séance-->
<div class="modal fade" id="AjoutSeanceModal" tabindex="-1" role="dialog" aria-labelledby="ajoutSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'demarrer']) ?>" method="post">
        <input type="hidden" name="cours_id" value="<?=$cours->id?>" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutSeanceModalLabel">Démarrer une séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="date" class="col-sm-4">Date</label>
                <div class="col-sm-8">
                    <input name="date" type="date" class="form-control" style="line-height:inherit;" value="<?= $auj->format('Y-m-d');?>" required>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Début</label>
                <div class="col-sm-8">
                    <select name="debut" class="form-control" required>
                        <?php foreach($heures as $heure):?>
                            <option value="<?=$heure?>">
                            <?php
                                $hr= (int)($heure);
                                $reste = $heure-$hr;
                                echo $hr."H ";
                                if($reste>0) echo "30MN";
                            ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Durée</label>
                <div class="col-sm-8">
                    <select name="duree" class="form-control" required>
                            <option value="1"> 1H </option>
                            <option value="1.5"> 1H 30MN </option>
                            <option value="2"> 2H </option>
                            <option value="2.5"> 2H 30MN </option>
                            <option value="3"> 3H </option>
                    </select>
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

<!-- Modal pj-->
<div class="modal fade" id="pjModal" tabindex="-1" role="dialog" aria-labelledby="pjModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Cours', 'action' => 'editer_pj']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$cours->id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="pjModalLabel">Chargement du document</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="eleves_acces_check" class="col-sm-2 col-xs-12">Document</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="file" name="pj" id="pj">
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
    CKEDITOR.replace( 'contenu' );
});

</script>
<?php $this->end(); ?>