<div class="titre">
    Liste des produits

    <a id="modif_btn" type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#ajoutProduitModal">
        <span class="glyphicon glyphicon-plus"></span> Ajouter
    </a>
    <a type="button" class="btn btn-primary pull-right btn-sm mr1" href="<?=$this->Url->Build(['controller'=>'Familles','action'=>'index'])?>">Familles</a>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="produits_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Libellé">Libellé</th>
                    <th title="Famille">Famille</th>
                    <th title="Prix">Prix</th>
                    <th class="actions" style="min-width:150px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($produits as $produit): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$produit->libelle?></td>
                    <td><?=$produit->famille->libelle?></td>
                    <td><?=$produit->prix?></td>
                    <td class="actions">
                        <?php //$this->Html->link('Voir la fiche',[],['class' => 'btn btn-xs btn-warning'])?>
                        <span class="btn btn-xs btn-default modifierProduit" data-toggle="modal" data-target="#modifierProduitModal" >
                            <i class="glyphicon glyphicon-pencil icone"></i>
                            <input type="hidden" value="<?=$produit->id.'*'.$produit->libelle.'*'.$produit->famille->id.'*'.$produit->prix?>">
                        </span>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'supprimer', $produit->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer ce produit # {0}?', $produit->id),'class'=>"btn btn-xs btn-default"]); ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Ajout produit-->
<div class="modal fade" id="ajoutProduitModal" tabindex="-1" role="dialog" aria-labelledby="ajoutProduitModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Produits', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutGroupeModalLabel">Ajouter un produit</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="libelle" class="col-sm-4">Libellé</label>
                <div class="col-sm-8">
                    <input required type="text" name="libelle" class="form-control" id="libelle">
                </div>
            </div>
            <div class="form-group row ">
                <label for="famille_id" class="col-sm-4">Famille</label>
                <div class="col-sm-8">
                    <?= $this->Form->select('famille_id',$familles,['class'=>'Form-control',"id"=>'famille_id']) ?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="prix" class="col-sm-4">Prix</label>
                <div class="col-sm-8">
                    <input required type="text" name="prix" class="form-control" id="prix">
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

<!-- Modal Modifier un produit-->
<div class="modal fade" id="modifierProduitModal" tabindex="-1" role="dialog" aria-labelledby="modifierProduitModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Produits', 'action' => 'modifier']) ?>" method="post">
        <input type="hidden" name="id" id="modifier_id" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modifierProduitModalLabel">Modifier le produit</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="libelle" class="col-sm-4">Libellé</label>
                <div class="col-sm-8">
                    <input required type="text" name="libelle" class="form-control" id="modifier_libelle">
                </div>
            </div>
            <div class="form-group row ">
                <label for="famille_id" class="col-sm-4">Famille</label>
                <div class="col-sm-8">
                    <?= $this->Form->select('famille_id',$familles,['class'=>'Form-control',"id"=>'modifier_famille_id']) ?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="prix" class="col-sm-4">Prix</label>
                <div class="col-sm-8">
                    <input required type="text" name="prix" class="form-control" id="modifier_prix">
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
                "zeroRecords": "Pas de produits trouvés!",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Pas de produit disponible",
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
        table.buttons().container().appendTo( '#produits_table_wrapper .col-sm-6:eq(0)' );        
    });

    $(".modifierProduit").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#modifier_id").val(data[0]);
        $("#modifier_libelle").val(data[1]);
        $("#modifier_famille_id").val(data[2]);
        $("#modifier_prix").val(data[3]);
    });
    
</script>
<?php $this->end(); ?>