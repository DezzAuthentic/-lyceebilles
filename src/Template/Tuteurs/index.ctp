<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tuteur[]|\Cake\Collection\CollectionInterface $tuteurs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tuteur'), ['action' => 'add']) ?></li>
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
<div class="tuteurs index large-9 medium-8 columns content">
    <h3><?= __('Tuteurs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('prenom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telephone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('adresse') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entreprise') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fonction') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_naissance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nationalite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('situation_matrimoniale') ?></th>
                <th scope="col"><?= $this->Paginator->sort('etat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('etablissement_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tuteurs as $tuteur): ?>
            <tr>
                <td><?= $this->Number->format($tuteur->id) ?></td>
                <td><?= h($tuteur->nom) ?></td>
                <td><?= h($tuteur->prenom) ?></td>
                <td><?= h($tuteur->telephone) ?></td>
                <td><?= h($tuteur->adresse) ?></td>
                <td><?= h($tuteur->entreprise) ?></td>
                <td><?= h($tuteur->fonction) ?></td>
                <td><?= h($tuteur->date_naissance) ?></td>
                <td><?= $tuteur->has('user') ? $this->Html->link($tuteur->user->id, ['controller' => 'Users', 'action' => 'view', $tuteur->user->id]) : '' ?></td>
                <td><?= $this->Number->format($tuteur->nationalite) ?></td>
                <td><?= h($tuteur->situation_matrimoniale) ?></td>
                <td><?= $this->Number->format($tuteur->etat) ?></td>
                <td><?= h($tuteur->photo) ?></td>
                <td><?= $tuteur->has('etablissement') ? $this->Html->link($tuteur->etablissement->id, ['controller' => 'Etablissements', 'action' => 'view', $tuteur->etablissement->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tuteur->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tuteur->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tuteur->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tuteur->id)]) ?>
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
