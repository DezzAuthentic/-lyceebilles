
<div class="row">
    <div class="col-xs-12" class="">
        <div class="panel panel-default">
            <div class="panel-heading page-container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="btn btn-default btn-sm margin-g-5" id="printer">
                            <span class="glyphicon glyphicon-print icone"></span> Imprimer
                        </span>
                    </div>
                </div>
                <br>
                <div class="pageA4 row" id='page'>
                    <div class="col-xs-3">
                        <div class="print-logo-container vertical-align">
                            <?php if(!empty($etablissement->logo)):?>
                                <img class="logo" src="<?= $etablissement->logo?>" height="120px;" >
                            <?php 
                            else:
                                echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'140px']);
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <div class="entete">
                            <h3><?=$etablissement->nom?></h3>
                            <?=$etablissement->adresse?>
                        </div>
                    </div>

                    <!-- Contenu de la page -->
                    <div class="col-xs-12 page-padding">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                Année scolaire: <b> <?=$inscription->promotion->annee->nom?></b>
                            </div>
                            <div class="col-xs-12 print-titre">
                                état de la facturation
                            </div>
                        </div>
                        <br>
                        <b><?=$inscription->elef->prenom?> <?=$inscription->elef->nom?> </b><br>
                        Matricule: <b><?=$inscription->elef->matricule?></b> <br>
                        Date de naissance: <b><?=$inscription->elef->date_naissance?></b><br>
                        Classe:  <b><?php if(isset($inscription->affectations[0])) echo $inscription->affectations[0]->groupe->nom?></b><br>
                        Effectif: <b><?php if(isset($affectations)) echo $affectations->count()?></b><br>
                        <br>
                        
                        <section class="row">
                            <?php if(sizeof($factures)>0):?>
                            <div class="col-xs-12">
                                <table id="factures_table" class="print-table table table-bordered" >
                                    <thead>
                                        <tr>
                                            <th title="Mois">Libellé</th>
                                            <th title="Montant">Montant</th>
                                            <th title="Payé">Payé</th>
                                            <th title="Restant">Restant</th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>            
                                    <?php 
                                    $total_montant=0;
                                    $total_paye=0;
                                    $total_restant=0;
                                    foreach($factures as $facture):
                                        $total_montant += $facture->montant; 
                                        $total_paye += $facture->paye; 
                                        $total_restant += $facture->restant;   
                                    ?>
                                        <tr>
                                            <td><?=$facture->frai->nom?></td>
                                            <td><?=$facture->montant?></td>
                                            <td><?=$facture->paye?></td>
                                            <td><?=$facture->restant?></td>
                                        </tr>
                                    <?php endforeach;?>
                                        <tr >
                                            <th></th>
                                            <th class="text-primary"><?=$total_montant?></th>
                                            <th class="text-primary"><?=$total_paye?></th>
                                            <th class="text-primary"><?=$total_restant?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif;?>

                            <?php foreach($mois as $moi):
                                $total_montant=0;
                                $total_paye=0;
                                $total_restant=0;
                            ?>
                                <?php if(sizeof($moi->factures) > 0):?>
                                    <div class="col-xs-12 no-break">
                                        <div class="panel panel-default">
                                            <div class="text-center panel-heading bg-print-header"><span class="soustitre2"><?=$moi->nom?></span></div>
                                            <table id="factures_table" class="print-table table table-bordered" >
                                                <thead>
                                                    <tr>
                                                        <th title="Mois">Libellé</th>
                                                        <th title="Montant">Montant</th>
                                                        <th title="Payé">Payé</th>
                                                        <th title="Restant">Restant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>            
                                                <?php $i=0; foreach($moi->factures as $facture): 
                                                    $total_montant += $facture->montant; 
                                                    $total_paye += $facture->paye; 
                                                    $total_restant += $facture->restant;     
                                                ?>
                                                    <tr>
                                                        <td><?=$facture->frai->nom?></td>
                                                        <td><?=$facture->montant?></td>
                                                        <td><?=$facture->paye?></td>
                                                        <td><?=$facture->restant?></td>
                                                    </tr>
                                                <?php $i++; endforeach;?>
                                                    <tr >
                                                        <th></th>
                                                        <th class="text-primary"><?=$total_montant?></th>
                                                        <th class="text-primary"><?=$total_paye?></th>
                                                        <th class="text-primary"><?=$total_restant?></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>

                        </section>

                    </div>
                    <!-- Contenu de la page -->
                    <div class="col-xs-12 footer-container no-break hidden">
                        <div class="print-footer text-center">
                            Education pour le Développement des Sciences Techniques et Innovations en Afrique – EDESTIA-SA – NINEA 4543890 2C3<br>
                            RC SN DKR 2012 B 4059 - BP : 6178 Dakar – ETOILE   Tel : (221) 77 677 7371 et (221) 33 959 22 12 www.lyceebilles.com <br>
                            Dakar - SENEGAL 
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
    "custom-print.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $("#printer").click(function() {
        printJS({ 
            printable: 'page', 
            type: 'html', 
            showModal:true,
            css:['/css/custom-print.css','/css/bootstrap/bootstrap.min.css']
        });
    });
</script>
<?php $this->end(); ?>