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
    <span>Suivi des séances <?php if($groupe) echo "de la classe ".$groupe->nom;?></span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#AjoutSeanceModal">
        <span class="glyphicon glyphicon-calendar"></span> Démarrer une séance
    </a>
</div>

<div class="row">
    <br>
    <div class="col-xs-12">
        <table id="seances_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <?php if(!$groupe) echo '<th title="Classe">Classe</th>';?>
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
                    <?php if(!$groupe) echo '<td>'.$seance->cour->groupe->nom.'</td>';?>
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
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Seances','action'=>"fiche",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Démarrage séance-->
<div class="modal fade" id="AjoutSeanceModal" tabindex="-1" role="dialog" aria-labelledby="ajoutSeanceModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Seances', 'action' => 'demarrer']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutSeanceModalLabel">Démarrer une séance</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Cours</label>
                <div class="col-sm-8">
                    <select name="cours_id" class="form-control" required>
                        <?php foreach($cours as $cour):?>
                            <option value="<?=$cour->id?>" 
								<?php 
                               if ($this->request->params['pass'][0] == $cour->groupe_id)
                               {
                                   echo "selected";
                               }
                            ?>
							>  <?=$cour->matiere->nom?> - <?=$cour->groupe->nom?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
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
                "zeroRecords": "Pas de séances trouvées!",
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
            }/*,
            "columnDefs": [ {
                "targets": 4,
                "orderable": false
                },{
                "targets": 5,
                "orderable": false
                }
            ]*/
        });

    });
    
</script>
<?php $this->end(); ?>