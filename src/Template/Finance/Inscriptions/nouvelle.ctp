
<div class="titre">
    <span>Nouvelle inscription</span>
    <a id="ajout_btn" href="/finance/inscriptions/liste" class="btn btn-default btn-sm pull-right" >
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

    <form action="<?= $this->Url->Build(['controller' => 'Inscriptions', 'action' => 'add']) ?>" method="post">

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default" id="inscription_infos" >
                <div class="text-center panel-heading" >
                    <br><br><br>
                    <span class="">Sélectionnez un tuteur ou ajoutez un, pour démarrer l'inscription</span>
                    <br><br><br><br>
                </div>
            </div>
            <div class="form-group row">
                <label for="select_tuteur" class="col-sm-2 col-form-label col-xs-12">Tuteur</label>
                <div class="col-sm-8 col-xs-10">
                    <?=$this->Form->select(null, $tuteurs, ['empty' => true,'class'=>'form-control select2','id'=>'select_tuteur']);?>
                </div>
                <div class="col-sm-2 col-xs-2">
                    <button type="button" id="ajouter_tuteur" class="btn btn-default btn-sm" data-toggle="modal" data-target="#tuteurModal">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
            <div class="form-group row" id="groupe_eleve">
                <label for="select_eleve" class="col-sm-2 col-form-label col-xs-12">Elève</label>
                <div class="col-sm-8 col-xs-10">
                    <select id='select_eleve' name='eleve_id' class='form-control' required></select>
                </div>
                <div class="col-sm-2 col-xs-2">
                    <button type="button" id="ajouter_eleve" class="btn btn-default btn-sm" data-toggle="modal" data-target="#eleveModal">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
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
                        <tbody class="body_frais">
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
                    <div class="col-xs-12"><button type="submit" class="btn btn-md btn-primary">Valider l'inscription</button></div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <input type="hidden" id="total_temp">
    <input type="hidden" id="facultatives_temp">

</div>
<!-- Modal ajout tuteur-->
<div class="modal fade" id="tuteurModal" tabindex="-1" role="dialog" aria-labelledby="tuteurModalLabel">
    <div class="modal-dialog" role="document">
        <form id="tuteurForm">
            <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="tuteurModalLabel">Enregistrement d'un nouveau tuteur</h4>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                    <label for="tuteurNom" class="col-sm-4 col-form-label">Nom</label>
                    <div class="col-sm-8">
                        <input type="text" name="nom" id="tuteurNom" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tuteurPrenom" class="col-sm-4 col-form-label">Prénom</label>
                    <div class="col-sm-8">
                        <input type="text" name="prenom" id="tuteurPrenom" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tuteurTelephone" class="col-sm-4 col-form-label">Téléphone</label> 
                    <div class="col-sm-8">
                        <input type="tel" name="telephone" id="tuteurTelephone" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tuteurAdresse" class="col-sm-4 col-form-label">Domicile</label>
                    <div class="col-sm-8">
                        <input type="text" name="adresse" id="tuteurAdresse" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tuteurFonction" class="col-sm-4 col-form-label">Fonction</label>
                    <div class="col-sm-8">
                        <input type="text" name="fonction" id="tuteurFonction" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" id="ajouterTuteur" class="btn btn-primary">Valider</button>
                <button type="submit" class="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal ajout eleve-->
