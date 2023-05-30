<div class="titre">
    <span>Configuration des périodes</span>
    <button id="ajout_btn" type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#initModal">
        <span class="glyphicon glyphicon-pencil"></span> Réinitialiser les périodes
    </button>
</div>

<section class="row">
    <div class="col-xs-12">
        <table id="annees_table" class="table" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Libellé">Libellé</th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=1; foreach($periodes as $periode):?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$periode->nom?></td>
                </tr>
            <?php $i++;endforeach;?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal init-->
<div class="modal fade" id="initModal" tabindex="-1" role="dialog" aria-labelledby="initModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Periodes', 'action' => 'initialiser']) ?>" method="post" enctype="multipart/form-data">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="initModalLabel">Réinitialisation des périodes</h4>
        </div>
        <div class="modal-body">
            
            <div class="form-group row">
                <label for="debut" class="col-sm-6 col-form-label">Nombre de périodes souhaité</label>
                <div class="col-sm-6">
                    <?=$this->Form->select('nombre',[2=>2,3=>3,4=>4,5=>5],['class'=>'form-control',"id"=>"debut","required"])?>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
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
$(document).ready( function () {
    $('#annees_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
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
        }
    });
} );
$(".edit_btn").click(function() {
    data = this.value.split('*');
    $("#AjoutAnneeModalLabel").html("Modifier l'année "+data[1]+" <input type='hidden' name='id' value='"+data[0]+"'>");
    $("#libelle").val(data[1]);
    $("#administration").val(data[2]);
    $("#professeur").val(data[3]);
    $("#inscription").val(data[4]);
    $("#classe").val(data[5]);
    $("#debut").val(data[6]);
    $("#fin").val(data[7]);
});
$("#ajout_btn").click(function() {
    $("#AjoutAnneeModalLabel").html("Ajouter une nouvelle année");
});
</script>
<?php $this->end(); ?>