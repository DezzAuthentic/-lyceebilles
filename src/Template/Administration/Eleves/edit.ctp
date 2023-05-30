<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Elef $elef
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $elef->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $elef->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Eleves'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tuteurs'), ['controller' => 'Tuteurs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tuteur'), ['controller' => 'Tuteurs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Etablissements'), ['controller' => 'Etablissements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Etablissement'), ['controller' => 'Etablissements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eleves form large-9 medium-8 columns content">
    <?= $this->Form->create($elef) ?>
    <fieldset>
        <legend><?= __('Edit Elef') ?></legend>
        <?php
            echo $this->Form->control('matricule');
            echo $this->Form->control('nom');
            echo $this->Form->control('prenom');
            echo $this->Form->control('genre');
            echo $this->Form->control('date_naissance', ['empty' => true]);
            echo $this->Form->control('lieu_naissance');
            echo $this->Form->control('telephone');
            echo $this->Form->control('adresse');
            echo $this->Form->control('tuteur_id');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('pays_naissance');
            echo $this->Form->control('nationalite');
            echo $this->Form->control('Religion');
            echo $this->Form->control('cours_religion');
            echo $this->Form->control('photo');
            echo $this->Form->control('etablissement_id', ['options' => $etablissements]);
            echo $this->Form->control('pere');
            echo $this->Form->control('mere');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
