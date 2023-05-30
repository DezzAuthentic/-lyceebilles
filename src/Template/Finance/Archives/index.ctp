<?php
$mois = $list_mois->toArray();
?>

<div class="titre">
    <span class="text-primary">Archives</span> 
    <span>Liste des années scolaires</span>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="annees_table" class="table" >
            <thead>
                <tr>
                    <th title="Libellé de l'année">Libellé</th>
                    <th title="Début">Début</th>
                    <th title="Fin">Fin</th>
                    <th ></th>
                </tr>
            </thead>
            <tbody>            
            <?php foreach($annees as $annee):?>
                <tr>
                    <td>
                        <?=$annee->nom?> 
                        <?php if($etablissement->annee_id == $annee->id) echo "(année en cours d'exploitation)";?>
                    </td>
                    <td><?=$mois[$annee->debut]?></td>
                    <td><?=$mois[$annee->fin]?></td>
                    <td>
                        <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['action'=>'init',$annee->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</section>



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
    $('#annees_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
        "buttons": [
            'copy', 'excel', 'pdf'
        ],
        "language": {
            "lengthMenu": "Afficher _MENU_ par page",
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
} );
</script>
<?php $this->end(); ?>