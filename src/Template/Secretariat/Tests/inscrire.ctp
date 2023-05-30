<div class="titre">
    Tests de niveau: inscription
</div>
<form method="post" >
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="eleve_id">Elève </label>
                    <select name="eleve_id" id="eleve" class="form-control select2">
                        <?php foreach($eleves as $eleve): ?>
                            <option value="<?=$eleve->id?>"><?=$eleve->prenom?> <?=$eleve->nom?> - <?=$eleve->matricule?> </option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="promotion_id">Promotion</label>
                    <select name="promotion_id" id="promotion" class="form-control select2">
                        <?php foreach($promotions as $promotion): ?>
                            <option value="<?=$promotion->id?>"><?=$promotion->nom?> </option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-8 col-lg-4">
                            <label for="matiere" class="">Matière</label>
                            <select id="matiere" class="form-control p1">
                                <?php foreach($matieres as $matiere): ?>
                                    <option value="<?=$matiere->id?>">
                                        <?=$matiere->nom?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach($matieres as $matiere): ?>
                            <span id="libelle<?=$matiere->id?>" style='display:none;'><?=$matiere->nom?></span>
                        <?php endforeach; ?>
                        <div class="col-xs-5 col-lg-3">
                            <label for="date" class="">Date</label>
                            <input id="date" type="date" placeholder='Date' class="form-contol" style="width:100%;">
                        </div>
                        <div class="col-xs-3 col-lg-2">
                            <label for="heure" class="">Heure</label>
                            <select id="heure" class="form-control p1">
                                <?php for($i=8;$i<=17;$i++):?>
                                    <option><?=$i?>H</option>
                                    <option><?=$i?>H30MN</option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-xs-3 col-lg-2">
                            <label for="duree" class="">Durée</label>
                            <select id="duree" class="form-control p1">
                                <option >30MN</option>
                                <option >1H</option>
                                <option >1H30MN</option>
                                <option >2H</option>
                                <option >2H30MN</option>
                                <option >3H</option>
                            </select>
                        </div>
                        <div class="col-xs-4 col-lg-1">
                            <br>
                            <a id="add_matiere" class="btn btn-md btn-block btn-primary mt2"><i class="glyphicon glyphicon-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div id="matieres" class="row">
        <div class="col-xs-12">
            <table class="datatable table-striped compact">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Durée</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="inscription" style="display:none;">
        <div class="col-xs-12 mt3">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="">Inscription de l'élève:</label>
                    <button type="submit" class="btn btn-md btn-success pull-right">Valider</button>
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
                "zeroRecords": "Pas encore de test !",
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

    $("#add_matiere").click( function(){
        id = $('#matiere').val();
        libelle = $('#libelle'+id).html();
        date = $('#date').val();
        heure = $('#heure').val();
        duree = $('#duree').val();
        if(date==""){
            alert('Merci de définir une date valide');
        }else ajouterLigne(id,libelle,date,heure,duree);
    });
    $("lignes").click( function(){
        alert(this.parents('tr'));
        this.parents('tr').remove();
    });
    $(document).on("click", ".supprligne" , function() {
        //$(this).parents('tr').remove();
        table.row($(this).parents('tr')).remove().draw();
        inscription();
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
        cell1 = "<input type='hidden' name='lignes["+i+"][matiere_id]' value='"+id+"'> "+libelle;
        cell2 = "<input type='date' name='lignes["+i+"][date]' value='"+date+"' readonly class='form-control input-sm'>";
        cell3 = "<input type='text' name='lignes["+i+"][heure]' value='"+heure+"' readonly class='form-control input-sm'>";
        cell4 = "<input type='text' name='lignes["+i+"][duree]' value='"+duree+"' readonly class='form-control input-sm'>";
        table.row.add( [
            "<td>"+cell1+"</td>",
            "<td>"+cell2+"</td>",
            "<td>"+cell3+"</td>",
            "<td>"+cell4+"</td>",
            "<td><span class='btn btn-xs btn-danger supprligne'>Suppr</span></td>"
        ] ).draw( false );
        i++;
        inscription();
    }
    function inscription(){
        nbr = $('.supprligne').length;
        if(nbr == 0) $('#inscription').hide();
        else $('#inscription').fadeIn();
    }
    
</script>