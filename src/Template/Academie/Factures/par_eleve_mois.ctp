<div class="titre">
    Facturation - 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>
    <!-- a class="btn btn-default btn-sm pull-right margin-g-5" href="<?=$this->Url->Build('/finance/factures/modifier/'.$inscription->id)?>" >
        <span class="glyphicon glyphicon-stop"></span> Abonnements
    </a -->

    <!-- span class="btn btn-default btn-sm pull-right margin-g-5" data-toggle="modal" data-target="#ajoutFactureModal" >
        <span class="glyphicon glyphicon-credit-card"></span> Ajouter une facture
    </span -->
    <!--a class="btn btn-warning btn-sm pull-right margin-g-5" href='/finance/factures/parrainage/<?=$inscription->id?>' >
        <span class="glyphicon glyphicon-credit-card"></span> Parrainage
    </a-->
    <span class="btn btn-default btn-sm pull-right margin-g-5" data-toggle="modal" data-target="#printModal" >
        <span class="glyphicon glyphicon-print"></span> Imprimer
    </span>
</div>

<div id="print">
    <section class="row">
        <?php if($total_parrain>0):?>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Montant total réglé par le parrain: <b><?= $total_parrain?> Fcfa</b></div>
                </div>
            </div>
        <?php endif;?>
        <?php if(sizeof($factures)>0):?>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <!--div class="text-center panel-heading"><span class="soustitre2">Inscription</span></div-->
                <table id="factures_table" class="table datatable hover compact" >
                    <thead>
                        <tr>
                            <th title="Mois">Libellé</th>
                            <th title="Montant">Montant</th>
                            <th title="Payé">Payé</th>
                            <th title="Restant">Restant</th>
                            <th class="actions" ></th>
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
                            <td class="actions text-left">
                                <a class="icone glyphicon glyphicon-chevron-right hover" href="/finance/factures/details/<?=$facture->id?>" >
                                </a>
                                <!--span class="<?php if($facture->restant<=0) echo 'hidden';?> icone glyphicon glyphicon-credit-card reglementFacture hover" data-toggle="modal"
                                data-target="#factureModal" >
                                    <input type="hidden" value="<?=$facture->id.'*'.$facture->frai->nom.'**'.$facture->restant?>">
                                </span-->
                                <?php if($facture->paye==0) echo $this->Form->postLink('<i class="icone glyphicon glyphicon-remove"></i>', ['action' => 'supprimer', $facture->id], ['confirm' => __('Voulez-vous supprimer cette facture # {0}?', $facture->id),'class'=>"btn btn-xs btn-default",'escape'=>false]); ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                        <tr >
                            <th></th>
                            <th class="text-primary"><?=$total_montant?></th>
                            <th class="text-primary"><?=$total_paye?></th>
                            <th class="text-primary"><?=$total_restant?></th>
                            <td class="actions text-left">
                                <a class="icone glyphicon glyphicon-chevron-right hover" href="/finance/factures/detailsMois/<?=$inscription->id?>" ></a>
                                <span class="<?php if($total_restant<=0) echo 'hidden';?> icone glyphicon glyphicon-credit-card reglementFacturesMois hover" data-toggle="modal"
                                data-target="#facturesMoisModal" >
                                    <input type="hidden" value="<?=$inscription->id.'***'.$total_restant?>">
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif;?>

        <?php foreach($mois as $moi):
            $total_montant=0;
            $total_paye=0;
            $total_restant=0;
        ?>
            <?php if(sizeof($moi->factures) > 0):?>
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="text-center panel-heading"><span class="soustitre2"><?=$moi->nom?></span> <?=$this->Html->link('<i class="glyphicon glyphicon-print icone"></i>',['action'=>"parEleveMois", $inscription_id, $moi->nom],['escape'=>false,'class' => 'pull-right', 'title' => 'Voir la fiche'])?></div>
                        <table id="factures_table" class="table datatable hover compact" >
                            <thead>
                                <tr>
                                    <th title="Mois">Libellé</th>
                                    <th title="Montant">Montant</th>
                                    <th title="Payé">Payé</th>
                                    <th title="Restant">Restant</th>
                                    <th class="actions" >   
                                    </th>
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
                                    <td class="actions text-left">
                                        <a class="icone glyphicon glyphicon-chevron-right hover" href="/finance/factures/details/<?=$facture->id?>" >
                                        </a>
                                        <span class="hidden  icone glyphicon glyphicon-credit-card reglementFacture hover"  ></span>
                                        </td>
                                </tr>
                            <?php $i++; endforeach;?>
                                <tr >
                                    <th></th>
                                    <th class="text-primary"><?=$total_montant?></th>
                                    <th class="text-primary"><?=$total_paye?></th>
                                    <th class="text-primary"><?=$total_restant?></th>
                                    <td class="actions text-left">
                                        <a class="icone glyphicon glyphicon-chevron-right hover" href="/finance/factures/detailsMois/<?=$inscription->id?>/<?=$moi->id?>" >
                                        </a>
                                        <span class="hidden" ></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>

    </section>
