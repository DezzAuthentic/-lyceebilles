<div class="titre">
    <span>Liste des classes</span>
    <a class="btn btn-sm btn-default pull-right" href="/academie/seances/classe/">Toutes les seances</a>
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
            echo '
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a class="btn btn-block btn-default btn-sm" href="/academie/seances/classe/'.$groupe->id.'">
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


