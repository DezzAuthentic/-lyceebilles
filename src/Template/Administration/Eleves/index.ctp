<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Elef[]|\Cake\Collection\CollectionInterface $eleves
 */
?>

<div class="col-md-12">
    <h3><?= __('Eleves') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('matricule') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('prenom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_naissance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lieu_naissance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telephone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('adresse') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tuteur_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pays_naissance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nationalite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Religion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cours_religion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('etablissement_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pere') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mere') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eleves as $elef): ?>
            <tr>
                <td><?= $this->Number->format($elef->id) ?></td>
                <td><?= h($elef->matricule) ?></td>
                <td><?= h($elef->nom) ?></td>
                <td><?= h($elef->prenom) ?></td>
                <td><?= h($elef->genre) ?></td>
                <td><?= h($elef->date_naissance) ?></td>
                <td><?= h($elef->lieu_naissance) ?></td>
                <td><?= h($elef->telephone) ?></td>
                <td><?= h($elef->adresse) ?></td>
                <td><?= $this->Number->format($elef->tuteur_id) ?></td>
                <td><?= $elef->has('user') ? $this->Html->link($elef->user->id, ['controller' => 'Users', 'action' => 'view', $elef->user->id]) : '' ?></td>
                <td><?= $this->Number->format($elef->pays_naissance) ?></td>
                <td><?= $this->Number->format($elef->nationalite) ?></td>
                <td><?= h($elef->Religion) ?></td>
                <td><?= $this->Number->format($elef->cours_religion) ?></td>
                <td><?= h($elef->photo) ?></td>
                <td><?= $elef->has('etablissement') ? $this->Html->link($elef->etablissement->id, ['controller' => 'Etablissements', 'action' => 'view', $elef->etablissement->id]) : '' ?></td>
                <td><?= h($elef->pere) ?></td>
                <td><?= h($elef->mere) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $elef->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $elef->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $elef->id], ['confirm' => __('Are you sure you want to delete # {0}?', $elef->id)]) ?>
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
