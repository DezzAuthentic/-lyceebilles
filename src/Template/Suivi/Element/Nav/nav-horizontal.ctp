<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header col-md-3 col-sm-4">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="icone pull-left" href="/suivi/dashboard/" >
                <?php if(!empty($etablissement->logo)):?>
                    <img class="logo" style='margin-top:5px;' src="<?= $etablissement->logo?>" height="40px;" >
                <?php 
                else:
                    echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'30px','class'=>"logo",'style'=>"margin-top:5px;"]);
                endif;
                ?>
            </a>
            <a class="navbar-brand" href="<?=$this->Url->Build(["controller"=>'Dashboard','action'=>'index'])?>">BILLES <small>Lycée d'Excellence</small></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Documentation <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">A propos</a></li>
                    <li><a href="#">Guide administrateur</a></li>
                    <li><a href="#">Guide professeur</a></li>
                    <!--li role="separator" class="divider"></li-->
                </ul>
                </li>
            </ul>
            
            <a class="btn btn-default navbar-btn navbar-right margin-g-5" href="<?=$this->request->referer()?>"><i class="glyphicon glyphicon-chevron-left icone"></i>Retour</a>
            <a class="btn btn-default navbar-btn navbar-right margin-g-5" href="/users/deconnexion">Déconnexion</a>
            <ul class="nav navbar-nav navbar-right">
                <!--li><a class="" href="#"><?=$etablissement->nom." (".$etablissement->annee->nom.")"?></a></li-->
                <li><a class="" href="#">Année scolaire <?=$etablissement->annee->nom?></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>