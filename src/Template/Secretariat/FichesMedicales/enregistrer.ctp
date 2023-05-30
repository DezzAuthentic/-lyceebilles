<?php
    $urgence_nom_id = null;
    $urgence_tel_id = null;
    $medecin_nom_id = null;
    $medecin_tel_id = null;
    $structure_sante_id = null;
    foreach($types as $type){
        foreach($type->renseignements as $renseignement){
            if($renseignement->libelle=="Nom contact d'urgence") $urgence_nom_id = $renseignement->id; 
            if($renseignement->libelle=="Téléphone du contact en cas d'urgence") $urgence_tel_id = $renseignement->id; 
            if($renseignement->libelle=="Médecin traitant") $medecin_nom_id = $renseignement->id; 
            if($renseignement->libelle=="Téléphone du médecin traitant") $medecin_tel_id = $renseignement->id; 
            if($renseignement->libelle=="Hôpital ou clinique de transfert") $structure_sante_id = $renseignement->id; 
        }
    }
    //dd($_types);
?>
<div class="titre">
    <span>Fiche médicale - Enregistrement</span>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-6">
        <label>Nom : </label> <?=$eleve->nom?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <label>Prénom : </label> <?=$eleve->prenom?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <label>Date de naissance : </label> <?=$eleve->date_naissance?>
    </div>
    <div class="col-xs-12 col-lg-6">
        <label>Classe : </label> 
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
        <label>Tuteur principal : </label> <?=$eleve->tuteur->prenom?> <?=$eleve->tuteur->nom?> / <?=$eleve->tuteur->telephone?>
    </div>
    <div class="col-xs-12"><hr class="mt1 mb1"></div>
    <div class="col-xs-12">
        <div class="titre2">Fiche médicale</div>
    </div>

    <form method="post">

    <div class="col-xs-12">
        <div class="soustitre3 border-b">En cas d'urgence</div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-md-12 col-lg-3 mt1 text-primary" >Personne à contacter</label>
        <input type="hidden" name="renseignements[<?=$urgence_nom_id?>][renseignement_id]" value="<?=$urgence_nom_id?>">
        <input type="hidden" name="renseignements[<?=$urgence_nom_id?>][valeur]" value="1">
        <label class="control-label col-xs-12 col-md-5 col-lg-2 mt1 text-right" for="renseignements[<?=$urgence_nom_id?>][commentaire]">Prénom et nom:</label>
        <div class="col-xs-12 col-md-7 col-lg-3 mt1">
            <input type="text" name="renseignements[<?=$urgence_nom_id?>][commentaire]" class="form-control">
        </div>

        <input type="hidden" name="renseignements[<?=$urgence_tel_id?>][renseignement_id]" value="<?=$urgence_tel_id?>">
        <input type="hidden" name="renseignements[<?=$urgence_tel_id?>][valeur]" value="1">
        <label class="control-label col-xs-12 col-md-5 col-lg-2 mt1 text-right" for="renseignements[<?=$urgence_tel_id?>][commentaire]">Téléphone:</label>
        <div class="col-xs-12 col-md-7 col-lg-2 mt1">
            <input type="text" name="renseignements[<?=$urgence_tel_id?>][commentaire]" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-md-12 col-lg-3 mt1 text-primary" >Médecin traitant</label>

        <input type="hidden" name="renseignements[<?=$medecin_nom_id?>][renseignement_id]" value="<?=$medecin_nom_id?>">
        <input type="hidden" name="renseignements[<?=$medecin_nom_id?>][valeur]" value="1">
        <label class="control-label col-xs-12 col-md-5 col-lg-2 mt1 text-right" for="renseignements[<?=$medecin_nom_id?>][commentaire]">Prénom et nom:</label>
        <div class="col-xs-12 col-md-7 col-lg-3 mt1">
            <input type="text" name="renseignements[<?=$medecin_nom_id?>][commentaire]" class="form-control">
        </div>

        <input type="hidden" name="renseignements[<?=$medecin_tel_id?>][renseignement_id]" value="<?=$medecin_tel_id?>">
        <input type="hidden" name="renseignements[<?=$medecin_tel_id?>][valeur]" value="1">
        <label class="control-label col-xs-12 col-md-5 col-lg-2 mt1 text-right" for="renseignements[<?=$medecin_tel_id?>][commentaire]">Téléphone:</label>
        <div class="col-xs-12 col-md-7 col-lg-2 mt1">
            <input type="text" name="renseignements[<?=$medecin_tel_id?>][commentaire]" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">Nous autorisez-vous à transporter votre enfant en cas d'urgence?</div>
        <input type="hidden" name="renseignements[<?=$structure_sante_id?>][renseignement_id]" value="<?=$structure_sante_id?>">
        <div class="col-xs-12 col-md-7 col-lg-3 mt1">
            <label for="renseignements[<?=$structure_sante_id?>][valeur]">Oui </label><input type="radio" name="renseignements[<?=$structure_sante_id?>][valeur]" value="1" class="btn-radio">
            <label for="renseignements[<?=$structure_sante_id?>][valeur]">Non </label><input type="radio" name="renseignements[<?=$structure_sante_id?>][valeur]" value="0" class="btn-radio">
            <label for="renseignements[<?=$structure_sante_id?>][valeur]">Autre </label><input type="radio" name="renseignements[<?=$structure_sante_id?>][valeur]" value="2" class="btn-radio">
        </div>
        <label class="control-label col-xs-12 col-md-5 col-lg-2 mt1 text-right" for="renseignements[<?=$structure_sante_id?>][commentaire]">Commentaire:</label>
        <div class="col-xs-12 col-md-7 col-lg-7 mt1">
            <input type="text" name="renseignements[<?=$structure_sante_id?>][commentaire]" class="form-control" placeholder="Adresse de l'hôpital ou de la clanique ou commentaires">
        </div>
    </div>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Maladies</div>
    </div>
    <div class="col-xs-12"></div>
    <?php foreach($types as $type): if($type->libelle == "maladie"): foreach($type->renseignements as $renseignement):?>
        <div class="form-group">
            <label class="control-label col-xs-12 col-md-5 col-lg-3 mt1 text-primary" ><?=$renseignement->libelle?></label>
            <input type="hidden" name="renseignements[<?=$renseignement->id?>][renseignement_id]" value="<?=$renseignement->id?>">
            <div class="col-xs-12 col-md-7 col-lg-2 mt1">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Oui </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="1" class="btn-radio">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Non </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="0" class="btn-radio">
            </div>
            <label class="control-label col-xs-12 col-md-4 col-lg-2 mt1 text-right" for="renseignements[<?=$renseignement->id?>][commentaire]">Commentaire:</label>
            <div class="col-xs-12 col-md-8 col-lg-5 mt1">
                <input type="text" name="renseignements[<?=$renseignement->id?>][commentaire]" value="<?php ?>" class="form-control" >
            </div>
        </div>
    <?php endforeach; endif; endforeach;?>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Troubles des sens</div>
    </div>
    <div class="col-xs-12"></div>
    <?php foreach($types as $type): if($type->libelle == "sens"): foreach($type->renseignements as $renseignement):?>
        <div class="form-group">
            <label class="control-label col-xs-12 col-md-5 col-lg-3 mt1 text-primary" ><?=$renseignement->libelle?></label>
            <input type="hidden" name="renseignements[<?=$renseignement->id?>][renseignement_id]" value="<?=$renseignement->id?>">
            <div class="col-xs-12 col-md-7 col-lg-2 mt1">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Oui </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="1" class="btn-radio">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Non </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="0" class="btn-radio">
            </div>
            <label class="control-label col-xs-12 col-md-4 col-lg-2 mt1 text-right" for="renseignements[<?=$renseignement->id?>][commentaire]">Commentaire:</label>
            <div class="col-xs-12 col-md-8 col-lg-5 mt1">
                <input type="text" name="renseignements[<?=$renseignement->id?>][commentaire]" value="<?php ?>" class="form-control" >
            </div>
        </div>
    <?php endforeach; endif; endforeach;?>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Vaccins</div>
    </div>
    <div class="col-xs-12"></div>
    <?php foreach($types as $type): if($type->libelle == "vaccin"): foreach($type->renseignements as $renseignement):?>
        <div class="form-group">
            <label class="control-label col-xs-12 col-md-5 col-lg-3 mt1 text-primary" ><?=$renseignement->libelle?></label>
            <input type="hidden" name="renseignements[<?=$renseignement->id?>][renseignement_id]" value="<?=$renseignement->id?>">
            <div class="col-xs-12 col-md-7 col-lg-2 mt1">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Oui </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="1" class="btn-radio">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Non </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="0" class="btn-radio">
            </div>
            <label class="control-label col-xs-12 col-md-4 col-lg-2 mt1 text-right" for="renseignements[<?=$renseignement->id?>][commentaire]">Commentaire:</label>
            <div class="col-xs-12 col-md-8 col-lg-5 mt1">
                <input type="text" name="renseignements[<?=$renseignement->id?>][commentaire]" value="<?php ?>" class="form-control" >
            </div>
        </div>
    <?php endforeach; endif; endforeach;?>

    <div class="col-xs-12 mt3">
        <div class="soustitre3 border-b">Autres informations</div>
    </div>
    <div class="col-xs-12"></div>
    <?php foreach($types as $type): if($type->libelle == "général"): foreach($type->renseignements as $renseignement):?>
        <div class="form-group">
            <label class="control-label col-xs-12 col-md-5 col-lg-3 mt1 text-primary" ><?=$renseignement->libelle?></label>
            <input type="hidden" name="renseignements[<?=$renseignement->id?>][renseignement_id]" value="<?=$renseignement->id?>">
            <div class="col-xs-12 col-md-7 col-lg-2 mt1">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Oui </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="1" class="btn-radio">
                <label for="renseignements[<?=$renseignement->id?>][valeur]">Non </label><input type="radio" name="renseignements[<?=$renseignement->id?>][valeur]" value="0" class="btn-radio">
            </div>
            <label class="control-label col-xs-12 col-md-4 col-lg-2 mt1 text-right" for="renseignements[<?=$renseignement->id?>][commentaire]">Commentaire:</label>
            <div class="col-xs-12 col-md-8 col-lg-5 mt1">
                <input type="text" name="renseignements[<?=$renseignement->id?>][commentaire]" value="<?php ?>" class="form-control" >
            </div>
        </div>
    <?php endforeach; endif; endforeach;?>
    <div class="col-xs-12"><hr class="mt1 mb1"></div>
    <div class="col-xs-12">
        <input type="submit" class="btn btn-md btn-primary">
    </div>
    <?=$this->Form->end()?>
</div>
<br><br>
