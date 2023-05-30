<?php
    /*$mois[1]='Janvier';
    $mois[2]='Février';
    $mois[3]='Mars';
    $mois[4]='Avril';
    $mois[5]='Mai';
    $mois[6]='Juin';
    $mois[7]='Juillet';
    $mois[8]='Août';
    $mois[9]='Septembre';
    $mois[10]='Octobre';
    $mois[11]='Novembre';
    $mois[12]='Décembre';*/
?>
<div class="titre">
    Gestion des abonnements - 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>

    <span class="btn btn-default btn-sm pull-right margin-g-5" data-toggle="modal" data-target="#engagementModal" >
        <span class="glyphicon glyphicon-credit-card"></span> Ajouter un abonnement
    </span>
    <a class="btn btn-warning btn-sm pull-right" href="<?=$this->Url->Build('/finance/factures/par-eleve-mois/'.$inscription->id)?>" >
        <span class="glyphicon glyphicon-credit-card"></span> Factures
    </a> 
</div>

<div class="row">
    <div class="col-xs-12">
    <div class="panel panel-default">
            <div class="text-center panel-heading"><span class="soustitre2">Factures mensuelles</span></div>
            <table id="factures_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Mois">Libellé</th>
                        <th title="Réduction">Réduction</th>
                        <th title="Montant">Montant net</th>
                        <th title="Début">Début</th>
                        <th title="Fin">Fin</th>
                        <th class="actions" >   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php foreach($engagements as $engagement): ?>
                    <tr>
                        <td><?=$engagement->frai->nom?></td>
                        <td><?=$engagement->reduction?>%</td>
                        <td><?=$engagement->frai->montant*(1-$engagement->reduction/100)?></td>
                        <td><?php foreach($mois as $moi){if($moi->id==$engagement->debut){echo $moi->nom;$ordre_debut=$moi->ordre;break;}}?></td>
                        <td><?php foreach($mois as $moi){if($moi->id==$engagement->fin){echo $moi->nom;$ordre_fin=$moi->ordre;break;}}?></td>
                        <td>
                            <span class="btn btn-xs btn-default modifEngagement" data-toggle="modal"
                                data-target="#editEngagementModal" > <span class="glyphicon glyphicon-pencil icone"></span>
                                <input type="hidden" value="<?=$engagement->id.'*'.$engagement->frais_id.'*'.$engagement->debut.'*'.$engagement->fin.
                                    '*'.$engagement->reduction?>">
                            </span>
                            <?=$this->Form->postLink(__('<i class="icone glyphicon glyphicon-remove"></i>'), ["controller"=>"Engagements","action" => "supprimer"],['escape'=>false,"data"=>["id"=>$engagement->id],'confirm' => __('Voulez-vous supprimer cet engagement # {0}?'),'class'=>"btn btn-xs btn-default"])?>    

                        </td>
                    </tr>
                    
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ajout engagement eleve-->
<div class="modal fade" id="engagementModal" tabindex="-1" role="dialog" aria-labelledby="engagementModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Engagements', 'action' => 'ajouter']) ?>" method="post">
            <input type="hidden" name="inscription_id" id="ajoutInscriptionId" value="<?=$inscription->id?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ajoutFactureModalLabel">Ajout d'un engagement</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for='ajoutType' class="col-sm-3 col-form-label">Frais</label>
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
                    <div for='ajoutDebut' class="form-group row">
                        <label class="col-sm-3 col-form-label">Début</label>
                        <div class="col-sm-8">
                            <?=$this->Form->select("debut", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'debutId']);?>
                        </div>
                    </div>
                    <div for='ajoutFin' class="form-group row">
                        <label class="col-sm-3 col-form-label">Fin</label>
                        <div class="col-sm-8">
                            <?=$this->Form->select("fin", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'finId']);?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajout" class="col-sm-3 col-form-label">Réduction</label>
                        <div class="col-sm-4">
                            <input type="number" name="reduction" id="ajoutReduction" min="0" max="100" class="form-control" required>
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

<!-- Modal Edit engagement eleve-->
<div class="modal fade" id="editEngagementModal" tabindex="-1" role="dialog" aria-labelledby="editEngagementModalLabel">
    <div class="modal-dialog" role="document">
        <form action="<?= $this->Url->Build(['controller' => 'Engagements', 'action' => 'modifier']) ?>" method="post">
            <input type="hidden" name="id" id="editEngagement" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editEngagementModalLabel">Modification de l'engagement </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for='editFrais' class="col-sm-3 col-form-label">Frais</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="editFrais" disabled>
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
                    <div for='ajoutDebut' class="form-group row">
                        <label class="col-sm-3 col-form-label">Début</label>
                        <div class="col-sm-8">
                            <?=$this->Form->select("debut", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'editDebut','disabled']);?>
                        </div>
                    </div>
                    <div for='ajoutFin' class="form-group row">
                        <label class="col-sm-3 col-form-label">Fin</label>
                        <div class="col-sm-8">
                            <?=$this->Form->select("fin", $mois_list, ['empty' => true,'class'=>'form-control','id'=>'editFin']);?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ajout" class="col-sm-3 col-form-label">Réduction</label>
                        <div class="col-sm-4">
                            <input type="number" id="editReduction" min="0" max="100" class="form-control" disabled>
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
    $(".modifEngagement").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".modifEngagement input").val());
        $("#editEngagement").val(data[0]);
        $("#editFrais").val(data[1]);
        $("#editDebut").val(data[2]);
        $("#editFin").val(data[3]);
        $("#editReduction").val(data[4]);
    });
</script>
<?php $this->end(); ?>