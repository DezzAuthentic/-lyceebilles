<div class="titre">
    Mes élèves
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Elèves inscrits
            </div>
            <table id="seances_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title=""></th>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Classe">Classe</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=1; foreach($inscriptions as $inscription): ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$inscription->elef->matricule?></td>
                        <td><?=$inscription->elef->nom?></td>
                        <td><?=$inscription->elef->prenom?></td>
                        <td><?php if($inscription->affectations) echo $inscription->affectations[0]->groupe->nom?></td>
                        <td class="actions">
                            <?php if($inscription->affectations) echo $this->Html->link('<span class="glyphicon glyphicon-eye-open icone"></span> classe','/suivi/groupes/fiche/'.$inscription->affectations[0]->groupe->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                            <?php if($inscription->affectations) echo $this->Html->link('<span class="glyphicon glyphicon-eye-open icone"></span> Empl. du T.','/suivi/edt/classe/'.$inscription->affectations[0]->groupe->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open icone"></span> Fiche élève','/suivi/eleves/fiche/'.$inscription->elef->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Elèves non inscrits
            </div>
            <table id="eleves_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title=""></th>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Date de naissance">Date de naissance</th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=1; foreach($eleves as $eleve): if($eleve->inscriptions!=null) continue; ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$eleve->matricule?></td>
                        <td><?=$eleve->nom?></td>
                        <td><?=$eleve->prenom?></td>
                        <td><?=$eleve->date_naissance?></td>
                        <td>
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open icone"></span> Fiche élève','/suivi/eleves/fiche/'.$eleve->id,['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        </td>    

                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
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
            "paging": false,
            "ordering": false,
            "searching": false,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
            "language": {
                "lengthMenu": "Afficher _MENU_ par page",
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
            }/*,
            "columnDefs": [ {
                "targets": 4,
                "orderable": false
                },{
                "targets": 5,
                "orderable": false
                }
            ]*/
        });

    });
    
</script>
<?php $this->end(); ?>