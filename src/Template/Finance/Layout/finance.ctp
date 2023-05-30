<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = ' - PAGES: Gestion d\'établissement scolaire';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
        <?= $cakeDescription ?>:
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php // $this->Html->css('base.css') ?>
    <?php // $this->Html->css('style.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <?= $this->Html->css('bootstrap/bootstrap.min.css');?>
    <?= $this->Html->css('print.min.css');?>

    <?= $this->Html->script('jquery/jquery.js');?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js');?>
    <?= $this->Html->script('print.min.js');?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <?= $this->Html->script('pdfmake/pdfmake.min.js');?>
    <?= $this->Html->script('pdfmake/vfs_fonts.js');?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->Element('Nav/nav-horizontal') ?>
    <?= $this->Flash->render() ?>
    <div class="container-fluid clearfix">
        <div class="col-sm-3">
            <?= $this->Element('Nav/nav-vertical') ?>
        </div>
        <div class="col-sm-9">
            <?= $this->fetch('content') ?>
        </div>
    </div>
    <footer>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
              

    </script>
    <?php echo $this->fetch('script'); ?>
    <?php echo $this->fetch('scriptBottom'); ?>

</body>