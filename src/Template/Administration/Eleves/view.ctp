<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Elef $elef
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Elef'), ['action' => 'edit', $elef->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Elef'), ['action' => 'delete', $elef->id], ['confirm' => __('Are you sure you want to delete # {0}?', $elef->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Eleves'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Elef'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tuteurs'), ['controller' => 'Tuteurs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tuteur'), ['controller' => 'Tuteurs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Etablissements'), ['controller' => 'Etablissements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Etablissement'), ['controller' => 'Etablissements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eleves view large-9 medium-8 columns content">
    <h3><?= h($elef->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Matricule') ?></th>
            <td><?= h($elef->matricule) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($elef->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Prenom') ?></th>
            <td><?= h($elef->prenom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genre') ?></th>
            <td><?= h($elef->genre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lieu Naissance') ?></th>
            <td><?= h($elef->lieu_naissance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telephone') ?></th>
            <td><?= h($elef->telephone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Domicile') ?></th>
            <td><?= h($elef->adresse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $elef->has('user') ? $this->Html->link($elef->user->id, ['controller' => 'Users', 'action' => 'view', $elef->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Religion') ?></th>
            <td><?= h($elef->Religion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($elef->photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Etablissement') ?></th>
            <td><?= $elef->has('etablissement') ? $this->Html->link($elef->etablissement->id, ['controller' => 'Etablissements', 'action' => 'view', $elef->etablissement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pere') ?></th>
            <td><?= h($elef->pere) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mere') ?></th>
            <td><?= h($elef->mere) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($elef->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tuteur Id') ?></th>
            <td><?= $this->Number->format($elef->tuteur_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pays Naissance') ?></th>
            <td><?= $this->Number->format($elef->pays_naissance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nationalite') ?></th>
            <td><?= $this->Number->format($elef->nationalite) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cours Religion') ?></th>
            <td><?= $this->Number->format($elef->cours_religion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Naissance') ?></th>
            <td><?= h($elef->date_naissance) ?></td>
        </tr>
    </table>
</div>
