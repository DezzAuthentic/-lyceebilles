<?php
use Cake\I18n\Time;

$auj = Time::now();

?>

<div class="titre">
    <span>Liste des devoirs de mes élèves</span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Devoirs notés
            </div>
            <table id="devoirs_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Classe">Classe</th>
                        <th title="Matière">Matière</th>
                        <th title="Note">Note</th>
                        <th class="actions" style="min-width:130px;">
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($devoirs as $devoir): if($devoir->devoir_notes):?>
                    <tr>
                        <td><?=$devoir->date?></td>
                        <td><?=$devoir->cour->groupe->nom?></td>
                        <td><?=$devoir->cour->matiere->nom?></td>
                        <td>
                            <?php foreach($devoir->devoir_notes as $note):?>
                                <span class="btn btn-default btn-xs"><?=$note->elef->prenom.' '.
                                    $note->elef->nom.': '.$note->note.''?>
                                </span>
                            <?php endforeach; ?>
                        </td>
                        <td class="actions">
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Devoirs','action'=>"fiche",$devoir->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                        </td>
                    </tr>
                <?php $i++; endif;endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Devoirs non encore notés
            </div>
            <table id="devoirs_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Classe">Classe</th>
                        <th title="Matière">Matière</th>
                        <th class="actions" style="min-width:130px;">
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($devoirs as $devoir): if($devoir->devoir_notes==null):?>
                    <tr>
                        <td><?=$devoir->date?></td>
                        <td><?=$devoir->cour->groupe->nom?></td>
                        <td><?=$devoir->cour->matiere->nom?></td>
                        <td class="actions">
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Devoirs','action'=>"fiche",$devoir->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                        </td>
                    </tr>
                <?php $i++; endif;endforeach;?>
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
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": false,
            "searching": false,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "&nbsp; Afficher _MENU_ par page",
                "zeroRecords": "Pas de devoirs trouvés!",
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
