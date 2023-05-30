<div class="titre">
    Enregistrer une vente
</div>
<form method="post" >
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="eleve_id">Client</label>
                    <select name="eleve_id" id="client" class="form-control select2">
                        <option value="null">Client générique</option>
                        <?php foreach($inscriptions as $inscription): ?>
                            <option value="<?=$inscription->elef->id?>"><?=$inscription->elef->prenom?> <?=$inscription->elef->nom?> - <?=$inscription->elef->matricule?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <div class="row">
                        <label for="" class="col-xs-12">Produit</label>
                        <div class="col-xs-8">
                            <select id="produit" class="form-control select2 p1">
                                <?php foreach($produits as $produit): ?>
                                    <option value="<?=$produit->id?>">
                                        <?=$produit->libelle?> - <?=$produit->famille->libelle?>
                                    </option>
                                    <!--span id="prix<?=$produit->id?>" style='display:none;'><?=$produit->prix?></span>
                                    <span id="libelle<?=$produit->id?>" style='display:none;'><?=$produit->libelle?></span-->
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach($produits as $produit): ?>
                            <span id="prix<?=$produit->id?>" style='display:none;'><?=$produit->prix?></span>
                            <span id="libelle<?=$produit->id?>" style='display:none;'><?=$produit->libelle?></span>
                        <?php endforeach; ?>
                        <div class="col-md-2 pl0">
                            <input id="quantite" type="number" min="1" placeholder='qté' class="form-contol" style="width:100%;padding:3px;">
                        </div>
                        <div class="col-xs-2 pl0">
                            <input id="add_produit" type="button" value="Ajouter" class="btn-block btn-primary" style="padding:3px;">
                        </div>
                    </div>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                </tbody>
                <tfoot class="" id="footer">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th><span id="total">0</span> Fcfa</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row" id="enregistrement" style="display:none;">
        <div class="col-xs-12 mt3">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="">Enregistement de la vente:</label>
                    <button type="submit" name="status" value='3' class="btn btn-md btn-success pull-right">Clôturer</button>
                    <button type="submit" name="status" value='2' class="btn btn-md btn-warning pull-right mr1">En attente</button>
                    <button type="button" id="partiel" class="btn btn-md btn-default pull-right mr1">Paiement partiel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="paiementpartiel" style="display:none;">
        <div class="col-xs-12 mt3">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="">Paiement partiel:</label>
                    <button type="button" id="annulerpartiel" class="btn btn-md btn-danger pull-right  ">Annuler</button>
                    <button type="submit" id="partiel" name='status' value = '4' class="btn btn-md btn-default pull-right mr1">Valider</button>
                    <input id="paye" type="number" name='paye' class="pull-right mr1" placeholder="Montant du paiement">
                </div>
            </div>
        </div>
    </div>
</form>
<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
    "https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css",
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
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js",
],
['block' => 'script']);
?>

<script>
    var i=0;
    $('.select2').select2();
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

    $("#add_produit").click( function(){
        id = $('#produit').val();
        libelle = $('#libelle'+id).html();
        prix = $('#prix'+id).html();
        quantite = $('#quantite').val();
        console.log('libelle:'+libelle+' prix:'+prix+' quantité:'+quantite);
        if(quantite>0) ajouterLigne(id,libelle,quantite,prix);
        else alert("Merci de renseigner une quantité valide");
        calculerTotal();
    });
    $("lignes").click( function(){
        alert(this.parents('tr'));
        this.parents('tr').remove();
    });
    $(document).on("click", ".supprligne" , function() {
        //$(this).parents('tr').remove();
        table.row($(this).parents('tr')).remove().draw();
        calculerTotal();
    });

    function ajouterLigne(id, libelle, quantite, prix){
        /*ligne = "<tr id='ligne"+i+"'>"+
                "<td>"+libelle+"</td>"+
                "<td>"+quantite+"</td>"+
                "<td>"+prix+"</td>"+
                "<td>"+quantite*prix+"</td>"+
                "<td><span class='btn btn-xs btn-danger supprligne'>Suppr</span></td>"+
                "</tr>";*/
        //$('#lignes').append(ligne);
        cell1 = "<input type='hidden' name='lignes["+i+"][produit_id]' value='"+id+"'> "+libelle;
        cell2 = "<input type='number' name='lignes["+i+"][quantite]' value='"+quantite+"' min='1' class='input-sm input-qte'>";
        cell3 = "<input type='hidden' name='lignes["+i+"][prix]' value='"+prix+"' min='1' class='form-control input-prix'>"+prix+" Fcfa";
        cell4 = "<span class='montant'>"+quantite*prix+"</span> Fcfa";
        table.row.add( [
            "<td>"+cell1+"</td>",
            "<td>"+cell2+"</td>",
            "<td>"+cell3+"</td>",
            "<td>"+cell4+"</td>",
            "<td><span class='btn btn-xs btn-danger supprligne'>Suppr</span></td>"
        ] ).draw( false );
        i++;
    }
    function calculerTotal(){
        total = 0;
        $('.montant').each(function(){
            montant = parseInt($(this).html());
            total += montant;
        });
        $("#total").html(total);
        if(total>0) {
            $('#paiementpartiel').hide();
            $('#enregistrement').fadeIn();
        }
        else {
            $('#paiementpartiel').hide();
            $('#enregistrement').hide();
        }
    }
    $(document).on("change", ".input-qte" , function() {
        prix = $(this).parents('tr').find('.input-prix').first().val();
        quantite = $(this).val();
        //console.log(prix*quantite);
        $(this).parents('tr').find('.montant').first().html(prix*quantite);
        calculerTotal();
    });
    $(document).on("click", "#partiel" , function() {
        $('#enregistrement').hide();
        $('#paiementpartiel').show();
    });
    $(document).on("click", "#annulerpartiel" , function() {
        $('#paiementpartiel').hide();
        $('#enregistrement').show();
    });
</script>