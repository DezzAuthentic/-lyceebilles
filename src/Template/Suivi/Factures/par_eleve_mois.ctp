<div class="titre">
    Facturation - 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>
    
    <a class="btn btn-default btn-sm pull-right margin-g-5" href="<?=$this->Url->Build('/suivi/factures/parEleveMois/'.$inscription->id.'/all')?>" >
        <span class="glyphicon glyphicon-print icone"></span> Imprimer
    </a>
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
                        <div class="text-center panel-heading"><span class="soustitre2"><?=$moi->nom?> <?=$this->Html->link('<i class="glyphicon glyphicon-print icone"></i>',['action'=>"parEleveMois", $inscription_id, $moi->nom],['escape'=>false,'class' => 'pull-right', 'title' => 'Voir la facture'])?></span></div>
                        <table id="factures_table" class="table datatable hover compact" >
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
                                    text: 'FACTURE DU MOIS <?= h($month) ?>',
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
                            text: [{text:'Date et leu de naissance: ',bold:true},'<?= h($affectation->inscription->elef->date_naissance) ?> à <?= h($affectation->inscription->elef->lieu_naissance) ?>'], 
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
                        <?php $montantTotal = 0; ?>
                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 30, 0, 0],
                            layout: 'lightHorizontalLines',
                            table: {
                                headerRows: 1,
                                widths: [400, 95],
                                body: [
                                    [{text: 'libellé', style: 'tableHeader'}, {text: 'Montant', style: 'tableHeader'}],
                                    <?php foreach($factureMoi->factures as $facture): $montantTotal += $facture->montant; ?>
                                        [
                                            {text: [{text:'<?= h($facture->frai->nom) ?>'}]},
                                            {text: [{text: formatNumber('<?= $facture->montant ?>')}]}
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
                                widths: [407, 95],
                                body: [
                                    ['', ''],
                                    [
                                        {text: [{text:'Total', bold: true}]},
                                        {text: [{text: formatNumber('<?= $montantTotal ?>'), bold: true}]}
                                    ]
                                ]
                            }
                        },

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
                        }
                    }

            }
            
            pdfMake.createPdf(dd).open();

            
        })  
    </script>

<?php endif; ?>

<!-- Les factures de touts les mois -->
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
                        {
                            margin: [0, 10, 0, 0],
                            table: {
                                // margin: [left, top, right, bottom]
                                widths: [95, 300, 95],
                                //headerRows: 1,
                                body: [
                                    ['Mois', 'Description', {text: 'Montant', style: 'center'}],
                                    <?php $total=0; foreach($intervalMonths as $k => $oneMonth): $sous_total=0; $total_paye=0; $total_rest=0; ?>
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
                                                        <?php endif; endforeach; ?>
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
                                        {text: [{text: formatNumber('<?= $total ?>'), bold: true, style: 'center'}]}
                                    ]
                                ]
                            }
                        }
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