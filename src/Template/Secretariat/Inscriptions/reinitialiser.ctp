
<div class="titre">
Réinitialisation de l'inscription: 
    <span class="">
        <?=$inscription->elef->prenom." ".$inscription->elef->nom.' - '.$inscription->promotion->nom?>
    </span>
    <a id="ajout_btn" href="<?=$this->Url->Build("/secretariat/inscriptions/liste")?>" class="btn btn-default btn-sm pull-right" >
        <span class="glyphicon glyphicon-arrow-left"></span> Retour à la liste
    </a>
</div>

<!--********************************************************************************
Onglet nouvelle inscription
*********************************************************************************-->
<div id="inscription_tab" class="tab">
    <div class="loader-container">
        <div class="loader"></div> 
    </div>
    <div class="noconnexion">
        Vérifiez votre connexion! 
    </div> 
    <br>

    <form action="<?= $this->Url->Build(['controller' => 'Inscriptions', 'action' => 'init']) ?>" method="post">
        <input type="hidden" name="inscription_id" value="<?=$inscription->id?>">
    <div class="row">
        <div class="col-xs-12">
            
            <div class="form-group row" id="groupe_promotion">
                <label for="select_promotion" class="col-sm-2 col-form-label col-xs-12">Promotion</label>
                <div class="col-sm-10 col-xs-12">
                    <?=$this->Form->select('promotion_id', $promotions, ['empty' => true,'class'=>'form-control','id'=>'select_promotion','required']);?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach($types as $type):?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="panel panel-default panel_frais" id="panel_<?=$type->nom?>">
                    <div class="text-center panel-heading"><span class="soustitre2"><?=$type->nom?></span></div>
                    <table id="table_<?=$type->id?>" class="table compact hover">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach;?>

        <div class="col-xs-12" id="reduction"></div>

        <div class="col-xs-12">
            <div class=" panel_frais">
                <div class="panel panel-default text-center panel-heading col-xs-12 bordures h4">
                    <!--div class="col-xs-12" id="total_inscription"></div>
                    <div class="col-xs-12" id="total_facultatives"></div>
                    <br><hr-->
                    <div class="col-xs-12"><button type="submit" class="btn btn-md btn-primary">Valider</button></div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <input type="hidden" id="total_temp">
    <input type="hidden" id="facultatives_temp">

</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        //******** initialisation *********/
        $('.panel_frais').hide();
        //******************************** */
        $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false
        });
        $('.select2').select2();
        //maj_total();
    });
    // gérer l'affichage des tab
    $(".tmenu").click(function() {
        $(".tab").hide();
        id = $(this).attr('id');
        suffixe = id.split('_')[0];
        $("#"+suffixe+"_tab").show();       
        console.log('ouverture tab');
        $(".tmenu").removeClass('active');
        $(this).addClass('active');
    });
    ///////////////////////////
    $("#select_promotion").change(function(){
        var promotion_id = $(this).val();
        if(promotion_id == '') {
            $(".panel_frais").hide();
            return;
        }
        
        console.log("promo ok");
        $('.loader-container').show();
        <?php $url=$this->Url->build(['controller' => 'Frais', 'action'=>'getFrais']); ?>
        console.log("<?= $url; ?>/"+promotion_id);
        $('[id^=table_]').html('<tbody></tbody>');
        $.ajax({
            type:"GET",
            url:"<?= $url; ?>/"+promotion_id,
            //async: false,
            success: function(data) {
                console.log(data);
                var frais = JSON.parse(data);
                
                type_id=null;
                i=0;
                id_scol=null;
                $.each( frais, function( key, frai ) {
                    // iniialiser les compteurs au changement de type
                    if(frai.type.id !=type_id) i=0;
                    
                    if(frai.type.selection==0){
                        if(i==0){
                            oblige = '';
                            if(frai.type.obligatoire==1) oblige=' checked disabled ';
                            ligne_tout = "<tfoot><tr><td colspan='3'><input type='checkbox' "+oblige+" name='types_tout["+frai.type.id+"]' value='"+frai.type.id+"'></td></tr></tfoot>"
                            $("#table_"+frai.type.id).append(ligne_tout);
                        } 
                        ligne = "<tr><td>"+frai.nom+"</td><td>"+frai.montant+"</td><tr>";
                    }else if(frai.type.selection==1){
                        if(i==0 && frai.type.obligatoire==0) {
                            ligne_null = "<tr><td><input type='radio' name='frais_uniques["+frai.type.id+"]' value='null' checked></td><td>Non Inscrit</td><td></td></tr>";
                            $("#table_"+frai.type.id+" tbody").append(ligne_null);
                        }
                        ligne="<tr><td><input type='radio' name='frais_uniques["+frai.type.id+"]' value='"+frai.id+"' required></td>"
                            +"<td>"+frai.nom+"</td>"+"<td>"+frai.montant+"</td></tr>";
                    }else if(frai.type.selection==2){
                        ligne="<tr><td><input type='checkbox' name='frais_multis["+frai.id+"]' value='"+frai.id+"'></td>"
                            +"<td>"+frai.nom+"</td>"+"<td>"+frai.montant+"</td></tr>";
                    }
                    $("#table_"+frai.type.id+" tbody").append(ligne);
                    i++;
                    type_id = frai.type.id;
                });
                $('td').css('padding','0 10px');
                $(".panel_frais").show();
                
            },
            error : function(resultat, statut, erreur){
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });

        //fonction ajax pour récuperer le nombre d'élèves déjà inscrits pour le tuteur sélectionné
        <?php $url=$this->Url->build(['controller' => 'Inscriptions', 'action'=>'getNombre']); ?>
        var tuteur_id = <?=$inscription->elef->tuteur_id?>;
        console.log("<?= $url; ?>/"+tuteur_id);
        $.ajax({
            type:"GET",
            url:"<?= $url; ?>/"+tuteur_id,
            //async: false,
            success : function(data, statut) {
            //success: function(data) {
                console.log(data+" inscrits");
                var nombre = JSON.parse(data);
                reduction_msg = "<div class='row'><div class='col-xs-12 h5'>";
                if(nombre == 0 ) reduction_msg += "Ce tuteur a n'a pas d'élève inscrit.";
                if(nombre == 1 ) reduction_msg += "Ce tuteur a "+nombre+" élève inscrit.";
                else if(nombre > 1 ) reduction_msg += "Ce tuteur a "+nombre+" élèves inscrits.";
                reduction_msg += " Souhaitez-vous appliquer une réduction?</div>"+
                    "<div class='col-sm-4 col-xs-12 col-md-3'><label>Réduction</label> (en %)</div>"+
                    "<div class='col-sm-3 col-xs-4 col-md-2'><input id='reduction_montant' min='0' max='100' type='number' name='reduction[pourcentage]' class='form-control'></div>"+
                    "<div class='col-sm-5 col-xs-8 col-md-4'><select name='reduction[type_id]' id='reduction[type_id]' class='form-control'>";
                reduction_msg += "<option value='0'>Choisissez l'objet de la réduction</option>";
                reduction_msg += "<option value='tout'>Tout</option>";
                <?php foreach($types as $type):?>
                    reduction_msg += "<option value='<?=$type->id?>'><?=$type->nom?></option>"; 
                <?php endforeach?>
                reduction_msg += "</select></div>";
                reduction_msg += "<div class='col-xs-12' id='reduction_msg'></div>"; 
                "</div>";
                $("#reduction").html(reduction_msg);
            }
        });
    });
    $(".noconnexion").click(function(){
        $(this).hide();
    });
    
</script>
<?php $this->end(); ?>