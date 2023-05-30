<div class="titre">
    <?= $cours->matiere->nom?> - <?=$cours->groupe->nom?><span>: Appreciations des élèves</span>
</div>

<div class="row">
    <table id="cours_table" class="table datatable hover compact table-bordered" >
        <thead>
            <tr>
                <th title="Elèves" rowspan="2">Elève</th>
                <?php foreach($periodes as $periode): ?>
                    <th title="<?=$periode->nom?>" colspan="2"><?=$periode->nom?></th>
                <?php endforeach;?>      
            </tr>
            <tr>
                <?php foreach($periodes as $periode): ?>
                    <th title="Note">Note</th>
                    <th title="Appréciation">Appréciation</th>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>      
        <?php $i=0; foreach($cours->groupe->affectations as $affectation): ?>
            <tr>
                <td><?=$affectation->inscription->elef->prenom?> <?=$affectation->inscription->elef->nom?></td>
                <?php foreach($affectation->periode_bulletins as $bulletin): $ligne = $bulletin->periode_bulletin_lignes[0]; ?>
                    <td><?php if ($ligne) echo $ligne->note;?></td>
                    <td>
                        <?php if ($ligne) echo $ligne->appreciation;?>
                        <a type="button" class="btn btn-default pull-right btn-xs mt1 appreciation_btn" data-toggle="modal" data-target="#appreciationsModal">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <input type="hidden" value="<?=$ligne->id."*".$ligne->note."*".$ligne->appreciation."*".$bulletin->periode->nom."*".$affectation->inscription->elef->prenom." ".$affectation->inscription->elef->nom?>">
                        </a>
                    </td>
                <?php endforeach;?>      
            </tr>
        <?php $i++; endforeach;?>      
        </tbody>
    </table>
</div>

<!-- Modal appréciations -->
<div class="modal fade" id="appreciationsModal" tabindex="-1" role="dialog" aria-labelledby="appreciationsModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Bulletins', 'action' => 'enregistrerAppreciations']) ?>" method="post">
        <input type="hidden" id="ligne_id" name="id">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="appreciationsModalLabel">Appréciations</h4>
            <span class="modal-title h5" id="semestre"></span> - 
            <span class="modal-title h5" id="eleve"></span>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="nom" class="col-xs-3">Note:</label>
                <div class="col-xs-3">
                    <input type="text" id="ligne_note" class="form-control" disabled>
                </div>
            </div>    
            <div class="form-group row ">
                <label for="nom" class="col-xs-12">Appréciations:</label>
                <div class="col-xs-12">
                    <textarea id="ligne_texte" name="appreciation" class="form-control" rows='1'></textarea>
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
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": true,
            "ordering": true,
            "searching": true,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page",
                "zeroRecords": "Pas d'enregistrement trouvé!",
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
                }
            ]
        });

    });

    $(".appreciation_btn").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#ligne_id").val(data[0]);
        $("#ligne_note").val(data[1]);
        $("#ligne_texte").html(data[2]);
        $("#semestre").html(data[3]);
        $("#eleve").html(data[4]);
    });
    
</script>
<?php $this->end(); ?>