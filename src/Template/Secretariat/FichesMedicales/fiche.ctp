<?php
    $urgence_nom = null;
    $urgence_tel = null;
    $medecin_nom = null;
    $medecin_tel = null;
    $structure_sante = null;
    foreach($types as $type){
        foreach($type->renseignements as $renseignement){
            if($renseignement->libelle=="Nom contact d'urgence") $urgence_nom = $renseignement; 
            if($renseignement->libelle=="Téléphone du contact en cas d'urgence") $urgence_tel = $renseignement; 
            if($renseignement->libelle=="Médecin traitant") $medecin_nom = $renseignement; 
            if($renseignement->libelle=="Téléphone du médecin traitant") $medecin_tel = $renseignement; 
            if($renseignement->libelle=="Hôpital ou clinique de transfert") $structure_sante = $renseignement; 
        }
    }
    //dd($_types);
?>
<div class="titre">
    <span>Fiche médicale - Enregistrement</span>
    <a id="ajout_btn" href="<?=$this->Url->build(['action'=>'modifier',$eleve->id])?>" class="btn btn-default btn-sm pull-right" >
        <span class="glyphicon glyphicon-pencil icone-l"></span> Modifier la fiche
    </a>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-6">
        <span>Nom : </span> <?=$eleve->nom?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <span>Prénom : </span> <?=$eleve->prenom?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <span>Date de naissance : </span> <?=$eleve->date_naissance?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <span>Classe : </span> 
        <?php
            if($eleve->inscriptions) {
                if($eleve->inscriptions[0]->affectations) echo $eleve->inscriptions[0]->affectations[0]->groupe->nom;
            }else{
                echo "---";
            }
        ?>
    </div>
    <div class="col-xs-12"><hr class="mt1 mb1"></div>
    <div class="col-xs-12 col-lg-6">
        <span>Tuteur principal : </span> <?=$eleve->tuteur->prenom?> <?=$eleve->tuteur->nom?> / <?=$eleve->tuteur->telephone?>
    </div>
    <div class="col-xs-12"><hr class="mt1 mb1"></div>
    <div class="col-xs-12">
        <div class="titre2">Fiche médicale</div>
    </div>

    <div class="col-xs-12">
        <div class="soustitre3 border-b">En cas d'urgence</div>
    </div>
    <div class="col-xs-12">
        <table id="table_urgence" class='datatable compact table-striped'>
            <thead>
                <th></th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="text-primary">Personne à contacter</span>: <?=$urgence_nom->renseignement_valeurs[0]->commentaire?></td>
                    <td><span>Téléphone: <?=$urgence_tel->renseignement_valeurs[0]->commentaire?></span></td>
                </tr>
                <tr>
                    <td><span class="text-primary">Médecin traitant</span>: <?=$medecin_nom->renseignement_valeurs[0]->commentaire?></td>
                    <td><span>Téléphone: <?=$medecin_tel->renseignement_valeurs[0]->commentaire?></span></td>
                </tr>
                <tr>
                    <td>
                        Autorisation de transporter l'élève dans une structure hospitalière: 
                        <?php if($structure_sante->renseignement_valeurs[0]->valeur===0) $val = 'Non';
                            elseif($structure_sante->renseignement_valeurs[0]->valeur==1) $val = 'Oui';
                            else $val = "Autre";
                        ?>
                        <span><?=$val?></span>
                    </td>
                    <td><span><?=$val?></span></td>
                </tr>
            </tbody>      
        </table>
        
    </div>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Maladies</div>
    </div>
    <div class="col-xs-12">
        <table id="table_maladies" class='datatable compact table-striped'>
            <thead>
                <th></th>
                <th></th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <?php foreach($types as $type): if($type->libelle == "maladie"): foreach($type->renseignements as $renseignement):?>
                <?php if($renseignement->renseignement_valeurs[0]->valeur===0) $val = '<span class="text-success">Non</span>';
                    elseif($renseignement->renseignement_valeurs[0]->valeur==1) $val = '<span class="text-danger">Oui</span>';
                    else $val = "Non défini";
                ?>
                    <tr>
                        <td><span class="control-span text-primary"><?=$renseignement->libelle?></span>:</td>
                        <td> <?=$val?></td>
                        <td><?=$renseignement->renseignement_valeurs[0]->commentaire?></td>
                    </tr>
                <?php endforeach; endif; endforeach;?>
            </tbody>      
        </table>
    </div>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Troubles des sens</div>
    </div>
    <div class="col-xs-12">
        <table id="table_sens" class='compact table-striped datatable'>
            <thead>
                <th></th>
                <th></th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <?php foreach($types as $type): if($type->libelle == "sens"): foreach($type->renseignements as $renseignement):?>
                <?php if($renseignement->renseignement_valeurs[0]->valeur===0) $val = '<span class="text-success">Non</span>';
                    elseif($renseignement->renseignement_valeurs[0]->valeur==1) $val = '<span class="text-danger">Oui</span>';
                    else $val = "Non défini";
                ?>
                    <tr>
                        <td><span class="control-span text-primary"><?=$renseignement->libelle?></span>:</td>
                        <td> <?=$val?></td>
                        <td> <?=$renseignement->renseignement_valeurs[0]->commentaire?></td>
                    </tr>
                <?php endforeach; endif; endforeach;?>
            </tbody>      
        </table>
    </div>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Vaccins</div>
    </div>
    <div class="col-xs-12">
        <table id="table_vaccins" class='compact table-striped datatable'>
            <thead>
                <th></th>
                <th></th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <?php foreach($types as $type): if($type->libelle == "vaccin"): foreach($type->renseignements as $renseignement):?>
                <?php if($renseignement->renseignement_valeurs[0]->valeur===0) $val = '<span class="text-success">Non</span>';
                    elseif($renseignement->renseignement_valeurs[0]->valeur==1) $val = '<span class="text-danger">Oui</span>';
                    else $val = "Non défini";
                ?>
                    <tr>
                        <td><span class="control-span text-primary"><?=$renseignement->libelle?></span>:</td>
                        <td> <?=$val?></td>
                        <td><?=$renseignement->renseignement_valeurs[0]->commentaire?></td>
                    </tr>
                <?php endforeach; endif; endforeach;?>
            </tbody>      
        </table>
    </div>
    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Autres informations</div>
    </div>
    <div class="col-xs-12">
        <table id="table_general" class='compact table-striped datatable'>
            <thead>
                <th></th>
                <th></th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <?php foreach($types as $type): if($type->libelle == "général"): foreach($type->renseignements as $renseignement):?>
                <?php if($renseignement->renseignement_valeurs[0]->valeur===0) $val = '<span class="text-success">Non</span>';
                    elseif($renseignement->renseignement_valeurs[0]->valeur==1) $val = '<span class="text-danger">Oui</span>';
                    else $val = "Non défini";
                ?>
                    <tr>
                        <td><span class="control-span text-primary"><?=$renseignement->libelle?></span>:</td>
                        <td> <?=$val?></td>
                        <td><?=$renseignement->renseignement_valeurs[0]->commentaire?></td>
                    </tr>
                <?php endforeach; endif; endforeach;?>
            </tbody>      
        </table>
    </div>
</div>
<br><br>


<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css",
    "https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js",
    "https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js",
    "https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js",
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
    $(function () {
        $('.datatable').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });
        /*$('#table_maladies').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });
        $('#table_sens').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });
        $('#table_vaccins').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });
        $('#table_general').DataTable({
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": false,
        });*/
    });
    
</script>
<?php $this->end(); ?>