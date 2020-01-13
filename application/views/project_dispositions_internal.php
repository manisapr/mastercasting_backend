<!-- <div class="mt-step-desc">
    <div class="font-dark bold uppercase">8 Steps Internal Disposition</div>
<br> </div> -->

<?php if(isset($project_disposition_internal[0])): ?>
<div class="col-md-1 mt-step-col first <?= isset($project_disposition_internal[0]) && $project_disposition_internal[0]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number active-green bg-white">1</div>
    <?php if(isset($project_disposition_internal[0])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title active-green uppercase font-grey-cascade <?= isset($project_disposition_internal[1]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[0]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[0]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[0]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[0]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[0]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[0]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[0]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if(isset($project_disposition_internal[1])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition_internal[1]) && $project_disposition_internal[1]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number active-green bg-white">2</div>
    <?php if(isset($project_disposition_internal[1])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title active-green uppercase font-grey-cascade  <?= isset($project_disposition_internal[2]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[1]['name'] ?></div>

    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[0]['flag'] == 1 && $project_disposition_internal[1]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[1]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[1]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[1]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[1]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[1]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>

</div>
<?php endif; ?>



<?php if(isset($project_disposition_internal[2])): ?>
<div class="col-md-1 mt-step-col active <?= isset($project_disposition_internal[2]) && $project_disposition_internal[2]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">3</div>
    <?php if(isset($project_disposition_internal[2])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[3]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[2]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[1]['flag'] == 1 && $project_disposition_internal[2]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[2]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[2]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[2]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[2]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[2]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>

</div>
<?php endif; ?>


<?php if(isset($project_disposition_internal[3])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition_internal[3]) && $project_disposition_internal[3]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">4</div>
    <?php if(isset($project_disposition_internal[3])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[4]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[3]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[2]['flag'] == 1 && $project_disposition_internal[3]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[3]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[3]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[3]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[3]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[3]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    
</div>
<?php endif; ?>


<?php if(isset($project_disposition_internal[4])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition_internal[4]) && $project_disposition_internal[4]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">5</div>
    <?php if(isset($project_disposition_internal[4])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[5]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[4]['name'] ?></div>

    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[3]['flag'] == 1 && $project_disposition_internal[4]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[4]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[4]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[4]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[4]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[4]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>


<?php if(isset($project_disposition_internal[5])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition_internal[5]) && $project_disposition_internal[5]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">6</div>
    <?php if(isset($project_disposition_internal[5])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[6]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[5]['name'] ?></div>

    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[4]['flag'] == 1 && $project_disposition_internal[5]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[5]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[5]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[5]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[5]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[5]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>



<?php if(isset($project_disposition_internal[6])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition_internal[6]) && $project_disposition_internal[6]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">7</div>
    <?php if(isset($project_disposition_internal[6])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[7]) ? '' : 'notlast' ?>"><?= $project_disposition_internal[6]['name'] ?></div>
    <?php if($client_approval): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[5]['flag'] == 1 && $project_disposition_internal[6]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[6]['project_disposition_id']?>" style="margin-bottom: 6px" >update</button>
    <?php elseif($project_disposition_internal[6]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[6]['project_disposition_id']?>" style="margin-bottom: 6px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[6]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[5]['project_disposition_id']?>"></button>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>


<?php if(isset($project_disposition_internal[7])): ?>
<div class="col-md-1 mt-step-col last <?= isset($project_disposition_internal[7]) && $project_disposition_internal[7]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">8</div>
    <?php if(isset($project_disposition_internal[7])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition_internal[7]) ? 'notlast' : '' ?>"><?= $project_disposition_internal[7]['name'] ?></div>
    <?php if($client_approval): ?>
    <!-- if $project_disposition_internal[0]['flag'] is 0 -->
    <?php if($project_disposition_internal[6]['flag'] == 1 && $project_disposition_internal[7]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition_internal btn-sm" value="<?= $project_disposition_internal[7]['project_disposition_id']?>" style="margin-bottom: 5px" >update</button>
    <?php elseif($project_disposition_internal[7]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert_internal" value="<?= $project_disposition_internal[7]['project_disposition_id']?>" style="margin-bottom: 5px">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition_internal btn-sm" data-toggle="modal" data-target="#change_disposition_internal_modal" value="<?= $project_disposition_internal[7]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition_internal" value="<?= $project_disposition_internal[7]['project_disposition_id']?>"></button>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>
