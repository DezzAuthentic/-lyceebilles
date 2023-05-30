<div class="titre">
    <span>Gestion des promotions</span>
    <button id="ajout_btn" type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#ajouterPromotionModal">
        <span class="glyphicon glyphicon-pencil"></span> Ajouter une promotion
    </button>
</div>

<section id="promotions_tab" class="row tab">
    <div class="col-xs-12">
        <table id="promotions_table" class="table datatable hover" >
            <thead>
                <tr>
                    <th title="Nom">Nom</th>
                    <th title="prenom">Inscription</th>
                    <th title="email">Scolarite</th>
                    <th class="actions" >
                        
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($promotions as $promotion): ?>
                <tr>
                    <td><?=$promotion->nom?></td>
                    <td><?=$promotion->montant_inscription?></td>
                    <td><?=$promotion->scolarite?></td>
                    <td class="actions">
                        <span class="icone glyphicon glyphicon-pencil editPromotion hover" data-toggle="modal"
                        data-target="#editPromotionModal" >
                            <input type="hidden" value="<?=$promotion->id.'*'.$promotion->niveau_id.'*'.$promotion->serie_id.'*'.$promotion->montant_inscription.'*'.$promotion->scolarite?>">
                        </span>
                        <span class="icone glyphicon glyphicon-remove supprPromotion hover" data-toggle="modal"
                        data-target="#supprPromotionModal">
                            <input type="hidden" value="<?=$promotion->id.'*'.$promotion->nom?>">
                        </span>
                        
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal ajout Promotion-->
<div class="modal fade" id="ajouterPromotionModal" tabindex="-1" role="dialog" aria-labelledby="ajouterPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'ajouter']) ?>" method="post">
        <input type="hidden" name="annee_id" value="<?=$etablissement->annee_id?>" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ajouterPromotionModalLabel">Ajout d'une promotion</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="ajouterPromotionNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="ajouterPromotionNom" required readonly >
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionNiveau" class="col-sm-4 col-form-label">Niveau</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"ajouterPromotionNiveau","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionSerie" class="col-sm-4 col-form-label">Série</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('serie_id',$series,['class'=>'form-control','empty'=>" ","id"=>"ajouterPromotionSerie"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionInscription" class="col-sm-4 col-form-label">Montant Inscription</label>
                <div class="col-sm-8">
                    <input type="number" name="montant_inscription" class="form-control" id="ajouterPromotionInscription" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="ajouterPromotionScolarite" class="col-sm-4 col-form-label">Montant Scolarité</label>
                <div class="col-sm-8">
                    <input type="number" name="scolarite" class="form-control" id="ajouterPromotionScolarite" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal Edit Promotion-->
<div class="modal fade" id="editPromotionModal" tabindex="-1" role="dialog" aria-labelledby="editPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'editer']) ?>" method="post">
        <input id="editerPromotionId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editPromotionModalLabel">Ajout d'une promotion</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editerPromotionNom" class="col-sm-4 col-form-label">Nom</label>
                <div class="col-sm-8">
                    <input type="text" name="nom" class="form-control" id="editerPromotionNom" required readonly >
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionNiveau" class="col-sm-4 col-form-label">Niveau</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('niveau_id',$niveaux,['class'=>'form-control',"id"=>"editerPromotionNiveau","required"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionSerie" class="col-sm-4 col-form-label">Série</label>
                <div class="col-sm-8">
                    <?=$this->Form->select('serie_id',$series,['class'=>'form-control','empty'=>" ","id"=>"editerPromotionSerie"])?>
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionInscription" class="col-sm-4 col-form-label">Montant Inscription</label>
                <div class="col-sm-8">
                    <input type="number" name="montant_inscription" class="form-control" id="editerPromotionInscription" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="editerPromotionScolarite" class="col-sm-4 col-form-label">Montant Scolarité</label>
                <div class="col-sm-8">
                    <input type="number" name="scolarite" class="form-control" id="editerPromotionScolarite" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal suppression Promotion-->
<div class="modal fade" id="supprPromotionModal" tabindex="-1" role="dialog" aria-labelledby="supprPromotionModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'supprimer']) ?>" method="post">
        <input id="supprPromotionId" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="supprPromotionModalLabel">Supression de la promotion : <span id="supprPromotionNom"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-8">
                    Voulez-vous vraiment supprimer cette promotion?
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            <button type="submit" class="btn btn-primary">Oui</button>
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
            }
        });    
    });

    $("#editerPromotionNiveau, #editerPromotionSerie").change(function() {
        var nom="";
        var str = $( "#editerPromotionSerie option:selected" ).text();
        if(str==' ') serie="";
        else{
            var matches = str.match(/\b(\w)/g);
            var serie = matches.join('');
        }
        var niveau = $( "#editerPromotionNiveau option:selected" ).text();
        $("#editerPromotionNom").val(niveau+" "+serie);
    });
    $("#ajouterPromotionNiveau, #ajouterPromotionSerie").change(function() {
        var nom="";
        var str = $( "#ajouterPromotionSerie option:selected" ).text();
        console.log(str);
        if(str==' ') serie="";
        else{
            var matches = str.match(/\b(\w)/g);
            var serie = matches.join('');
        }
        var niveau = $( "#ajouterPromotionNiveau option:selected" ).text();
        $("#ajouterPromotionNom").val(niveau+" "+serie);
    });
    
    $(".editPromotion").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".editPromotion input").val());
        $("#editerPromotionId").val(data[0]);
        $("#editerPromotionNiveau").val(data[1]);
        $("#editerPromotionSerie").val(data[2]);
        $("#editerPromotionInscription").val(data[3]);
        $("#editerPromotionScolarite").val(data[4]);
    });
    $(".supprPromotion").click(function() {
        data = $(this).children("input").val().split("*");
        console.log($(".supprPromotion input").val());
        $("#supprPromotionId").val(data[0]);
        $("#supprPromotionNom").html(data[1]);
    });

</script>
<?php $this->end(); ?>