</div>

<!-- Modal reglement de facture eleve-->
<div class="modal fade" id="factureModal" tabindex="-1" role="dialog" aria-labelledby="factureModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Reglements', 'action' => 'add']) ?>" method="post">
            <input type="hidden" name="facture_id" id="factureId" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="factureModalLabel">Réglement : <span id="facture_label"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Type de règlement</label>
                    <div class="col-sm-8">
                        <label class="radio-inline"><input type="radio" value="0" name="parrainage" checked>Tuteur</label>
                        <label class="radio-inline"><input type="radio" value="1" name="parrainage">Parrain</label>
                    </div>
                </div>                    
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Montant à payer</label>
                    <div class="col-sm-8">
                        <div id="factureAPayer"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMontant" class="col-sm-4 col-form-label">Montant</label>
                    <div class="col-sm-8">
                        <input type="number" name="montant" id="factureMontant" min="0" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMoyen" class="col-sm-4 col-form-label">Moyen de paiement</label> 
                    <div class="col-sm-8">
                        <?=$this->Form->select("moyen", ['Especes'=>'Especes','Chèque'=>"Chèque",'Virement'=>"Virement","Transfert d'argent"=>"Transfert d'argent"], ['empty' => true,'class'=>'form-control','id'=>'factureMoyen','required']);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal reglement de factures Mois eleve-->
<div class="modal fade" id="facturesMoisModal" tabindex="-1" role="dialog" aria-labelledby="facturesMoisModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Reglements', 'action' => 'mois']) ?>" method="post">
            <input type="hidden" name="inscription_id" id="inscriptionId" >
            <input type="hidden" name="mois_id" id="moisId" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="facturesMoisModalLabel">Réglement : <span id="factures_label"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Type de règlement</label>
                    <div class="col-sm-8">
                        <label class="radio-inline"><input type="radio" name="parrainage" value="0" checked>Tuteur</label>
                        <label class="radio-inline"><input type="radio" name="parrainage" value="1">Parrain</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Montant à payer</label>
                    <div class="col-sm-8">
                        <div id="facturesAPayer"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMontant" class="col-sm-4 col-form-label">Montant</label>
                    <div class="col-sm-8">
                        <input type="number" name="montant" id="facturesMontant" min="0" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="factureMoyen" class="col-sm-4 col-form-label">Moyen de paiement</label> 
                    <div class="col-sm-8">
                        <?=$this->Form->select("moyen", ['Especes'=>'Especes','Chèque'=>"Chèque",'Virement'=>"Virement","Transfert d'argent"=>"Transfert d'argent"], ['empty' => true,'class'=>'form-control','id'=>'facturesMoyen','required']);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal facturation libre-->
