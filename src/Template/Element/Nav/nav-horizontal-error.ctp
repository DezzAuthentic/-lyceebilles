<nav class="navbar navbar-default">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header col-xs-12">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="icone pull-left" href="/" >
                <?php if(!empty($etablissement->logo)):?>
                    <img class="logo" style='margin-top:5px;' src="<?= $etablissement->logo?>" height="40px;" >
                <?php 
                else:
                    echo $this->Html->image('default-img.gif', ['alt' => 'logo etablissement','height'=>'30px','class'=>"logo",'style'=>"margin-top:5px;"]);
                endif;
                ?>
            </a>
            <a class="navbar-brand" href="#">PAGES</a>
        </div>
        
    </div>

   
</nav>
