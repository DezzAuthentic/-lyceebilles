<?php
$this->setLayout('default');
$this->assign('title','Test génération pdf');
?>




<?php $this->start('scriptBottom'); ?>
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
                title: 'Test pdf Afridev',
                author: 'Afridev',
                subject: 'Document test',
                keywords: 'test',
            },
            content: [
                {
                    columns: [
                        {
                            image: dataUrl,
                            width: 90
                        },
                        {
                            text: 'Lycée BILLES \n Bilingual Lycee of Excellence in Sciences \n Lycée Bilingue d’Excellence pour les Sciences',
                            style: 'entete'
                        }
                    ]       
                },
                {
                    columns: [
                        {
                            text: 'BULLETIN DE NOTES DE PREMIER SEMESTRE',
                            style: ['header','marginTop15']
                        },
                        {
                            text: ['Année scolaire: ', {text:'2018-2019',bold:true}],
                            style: ['right','marginTop15']
                        }
                    ],       
                },
                {
                    columns: [
                        {
                            width: 150,
                            text: [{text:'NOM: ',bold:true},'FALL'],
                            fontSize:10,
                            margin: [0,2]
                        },
                        {
                            text: [{text:'PRENOM: ',bold:true},'Macoumba'],
                            fontSize: 10,
                            margin: [0,2]
                        }
                    ],   
                },
                {
                    text: [{text:'Date et leu de naissance: ',bold:true},'27/06/0000 à Dakar'], 
                    fontSize: 10,
                    margin: [0,2]   
                },
                {
                    columns: [
                        {
                            width: 150,
                            text: [{text:'Classe: ',bold:true},'Sixième A'],
                            fontSize:10,
                            margin: [0,2]
                        },
                        {
                            text: [{text:'Effectif: ',bold:true},'20'],
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
                                {text: [{text:'OCT',bold:true}]}, 
                                {text: [{text:'NOV',bold:true}]}, 
                                {text: [{text:'DEC',bold:true}]}, 
                                {text: [{text:'JAN',bold:true}]}, 
                                {text: [{text:'FEV',bold:true}]}, 
                                {text: [{text:'MOY /20',bold:true}]}, 
                                {text: [{text:'MOY X COEF',bold:true}]}, 
                                {text: [{text:'MOY CLASSE',bold:true}]}, 
                                {text: [{text:'APPRECIATIONS',bold:true}]}, 
                            ],
                            [
                                {text: [{text:'Mathématiques',bold:true}]},
                                {text: [{text:'',bold:true}]},
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                                {text: [{text:'',bold:true}]}, 
                            ]
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
                                {text: [{text:'',bold:true}],fillColor: 'brown', color: "white", margin: [5,2]}, 
                            ],
                            [
                                {text: [{text:'Moyenne de la classe',fontSize: 10, bold:true}],fillColor: 'lightblue', margin: [5,2]}, 
                                {text: [{text:'',bold:true}],fillColor: 'lightblue'}, 
                            ],
                            [
                                {text: [{text:'Meilleure moyenne',fontSize: 10, bold:true}],fillColor: 'lightblue', margin: [5,2]}, 
                                {text: [{text:'',bold:true}],fillColor: 'lightblue', margin: [5,2]}, 
                            ]
                        ]
                    }
                },
                {
                    width: 150,
                    text: [{text:"Nombre d'heures d'absence: ",bold:true}," 10"],
                    fontSize:10,
                    margin: [5,10,0,0]
                },
                {
                    width: 150,
                    text: [{text:"Nombre d'heures de retard: ",bold:true}," 10"],
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
<?php $this->end(); ?>