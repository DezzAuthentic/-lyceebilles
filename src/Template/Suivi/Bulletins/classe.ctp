<div class="titre">
    <span>Liste des inscrits</span>
</div>

<div id="liste_tab" class="row tab">
    <br>
    <div class="col-xs-12">
        <table id="inscriptions_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Promotion">Classe</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($affectations as $affectation): ?>
                <tr>
                    <td><?=$affectation->inscription->elef->nom?></td>
                    <td><?=$affectation->inscription->elef->prenom?></td>
                    <td><?=$affectation->groupe->nom?></td>
                    <td class="actions">
                        <?php foreach($periodes as $periode):?>
                            <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>'.$periode->nom,['action'=>"classe",$periode->id,$affectation->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                        <?php endforeach;?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
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
    
</script>


<?php if(isset($bulletin) && $bulletin->periode_bulletin_lignes != null): ?>

    <script>
        <?php if(!empty($etablissement->logo)):?>
            url="<?= $this->Url->image($etablissement->logo,['fullBase' => true])?>";
        <?php else: ?>
            url="<?= $this->Build->Url('default-img.gif',['fullBase' => true])?>";
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
            var dd = {
                info: {
                    title: 'Bulletin de note - <?=$etablissement->nom?>',
                    author: 'PAGES',
                    subject: 'Bulletin de notes',
                    keywords: 'bulletin',
                },
                content: [
                    {
                        columns: [
                            {
                                image: dataUrl,
                                width: 90
                            },
                            {
                                text: "<?=$etablissement->nom?> \n <?=$etablissement->adresse?>",
                                style: 'entete'
                            }
                        ]       
                    },
                    {
                        columns: [
                            {
                                text: 'BULLETIN DE NOTES DU <?= strtoupper($periode->nom) ?>',
                                style: ['header','marginTop15']
                            },
                            {
                                text: ['Année scolaire: ', {text:'<?=$etablissement->annee->nom?>',bold:true}],
                                style: ['right','marginTop15']
                            }
                        ],       
                    },
                    {
                        columns: [
                            {
                                width: 150,
                                text: [{text:'NOM: ',bold:true},'<?=$affectation->inscription->elef->nom?>'],
                                fontSize:10,
                                margin: [0,2]
                            },
                            {
                                text: [{text:'PRENOM: ',bold:true},'<?=$affectation->inscription->elef->prenom?>'],
                                fontSize: 10,
                                margin: [0,2]
                            }
                        ],   
                    },
                    {
                        text: [{text:'Date et leu de naissance: ',bold:true},'<?=$affectation->inscription->elef->date_naissance?> à <?=$affectation->inscription->elef->lieu_naissance?>'], 
                        fontSize: 10,
                        margin: [0,2]   
                    },
                    {
                        columns: [
                            {
                                width: 150,
                                text: [{text:'Classe: ',bold:true},'<?= $affectation->groupe->nom?>'],
                                fontSize:10,
                                margin: [0,2]
                            },
                            {
                                text: [{text:'Effectif: ',bold:true},'<?php if(isset($affectations)) echo $affectations->count()?>'],
                                fontSize: 10,
                                margin: [0,2]
                            }
                        ],   
                    },
                    {
                        style: 'table',
                        table: {
                            widths: [100, 12, 25, 25, 25, 25, 25, 25, 25, 25, "*"],
                            body: [
                                [
                                    {text: [{text:'NOTE',bold:true,alignment:'right'},'\nDisciplines']},
                                    {text: [{text:'COEF',bold:true}]},
                                    <?php if($periode->nom == 'Semestre 1'): ?>
                                        {text: [{text:'OCT',bold:true}]}, 
                                        {text: [{text:'NOV',bold:true}]}, 
                                        {text: [{text:'DEC',bold:true}]}, 
                                        {text: [{text:'JAN',bold:true}]}, 
                                        {text: [{text:'FEV',bold:true}]}, 
                                    <?php elseif($periode->nom == 'Semestre 2'): ?>
                                        {text: [{text:'MARS',bold:true}]}, 
                                        {text: [{text:'AVR',bold:true}]}, 
                                        {text: [{text:'MAI',bold:true}]}, 
                                        {text: [{text:'JUIN',bold:true}]}, 
                                        {text: [{text:'JUIL',bold:true}]}, 
                                    <?php else: ?>
                                        {text: [{text:'Note 1',bold:true}]}, 
                                        {text: [{text:'Note 2',bold:true}]}, 
                                        {text: [{text:'Note 3',bold:true}]}, 
                                        {text: [{text:'Note 4',bold:true}]}, 
                                        {text: [{text:'Note 5',bold:true}]}, 
                                    <?php endif ?>
                                    {text: [{text:'MOY /20',bold:true}]}, 
                                    {text: [{text:'MOY X COEF',bold:true}]}, 
                                    {text: [{text:'MOY CLASSE',bold:true}]}, 
                                    {text: [{text:'APPRECIATIONS',bold:true}]}, 
                                ],
                                <?php foreach($bulletin->periode_bulletin_lignes as $ligne): ?>
                                    <?php foreach($matieres as $matiere): 
                                        if($matiere['nom']==$ligne->cour->matiere->nom):?>
                                            [
                                                {text: [{text:'<?=$ligne->cour->matiere->nom?>',bold:true}]},
                                                {text: [{text:'<?=$ligne->coef?>',bold:true}]},
                                                <?php for($i=0;$i<5;$i++):
                                                    $note = ' - ';
                                                    $note_ok = 0;
                                                    if(isset($matiere['notes'][$i]['eleves'][$affectation->inscription->eleve_id])){
                                                        $note = $matiere['notes'][$i]['eleves'][$affectation->inscription->eleve_id];
                                                        $note_ok = 1;
                                                    }
                                                ?>
                                                    <?php if($note_ok):?>
                                                        {text: [{text:'<?=$this->Number->format($note,['precision'=> 2])?>',bold:true}]}, 
                                                    <?php else:?>
                                                        {text: [{text:'<?=$note?>',bold:true}]}, 
                                                    <?php endif;?>
                                                <?php endfor; ?>
                                                <?php if($ligne->note):?>
                                                    {text: [{text:'<?=$this->Number->format($ligne->note,['precision'=> 2])?>',bold:true}]}, 
                                                    {text: [{text:'<?=$this->Number->format($ligne->note*$ligne->coef,['precision'=> 2])?>',bold:true}]}, 
                                                <?php else:?>
                                                    {text: [{text:' - ',bold:true}]}, 
                                                    {text: [{text:' - ',bold:true}]}, 
                                                <?php endif;?>
                                                {text: [{text:'<?=$this->Number->format($ligne->moyenne_classe,['precision'=> 2])?>',bold:true}]}, 
                                                {text: [{text:'<?=$ligne->appreciation?>',bold:true}]}, 
                                            ],
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach;?>
                            ]
                        }
                    },
                    {
                        layout: "noBorders",
                        table: {
                            widths: [150, 50],
                            fontSize: 10,
                            body: [
                                [
                                    {text: [{text:'Moyenne élève',fontSize: 10, bold:true}],fillColor: 'brown', color: "white", margin: [5,2]}, 
                                    {text: [{text:'<?=$this->Number->format($bulletin->moyenne,['precision'=> 2])?>',bold:true}],fillColor: 'brown', color: "white", margin: [5,2],alignment: 'center'}, 
                                ],
                                [
                                    {text: [{text:'Moyenne de la classe',fontSize: 10, bold:true}],fillColor: 'lightblue', margin: [5,2]}, 
                                    {text: [{text:'<?=$this->Number->format($bulletin->moyenne_classe,['precision'=> 2])?>',bold:true}],fillColor: 'lightblue',alignment: 'center'}, 
                                ],
                                [
                                    {text: [{text:'Meilleure moyenne',fontSize: 10, bold:true}],fillColor: 'lightblue', margin: [5,2]}, 
                                    {text: [{text:'<?=$this->Number->format($bulletin->meilleure_moyenne,['precision'=> 2])?>',bold:true}],fillColor: 'lightblue', margin: [5,2],alignment: 'center'}, 
                                ]
                            ]
                        }
                    },
                    {
                        width: 150,
                        text: [{text:"Nombre d'heures d'absence: ",bold:true}," <?=$retards->count()?>"],
                        fontSize:10,
                        margin: [5,10,0,0]
                    },
                    {
                        width: 150,
                        text: [{text:"Nombre d'heures de retard: ",bold:true}," <?=$absences->count()?>"],
                        fontSize:10 ,
                        margin: 5
                    },
                    {
                        margin: [0,10],
                        table: {
                            widths: [505],
                            fontSize: 10,
                            body: [
                                [
                                    {text: [{text:'Appréciations Générales du Conseil de Classe',fontSize: 12, bold:true}],fillColor: 'lightgray', color: "white",alignment: 'center',margin:2}, 
                                ],
                                [
                                    {
                                        layout: 'noBorders',
                                        bold: true,
                                        table:{ 
                                            widths: [20,'*'],
                                            body: [
                                                [
                                                    carre1,
                                                    {text: 'Félicitations'}
                                                ],
                                                [
                                                    carre2,
                                                    {text: 'Encouragements'}
                                                ],
                                                [
                                                    carre3,
                                                    {text: "Tableau d'honneur"}
                                                ],
                                                [
                                                    carre4,
                                                    {text: 'Avertissement'}
                                                ],
                                                [
                                                    carre5,
                                                    {text: 'Blâme'}
                                                ],
                                                [
                                                    carre6,
                                                    {text:'Insuffisant'},
                                                ],
                                                [
                                                    {text:''},
                                                    {text:'Professeur Principal : M .....................', alignment:'center'}
                                                ]
                                            ]
                                        }
                                    }
                                ]
                            ]
                        }
                    },
                    {text: 'Le directeur général', alignment:'right'}
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
                    {text: 'Education pour le Développement des Sciences Techniques et Innovations en Afrique – EDESTIA-SA – '+
                        'NINEA 4543890 2C3 \nRC SN DKR 2012 B 4059 - BP : 6178 Dakar – ETOILE   Tel : (221) 77 677 7371 et '+
                        '(221) 33 959 22 12 www.lyceebilles.com \nDakar - SENEGAL',fontSize: 8,bold: true,alignment: 'center'}
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
                    small: {
                        fontSize: 8
                    }
                }
            }
            pdfMake.createPdf(dd).open();
        })  
    </script>

<?php endif; ?>


<?php $this->end(); ?>