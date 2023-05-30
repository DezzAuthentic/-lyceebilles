<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tuteur $tuteur
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tuteur'), ['action' => 'edit', $tuteur->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tuteur'), ['action' => 'delete', $tuteur->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tuteur->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tuteurs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tuteur'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Etablissements'), ['controller' => 'Etablissements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Etablissement'), ['controller' => 'Etablissements', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Demandes'), ['controller' => 'Demandes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Demande'), ['controller' => 'Demandes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Eleves'), ['controller' => 'Eleves', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Elef'), ['controller' => 'Eleves', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tuteurs view large-9 medium-8 columns content">
    <h3><?= h($tuteur->nomComplet) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($tuteur->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Prenom') ?></th>
            <td><?= h($tuteur->prenom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telephone') ?></th>
            <td><?= h($tuteur->telephone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Adresse') ?></th>
            <td><?= h($tuteur->adresse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entreprise') ?></th>
            <td><?= h($tuteur->entreprise) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fonction') ?></th>
            <td><?= h($tuteur->fonction) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $tuteur->has('user') ? $this->Html->link($tuteur->user->id, ['controller' => 'Users', 'action' => 'view', $tuteur->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Situation Matrimoniale') ?></th>
            <td><?= h($tuteur->situation_matrimoniale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($tuteur->photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Etablissement') ?></th>
            <td><?= $tuteur->has('etablissement') ? $this->Html->link($tuteur->etablissement->id, ['controller' => 'Etablissements', 'action' => 'view', $tuteur->etablissement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tuteur->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nationalite') ?></th>
            <td><?= $this->Number->format($tuteur->nationalite) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Etat') ?></th>
            <td><?= $this->Number->format($tuteur->etat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Naissance') ?></th>
            <td><?= h($tuteur->date_naissance) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Demandes') ?></h4>
        <?php if (!empty($tuteur->demandes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Texte') ?></th>
                <th scope="col"><?= __('Etat') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Tuteur Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tuteur->demandes as $demandes): ?>
            <tr>
                <td><?= h($demandes->id) ?></td>
                <td><?= h($demandes->type) ?></td>
                <td><?= h($demandes->texte) ?></td>
                <td><?= h($demandes->etat) ?></td>
                <td><?= h($demandes->date) ?></td>
                <td><?= h($demandes->tuteur_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Demandes', 'action' => 'view', $demandes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Demandes', 'action' => 'edit', $demandes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Demandes', 'action' => 'delete', $demandes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $demandes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Eleves') ?></h4>
        <?php if (!empty($tuteur->eleves)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Matricule') ?></th>
                <th scope="col"><?= __('Nom') ?></th>
                <th scope="col"><?= __('Prenom') ?></th>
                <th scope="col"><?= __('Genre') ?></th>
                <th scope="col"><?= __('Date Naissance') ?></th>
                <th scope="col"><?= __('Lieu Naissance') ?></th>
                <th scope="col"><?= __('Telephone') ?></th>
                <th scope="col"><?= __('Adresse') ?></th>
                <th scope="col"><?= __('Tuteur Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Pays Naissance') ?></th>
                <th scope="col"><?= __('Nationalite') ?></th>
                <th scope="col"><?= __('Religion') ?></th>
                <th scope="col"><?= __('Cours Religion') ?></th>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= __('Etablissement Id') ?></th>
                <th scope="col"><?= __('Pere') ?></th>
                <th scope="col"><?= __('Mere') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tuteur->eleves as $eleves): ?>
            <tr>
                <td><?= h($eleves->id) ?></td>
                <td><?= h($eleves->matricule) ?></td>
                <td><?= h($eleves->nom) ?></td>
                <td><?= h($eleves->prenom) ?></td>
                <td><?= h($eleves->genre) ?></td>
                <td><?= h($eleves->date_naissance) ?></td>
                <td><?= h($eleves->lieu_naissance) ?></td>
                <td><?= h($eleves->telephone) ?></td>
                <td><?= h($eleves->adresse) ?></td>
                <td><?= h($eleves->tuteur_id) ?></td>
                <td><?= h($eleves->user_id) ?></td>
                <td><?= h($eleves->pays_naissance) ?></td>
                <td><?= h($eleves->nationalite) ?></td>
                <td><?= h($eleves->Religion) ?></td>
                <td><?= h($eleves->cours_religion) ?></td>
                <td><?= h($eleves->photo) ?></td>
                <td><?= h($eleves->etablissement_id) ?></td>
                <td><?= h($eleves->pere) ?></td>
                <td><?= h($eleves->mere) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Eleves', 'action' => 'view', $eleves->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Eleves', 'action' => 'edit', $eleves->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Eleves', 'action' => 'delete', $eleves->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eleves->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
