<?php
use Cake\I18n\Time;

$auj = Time::now();

?>

<div class="titre">
    <span>Liste des devoirs <?php if($groupe) echo "de la classe ".$groupe->nom;?></span>
    <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#ajoutDevoirModal">
        <span class="glyphicon glyphicon-calendar"></span> Ajouter un devoir
    </a>
</div>

<div class="row">
    <br>
    <div class="col-xs-12">
        <table id="devoirs_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <?php if(!$groupe) echo '<th title="Classe">Classe</th>';?>
                    <th title="Matière">Matière</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($devoirs as $devoir): ?>
                <tr>
                    <td><?=$devoir->date->format('Y-m-d H:i')?></td>
                    <?php if(!$groupe) echo '<td>'.$devoir->cour->groupe->nom.'</td>';?>
                    <td><?=$devoir->cour->matiere->nom?></td>
                    <td class="actions">
                        <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['controller'=>'Devoirs','action'=>"fiche",$devoir->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ajout devoir -->
<div class="modal fade" id="ajoutDevoirModal" tabindex="-1" role="dialog" aria-labelledby="ajoutDevoirModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Devoirs', 'action' => 'ajouter']) ?>" method="post">
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
                <label for="cours" class="col-sm-4">Cours</label>
                <div class="col-sm-8">
                    <select name="cours_id" class="form-control" required>
                        <?php foreach($cours as $cour):?>
                            <option value="<?=$cour->id?>">  <?=$cour->matiere->nom?> - <?=$cour->groupe->nom?></option>
                        <?php endforeach; ?>
                    </select>
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
        table = $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": true,
            "order": [[ 0, "desc" ]],
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
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
                "targets": 3,
                "orderable": false
                },
            ]*/
        });
        table.buttons().container().appendTo( '#devoirs_table_wrapper .col-sm-6:eq(0)' );
    });
    
</script>
<?php $this->end(); ?>