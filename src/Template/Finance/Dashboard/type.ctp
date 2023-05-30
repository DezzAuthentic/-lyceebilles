<div class="titre">
    Tableau de bord - <?=$type->nom?> 
</div>

<div class="row">
    <div class="col-xs-12">
    <?php foreach($promotions as $promotion):?>
        <table id="abonnements_table" class="table datatable table-bordered table-striped compact" >
            <thead>
                <tr>
                    <th></th>
                <?php foreach($type->frais as $frai): if($frai->niveau_id == $promotion->niveau_id and $frai->serie_id == $promotion->serie_id):?>
                    <th title="<?=$frai->nom?>"><?=$frai->nom?></th>
                <?php endif; endforeach;?>
                </tr>
            </thead>
            <tbody>            
                <tr>
                    <th width='150px'><?=$promotion->nom?></th>
                <?php foreach($type->frais as $frai): if($frai->niveau_id == $promotion->niveau_id and $frai->serie_id == $promotion->serie_id):?>
                    <?php
                        $nombre=0;
                        foreach($promotion->frais as $nombre_frai){
                            //if ($promotion->id == $)
                                if($frai->id == $nombre_frai["frais_id"]) 
                                    $nombre = $nombre_frai["nombre"];
                        }
                    ?>
                    <td><?=$nombre?></td>
                <?php endif; endforeach;?>
                </tr>
            </tbody>
        </table>
        <br>
    <?php endforeach;?>
    </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js",
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
    });
    
</script>
<?php $this->end(); ?>