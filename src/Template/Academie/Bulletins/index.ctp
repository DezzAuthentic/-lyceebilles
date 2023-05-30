<div class="titre">
    <span>Bulletin: Liste des classes</span>

    <a href="<?=$this->Url->build(['controller'=>'Periodes','action'=>'index'])?>" class="btn btn-default pull-right btn-sm" >
        <span class="glyphicon glyphicon-calendar pr1"></span> Gestion des périodes
    </a>
</div>

<section class="row">
    <div class="col-xs-12">
        <div class="row">
        <?php 
        $niveau_id=null;
        $i=0; foreach($groupes as $groupe):
            if($i==0){
                $niveau_id = $groupe->promotion->niveau_id;
                echo '
                <div class="col-xs-12 panel-heading"><span class="soustitre">'.$groupe->promotion->niveaux->nom.': '.$effectifs[$groupe->promotion->niveau_id].' élève(s) inscrit(s)</span></div>
                                
                ';    
            }

            else{
                if($niveau_id!=$groupe->promotion->niveau_id){
                    echo '      
                    <div class="col-xs-12 panel-heading"><span class="soustitre">'.$groupe->promotion->niveaux->nom.': '.$effectifs[$groupe->promotion->niveau_id].' élève(s) inscrit(s)</span></div>
                    ';
                }
            }
            $url = $this->Url->Build("/academie/bulletins/classe/".$groupe->id);
            echo '
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a class="btn btn-block btn-default btn-sm bg-gris" href="'.$url.'">
                    <span class="h5">
                        '.$groupe->nom.': '.sizeof($groupe->affectations).' élèves(s)
                    </span>
                </a>
            </div>
            ';
            $niveau_id = $groupe->promotion->niveau_id;
        $i++; endforeach;
        ?>
         
            </div>
        </div>
    </div>
</section>

<!-- Modal Ajout groupe-->
<div class="modal fade" id="AjoutGroupeModal" tabindex="-1" role="dialog" aria-labelledby="ajoutGroupeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Groupes', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutGroupeModalLabel">Ajouter une nouvelle classe</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="promotion_id" class="col-sm-5">Promotion</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('promotion_id',$promotions,['class'=>'form-control',"id"=>"promotion_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="nom" class="col-sm-5">Nom</label>
                <div class="col-sm-4">
                    <input required type="text" name="nom" class="form-control" id="nom" readonly>
                </div>
                <div class="col-sm-3 row">
                    <input required type="text" name="nom_cmpl" class="form-control" id="nom_cmpl"  placeholder="complément">
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal édition Groupe-->
<div class="modal fade" id="editGroupeModal" tabindex="-1" role="dialog" aria-labelledby="editGroupeModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Groupes', 'action' => 'editer']) ?>" method="post">
        <input id="edit_groupe_id" type="hidden" name="id" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editGroupeModalLabel">Modification du groupe</h4>
        </div>
        <div class="modal-body">
            <div class="form-group row ">
                <label for="promotion_id" class="col-sm-5">Promotion</label>
                <div class="col-sm-7">
                    <?=$this->Form->select('promotion_id',$promotions,['class'=>'form-control',"id"=>"edit_promotion_select"])?>
                </div>
            </div>
            <div class="form-group row ">
                <label for="nom" class="col-sm-5">Nom</label>
                <div class="col-sm-4">
                    <input required type="text" name="nom" class="form-control" id="edit_nom" readonly>
                </div>
                <div class="col-sm-3 row">
                    <input required type="text" class="form-control" id="edit_nom_cmpl"  placeholder="complément">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>


