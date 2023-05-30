<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->employes)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->employes[0]->prenom?> <?=$user->employes[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<?php if($user->profil=='admin'):?>
    <nav class="navbar" style="margin-bottom:5px;">
        <button class="btn btn-default dropdown-toggle btn-block" type="button" data-toggle="dropdown">Connecté en tant que: <b>Secrétaire</b>
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/dashboard/')?>">Admin</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/dashboard/')?>">Comptable</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/dashboard/')?>">Surveillant G.</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/dashboard/')?>">Secretaire</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/dashboard/')?>">Boutiquier</a></li>
        </ul>
    </nav>
<?php endif;?>

<nav class="navbar navbar-default">
    <ul class="nav nav-pills nav-stacked ">
        <?php if($user->profil=='secretaire' or $user->profil=='admin'):?>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/dashboard/')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
            <li role="presentation" class="rubrique">élèves</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/eleves/liste-globale')?>"><i class="glyphicon glyphicon-stop icone"></i>Liste globale</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/eleves/liste-annee-en-cours')?>"><i class="glyphicon glyphicon-stop icone"></i>Liste année en cours</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/eleves/classes')?>"><i class="glyphicon glyphicon-stop icone"></i>Par classe</a></li>
            <li role="presentation" class="rubrique">tuteurs</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/tuteurs/liste')?>"><i class="glyphicon glyphicon-stop icone"></i>Liste</a></li>
            <li role="presentation" class="rubrique">Inscriptions</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/inscriptions/nouvelle')?>"><i class="glyphicon glyphicon-stop icone"></i>Nouvelle</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/inscriptions/liste')?>"><i class="glyphicon glyphicon-stop icone"></i>Liste</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/tests')?>"><i class="glyphicon glyphicon-stop icone"></i>Tests de niveau</a></li>
            <li role="presentation" class="rubrique">Vie scolaire</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/fiches-medicales/')?>"><i class="glyphicon glyphicon-stop icone"></i>Fiches medicales</a></li>
        <?php else:?>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/dashboard/')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
            <li role="presentation" class="rubrique">élèves</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/eleves/liste-globale')?>"><i class="glyphicon glyphicon-stop icone"></i>Liste globale</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/eleves/classes')?>"><i class="glyphicon glyphicon-stop icone"></i>Par classe</a></li>
            <li role="presentation" class="rubrique">Vie scolaire</li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/fiches-medicales/')?>"><i class="glyphicon glyphicon-stop icone"></i>Fiches medicales</a></li>
        <?php endif;?>
    </ul>
</nav>

