<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reglement[]|\Cake\Collection\CollectionInterface $reglements
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reglement'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Factures'), ['controller' => 'Factures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facture'), ['controller' => 'Factures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reglements index large-9 medium-8 columns content">
    <h3><?= __('Reglements') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('montant') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moyen') ?></th>
                <th scope="col"><?= $this->Paginator->sort('facture_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reglements as $reglement): ?>
            <tr>
                <td><?= $this->Number->format($reglement->id) ?></td>
                <td><?= h($reglement->date) ?></td>
                <td><?= $this->Number->format($reglement->montant) ?></td>
                <td><?= h($reglement->moyen) ?></td>
                <td><?= $reglement->has('facture') ? $this->Html->link($reglement->facture->id, ['controller' => 'Factures', 'action' => 'view', $reglement->facture->id]) : '' ?></td>
                <td><?= $reglement->has('user') ? $this->Html->link($reglement->user->id, ['controller' => 'Users', 'action' => 'view', $reglement->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reglement->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reglement->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reglement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reglement->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
