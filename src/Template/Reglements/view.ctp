<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reglement $reglement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reglement'), ['action' => 'edit', $reglement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reglement'), ['action' => 'delete', $reglement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reglement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reglements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reglement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Factures'), ['controller' => 'Factures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facture'), ['controller' => 'Factures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reglements view large-9 medium-8 columns content">
    <h3><?= h($reglement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Moyen') ?></th>
            <td><?= h($reglement->moyen) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Facture') ?></th>
            <td><?= $reglement->has('facture') ? $this->Html->link($reglement->facture->id, ['controller' => 'Factures', 'action' => 'view', $reglement->facture->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $reglement->has('user') ? $this->Html->link($reglement->user->id, ['controller' => 'Users', 'action' => 'view', $reglement->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($reglement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Montant') ?></th>
            <td><?= $this->Number->format($reglement->montant) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($reglement->date) ?></td>
        </tr>
    </table>
</div>
