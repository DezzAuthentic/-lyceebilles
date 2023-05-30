<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->employes)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->employes[0]->prenom?> <?=$user->employes[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<?php if($user->profil=='admin'):?>
    <nav class="navbar" style="margin-bottom:5px;">
        <button class="btn btn-default dropdown-toggle btn-block" type="button" data-toggle="dropdown">Connecté en tant que: <b>Boutiquier</b>
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
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/dashboard/')?>"><i class="glyphicon glyphicon-stop icone"></i>Tableau de bord</a></li>
        <li role="presentation" class="rubrique">Boutique</li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/ventes/')?>"><i class="glyphicon glyphicon-stop icone"></i>Enregistrer</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/ventes/liste')?>"><i class="glyphicon glyphicon-stop icone"></i>Ventes en attente</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/ventes/non-soldees')?>"><i class="glyphicon glyphicon-stop icone"></i>Ventes non soldées</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/ventes/effectives')?>"><i class="glyphicon glyphicon-stop icone"></i>Ventes clôturées</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/produits/')?>"><i class="glyphicon glyphicon-stop icone"></i>Produits</a></li>
        <li role="presentation" class="rubrique">Vie scolaire</li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/boutique/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
    </ul>
</nav>