<div class="modal fade" id="ajoutFactureModal" tabindex="-1" role="dialog" aria-labelledby="ajoutFactureModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Factures', 'action' => 'libre']) ?>" method="post">
            <input type="hidden" name="inscription_id" id="ajoutInscriptionId" value="<?=$inscription->id?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ajoutFactureModalLabel">Ajout d'une facture</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for='ajoutType' class="col-sm-4 col-form-label">Frais</label>
                        <div class="col-sm-8">
                            <select name="frais_id" class="form-control select2" id="ajoutType" required>
                                <option>Choisissez un frais</option>
                                <?php foreach($types as $type):?>
                                    <optgroup label="<?=$type->nom?>">
                                    <?php foreach($type->frais as $frai):?>
                                        <option value="<?=$frai->id?>"><?=$frai->nom?></option>
                                    <?php endforeach;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div for='ajoutMois' class="form-group row">
                        <label class="col-sm-4 col-form-label">Mois</label>
                        <div class="col-sm-8">
                            <?=$this->Form->select("mois_id", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'moisId']);?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajoutMontant" class="col-sm-4 col-form-label">Montant</label>
                        <div class="col-sm-8">
                            <input type="number" name="montant" id="ajoutMontant" min="0" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal print -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Factures', 'action' => 'parEleveMois',$inscription->id]) ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ajoutFactureModalLabel">Impression de la facturation</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for='debut' class="col-sm-4 col-form-label">Premier mois</label>
                        <div class="col-sm-8">
                            <select name="debut" class="form-control select2" id="debut" required>
                                <option>Choisissez un mois</option>
                                <option value="0">Inscription</option>
                                <?php foreach($mois as $moi): if(sizeof($moi->factures) > 0):?>
                                    <option value="<?=$moi->ordre?>"><?=$moi->nom?></option>
                                <?php endif; endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='debut' class="col-sm-4 col-form-label">Dernier mois</label>
                        <div class="col-sm-8">
                            <select name="fin" class="form-control select2" id="fin" required>
                                <option>Choisissez un mois</option>
                                <option value="0">Inscription</option>
                                <?php foreach($mois as $moi):if(sizeof($moi->factures) > 0):?>
                                    <option value="<?=$moi->ordre?>"><?=$moi->nom?></option>
                                <?php endif; endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" id="factureSubmit" class="btn btn-primary">Valider</button>
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
    $(".reglementFacture").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".reglementFacture input").val());
        $("#factureId").val(data[0]);
        $("#facture_label").html(data[1]+" "+data[2]);
        $("#factureAPayer").html(data[3]);
        $("#factureMontant").attr('max',data[3]);
    });
    $(".reglementFacturesMois").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".reglementFacturesMois input").val());
        $("#inscriptionId").val(data[0]);
        $("#moisId").val(data[1]);
        $("#factures_label").html("Factures "+data[2]);
        $("#facturesAPayer").html(data[3]);
        $("#facturesMontant").attr('max',data[3]);
    });
    $("#printer").click(function() {
        printJS({ 
            printable: 'print', 
            type: 'html', 
            header: 'Etat facturation',
            showModal:true,
            css:'/css/bootstrap/bootstrap.min.css',
            ignoreElements:['']
        });
    });
</script>