<div class="modal fade" id="eleveModal" tabindex="-1" role="dialog" aria-labelledby="eleveModalLabel">
    <div class="modal-dialog" role="document">
        <form id="eleveForm">
            <input type="hidden" name="etablissement_id" value="<?=$etablissement->id?>" >
            <input type="hidden" name="tuteur_id" id="eleveTuteurId" >
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="eleveModalLabel">Enregistrement d'un nouvel élève</h4>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                    <label for="eleveNom" class="col-sm-4 col-form-label">Nom</label>
                    <div class="col-sm-8">
                        <input type="text" name="nom" id="eleveNom" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="elevePrenom" class="col-sm-4 col-form-label">Prénom</label>
                    <div class="col-sm-8">
                        <input type="text" name="prenom" id="elevePrenom" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="eleveDateNaissance" class="col-sm-4 col-form-label">Date de naissance</label> 
                    <div class="col-sm-8">
                        <input type="date" name="date_naissance" id="eleveDateNaissance" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="eleveLieuNaissance" class="col-sm-4 col-form-label">Lieu de naissance</label>
                    <div class="col-sm-8">
                        <input type="text" name="lieu_naissance" id="eleveLieuNaissance" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="genre" class="col-sm-4 col-form-label">Sexe: </label>
                    <div class="col-sm-8">
                    <label class="radio-inline">
                        <input type="radio" name="genre" value="f" checked>Fille
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="genre" value="g">Garçon
                    </label>
                    </div>
                </div>
                <div class="form-group row">
                    <lablel for="nationalite" class="col-sm-4 col-form-label">Nationalité</lablel>
                    <div class="col-sm-8">
                    <select class="form-control" id="genre">
                        <option name="nationalite" value="1">Américaine</option>
                        <option name="nationalite" value="2">Béninoise</option>
                        <option name="nationalite" value="3">Bissao-Guinéenne</option>
                        <option name="nationalite" value="4">Bourkinabaise</option>
                        <option name="nationalite" value="5">Camerounaise</option>
                        <option name="nationalite" value="6">Canadienne</option>
                        <option name="nationalite" value="7">Capverdienne</option>
                        <option name="nationalite" value="8">Comorienne</option>
                        <option name="nationalite" value="9">Espagnol</option>
                        <option name="nationalite" value="10">Française</option>
                        <option name="nationalite" value="11">Gabonnaise</option>
                        <option name="nationalite" value="12">Guinéenne</option>
                        <option name="nationalite" value="13">Italienne</option>
                        <option name="nationalite" value="14">Ivoirienne</option>
                        <option name="nationalite" value="15">Malienne</option>
                        <option name="nationalite" value="16">Mauritanienne</option>
                        <option name="nationalite" value="17" selected>Sénégalaise</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" id="ajouterEleve" class="btn btn-primary">Valider</button>
                <button type="submit" class="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </form>
    </div>
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
        $('#select_tuteur').val(''); 
        $('.submit').hide();
        $('.panel_frais').hide();
        $('#groupe_eleve').hide();
        $('#groupe_promotion').hide();
        inscription_type_id=null;
        scolarite_type_id=null;
        inscription_montant=0;
        scolarite_montant=0;
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
    $("#select_tuteur").change(function(){
        var tuteur_id = $(this).val();
        if(tuteur_id == '') {
            $("#inscription_infos").show();
            $("#groupe_eleve").hide();
            $("#groupe_promotion").hide();
            return;
        }
        $("#inscription_infos").hide();
        $('.loader-container').show();
        <?php $url=$this->Url->build(['controller' => 'Eleves', 'action'=>'getEleve']); ?>
        $.ajax({
            type:"GET",
            url:"<?= $url; ?>/"+tuteur_id,
            //async: false,
            success : function(data, statut) {
            //success: function(data) {
                console.log(data);
                var eleves = JSON.parse(data);
                $("#select_eleve").html('');
                $.each( eleves, function( key, eleve ) {
                    $("#select_eleve").append("<option value="+eleve.id+">"+eleve.prenom+" "+eleve.nom+"</option>");
                });
                $("#groupe_eleve").show();
                $("#groupe_promotion").show();

                //remplissage de l'input eleveTuteurId
                $("#eleveTuteurId").val(tuteur_id);
            },
            error : function(resultat, statut, erreur){
            //error: function(){
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });
    });
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
                    else ligne='';
                    $("#table_"+frai.type.id+" tbody").append(ligne);
                    i++;
                    type_id = frai.type.id;
                });
                $('td').css('padding','0 10px');
                $(".panel_frais").show();
                /*mois1 = "<tr><td><?=$debut->nom?></td><td width='50%' class='td-right'>"+scolarite+" FCFA</td><tr>";
                mois2 = "<tr><td><?=$fin->nom?></td><td width='50%' class='td-right'>"+scolarite+" FCFA</td><tr>";
                $("#table_scolarite tbody").append(mois1).append(mois2);
                
                inscription_montant = somme;
                scolarite_montant = scolarite;
                total = somme+(2*scolarite);
                console.log(total);
                $("#total_inscription").html("Total (inscription + 2 mois de scolarité): <span id='total'>"+total+"</span> FCFA");

                //creation d'une variable temporaire pour garder le montant total hors option                
                $('#total_temp').val(total);*/
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
        var tuteur_id = $("#select_tuteur").val();
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
                reduction_msg += " Souhaitez-vous appliquer une réduction ?</div>"+
                    "<div class='col-sm-4 col-xs-12 col-md-3'><label>Réduction</label> (en %)</div>"+
                    "<div class='col-sm-3 col-xs-4 col-md-2'><input id='reduction_montant' min='0' max='100' step='0.001' type='number' name='reduction[pourcentage]' class='form-control'></div>"+
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
    
    /*function maj_total(){
        $("#reduction_msg").html('');
        total = Number($("#total_temp").val());
        montant_fac = Number($("#facultatives_temp").val());
        montant_base_t = 0; //base reduction inscription+scolarité
        montant_base_f = 0; //base facultatives
        montant_reduction_t = 0;
        montant_reduction_f = 0;
        //reduction
        id=$("#reduction_type_id").val();
        if(id==inscription_type_id) montant_base_t = inscription_montant;
        else if(id==scolarite_type_id) montant_base_t = scolarite_montant*2;
        else {
            choix = $("#facultative_"+id+' option:selected').text().split(' - ');
            if(choix[1]) montant_base_f = Number(choix[1]);
            else montant_base_f = 0;
        }
        
        reduction = Number($("#reduction_montant").val());
        if(reduction > 0) {
            montant_reduction_t = montant_base_t*reduction/100;
            montant_reduction_f = montant_base_f*reduction/100;
        }
        
        if(montant_base_t > 0) {
            total = total-montant_reduction_t;
            $("#reduction_msg").html("Vous allez appliquer une réduction de "+montant_reduction_t+" FCFA");
        } else if(montant_base_f > 0){
            montant_fac = montant_fac-montant_reduction_f;
            $("#reduction_msg").html("Vous allez appliquer une réduction de "+montant_reduction_f+" FCFA");
        }

        $("#total").html(total);        
        $("#t_facultatives").html(montant_fac);        
    }
    $('#table_facultatives').on('change',".select_facultative", function(){
        montant = 0;
        $('.select_facultative').each(function(){
            sel = $(this).attr('id');
            choix = $('#'+sel+' option:selected').text().split(' - ');
            if(choix[1]) montant += Number(choix[1]);
        });

        $('#facultatives_temp').val(montant);
        $("#total_facultatives").html("Total (facultatives): <span id='t_facultatives'>"+montant+"</span> FCFA");
        
        maj_total();        
    });
    $('#reduction').on('input',"#reduction_montant", function(){
        maj_total();
    });
    $('#reduction').on('change',"#reduction_type_id", function(){
        maj_total();
    });*/
    $("#ajouterTuteur").click(function(){
        var myForm = $('#tuteurForm');
        console.log(myForm.serialize());
        if(! myForm[0].checkValidity()) {
        myForm.find(':submit').click();
        }
        $('#tuteurModal').modal('toggle');
        $('.loader-container').show();
        //fonction ajax pour ajouter un nouveau tuteur
        <?php $url=$this->Url->build(['controller' => 'Tuteurs', 'action'=>'add']); ?>
        $.ajax({
            type:"POST",
            data: myForm.serialize(),
            url:"<?= $url; ?>/",
            dataType : 'html',
            //async: false,
            success : function(data, statut) {
                console.log(data);
                tuteur = JSON.parse(data);
                if(tuteur.id) $("#select_tuteur").append("<option value='"+tuteur.id+"'>"+tuteur.id+" - "+tuteur.prenom+" "+tuteur.nom+"</option>");
            },
            error : function(resultat, statut, erreur){
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });
    });

    $("#ajouterEleve").click(function(){
        var eleveForm = $('#eleveForm');
        if(! eleveForm[0].checkValidity()) {
            eleveForm.find(':submit').click();
        }
        $('#eleveModal').modal('toggle');
        $('.loader-container').show();
        //fonction ajax pour ajouter un nouvel eleve
        <?php $url=$this->Url->build(['controller' => 'Eleves', 'action'=>'add']); ?>
        $.ajax({
            type:"POST",
            data: eleveForm.serialize(),
            url:"<?= $url; ?>/",
            dataType : 'html',
            //async: false,
            success : function(data, statut) {
                console.log(data);
                eleve = JSON.parse(data);
                if(eleve.id) $("#select_eleve").append("<option value='"+eleve.id+"'>"+eleve.prenom+" "+eleve.nom+"</option>");
            },
            error : function(resultat, statut, erreur){
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });
    });
</script>
<?php $this->end(); ?>