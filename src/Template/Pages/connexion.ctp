<?php
$this->setLayout('default');
$this->assign('title','Connexion');
?>
<div class="row">

    <div class="col-md-6 col-sm-4 col-xs-12 img-login  hidden-xs">
        <?php // $this->Html->image('billes_home_bg.jpg', ['alt' => 'Image etablissement','width'=>'100%']);?>
    </div>

    <div class="col-md-6 col-sm-8 col-xs-12 pull-left">

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
            <div class="titre">Connectez-vous à votre compte
            </div>

            <form action="<?= $this->Url->Build(['controller' => 'Users', 'action' => 'connecter']) ?>" method="post">
                <br>
                <input type="email" name="email" class="form-control" placeholder="votre email" required>
                <br>
                <input type="password" name="password" class="form-control" placeholder="votre mot de passe" required>
                <br>
                
                <div class="form-group row">
                    <div class="col-md-4 ">
                    <a href='<?=$this->Url->Build("/pages/mot-de-passe-oublie")?>' class="btn btn-link btn-block btn-lg">Mot de passe oublié</a>
                    </div>
                    <div class="col-md-6 col-md-offset-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Se connecter</button>
                    </div>
                </div>
                
            </form>

        </div>

    </div>

</div>