<div class="titre">
    Remédiation: Fiche

    <a href="<?=$this->Url->build(["action"=>"modifier",$inscription->id])?>" class="btn btn-sm btn-default pull-right">Modifier</a>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default bg-gris">
            <div class="panel-body">
                <label for="eleve_id">Elève: </label>
                <?=$inscription->elef->prenom?> <?=$inscription->elef->nom?> - <?=$inscription->elef->matricule?>
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
                            <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['action'=>'seances',$remediation->id],['class' => 'btn btn-xs btn-default','escape'=>false])?>
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

</script>