<div class="titre">
    <span>Bulletins de la classe <?=$groupe->nom?></span>
</div>

<div class="row">
    <div class="col-xs-12 soustitre">
        <span>Bulletins de notes semestrielles pour l'ensemble des élèves
    </div>
    <?php foreach($periodes as $periode):?>
        <div class="col-xs-2 mb2">
            <?=$this->Html->link($periode->nom,['action'=>"classe",$groupe->id, $periode->id, "all"],['escape'=>false,'class' => 'btn btn-md btn-block btn-default'])?>
        </div>
    <?php endforeach;?>
</div>

<div class="row mt3">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Liste des élèves</div>
            <table id="affectations_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Matricule">Matricule</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->affectations as $affectation): ?>
                    <tr>
                        <td><?=$affectation->inscription->elef->nom?></td>
                        <td><?=$affectation->inscription->elef->prenom?></td>
                        <td><?=$affectation->inscription->elef->matricule?></td>
                        <td class="">
                            <?php foreach($periodes as $periode):?>
                                <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>'.$periode->nom, ['action'=>"classe", $groupe->id, $periode->id, "one", $affectation->id],['escape'=>false,'class' => 'btn btn-xs btn-default'])?>
                            <?php endforeach;?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
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
            $(function () {
                table = $('.datatable').DataTable({
                    "info": false,
                    "paging": true,
                    "ordering": true,
                    "searching": true,
                    "buttons": [
                        'copy', 'excel'
                    ],
                    "language": {
                        "lengthMenu": "Afficher _MENU_ par page &nbsp;",
                        "zeroRecords": "Pas de séances trouvées!",
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
                        "targets": 3,
                        "orderable": false
                        },{
                        "targets": 4,
                        "orderable": false
                        }
                    ]
                });
                table.buttons().container().appendTo( '#affectations_table .col-sm-6:eq(0)' );        
            });
        </script>

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

    <?php if(isset($allBulletins) && $allBulletins != null): ?>

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
                    <?php foreach($groupe->affectations as $affect): ?>
                        info: {
                            title: 'Bulletin de note',
                            author: 'PAGES',
                            subject: 'Bulletin de notes',
                            keywords: 'bulletin',
                        },
                        content: [
                        <?php $lastElement = end($allBulletins); foreach($allBulletins as $bulletin): ?>
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
                                        text: 'BULLETIN DE NOTES DU <?= strtoupper($periode->nom) ?>',
                                        style: ['header','marginTop15']
                                    },
                                    {
                                        text: ['Année scolaire: ', {text:'<?= h($etablissement->annee->nom) ?>',bold:true}],
                                        style: ['right','marginTop15']
                                    }
                                ],       
                            },
                            {
                                columns: [
                                    {
                                        width: 150,
                                        text: [{text:'NOM: ',bold:true},'<?= h($affect->inscription->elef->nom) ?>'],
                                        fontSize:10,
                                        margin: [0,2]
                                    },
                                    {
                                        text: [{text:'PRENOM: ',bold:true},'<?= h($affect->inscription->elef->prenom) ?>'],
                                        fontSize: 10,
                                        margin: [0,2]
                                    }
                                ],   
                            },
                            {
                                text: [{text:'Date et leu de naissance: ',bold:true},'<?=$affect->inscription->elef->date_naissance?> à <?= h($affect->inscription->elef->lieu_naissance) ?>'], 
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
                                    },
                                    {
                                        text: [{text:'Effectif: ',bold:true},'<?php if(isset($affectations)) echo count($affectations); ?>'],
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
                                                        {text: [{text:'<?= h($ligne->cour->matiere->nom) ?>',bold:true}]},
                                                        {text: [{text:'<?=$ligne->coef?>',bold:true}]},
                                                        <?php for($i=0;$i<5;$i++):
                                                            $note = ' - ';
                                                            $note_ok = 0;
                                                            if(isset($matiere['notes'][$i]['eleves'][$affect->inscription->eleve_id])){
                                                                $note = $matiere['notes'][$i]['eleves'][$affect->inscription->eleve_id];
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
                                        <?php endforeach; ?>
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
                                <?php $arrayAbsences = []; foreach($absences as $absence): if($absence->eleve_id == $affect->eleve_id) array_push($arrayAbsences, $absence->eleve_id); endforeach; ?>
                                width: 150,
                                text: [{text:"Nombre d'heures d'absence : ",bold:true}," <?= count($arrayAbsences) ?>"],
                                fontSize:10 ,
                                margin: 5
                            },
                            {
                                <?php $arrayRetards = []; foreach($retards as $retard): if($retard->eleve_id == $affect->eleve_id) array_push($arrayRetards, $retard->eleve_id); endforeach; ?>
                                width: 150,
                                text: [{text:"Nombre d'heures de retard : ",bold:true}," <?= count($arrayRetards) ?>"],
                                fontSize:10,
                                margin: [5,10,0,0]
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
                            {text: 'Le directeur général', alignment:'right' <?php if($bulletin->id != $lastElement->id) echo ", pageBreak: 'after'"; ?>},
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
                            small: {
                                fontSize: 8
                            }
                        },
                        

                <?php endforeach; ?>

                }
                
                pdfMake.createPdf(dd).open();

                
            })  
        </script>


    <?php endif; ?>

<?php $this->end(); ?>