<?php if(isset($factureMoi) && $factureMoi != null): ?>
    <script>
        <?php if(!empty($etablissement->logo)):?>
            url="<?= $this->Url->image($etablissement->logo,['fullBase' => true])?>";
        <?php else: ?>
            url="<?= $this->Url->image('default-img.gif',['fullBase' => true])?>";
        <?php endif; ?>

        <?php for($i=1;$i<7;$i++):?>
            carre<?=$i?> = { canvas: 
                [
                    {
                        type: 'rect',
                        x: 5,
                        y: 2,
                        w: 10,
                        h: 10,
                        //r: 0,
                        //dash: { length: 5 },
                        // lineWidth: 10,
                        //lineColor: 'blue',
                    }
                ]
            };
        <?php endfor; ?>
        
        appreciations = '\u2610 test';

        function formatNumber(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function toDataURL(url, callback, outputFormat) {
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                var canvas = document.createElement('CANVAS');
                var ctx = canvas.getContext('2d');
                var dataURL;
                canvas.height = this.naturalHeight;
                canvas.width = this.naturalWidth;
                ctx.drawImage(this, 0, 0);
                dataURL = canvas.toDataURL(outputFormat);
                callback(dataURL);
            };
            img.src = url;
            if (img.complete || img.complete === undefined) {
                //img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                img.src = src;
            }
        }
        toDataURL(url, function(dataUrl) {
            var dd = 
                {
                    info: {
                        title: 'Facture',
                        author: 'PAGES',
                        subject: 'Facture',
                        keywords: 'facture',
                    },
                    content: [
                        {
                            columns: [
                                {
                                    image: dataUrl,
                                    width: 90
                                },
                                {
                                    text: "<?php if ($etablissement->nom) echo h($etablissement->nom);?> \n <?php if ($etablissement->adresse) echo h($etablissement->adresse);?>",
                                    style: 'entete'
                                }
                            ]       
                        },
                        {
                            columns: [
                                {
                                    text: 'FACTURE DU MOIS DE <?= h($month) ?>',
                                    style: ['header','marginTop15']
                                },
                                {
                                    text: ['Année : ', {text:'<?= h($etablissement->annee->nom) ?>',bold:true}],
                                    style: ['right','marginTop15']
                                }
                            ],       
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'NOM: ',bold:true},'<?= h($affectation->inscription->elef->nom) ?>'],
                                    fontSize:10,
                                    margin: [0,2]
                                }
                            ],
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'PRENOM: ',bold:true},'<?= h($affectation->inscription->elef->prenom) ?>'],
                                    fontSize: 10,
                                    margin: [0,2]
                                }
                            ],   
                        },
                        {
                            text: [{text:'Date et lieu de naissance: ',bold:true},'<?= h($affectation->inscription->elef->date_naissance) ?> à <?= h($affectation->inscription->elef->lieu_naissance) ?>'], 
                            fontSize: 10,
                            margin: [0,2]   
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'Classe: ',bold:true},'<?= h($affectation->groupe->nom) ?>'],
                                    fontSize:10,
                                    margin: [0,2]
                                }
                            ],   
                        },
                        <?php 
                            $montantTotal = 0;
                            $PayeTotal = 0;
                            $RestantTotal = 0;
                        ?>
                        

                        

                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 30, 0, 0],
                            layout: 'lightHorizontalLines',
                            table: {
                                headerRows: 1,
                                widths: [170, 100, 100, 100],
                               // widths: [400, 95],
                                body: [
                                    [{text: 'libellés', style: 'tableHeader'},
                                     {text: 'Montant', style: 'tableHeader'}, 
                                     {text: 'Payé', style: 'tableHeader'}, 
                                     {text: 'Restant', style: 'tableHeader'}
                                    ],
                                    <?php foreach($factureMoi->factures as $facture): 
                                        $montantTotal += $facture->montant; 
                                        $PayeTotal += $facture->paye; 
                                       $RestantTotal += $facture->restant; ?>
                                        [
                                            {text: [{text:'<?= h($facture->frai->nom) ?>'}]},
                                            {text: [{text: formatNumber('<?= $facture->montant ?>')}]},
                                            {text: [{text: formatNumber('<?= $facture->paye ?>')}]},
                                            {text: [{text: formatNumber('<?= $facture->restant ?>')}]}
                                        ],
                                    <?php endforeach; ?>
                                ]
                            }
                        },
                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 10, 0, 0],
                            layout: 'noBorders',
                            table: {
                                headerRows: 1,
                                widths: [407, 95],
                                body: [
                                    ['', ''],
                                    <?php $totalPrec = 0;
                                    foreach($moisPrecedents as $theMonth): $sousTotalPrec = 0;
                                        foreach($theMonth->factures as $fact): 
                                            
                                                $totalPrec += $fact->restant; $sousTotalPrec += $fact->restant;
                                        endforeach; ?>
                                        <?php if($sousTotalPrec > 0): ?>
                                            [
                                                {text: [{text:'Solde Antérieur (<?= h($theMonth->nom); ?>)'}]},
                                                {text: [{text: formatNumber('<?= $sousTotalPrec ?>')}]}
                                            ],
                                    <?php endif; endforeach; ?>
                                ]
                            }
                        },
                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 30, 0, 0],
                            layout: 'noBorders',
                            table: {
                                widths: [407, 95],
                                body: [
                                    ['', ''],
                                    [
                                        {text: [{text:'Total', bold: true}]},
                                        {text: [{text: formatNumber('<?= $montantTotal + $totalPrec?>'), bold: true}]},
                                    ],
                                    [
                                        {text: [{text:'Total Payé', bold: true}]},
                                        {text: [{text: formatNumber('<?= h($PayeTotal) ?>'), bold: true}]},
                                    ],
                                    [
                                        {text: [{text:'Total Restant', bold: true}]},
                                        {text: [{text: formatNumber('<?= h($RestantTotal + $totalPrec) ?>'), bold: true}]},
                                    ]
                                ]
                            }
                        },
