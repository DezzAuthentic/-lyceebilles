<div class="titre">
    <span>Liste des classes</span>
</div>

<div class="row">
    <div class="col-xs-12">
        <table id="groupes_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title=""></th>
                    <th title="Matricule">Classe</th>
                    <th title="Nom">Elève(s)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=1; foreach($groupes as $groupe): if(sizeof($groupe->affectations)==0) continue;?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$groupe->nom?></td>
                    <td>
                        <?php foreach($groupe->affectations as $affectation){
                            echo '<a class="btn btn-sm btn-default">'.$affectation->inscription->elef->prenom.' '.$groupe->affectations[0]->inscription->elef->nom.'</a>';
                        }
                        ?>
                    </td>
                    <td class="actions">
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> fiche cl.','/suivi/groupes/fiche/'.$groupe->id,['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> Empl. du T.','/suivi/edt/classe/'.$groupe->id,['escape'=>false,'class' => 'btn btn-xs btn-primary'])?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
        </table>
    </div>
</div>
