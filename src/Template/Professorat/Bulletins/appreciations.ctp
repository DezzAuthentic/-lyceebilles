<div class="titre">
    <span> Gestion des appréciations</span>
</div>

<div class="row">
    <table id="cours_table" class="table datatable hover compact" >
        <thead>
            <tr>
                <th title="Matiere">Matière</th>
                <th title="Classe">Classe</th>
                <th class="actions" style="min-width:150px;">   
                </th>
            </tr>
        </thead>
        <tbody>            
        <?php $i=0; foreach($cours as $cour): ?>
            <tr>
                <td><?=$cour->matiere->nom?></td>
                <td><?=$cour->groupe->nom?></td>
                <td class="actions">
                    <?=$this->Html->link('appréciations',['controller'=>'Bulletins','action' => 'appreciationsCours', $cour->id],['class' => 'btn btn-xs btn-default'])?>
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
    
</script>
<?php $this->end(); ?>