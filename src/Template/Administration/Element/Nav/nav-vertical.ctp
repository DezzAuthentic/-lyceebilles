<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->employes)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->employes[0]->prenom?> <?=$user->employes[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<?php if($user->profil=='admin'):?>
    <nav class="navbar" style="margin-bottom:5px;">
        <button class="btn btn-default dropdown-toggle btn-block" type="button" data-toggle="dropdown">Connecté en tant que: <b>Administrateur</b>
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
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/dashboard/')?>"><i class="glyphicon glyphicon-stop"></i> Tableau de bord</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/etablissements/parametrage')?>"><i class="glyphicon glyphicon-stop"></i> Paramètrage établissement</a></li>
        <!--li role="presentation" class="" ><a href="<?= $this->Url->Build('/administration/annees/configuration')?>"><i class="glyphicon glyphicon-stop"></i> Configuration des années scolaires</a></li-->
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/etablissements/gestion-utilisateurs')?>"><i class="glyphicon glyphicon-stop"></i> Gestion des utilisateurs</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/etablissements/parametrageGeneral')?>"><i class="glyphicon glyphicon-stop"></i> Paramètrage général</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/periodes/configuration')?>"><i class="glyphicon glyphicon-stop"></i> Paramétrage des périodes</a></li>
        <!--li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/coefficients/configuration')?>"><i class="glyphicon glyphicon-stop"></i> Paramétrage des coefficients</a></li-->
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/promotions/parametrage')?>"><i class="glyphicon glyphicon-stop"></i> Parametrage des promotions</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/groupes/parametrage')?>"><i class="glyphicon glyphicon-stop"></i> Parametrage des classes</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/menus/')?>"><i class="glyphicon glyphicon-stop"></i> Cantine</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/administration/fiches-medicales/parametrage')?>"><i class="glyphicon glyphicon-stop"></i> Paramétrage des fiches médicales</a></li>
        <!--li role="separator" class="divider" ></li>
        <hr-->
    </ul>
</nav>
