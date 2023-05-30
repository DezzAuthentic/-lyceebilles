<div class="titre">
    <span>Facturation de la classe <?=$groupe->nom?></span>
</div>

<div class="row">
    <div class="col-xs-12 soustitre">
        <span>Factures de scolarité mensuelles pour l'ensemble des élèves
    </div>
    <?php foreach($mois as $moi): if($moi->factures != null): ?>
        <div class="col-xs-2 mb2">
            <?=$this->Html->link($moi->nom,['action'=>"classe",$groupe->id, $moi->id, "all"],['escape'=>false,'class' => 'btn btn-md btn-default btn-block'])?>
        </div>
    <?php endif; endforeach;?>
</div>

<div class="row mt3">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Liste des élèves <span id="export" class="pull-right"></span></div>
            <table id="affectations_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Matricule">Matricule</th>
                        <th style="width:200px;"></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->affectations as $affectation): ?>
                    <tr>
                        <td><?=$affectation->inscription->elef->nom?></td>
                        <td><?=$affectation->inscription->elef->prenom?></td>
                        <td><?=$affectation->inscription->elef->matricule?></td>
                        <td class="">
                            <?=$this->Html->link('Facturation',['controller'=>'Factures','action'=>"parEleveMois",$affectation->inscription->id],['class' => 'btn btn-xs btn-default'])?>
                            <?=$this->Html->link('voir la fiche',['controller'=>'Eleves','action'=>"fiche",$affectation->inscription->elef->id],['class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
    "https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    table = $('#affectations_table').DataTable({
        "info": false,
        "paging": false,
        "ordering": true,
        "searching": false,
        "buttons": [
            'copy', 'excel'
        ],
        "language": {
            "lengthMenu": "Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
            "search": "Recherche",
            "scrollX": true,
            "paginate": {
                "first":      "<<",
                "last":       ">>",
                "next":       ">",
                "previous":   "<"
            }
        },
        "columnDefs": [ {
            "targets": 3,
            "orderable": false
            }
        ]
    });
    table.buttons().container().appendTo( '#export' );
    $("#export").css('margin-top','-7px')
});
</script>

