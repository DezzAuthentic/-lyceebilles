<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->tuteurs)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->tuteurs[0]->prenom?> <?=$user->tuteurs[0]->nom?></span>
        <?php elseif(sizeof($user->tuteur_secondaires)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->tuteur_secondaires[0]->prenom?> <?=$user->tuteur_secondaires[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<nav class="navbar navbar-default">
    <ul class="nav nav-pills nav-stacked ">
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/dashboard/')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/eleves/')?>"><i class="glyphicon glyphicon-stop icone"></i>Mes élèves</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/groupes/')?>"><i class="glyphicon glyphicon-stop icone"></i>Classes</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/cours')?>"><i class="glyphicon glyphicon-stop icone"></i>Cours</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/devoirs')?>"><i class="glyphicon glyphicon-stop icone"></i>Devoirs</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/presences/')?>"><i class="glyphicon glyphicon-stop icone"></i>Discipline</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/factures/')?>"><i class="glyphicon glyphicon-stop icone"></i>Factures</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/bulletins/classe')?>"><i class="glyphicon glyphicon-stop icone"></i>Bulletins de notes</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/suivi/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
                    <!--li role="separator" class="divider"></li-->
    </ul>
</nav>