/** 
                        <?php if($totalPrev > 0): ?>
                        {
                            margin: [0, 50, 0, 0],
                            text: "Reliquat", bold: true
                        },
                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 10, 0, 0],
                            layout: 'lightHorizontalLines',
                            table: {
                                headerRows: 1,
                                widths: [200, 95],
                                body: [
                                    [{text: 'Mois', style: 'tableHeader'}, {text: 'Restant', style: 'tableHeader', style: 'center'}],
                                    <?php 
                                    foreach($moisPrecedents as $theMonth): $montantTotalPrec = 0;
                                        foreach($theMonth->factures as $fact): if($fact->mois_id == $theMonth->id):
                                            $montantTotalPrec += $fact->restant; 
                                        endif; endforeach; ?>
                                        <?php if($montantTotalPrec > 0): ?>
                                            [
                                                {text: [{text:'<?= h($theMonth->nom); ?>'}]},
                                                {text: [{text: formatNumber('<?= $montantTotalPrec ?>'), style: 'center'}]}
                                            ],
                                    <?php endif; endforeach; ?>
                                ]
                            }
                        },
                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 0, 0, 0],
                            layout: 'noBorders',
                            table: {
                                widths: [210, 95],
                                body: [
                                    ['', ''],
                                    [
                                        {text: [{text:'Total', bold: true}]},
                                        {text: [{text: formatNumber('<?= $totalPrev ?>'), bold: true, style: 'center'}]}
                                    ]
                                ]
                            }
                        }
                        <?php endif; ?>
*/
                    ],
                    footer: [
                        {canvas: [
                            {
                                type: 'polyline',
                                lineWidth: 1,
                                color: "red",
                                closePath: true,
                                points: [{ x: 50, y: 10 }, { x: 550, y: 10 }]
                            },
                        ]},
                        {text: '<?php if ($etablissement->nom) echo h($etablissement->nom);?> \n <?php if ($etablissement->adresse) echo h($etablissement->adresse);?>',fontSize: 8,bold: true,alignment: 'center'}
                    ],
                    styles: {
                        entete: {
                            fontSize: 11,
                            margin: [25,24]
                        },
                        header: {
                            fontSize: 12,
                            bold: true,
                        },
                        marginTop15: {
                            margin: [0,15,0,10]
                        },
                        marginLeft100: {
                            margin: [100,0,0,3]
                        },
                        right: {
                            alignment: "right"
                        },
                        table: {
                            fontSize: 9,
                            margin: [0, 5, 0, 10]
                        },
                        center: {
                            alignment: "center"
                        },
                        small: {
                            fontSize: 8
                        }
                    }

            }
            
            pdfMake.createPdf(dd).open();

            
        })  
    </script>

<?php endif; ?>

