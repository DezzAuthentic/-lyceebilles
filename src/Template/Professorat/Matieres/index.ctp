<div class="titre">
    <span>Suivi Matières</span>
</div>

<div class="row">
    <div class="col-xs-12">
        vous avez ici la liste des matières pour lesquels vous avez été désigné "professeur principal".
    </div>
</div>

<div class="row">
    <?php if(sizeof($matieres)==0): ?>
        <div class="col-xs-12">
            <div class="vide-text">
                Aucune matière ne vous a été assignée.
            </div>
        </div>
    <?php else: ?>
        <div class="col-xs-12 mt3"></div>
        <?php foreach($matieres as $matiere): ?>
            <div class="col-xs-6 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading panel-stats">
                        <div class="panel-texte mb3"><?=$matiere->nom?></div>
                        <a id="ajout_btn" type="button" class="btn btn-default btn-sm mr1" href="<?=$this->Url->Build('/professorat/matieres/cours/'.$matiere->id)?>">
                            <span class="glyphicon glyphicon-user"></span> Cours
                        </a>
                        <a id="ajout_btn" type="button" class="btn btn-default btn-sm mr1" href="<?=$this->Url->Build('/professorat/matieres/seances/'.$matiere->id)?>">
                            <span class="glyphicon glyphicon-user"></span> Séances
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>