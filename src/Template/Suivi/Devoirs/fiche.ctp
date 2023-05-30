<?php
use Cake\I18n\Time;

$auj = Time::now();
?>

<div class="titre">
    <span>Fiche du devoir </span>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Détails du devoir
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Date">Date</th>
                        <th title="Matiere">Matière</th>
                        <th title="Durée">Durée</th>
                    </tr>
                </thead>
                <tbody>            
                    <tr>
                        <td><?= $devoir->date?></td>
                        <td><?= $devoir->cour->matiere->nom?></td>
                        <?php 
                            $hr_duree = (int) $devoir->duree;
                            $mn_duree = ($devoir->duree - $hr_duree) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr_duree.'H '.$mn_duree?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Contenu du devoir
            </div>
            <div class="panel-body">
                <?php if($devoir->description) echo $devoir->description;
                else echo '<div class="text-center soustitre">Pas de contenu</div>'; 
                ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if($devoir->pj):?>
                    <a class="btn btn-sm btn-default" href="<?=$this->Url->Build($devoir->pj)?>" target='_blank'> Voir le document</a>
                <?php else:?>
                Pas de document
                <?php endif;?>
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
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
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