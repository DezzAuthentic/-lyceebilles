
<nav class="navbar navbar-default">
    <div class="col-xs-12 nav-username">
        <?php if(sizeof($user->professeurs)>0):?>
            <i class="glyphicon glyphicon-user icone"></i>Pr. <span><?=$user->professeurs[0]->prenom?> <?=$user->professeurs[0]->nom?></span>
        <?php endif;?>
    </div>
</nav>
<nav class="navbar navbar-default">
    <ul class="nav nav-pills nav-stacked ">
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/edt/')?>"><i class="glyphicon glyphicon-stop icone"></i>Mon emploi du temps</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/cours/')?>"><i class="glyphicon glyphicon-stop icone"></i>Mes cours</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/seances/')?>"><i class="glyphicon glyphicon-stop icone"></i>Mes séances</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/devoirs/')?>"><i class="glyphicon glyphicon-stop icone"></i>Mes devoirs</a></li>
        <?php if(sizeof($user->professeurs[0]->matieres)>0):?>
            <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/matieres/')?>"><i class="glyphicon glyphicon-stop icone"></i>Suivi matières</a></li>
        <?php endif;?>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/bulletins/')?>"><i class="glyphicon glyphicon-stop icone"></i>Bulletins de notes</a></li>
        <li role="presentation" class="" ><a href="<?=$this->Url->Build('/professorat/menus/')?>"><i class="glyphicon glyphicon-stop icone"></i>Cantine</a></li>
                    <!--li role="separator" class="divider"></li-->
    </ul>
</nav>

