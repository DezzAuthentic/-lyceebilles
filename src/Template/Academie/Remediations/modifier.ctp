<div class="titre">
    Remédiations: inscription
</div>
<form method="post" >
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <label for="eleve_id">Elève </label> <br>
                    <?=$inscription->elef->prenom?> <?=$inscription->elef->nom?> - <?=$inscription->elef->matricule?>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12">
            <div class="panel panel-default bg-gris">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-lg-3">
                            <label for="matiere" class="">Matière</label>
                            <select id="matiere" class="form-control p1 select2">
                                <?php foreach($matieres as $matiere): ?>
                                    <option value="<?=$matiere->id?>">
                                        <?=$matiere->nom?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach($matieres as $matiere): ?>
                            <span id="libellem<?=$matiere->id?>" style='display:none;'><?=$matiere->nom?></span>
                        <?php endforeach; ?>
                        <div class="col-xs-6 col-lg-3">
                            <label for="professeur" class="">Professeur</label>
                            <select id="professeur" class="form-control p1 select2 input-sm">
                                <?php foreach($professeurs as $professeur): ?>
                                    <option value="<?=$professeur->id?>" style="display:none;visible:false">
                                        Pr. <?=$professeur->prenom?> <?=$professeur->nom?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach($professeurs as $professeur): ?>
                            <span id="libellep<?=$professeur->id?>" style='display:none;'>Pr. <?=$professeur->prenom?> <?=$professeur->nom?></span>
                        <?php endforeach; ?>
                        <div class="col-xs-8 col-lg-5">
                            <label for="objet" class="">Objet</label>
                            <input type="text" id="objet" class="form-control p1 input-sm">
                        </div>
                        <div class="col-xs-4 col-lg-1">
                            <br>
                            <a id="add_matiere" class="btn btn-sm btn-block btn-primary mt2"><i class="glyphicon glyphicon-plus"></i></a>
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
                        <th>Professeur</th>
                        <th>Objet</th>
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
                    <label for="">Validation de l'inscription:</label>
                    <button type="submit" class="btn btn-md btn-success pull-right">Valider</button>
                </div>
            </div>
        </div>
    </div>

</form>

<div class="row">
    <div class="col-xs-12">
        <div class="soustitre2">Remédiations en cours</div>
        <table class="datatable table-striped compact">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Professeur</th>
                    <th>Objet</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="lignes">
            <?php foreach($remediations as $remediation):?>
                <tr>
                    <th><?=$remediation->matiere->nom?></th>
                    <th>Pr. <?=$remediation->professeur->prenom?> <?=$remediation->professeur->nom?></th>
                    <th><?=$remediation->objet?></th>
                    <th>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'supprimerRem', $remediation->id], ["escape"=>false,'confirm' => __('Voulez-vous supprimer la remédiation # {0}?', $remediation->id),'class'=>"btn btn-xs btn-default"]); ?>
                    </th>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>



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
                "zeroRecords": "Pas de nouvelle remédiation !",
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
        idm = $('#matiere').val();
        libelle = $('#libellem'+idm).html();
        idp = $('#professeur').val();
        professeur = $('#libellep'+idp).html();
        objet = $('#objet').val();
        if(objet==""){
            alert('Merci de définir un objet');
        }else {
            ajouterLigne(idm,libelle,idp,professeur,objet);
            $('#objet').val('');
        }
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

    function ajouterLigne(idm, libelle, idp, professeur, objet){
        cell1 = "<input type='hidden' name='lignes["+i+"][matiere_id]' value='"+idm+"'> "+libelle;
        cell2 = "<input type='hidden' name='lignes["+i+"][professeur_id]' value='"+idp+"'> "+professeur;
        cell3 = "<input type='hidden' name='lignes["+i+"][objet]' value='"+objet+"'>"+objet;
        table.row.add( [
            "<td>"+cell1+"</td>",
            "<td>"+cell2+"</td>",
            "<td>"+cell3+"</td>",
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