<div class="titre">
    <span class="text-primary">Archives <?=$promotion->annee->nom?> </span> <span>Promotion <?=$promotion->nom?></span>
</div>

<div class="row">
    <?php foreach($promotion->groupes as $groupe):?>
        <div class="col-xs-12 col-md-6">
            <a href="<?=$this->Url->Build('/academie/archives/groupe/'.$groupe->id)?>">
                <div class="panel panel-default">
                    <div class="text-center panel-heading">
                    <div class="soustitre">
                        <?=$groupe->nom?>: <?=sizeof($groupe->affectations)?> élèves(s)
                    </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach;?>

</div>



<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('.datatable').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
    });
} );
</script>
<?php $this->end(); ?>