<?php
$this->setLayout('default');
$this->assign('title','Mot de passe oublié');
?>
<div class="row">

    <div class="loader-container">
        <div class="loader"></div> 
    </div>
    <div class="noconnexion">
        Vérifiez votre connexion! 
    </div> 
    <br>

    <div class="col-md-6 col-sm-8 col-xs-12 img-login pull-right hidden-xs">
        <?php // $this->Html->image('billes_home_bg.jpg', ['alt' => 'Image etablissement','width'=>'100%']);?>
    </div>

    <div class="col-md-6 col-sm-4 col-xs-12">

        <div class="hidden-xs col-sm-12">
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="col-xs-12 text-center logo-connexion">
                <?php if(!empty($etablissement->logo)):?>
                    <img class="logo" style='margin-top:5px;' src="<?= $etablissement->logo?>" height="140px;" >
                <?php 
                else:
                    echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'30px','class'=>"logo",'style'=>"margin-top:5px;"]);
                endif;
                ?>
            </div>
            <div class="titre">Réinitialisation de mot de passe
            </div>
            <div id="rep"></div>
            <div id="form">
                <br>
                <input id="email" type="email" name="email" class="form-control" placeholder="votre email" required>
                <br>                
                <div class="form-group row">
                    <div class="col-md-6">
                        <button id="submit" class="btn btn-primary btn-block btn-lg">Valider</button>
                    </div>
                    <div class="col-md-6 ">
                        <a href='/pages/connexion' class="btn btn-default btn-block btn-lg">Annuler</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>
<script>
    $("#submit").click(function(){
        var email = $("#email").val();
        if(email == '') {
            alert("Merci de renseigner votre email!")
            return;
        }
        $('.loader-container').show();
        <?php $url=$this->Url->build(['controller' => 'Users', 'action'=>'resetPassword']); ?>
        $.ajax({
            type:"GET",
            url:"<?= $url; ?>/"+email,
            //async: false,
            success : function(data, statut) {
            //success: function(data) {
                console.log(data);
                var rep = JSON.parse(data);
                if(rep=='ok'){
                    $("#form").hide();
                    $('#rep').html('<div class="panel panel-success"><div class="panel-heading">Mot de passe réinitialisé avec succès!</div></div>');
                    $("#rep").append("<a href='/pages/connexion' class='btn btn-default btn-link btn-lg'>Retour</a>");
                }else{
                    $('#rep').html('<div class="panel panel-danger"><div class="panel-heading">E-mail non identifié. Merci de réessayer.</div></div>');
                }
            },
            error : function(resultat, statut, erreur){
            //error: function(){
                $('.noconnexion').show();
            },
            complete: function(resultat, statut){
                $('.loader-container').hide();
            }
        });
        $("body").click(function(){
            $('.noconnexion').hide();
        });
    });
</script>
<?php $this->end(); ?>