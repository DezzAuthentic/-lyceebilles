<div class="titre">
    Tests de niveau: Fiche

    <a href="<?=$this->Url->build(["action"=>"modifier",$eleve->id])?>" class="btn btn-sm btn-default pull-right">Modifier</a>
    <a id="modifier" class="btn btn-sm btn-default pull-right mr1">Editer les notes</a>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Elève: </label>
                <?=$eleve->prenom?> <?=$eleve->nom?> - <?=$eleve->matricule?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="promotion_id">Promotion: </label>
                <?=$promotion->nom?>
            </div>
        </div>
    </div>
</div>
<form method="post" >
    <div id="matieres" class="row">
        <div class="col-xs-12">
            <table class="datatable table-striped compact">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Durée</th>
                        <th>Note</th>
                        <th>Appréciations</th>
                    </tr>
                </thead>
                <tbody id="lignes">
                <?php foreach($tests as $test):?>
                    <tr>
                        <th><?=$test->matiere->nom?></th>
                        <th><?=$test->date?></th>
                        <th><?=$test->heure?></th>
                        <th><?=$test->duree?></th>
                        <th>
                            <input type="hidden" name="tests[<?=$test->id?>][id]" value="<?=$test->id?>">
                            <input type="number" name="tests[<?=$test->id?>][note]" value="<?=$test->note?>" readonly style="width:70px;" class="form-control input-sm readonly">
                        </th>
                        <th>
                            <input type="text" name="tests[<?=$test->id?>][appreciation]" value="<?=$test->appreciation?>" readonly class="form-control input-sm readonly">
                        </th>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div id='validation' class="col-xs-12 mt3 text-center">
            <input type="submit" value="Valider" class="btn btn-default btn-md">
            <span id="annuler" class="btn btn-md btn-danger mr1">Annuler</span>
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
    $('#validation').hide();
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

    $('#modifier').click(function(){
        $("#validation").fadeIn();
        $('#modifier').hide();   
        $('.readonly').removeAttr('readonly');
    });

    $('#annuler').click(function(){
        $("#validation").hide();
        $('#modifier').fadeIn();  
        $('.readonly').attr('readonly',"true");
    });
    
</script>