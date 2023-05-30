<div class="titre">
    <span>Transfert d'élève</span>
</div>

<section class="row">
    <div class="col-xs-12">
        <div class="loader-container">
            <div class="loader"></div> 
        </div>
        <div class="noconnexion">
            Vérifiez votre connexion! 
        </div>

        <form action="<?= $this->Url->Build(['controller' => 'Promotions', 'action' => 'transfert']) ?>" method="post">
            <div class="form-group row ">
                <label for="nom" class="col-sm-3">Elève</label>
                <div class="col-sm-9">
                    <select required type="text" name="affectation_id" class="form-control select2" id="eleve">
                        <option></option>
                        <?php foreach($affectations as $affectation):?>
                            <option value="<?=$affectation->id?>"><?=$affectation->inscription->elef->matricule?> -- <?=$affectation->inscription->elef->prenom?> <?=$affectation->inscription->elef->nom?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Affectation actuelle
                </div>
                <div class="panel-body">
                    <div class="form-group row ">
                        <label for="promotion_0" class="col-sm-3">Promotion</label>
                        <div class="col-sm-9">
                            <input id="promotion_0" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="classe_0" class="col-sm-3">Classe</label>
                        <div class="col-sm-9">
                            <input id="classe_0" type="text" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Transférer vers
                </div>
                <div class="panel-body">
                    <div class="form-group row ">
                        <label for="promotion" class="col-sm-3">Promotion</label>
                        <div class="col-sm-9">
                            <select id="promotion_id" name="promotion_id" class="form-control" required >
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="classe" class="col-sm-3">Classe</label>
                        <div class="col-sm-9">
                            <select id="classe_id" name="classe_id" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <button class="btn btn-primary btn-block" type="submit">Valider</button>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
$this->Html->css([
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(document).ready( function () {
        $('.select2').select2();
    });
    
    ///////////////////////////
    $("#eleve").change(function(){
        var affectation_id = $(this).val();
        $('.noconnexion').hide();
        $('.loader-container').show();
        <?php $url=$this->Url->build(['controller' => 'Affectations', 'action'=>'getDetails']); ?>
        $.ajax({
            type:"GET",
            url:"<?= $url; ?>/"+affectation_id,
            //async: false,
            success : function(data, statut) {
                console.log(data);
                var affectation = JSON.parse(data);
                $("#promotion_0").val(affectation.inscription.promotion.nom);
                $("#classe_0").val(affectation.groupe.nom);
                $("#promotion_id").html('');
                $("#classe_id").html('');
                $("#promotion_id").append("<option></option>");
                $("#classe_id").append("<option></option>");
                $.each( affectation.promotions, function( key, promotion ) {
                    $("#promotion_id").append("<option value="+promotion.id+">"+promotion.nom+"</option>");
                    $.each( promotion.groupes, function( key2, classe ) {
                        $("#classe_id").append("<option class='classe promo_"+promotion.id+"' value="+classe.id+">"+classe.nom+"</option>");
                    });
                });
                $('.classe').hide();
            },
            error : function(resultat, statut, erreur){
                $('.loader-container').hide();
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });
    });
    $('#promotion_id').change( function(){
        $('.classe').hide();
        $('.promo_'+$(this).val()).show();
    });
</script>
<?php $this->end(); ?>