<!-- PDF intervalle de mois -->
<?php if(isset($pdfFactures) && $pdfFactures != null): ?>
    <script>
        <?php if(!empty($etablissement->logo)):?>
            url="<?= $this->Url->image($etablissement->logo,['fullBase' => true])?>";
        <?php else: ?>
            url="<?= $this->Url->image('default-img.gif',['fullBase' => true])?>";
        <?php endif; ?>

        <?php for($i=1;$i<7;$i++):?>
            carre<?=$i?> = { canvas: 
                [
                    {
                        type: 'rect',
                        x: 5,
                        y: 2,
                        w: 10,
                        h: 10,
                        //r: 0,
                        //dash: { length: 5 },
                        // lineWidth: 10,
                        //lineColor: 'blue',
                    }
                ]
            };
        <?php endfor; ?>
        
        appreciations = '\u2610 test';

        function formatNumber(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function toDataURL(url, callback, outputFormat) {
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                var canvas = document.createElement('CANVAS');
                var ctx = canvas.getContext('2d');
                var dataURL;
                canvas.height = this.naturalHeight;
                canvas.width = this.naturalWidth;
                ctx.drawImage(this, 0, 0);
                dataURL = canvas.toDataURL(outputFormat);
                callback(dataURL);
            };
            img.src = url;
            if (img.complete || img.complete === undefined) {
                //img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                img.src = src;
            }
        }
        toDataURL(url, function(dataUrl) {
            var dd = 
                {
                    info: {
                        title: 'Facture',
                        author: 'PAGES',
                        subject: 'Facture',
                        keywords: 'facture',
                    },
                    content: [
                        {
                            columns: [
                                {
                                    image: dataUrl,
                                    width: 90
                                },
                                {
                                    text: "<?php if ($etablissement->nom) echo h($etablissement->nom);?> \n <?php if ($etablissement->adresse) echo h($etablissement->adresse);?>",
                                    style: 'entete'
                                }
                            ]       
                        },
                        {
                            columns: [
                                <?php $lastMonth = end($intervalMonths); $firstMonth = $intervalMonths[0]; ?>
                                {
                                    text: 'FACTURES DE <?= h($firstMonth->nom) ?> à <?= h($lastMonth->nom) ?>',
                                    style: ['header','marginTop15']
                                },
                                {
                                    text: ['Année : ', {text:'<?= h($etablissement->annee->nom) ?>',bold:true}],
                                    style: ['right','marginTop15']
                                }
                            ],       
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'NOM: ',bold:true},'<?= h($affectation->inscription->elef->nom) ?>'],
                                    fontSize:10,
                                    margin: [0,2]
                                },
                                {
                                    text: [{text:'PRENOM: ',bold:true},'<?= h($affectation->inscription->elef->prenom) ?>'],
                                    fontSize: 10,
                                    margin: [0,2]
                                }
                            ],   
                        },
                        {
                            text: [{text:'Date et lieu de naissance: ',bold:true},'<?=$affectation->inscription->elef->date_naissance?> à <?= h($affectation->inscription->elef->lieu_naissance) ?>'], 
                            fontSize: 10,
                            margin: [0,2]   
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'Classe: ',bold:true},'<?= h($affectation->groupe->nom) ?>'],
                                    fontSize:10,
                                    margin: [0,2]
                                }
                            ],   
                        },
                        <?php if($factures != null): ?>
                            {
                                // margin: [left, top, right, bottom]
                                margin: [0, 30, 0, 0],
                                layout: 'lightHorizontalLines',
                                table: {
                                    headerRows: 1,
                                    widths: [170, 100, 100, 100],
                                    body: [
                                        [
                                            {text: 'libellé', style: 'tableHeader'},
                                             {text: 'Montant', style: 'tableHeader'},
                                              {text: 'Payé', style: 'tableHeader'},
                                               {text: 'Restant', style: 'tableHeader'}
                                        ],
                                        <?php 
                                        $totalMontant=0;
                                        $totalPaye=0;
                                        $totalRestant=0;
                                        foreach($factures as $facture): 
                                            $totalMontant += $facture->montant; 
                                            $totalPaye += $facture->paye; 
                                            $totalRestant += $facture->restant;
                                        ?>
                                            [
                                                {text: [{text:'<?= h($facture->frai->nom) ?>'}]},
                                                {text: [{text: formatNumber('<?= $facture->montant ?>')}]},
                                                {text: [{text:'<?= h($facture->paye) ?>'}]},
                                                {text: [{text:'<?= h($facture->restant) ?>'}] }
                                            ],
                                        <?php endforeach; ?>

                                        [
                                            {text: [{text:'Total : ', bold: true}]},
                                            {text: [{text: formatNumber('<?= $totalMontant ?>'), bold: true}]},
                                            {text: [{text: formatNumber('<?= h($totalPaye) ?>'), bold: true}]},
                                            {text: [{text: formatNumber('<?= h($totalRestant) ?>'), bold: true}] }
                                        ]
                                    ]
                                }
                            },
                        <?php endif; ?>

                        <?php if($onlyInscription != "ok"): ?>
                            {
                                margin: [0, 10, 0, 0],
                                table: {
                                    // margin: [left, top, right, bottom]
                                    widths: [95, 300, 95],
                                    //headerRows: 1,
                                    body: [
                                        ['Mois', 'Description', {text: 'Montant', style: 'center'}],
                                        <?php $total=0; $restant=0; $paye=0; 
                                        foreach($intervalMonths as $k => $oneMonth): 
                                            $sous_total=0; $total_paye=0; $total_rest=0; ?>
                                        [
                                            {
                                                text: '<?= $oneMonth->nom ?>', style: 'textSize', bold: true
                                            },
                                            [
                                                {
                                                    margin: [-5, -7, 0, 0],
                                                    layout: 'lightHorizontalLines',
                                                    table: {
                                                        widths: [309],
                                                        body: [
                                                            [''],
                                                            <?php foreach($pdfFactures as $facture): if($facture->mois_id == $oneMonth->id): ?>
                                                                [
                                                                    {text: '<?= h($facture->frai->nom) ?>', style: 'textSize', margin: [5, 0, 0, 0]},
                                                                ],
                                                            <?php endif; endforeach; ?>
                                                            [{text: 'Payé', style: 'textSize', margin: [5, 0, 0, 0]}],
                                                            [{text: 'Restant', style: 'textSize', margin: [5, 0, 0, 0]}],
                                                            [{text: 'Sous-Total', style: 'textSize', margin: [5, 0, 0, 0]}]
                                                        ]
                                                    },
                                                }
                                            ],
                                            [
                                                {
                                                    margin: [-5, -7, 0, 0],
                                                    layout: 'lightHorizontalLines',
                                                    table: {
                                                        widths: [104],
                                                        body: [
                                                            [''],
                                                            <?php foreach($pdfFactures as $facture): if($facture->mois_id == $oneMonth->id): $sous_total += $facture->montant; $total_paye += $facture->paye;$total_rest += $facture->restant; $total += $facture->montant; ?>
                                                                [{text: formatNumber('<?= $facture->montant ?>'), style: 'textSize', margin: [35, 0, 0, 0]}],
                                                            <?php endif; endforeach; $restant += $total_rest; $paye += $total_paye; ?>
                                                            [{text: formatNumber('<?= $total_paye ?>'), style: 'textSize', bold: true, margin: [35, 0, 0, 0]}],
                                                            [{text: formatNumber('<?= $total_rest ?>'), style: 'textSize', bold: true, margin: [35, 0, 0, 0]}],
                                                            [{text: formatNumber('<?= $sous_total ?>'), style: 'textSize', bold: true, margin: [35, 0, 0, 0]}],
                                                        ]
                                                    },
                                                }
                                            ]
                                        ],
                                        <?php endforeach; ?>
                                    ]
                                }
                            },
                            {
                                // margin: [left, top, right, bottom]
                                margin: [0, 0, 0, 0],
                                layout: 'noBorders',
                                table: {
                                    widths: [100, 305, 95],
                                    body: [
                                        ['', '', ''],
                                        [
                                            {text: ''},
                                            {text: [{text:'Total', bold: true}]},
                                            {text: [{text: formatNumber('<?= $total + $totalMontant ?>'), bold: true, style: 'center'}]}
                                        ]
                                    ]
                                }
                            },
                            {
                                // margin: [left, top, right, bottom]
                                margin: [0, 0, 0, 0],
                                layout: 'noBorders',
                                table: {
                                    widths: [100, 305, 95],
                                    body: [
                                        ['', '', ''],
                                        [
                                            {text: ''},
                                            {text: [{text:'Total payé', bold: true}]},
                                            {text: [{text: formatNumber('<?= $paye + $totalPaye ?>'), bold: true, style: 'center'}]}
                                        ]
                                    ]
                                }
                            },
                            {
                                // margin: [left, top, right, bottom]
                                margin: [0, 0, 0, 0],
                                layout: 'noBorders',
                                table: {
                                    widths: [100, 305, 95],
                                    body: [
                                        ['', '', ''],
                                        [
                                            {text: ''},
                                            {text: [{text:'Total restant', bold: true}]},
                                            {text: [{text: formatNumber('<?= $restant + $totalRestant ?>'), bold: true, style: 'center'}]}
                                        ]
                                    ]
                                }
                            }
                        <?php endif; ?>
                    ],
                    footer: [
                        {canvas: [
                            {
                                type: 'polyline',
                                lineWidth: 1,
                                color: "red",
                                closePath: true,
                                points: [{ x: 50, y: 10 }, { x: 550, y: 10 }]
                            },
                        ]},
                        {text: '<?php if ($etablissement->nom) echo h($etablissement->nom);?> \n <?php if ($etablissement->adresse) echo h($etablissement->adresse);?>',fontSize: 8,bold: true,alignment: 'center'}
                    ],
                    styles: {
                        entete: {
                            fontSize: 11,
                            margin: [25,24]
                        },
                        header: {
                            fontSize: 12,
                            bold: true,
                        },
                        marginTop15: {
                            margin: [0,15,0,3]
                        },
                        right: {
                            alignment: "right"
                        },
                        table: {
                            fontSize: 9,
                            margin: [0, 5, 0, 10]
                        },
                        center: {
                            alignment: "center"
                        },
                        small: {
                            fontSize: 8
                        },
                        textSize: {
                            fontSize: 10
                        },
                        styleMontant: {
                            fontSize: 10,
                            bold: true,
                            alignment: "center"
                        }
                    }

            }
            
            pdfMake.createPdf(dd).open();

            
        })  
    </script>

<?php endif; ?>
<?php $this->end(); ?>