<div class="titre">
    Liste des familles

    <a id="modif_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#ajoutFamilleModal">
        <span class="glyphicon glyphicon-plus"></span> Ajouter
    </a>
    <a type="button" class="btn btn-primary pull-right btn-sm mr1" href="<?=$this->Url->Build(['controller'=>'Produits','action'=>'index'])?>">Produits</a>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="familles_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Libellé">Libellé</th>
                    <th class="actions" style="min-width:150px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($familles as $famille): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$famille->libelle?></td>
                    <td class="actions">
                        <?php //$this->Html->link('Voir la fiche',[],['class' => 'btn btn-xs btn-warning'])?>
                        <span class="btn btn-xs btn-default modifierFamille" data-toggle="modal" data-target="#modifierFamilleModal" >
                            <i class="glyphicon glyphicon-pencil icone"></i>
                            <input type="hidden" value="<?=$famille->id.'*'.$famille->libelle?>">
                        </span>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'supprimer', $famille->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer cette famille # {0}?', $famille->id),'class'=>"btn btn-xs btn-default"]); ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Ajout famille-->
<div class="modal fade" id="ajoutFamilleModal" tabindex="-1" role="dialog" aria-labelledby="ajoutFamilleModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Familles', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutFamilleModalLabel">Ajouter une famille</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="libelle" class="col-sm-4">Libellé</label>
                <div class="col-sm-8">
                    <input required type="text" name="libelle" class="form-control" id="libelle">
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

<!-- Modal Modifier famille-->
<div class="modal fade" id="modifierFamilleModal" tabindex="-1" role="dialog" aria-labelledby="modifierFamilleModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Familles', 'action' => 'modifier']) ?>" method="post">
        <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
        <input type="hidden" name="id" id="modifier_id" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modifierFamilleModalLabel">Modifier la famille</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="libelle" class="col-sm-4">Libellé</label>
                <div class="col-sm-8">
                    <input required type="text" name="libelle" class="form-control" id="modifier_libelle">
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
        table.buttons().container().appendTo( '#familles_table_wrapper .col-sm-6:eq(0)' );        
    });

    $(".modifierFamille").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#modifier_id").val(data[0]);
        $("#modifier_libelle").val(data[1]);
    });
    
</script>
<?php $this->end(); ?>