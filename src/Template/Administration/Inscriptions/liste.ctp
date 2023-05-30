<div class="titre">
    <span>Liste des inscriptions</span>
    <a id="ajout_btn" href="/administration/inscriptions/nouvelle" class="btn btn-default btn-sm pull-right" >
        <span class="glyphicon glyphicon-pencil"></span> inscrire un élève
    </a>
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="inscriptions_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="id"></th>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Promotion">Promotion</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($inscriptions as $inscription): ?>
                <tr>
                    <td><?=$inscription->id?></td>
                    <td><?=$inscription->elef->nom?></td>
                    <td><?=$inscription->elef->prenom?></td>
                    <td><?=$inscription->promotion->nom?></td>
                    <td class="actions">
                        <?=$this->Html->link('Facturation',['controller'=>'Factures','action'=>"parEleveMois",$inscription->id],['class' => 'btn btn-xs btn-warning'])?>
                        <?= $this->Form->postLink('Suppr.', ['action' => 'supprimer', $inscription->id], ['confirm' => __('Voulez-vous annuler cette inscription # {0}?', $inscription->id),'class'=>"btn btn-xs btn-danger"]) ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
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