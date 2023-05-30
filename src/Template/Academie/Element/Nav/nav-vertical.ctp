<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->employes)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->employes[0]->prenom?> <?=$user->employes[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<?php if($user->profil=='admin'):?>
    <nav class="navbar" style="margin-bottom:5px;">
        <button class="btn btn-default dropdown-toggle btn-block" type="button" data-toggle="dropdown">Connecté en tant que: <b>Surveillant G.</b>
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/dashboard/')?>">Admin</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/dashboard/')?>">Comptable</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/dashboard/')?>">Surveillant G.</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/secretariat/dashboard/')?>">Secrétaire</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/dashboard/')?>">Boutiquier</a></li>
        </ul>
    </nav>
<?php endif;?>

<nav class="navbar navbar-default">
    <ul class="nav nav-pills nav-stacked ">
        <?php if($user->profil=='surveillant' or $user->profil=='admin'):?>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/dashboard')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
            <!--li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/promotions')?>"><i class="glyphicon glyphicon-stop icone"></i>Gestion des promotions</a></li-->
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/groupes')?>"><i class="glyphicon glyphicon-stop icone"></i>Gestion des classes</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/professeurs')?>"><i class="glyphicon glyphicon-stop icone"></i>Gestion des professeurs</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/seances/')?>"><i class="glyphicon glyphicon-stop icone"></i>Suivi des séances</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/devoirs/')?>"><i class="glyphicon glyphicon-stop icone"></i>Suivi des devoirs</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/factures')?>"><i class="glyphicon glyphicon-stop icone"></i>Facturation</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/remediations/')?>"><i class="glyphicon glyphicon-stop icone"></i>Remédiations</a></li>
            <!--li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/promotions/transfert')?>"><i class="glyphicon glyphicon-stop icone"></i>Transfert d'élève</a></li-->
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/bulletins/')?>"><i class="glyphicon glyphicon-stop icone"></i>Bulletins de notes</a></li>
            <!--li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/periodes/')?>"><i class="glyphicon glyphicon-stop icone"></i>Gestion des périodes</a></li-->
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/archives/')?>"><i class="glyphicon glyphicon-stop icone"></i>Archives</a></li>
        <?php else:?>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/dashboard')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/seances/')?>"><i class="glyphicon glyphicon-stop icone"></i>Suivi des séances</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/devoirs/')?>"><i class="glyphicon glyphicon-stop icone"></i>Suivi des devoirs</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/tests')?>"><i class="glyphicon glyphicon-stop icone"></i>Tests de niveau</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/remediations/')?>"><i class="glyphicon glyphicon-stop icone"></i>Remédiations</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/bulletins/')?>"><i class="glyphicon glyphicon-stop icone"></i>Bulletins de notes</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/academie/archives/')?>"><i class="glyphicon glyphicon-stop icone"></i>Archives</a></li>
        <?php endif;?>
    </ul>
</nav>

