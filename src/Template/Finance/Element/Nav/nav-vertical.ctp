<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->employes)>0):?>
            <i class="glyphicon glyphicon-user"></i> <span><?=$user->employes[0]->prenom?> <?=$user->employes[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>

<?php if($user->profil=='admin'):?>
    <nav class="navbar" style="margin-bottom:5px;">
        <button class="btn btn-default dropdown-toggle btn-block" type="button" data-toggle="dropdown">Connecté en tant que: <b>Comptable</b>
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
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/dashboard')?>"><i class="glyphicon glyphicon-stop"></i> Tableau de bord</a></li>
        <?php foreach($_types_fac as $type): ?>
            <li role="presentation" class="subli" ><a href="<?=$this->Url->Build('/finance/dashboard/type/'.$type->id)?>"><i class="glyphicon glyphicon-minus icone"></i><?=$type->nom?></a></li>
        <?php endforeach; ?>
        
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/etablissements/parametrageFinancier')?>"><i class="glyphicon glyphicon-stop icone"></i>Paramétrage financier</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/inscriptions/liste')?>"><i class="glyphicon glyphicon-stop icone"></i>Inscriptions</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/factures/')?>"><i class="glyphicon glyphicon-stop icone"></i>Facturation</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/finance/archives/')?>"><i class="glyphicon glyphicon-stop icone"></i>Archives</a></li>
    </ul>
</nav>
