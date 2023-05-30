<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    //$this->assign('title', $message);
    $this->assign('title', "Erreur");
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
if (extension_loaded('xdebug')) :
    xdebug_print_function_stack();
endif;

$this->end();
endif;
?>
<h2>Page indisponible!</h2>
<p class="error">
    <!--strong><?= __d('cake', 'Error') ?>: </strong-->
    <?= __d('cake', 'La page demandée est introuvable ou vous ne disposez pas des habilitations nécessaires pour y accéder.<br>Merci de contacter votre administrateur.', "<strong>'{$url}'</strong>") ?>
</p>
<div id="footer">
    <?= $this->Html->link(__('<span class="glyphicon glyphicon-chevron-left"><span>Retour'), 'javascript:history.back()',['class'=>'btn btn-lg btn-default','escape'=>false]) ?>
</div>
