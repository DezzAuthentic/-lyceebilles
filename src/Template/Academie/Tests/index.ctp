<?php
    $eleves_i = [];
    foreach($tests as $test){
        $eleves_i[$test->eleve_id]['id'] = $test->elef->id;
        $eleves_i[$test->eleve_id]['nom'] = $test->elef->nom;
        $eleves_i[$test->eleve_id]['prenom'] = $test->elef->prenom;
        $eleves_i[$test->eleve_id]['matricule'] = $test->elef->matricule;
        $eleves_i[$test->eleve_id]['promotion'] = $test->promotion->nom;
        $eleves_i[$test->eleve_id]['matieres'][] = $test->matiere->nom;
    }
    //dd($eleves_i);
?>
<div class="titre">
    <span>Gestion des tests de niveau</span>
    <a id="ajout_btn" href="<?=$this->Url->build(['action'=>'inscrire'])?>" class="btn btn-default pull-right btn-sm" >
        <span class="glyphicon glyphicon-plus"></span> Inscrire un élève
    </a>
</div>

<div class="row">

    <div class="col-xs-12">
        <table id="professeurs_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th>#</th>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Matricule">Matricule</th>
                    <th title="Promotion">Promotion</th>
                    <th title="Matières testées">Matières testées</th>
                    <th class="actions" style="min-width:70px;">   
                    </th>
                </tr> 
            </thead>
            <tbody>            
            <?php $i=0; foreach($eleves_i as $eleve): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$eleve['nom']?></td>
                    <td><?=$eleve['prenom']?></td>
                    <td><?=$eleve['matricule']?></td>
                    <td><?=$eleve['promotion']?></td>
                    <td>
                        <?php foreach($eleve['matieres'] as $matiere){
                            echo '<span class="label label-default mr1">'.$matiere.'</span>';
                        }
                        ?>
                    </td>
                    <td class="actions">
                        <?=$this->Html->link('<i class="glyphicon glyphicon-eye-open icone"></i>',['action'=>'fiche',$eleve['id']],['class' => 'btn btn-xs btn-default','escape'=>false])?>
                        <?=$this->Form->postLink('<i class="glyphicon glyphicon-remove icone"></i>', ['action' => 'supprimer', $eleve['id']], ["escape"=>false,'confirm' => __('Voulez-vous supprimer ces tests # {0}?', $eleve['id']),'class'=>"btn btn-xs btn-default"]); ?>
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
            "ordering": false,
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
            }/*,
            "columnDefs": [ {
                "targets": 3,
                "orderable": false
                },{
                "targets": 4,
                "orderable": false
                }
            ]*/
        });
        table.buttons().container().appendTo( '#professeurs_table_wrapper .col-sm-6:eq(0)' );        
    });

    $(".modifierProf").click(function() {
        $("[id^='mat_']").removeAttr("checked");
        data = $(this).children("input").val().split("*");
        console.log($(this).children("input").val());
        $("#modifier_id").val(data[0]);
        $("#modifier_nom").val(data[1]);
        $("#modifier_prenom").val(data[2]);
        i = 3;
        while(data[i]){
            console.log(data[i]);
            $("#mat_"+data[i]).attr("checked","checked");
            i++;
        }
    });
    
</script>
<?php $this->end(); ?>