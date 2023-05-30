<div class="titre">
    <span>Gestion des périodes</span>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="annees_table" class="table" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Libellé">Libellé</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=1; foreach($periodes as $periode):?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$periode->nom?></td>
                    <td><?=$periode->statut?></td>
                    <td>
                        <?php if($periode->statut=="actif"):?>
                            <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>Clôturer', ['action' => 'cloturer', $periode->id], ['escape'=> false,'confirm' => __('Voulez-vous clôturer cette période # {0}?', $periode->id),'class'=>"btn btn-xs btn-default"]) ?>
                        <?php else:?>
                            <?= $this->Form->postLink('<i class="icone glyphicon glyphicon-open"></i>Réouvrir', ['action' => 'ouvrir', $periode->id], ['escape'=> false,'confirm' => __('Voulez-vous clôturer cette période # {0}?', $periode->id),'class'=>"btn btn-xs btn-default"]) ?>
                        <?php endif;?>
                    </td>

                    
                </tr>
            <?php $i++;endforeach;?>
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