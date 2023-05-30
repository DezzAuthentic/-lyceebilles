<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tuteur $tuteur
 */
?>
<div class="tuteurs form large-9 medium-8 columns content">
    <?= $this->Form->create($tuteur) ?>
    <fieldset>
        <legend><?= __('Add Tuteur') ?></legend>
        <?php
            echo $this->Form->control('nom');
            echo $this->Form->control('prenom');
            echo $this->Form->control('telephone');
            echo $this->Form->control('adresse');
            echo $this->Form->control('entreprise');
            echo $this->Form->control('fonction');
            echo $this->Form->control('date_naissance', ['empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('nationalite');
            echo $this->Form->control('situation_matrimoniale');
            echo $this->Form->control('etat');
            echo $this->Form->control('photo');
            echo $this->Form->control('etablissement_id', ['options' => $etablissements]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
