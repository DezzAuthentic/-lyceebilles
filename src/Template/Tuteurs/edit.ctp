<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tuteur $tuteur
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tuteur->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tuteur->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tuteurs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Etablissements'), ['controller' => 'Etablissements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Etablissement'), ['controller' => 'Etablissements', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Demandes'), ['controller' => 'Demandes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Demande'), ['controller' => 'Demandes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Eleves'), ['controller' => 'Eleves', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Elef'), ['controller' => 'Eleves', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tuteurs form large-9 medium-8 columns content">
    <?= $this->Form->create($tuteur) ?>
    <fieldset>
        <legend><?= __('Edit Tuteur') ?></legend>
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