<?php if(isset($allFactures) && $allFactures != null): ?>
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
                        <?php foreach($groupe->affectations as $affect): ?>
                        {
                            columns: [
                                {
                                    image: dataUrl,
                                    width: 90
                                },
                                {
                                    text: "<?php if ($etablissement->nom) echo $etablissement->nom;?> \n <?php if ($etablissement->adresse) echo $etablissement->adresse;?>",
                                    style: 'entete'
                                }
                            ]       
                        },
                        {
                            columns: [
                                {
                                    text: ['Année : ', {text:'<?= h($etablissement->annee->nom) ?>',bold:true}],
                                    style: ['right','marginTop15'],
                                    margin: [0,15]
                                }
                            ],       
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'NOM: ',bold:true},'<?= h($affect->inscription->elef->nom) ?>\n '],
                                    fontSize:10,
                                    margin: [0,2]
                                },
                                {
                                    text: [{text:'PRENOM: ',bold:true},'<?= h($affect->inscription->elef->prenom) ?>'],
                                    fontSize: 10,
                                    margin: [0,2]
                                },
                            ],   
                        },
                        {
                            text: [{text:'Date et lieu de naissance: ',bold:true},'<?= h($affect->inscription->elef->date_naissance) ?> à <?= h($affect->inscription->elef->lieu_naissance) ?>'], 
                            fontSize: 10,
                            margin: [0,2]   
                        },
                        {
                            columns: [
                                {
                                    width: 150,
                                    text: [{text:'Classe: ',bold:true},'<?= h($groupe->nom) ?>'],
                                    fontSize:10,
                                    margin: [0,2]
                                }
                            ],   
                        },

                        {
                            text: 'FACTURES DU MOIS DE <?= h(strtoupper($leMois->nom)) ?>',
                            style: ['header','marginTop15', 'center']
                        },
                        
                        <?php  $sous_total_prev = 0; 
                            foreach($moisPrecedents as $theMonth):
                                foreach($theMonth->factures as $f): 
                                    if($f->inscription->id == $affect->inscription->id && $f->mois_id == $theMonth->id):
                                        $sous_total_prev += $f->restant;
                        endif; endforeach; endforeach; ?>

                        {
                            // margin: [left, top, right, bottom]
                            margin: [0, 30, 0, 0],
                            layout: 'lightHorizontalLines',
                            table: {
                                headerRows: 1,
                                widths: [170, 100, 100, 100],
                                body: [
                                    [{text: 'libellé', style: 'tableHeader'}, 
                                    {text: 'Montant', style: 'tableHeader'}, 
                                     {text: 'Payé', style: 'tableHeader'}, 
                                     {text: 'Restant', style: 'tableHeader'}
                                    ],
                                    <?php 
                                    $montantTotal=0;
                                    $PayeTotal = 0;
                                    $RestantTotal = 0; 
                                    $lastFacture = end($allFactures);

                                    foreach($allFactures as $facture): 
                                        if($facture->inscription->elef->id==$affect->inscription->elef->id): 
                                            $montantTotal += $facture->montant;
                                            $PayeTotal += $facture->paye; 
                                            $RestantTotal += $facture->restant;
                                    ?>
                                    [
                                        {text: [{text:'<?= h($facture->frai->nom) ?>'}]},
                                        {text: [{text: formatNumber('<?= $facture->montant ?>')}]},
                                        {text: [{text: formatNumber('<?= $facture->paye ?>')}]},
                                        {text: [{text: formatNumber('<?= $facture->restant ?>')}]}
                                    ],
                                    
                                    <?php endif; endforeach; ?>
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
                                            if($fact->inscription->id == $affect->inscription->id && $fact->mois_id == $theMonth->id):
                                                $totalPrec += $fact->restant; $sousTotalPrec += $fact->restant;
                                        endif; endforeach; ?>
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
                            margin: [0, 5, 0, 0],
                            layout: 'noBorders',
                            table: {
                                headerRows: 1,
                                widths: [407, 95],
                                body: [
                                    
                                    ['', ''],
                                    [
                                        {text: [{text:'Total', bold: true}]},
                                        {text: [{text: formatNumber('<?= $montantTotal + $totalPrec ?>'), bold: true}]}
                                    ],
                                    [
                                        {text: [{text:'Total Payé', bold: true}]},
                                        {text: [{text: formatNumber('<?= h($PayeTotal) ?>'), bold: true}]},
                                    ],
                                    [
                                        {text: [{text:'Total Restant', bold: true}]},
                                        {text: [{text: formatNumber('<?= h($RestantTotal + $totalPrec ) ?>'), bold: true}]},
                                    ]
                                ]
                            }
                        },
/** 
                        
                       
*/
                        {
                            // margin: [left, top, right, bottom]
                            margin: [400, 200, 0, 0],
                            layout: 'noBorders',
                             <?php if($affect->id != $lastAffectation->id) echo "pageBreak: 'after',"; ?>
                            table: {
                                widths: [0, 100],
                                body: [
                                    ['', {text: [{text: 'La Comptabilité', bold: true}]}],
                                    
                                ]
                            }
                        },


                    <?php endforeach; ?>

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
                        {text: 'Education pour le Développement des Sciences Techniques et Innovations en Afrique – EDESTIA-SA – NINEA 4543890 2C3 \n RC SN DKR 2012 B 4059 - BP : 6178 Dakar – ETOILE   Tel : (221) 77 677 7371 et (221) 33 959 22 12 www.lyceebilles.com ',fontSize: 8,bold: true,alignment: 'center'}
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
                    },

                

            }
            
            pdfMake.createPdf(dd).open();

            
        })  
    </script>

<?php endif; ?>

<?php $this->end(); ?>