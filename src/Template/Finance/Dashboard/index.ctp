<div class="titre">
    Tableau de bord
</div>

<section class="row">

    <div class="col-xs-12 col-md-4 text-center">
        <div class="text-center titre-stats text-primary">Effectif total</div>
        <?php $effectif=0; foreach($promotions as $promotion){
            $effectif += sizeof($promotion->inscriptions);
        }
        ?>
        <span class="stats"><?=$effectif?></span> élève(s)
    </div>
    <div class="col-xs-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                Effectifs
            </div>
            <table id="abonnements_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Effectif</th>
                    <?php foreach($types as $type):?>
                        <th title="<?=$type->nom?>"><?=$type->nom?></th>
                    <?php endforeach;?>
                        <th>Abandons</th>
                    </tr>
                </thead>
                <tbody>            
                <?php $abandons=0; foreach($promotions as $k => $promotion): ?>
                    <tr>
                        <th><?=$promotion->nom?></th>
                        <td><?=sizeof($promotion->inscriptions)?></td>
                    <?php foreach($types as $type):?>
                        <?php
                            $nombre=0;
                            foreach($promotion->inscriptions as $inscription){
                                foreach($inscription->engagements as $engagement){
                                    if($engagement->frai->type_id == $type->id) $nombre++;
                                }
                            }
                            $type->total += $nombre;
                        ?>
                        <td><?=$nombre?></td>
                    <?php endforeach;?>
                        <td><?=sizeof($promotions_abandons[$k]->inscriptions)?></td>
                    </tr>
                <?php $abandons+=sizeof($promotions_abandons[$k]->inscriptions); endforeach;?>
                <tr>
                    <th>Total</th>
                    <td><?=$effectif?></td>
                    <?php foreach($types as $type):?>
                        <td><?=$type->total?></td>
                    <?php endforeach;?>
                    <td><?=$abandons?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-xs-12 titre-stats text-primary text-center">Recouvrements</div>
    <div class="col-xs-12"><canvas id="myChart" width="400" height="130"></canvas></div>

    <div class="col-xs-12">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                Tableau des factures
            </div>
            <table id="factures_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Libellé">Libellé</th>
                        <th title="Montant">Total à payer</th>
                        <th title="Payé">Payé</th>
                        <th title="Restant">Restant</th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($mois as $moi): ?>
                    <tr>
                        <td>
                        <?php 
                            if($moi->nom ) echo $moi->nom;
                            else echo "Inscriptions"
                        ?>
                        </td>
                        <td><?=$moi->a_payer?></td>
                        <td><?=$moi->paye?></td>
                        <td><?= $moi->a_payer - $moi->paye ?></td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</section>

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
    var ctx = $("#myChart");
    labels = [<?php foreach($mois as $moi){
            if ($moi->nom) echo '"'.$moi->nom.'",';
            else echo '"Inscriptions",';
        } ?>];
    data1 = [<?php foreach($mois as $moi) echo $moi->a_payer.',';?>];
    data2 = [<?php foreach($mois as $moi) echo $moi->paye.',';?>];
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Montants recouvrés',
                data: data2,
                backgroundColor: '#aaaaff',
                borderWidth: 1
            },{
                label: 'Montants facturés',
                data: data1,
                backgroundColor: '#f5f5f5',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
<?php $this->end(); ?>