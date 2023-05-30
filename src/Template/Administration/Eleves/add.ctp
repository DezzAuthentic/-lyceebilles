<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Elef $elef
 */
?>

<div class="col-md-12">
    <?= $this->Form->create($elef) ?>
    <fieldset>
        <?php
            echo $this->Form->control('tuteur_id', ['options' => $tuteurs, 'empty' => true,'class'=>'form-control js-example-basic-single col-md-12']);
            echo $this->Form->input('matricule',['class'=>'form-control col-md-12']);
            echo $this->Form->control('nom');
            echo $this->Form->control('prenom');
            echo $this->Form->control('genre');
            echo $this->Form->control('date_naissance', ['empty' => true]);
            echo $this->Form->control('lieu_naissance');
            echo $this->Form->control('telephone');
            echo $this->Form->control('adresse');
            // echo $this->Form->control('user.login');
            // echo $this->Form->control('user.password');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('pays_naissance');
            echo $this->Form->control('nationalite');
            echo $this->Form->control('Religion');
            echo $this->Form->control('cours_religion');
            echo $this->Form->control('photo');
            // echo $this->Form->control('etablissements', ['options' => $etablissements]);
            echo $this->Form->control('pere');
            echo $this->Form->control('mere');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Ajouter')) ?>
    <?= $this->Form->end() ?>
</div>
<?php $this->start('script'); ?>
  <script>
    $('.js-example-basic-single').select2();
  </script>
<?php $this->end(); ?>