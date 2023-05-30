<div class="titre">
    Fiche de la vente n°<?=$vente->id?>: <small class="weight-500"><?=$vente->created->nice()?></small>
    <?php if($vente->status==1):?>
        <a type="button" class="btn btn-danger pull-right btn-sm mr1" href="<?=$this->Url->Build(['action'=>'annuler',$vente->id])?>">Annuler</a>
        <a type="button" class="btn btn-success pull-right btn-sm mr1" href="<?=$this->Url->Build(['action'=>'confirmer',$vente->id])?>">Confirmer</a>
    <?php elseif($vente->status==2):?>
        <a type="button" class="btn btn-primary pull-right btn-sm mr1" href="<?=$this->Url->Build(['action'=>'cloturer',$vente->id])?>">Clôturer</a>
    <?php endif;?>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Client:</label><br>
                <?php 
                    if($vente->eleve_id!=null) echo $vente->elef->prenom.' '.$vente->elef->nom." - ".$vente->elef->matricule;
                    else echo "Client générique"
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Etat:</label><br>
                <?php 
                    if($vente->status == 1) $etat = '<span class="label label-warning">Enregistré</span>';
                    elseif($vente->status == 2) $etat = '<span class="label label-success">Validé</span>';
                    elseif($vente->status == 3) $etat = '<span class="label label-success">Clôturé</span>';
                    elseif($vente->status == 4) $etat = '<span class="label label-success">Non soldé</span>';
                    elseif($vente->status == 0) $etat = '<span class="label label-danger">Annulé</span>';
                    else $etat = '<span class="label label-default">Non défini</span>';
                    echo $etat;
                ?>
            </div>
        </div>
    </div>
</div>  

<div id="commande" class="row">
    <div class="col-xs-12">
        <table class="datatable table-striped compact">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Quantité</th>
                    <th>Prix U.</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody id="lignes">
                <?php foreach($vente->v_lignes as $ligne): ?>
                    <tr>
                        <td><?=$ligne->produit->libelle?></td>
                        <td><?=$ligne->quantite?></td>
                        <td><?=$this->Number->format($ligne->prix)?> Fcfa</td>
                        <td><?=$this->Number->format($ligne->prix*$ligne->quantite)?> Fcfa</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot class="" id="footer">
                <tr class='bg-gris'>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th><span id="total"><?=$this->Number->format($vente->total)?></span> Fcfa</th>
                </tr>
                <tr class='bg-gris'>
                    <th></th>
                    <th></th>
                    <th>Payé</th>
                    <th><span id="paye"><?=$this->Number->format($vente->paye)?></span> Fcfa</th>
                </tr>
                <tr class='bg-gris'>
                    <th></th>
                    <th></th>
                    <th class="text-primary">Restant</th>
                    <th class="text-primary"><span id="paye"><?=$this->Number->format($vente->restant)?></span> Fcfa</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php if($vente->status=='4' or $vente->status=='2'):?>
    <form action="<?=$this->Url->build(['action'=>"payer",$vente->id])?>" method="post" >
        <div class="row" id="paiementpartiel">
            <div class="col-xs-12 mt3">
                <div class="panel panel-default bg-gris">
                    <div class="panel-body">
                        <label for="">Paiement:</label>
                        <button type="submit" id="partiel" name='status' value = '4' class="btn btn-md btn-default pull-right mr1">Valider</button>
                        <input id="paye" type="number" name='paye' class="pull-right mr1" placeholder="Montant du paiement">
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif;?>

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

<script>
    var i=0
    $(function () {
        table = $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
            "buttons": [
                'copy', 'excel'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page &nbsp;",
                "zeroRecords": "Pas encore de produit commandé!",
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
    });
</script>