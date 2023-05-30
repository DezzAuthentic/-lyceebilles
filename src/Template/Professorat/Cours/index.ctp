<div class="titre">
    <span>Mes Cours
</div>

<div class="row">
    <table id="cours_table" class="table datatable hover compact" >
        <thead>
            <tr>
                <th title="Matiere">Matière</th>
                <th title="Classe">Classe</th>
                <th title="heures par semaine">Heures par semaine</th>
                <th class="actions" style="min-width:150px;">   
                </th>
            </tr>
        </thead>
        <tbody>            
        <?php $i=0; foreach($cours as $cour): ?>
            <tr>
                <td><?=$cour->matiere->nom?></td>
                <td><?=$cour->groupe->nom?></td>
                <?php
                $heures=0;
                foreach($cour->edt as $seance){
                    $heures += $seance->duree;
                }
                $hr = (int) $heures;
                $mn = ($heures - $hr) > 0 ?'30MN':'';
                ?>
                <td><?=$hr.'H '.$mn?></td>
                <td class="actions">
                    <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Cours','action' => 'fiche', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                    <?=$this->Html->link('Cahier de texte',['controller'=>'Cours','action' => 'cahierDeTexte', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-primary'])?>
                </td>
            </tr>
        <?php $i++; endforeach;?>
        </tbody>
    </table>

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
            "ordering": false,
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