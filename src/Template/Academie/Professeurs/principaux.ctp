<div class="titre">
    <span>Professeurs principaux</span>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="professeurs_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Matière">Matière</th>
                    <th title="Professeur principal">Professeur principal</th>
                    <th class="actions" style="min-width:150px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($matieres as $matiere): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$matiere->nom?></td>
                    <td><?php if($matiere->professeur) echo $matiere->professeur->prenom." ".$matiere->professeur->nom?></td>
                    <td class="actions">
                        <span class="btn btn-xs btn-default modifierProf" data-toggle="modal" data-target="#modifierProfModal" >
                            <i class="glyphicon glyphicon-pencil icone"></i>
                            <input type="hidden" value="<?=$matiere->id."*".$matiere->nom."*".$matiere->professeur_id?>">
                        </span>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'retirerPrincipal', $matiere->id], ["escape"=>false,'confirm' => __('Voulez-vous retirer ce professeur # {0}?', $matiere->id),'class'=>"btn btn-xs btn-default"]); ?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Modifier un prof-->
<div class="modal fade" id="modifierProfModal" tabindex="-1" role="dialog" aria-labelledby="modifierProfModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Professeurs', 'action' => 'definirPrincipal']) ?>" method="post">
        <input type="hidden" name="id" id="modifier_id" >
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modifierProfModalLabel">Définir le professeur principal</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Matière</label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control" id="modifier_nom" disabled>
                </div>
            </div>
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Professeur principal</label>
                <div class="col-sm-8">
                    <select required name="professeur_id" class="form-control select2" id="modifier_prof">
                        <?php foreach($professeurs as $prof):?>
                            <option id="prof<?=$prof->id?>" value="<?=$prof->id?>" >Pr. <?=$prof->prenom?> <?=$prof->nom?> </option> 
                        <?php $i++; endforeach?>
                    </select>
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

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        //$('.select2').select2();     
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
                "targets": 2,
                "orderable": false
                },{
                "targets": 3,
                "orderable": false
                }
            ]
        });
        table.buttons().container().appendTo( '#professeurs_table_wrapper .col-sm-6:eq(0)' );   
    });
    $(".modifierProf").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#modifier_id").val(data[0]);
        $("#modifier_nom").val(data[1]);
        console.log('prof'+data[2]);
        $("#prof"+data[2]).prop('selected',true);
    });
</script>
<?php $this->end(); ?>