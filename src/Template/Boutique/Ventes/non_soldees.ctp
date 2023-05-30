<div class="titre">
    Liste des ventes non soldées

    <a type="button" class="btn btn-default pull-right btn-sm mr1" href="<?=$this->Url->Build(['action'=>'annulees'])?>">Ventes annulées</a>
    <a type="button" class="btn btn-default pull-right btn-sm mr1" href="<?=$this->Url->Build(['action'=>'effectives'])?>">Ventes effectives</a>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="ventes_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Client">Client</th>
                    <th title="Nombre de produits">Nbre Produits</th>
                    <th title="Montant">Montant</th>
                    <th title="Payé">Payé</th>
                    <th title="Restant">Restant</th>
                    <th class="actions" style="min-width:150px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($ventes as $vente): 
                $client = "Client Générique";
                if($vente->eleve_id!=null) $client = $vente->elef->prenom.' '.$vente->elef->nom." - ".$vente->elef->matricule;
            ?>
                <tr>
                    <td><?=$vente->created?></td>
                    <td><?=$client?></td>
                    <td><?=sizeof($vente->v_lignes)?></td>
                    <td><?=$vente->total?></td>
                    <td><?=$vente->paye?></td>
                    <td><?=$vente->restant?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['action' => 'fiche', $vente->id],["escape"=>false,'class' => 'btn btn-xs btn-primary','title' => 'Afficher la fiche de la vente'])?>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'annuler', $vente->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer ce produit # {0}?', $vente->id),'class'=>"btn btn-xs btn-default",'title' => 'Annuler la vente']); ?>
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
            "ordering": false,
            "searching": true,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
                "zeroRecords": "Pas de ventes trouvées!",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Pas de vente disponible",
                "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
                "search":         "Recherche",
                "scrollX": true,
                "paginate": {
                    "first":      "<<",
                    "last":       ">>",
                    "next":       ">",
                    "previous":   "<"
                }
            },
            "columnDefs": [ {
                "targets": 3,
                "orderable": false
                },{
                "targets": 4,
                "orderable": false
                }
            ]
        });
        table.buttons().container().appendTo( '#ventes_table_wrapper .col-sm-6:eq(0)' );        
    });
    
</script>
<?php $this->end(); ?>