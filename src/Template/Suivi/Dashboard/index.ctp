<?php
    $nom_mois[1]="Janvier";
    $nom_mois[2]="Fevrier";
    $nom_mois[3]="Mars";
    $nom_mois[4]="Avril";
    $nom_mois[5]="Mai";
    $nom_mois[6]="Juin";
    $nom_mois[7]="Juillet";
    $nom_mois[8]="Août";
    $nom_mois[9]="Septembre";
    $nom_mois[10]="Octobre";
    $nom_mois[11]="Novembre";
    $nom_mois[12]="Décembre";
?>

<div class="titre">
    Tableau de bord
</div>

<section class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center">Notes: Evolutions mensuelles</div>
            <div class="panel-body">
                <?php foreach($affectations as $affectation):?>
                    <canvas id="chart<?=$affectation->eleve_id?>" width="400" height="90"></canvas>
                <?php endforeach;?>
            </div>
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
    });
    <?php foreach($affectations as $affectation):?>
        var ctx<?=$affectation->eleve_id?> = $("#chart<?=$affectation->eleve_id?>");
        labels = [<?php foreach($affectation->mois as $moi){ echo '"'.$nom_mois[$moi->num].'",'; } ?>];
        data = [<?php foreach($affectation->mois as $moi) echo $moi->moyenne.',';?>];
        var myLineChart<?=$affectation->eleve_id?> = new Chart(ctx<?=$affectation->eleve_id?>, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "<?=$affectation->prenom.' '.$affectation->nom?>",
                    data: data,
                    backgroundColor: '#aaaaff',
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
    <?php endforeach;?>
</script>
<?php $this->end(); ?>