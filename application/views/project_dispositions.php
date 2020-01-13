<?php 
$pro_id = $this->uri->segment('3');
$isCompleted = $this->db->get_where('project_details', ['project_id' => $pro_id])->result_array(); 
//echo $isCompleted[0]['type'];
?>
<?php if(isset($project_disposition[0])): ?>
<div class="col-md-1 mt-step-col first <?= isset($project_disposition[0]) && $project_disposition[0]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number active-green bg-white">1</div>
    <?php if(isset($project_disposition[0])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title active-green uppercase font-grey-cascade <?= isset($project_disposition[1]) ? '' : 'notlast' ?>"><?= $project_disposition[0]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[0]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[0]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[0]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[0]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[0]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[0]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if(isset($project_disposition[1])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition[1]) && $project_disposition[1]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number active-green bg-white">2</div>
    <?php if(isset($project_disposition[1])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title active-green uppercase font-grey-cascade  <?= isset($project_disposition[2]) ? '' : 'notlast' ?>"><?= $project_disposition[1]['name'] ?></div>

    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[0]['flag'] == 1 && $project_disposition[1]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[1]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[1]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[1]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[1]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[1]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>



<?php if(isset($project_disposition[2])): ?>
<div class="col-md-1 mt-step-col active <?= isset($project_disposition[2]) && $project_disposition[2]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">3</div>
    <?php if(isset($project_disposition[2])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[3]) ? '' : 'notlast' ?>"><?= $project_disposition[2]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[1]['flag'] == 1 && $project_disposition[2]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[2]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[2]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[2]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[2]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[2]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>

</div>
<?php endif; ?>


<?php if(isset($project_disposition[3])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition[3]) && $project_disposition[3]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">4</div>
    <?php if(isset($project_disposition[3])): ?> <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[4]) ? '' : 'notlast' ?>"><?= $project_disposition[3]['name'] ?></div>
    
    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[2]['flag'] == 1 && $project_disposition[3]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[3]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[3]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[3]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[3]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[3]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    
</div>
<?php endif; ?>


<?php if(isset($project_disposition[4])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition[4]) && $project_disposition[4]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">5</div>
    <?php if(isset($project_disposition[4])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[5]) ? '' : 'notlast' ?>"><?= $project_disposition[4]['name'] ?></div>


    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[3]['flag'] == 1 && $project_disposition[4]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[4]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[4]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[4]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[4]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[4]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>


<?php if(isset($project_disposition[5])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition[5]) && $project_disposition[5]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">6</div>
    <?php if(isset($project_disposition[5])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[6]) ? '' : 'notlast' ?>"><?= $project_disposition[5]['name'] ?></div>


    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'live'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[4]['flag'] == 1 && $project_disposition[5]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[5]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[5]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[5]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[5]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[5]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>

<?php if(isset($project_disposition[6])): ?>
<div class="col-md-1 mt-step-col <?= isset($project_disposition[6]) && $project_disposition[6]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">7</div>
    <?php if(isset($project_disposition[6])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[7]) ? '' : 'notlast' ?>"><?= $project_disposition[6]['name'] ?></div>


    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] == 'completed'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[5]['flag'] == 1 && $project_disposition[6]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[6]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[6]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[6]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[6]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[6]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>
<?php endif; ?>


<?php if(isset($project_disposition[7])): ?>
<div class="col-md-1 mt-step-col last <?= isset($project_disposition[7]) && $project_disposition[7]['flag'] == 1 ? 'done' : ''?>">
    <div class="mt-step-number bg-white active-green">8</div>
    <?php if(isset($project_disposition[7])): ?>  <!-- if isset project_disposition isset -->
    <div class="mt-step-title uppercase font-grey-cascade active-green  <?= isset($project_disposition[7]) ? 'notlast' : '' ?>"><?= $project_disposition[7]['name'] ?></div>

    <?php if($client_approval): ?>
    <?php //if(!$completed): ?>
    <?php //if($isCompleted[0]['type'] != 'completed'): ?>
    <!-- if $project_disposition[0]['flag'] is 0 -->
    <?php if($project_disposition[6]['flag'] == 1 && $project_disposition[7]['flag'] == 0): ?>
    <button class="btn btn-circle update_disposition btn-sm" value="<?= $project_disposition[7]['project_disposition_id']?>">update</button>
    <?php elseif($project_disposition[7]['flag'] == 1): ?>
    <button class="btn btn-circle btn-sm revert" value="<?= $project_disposition[7]['project_disposition_id']?>">revert</button>
    <?php endif; ?>
    
    <button class="fas btn-circle fa-cogs btn btn-default change_disposition btn-sm" data-toggle="modal" data-target="#change_disposition_modal" value="<?= $project_disposition[7]['project_disposition_id']?>"></button>
    <button class="btn btn-circle btn-default fas fa-trash btn-sm delete_disposition" value="<?= $project_disposition[7]['project_disposition_id']?>"></button>
    <?php //endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div></div>
    <!-- <div class="mt-step-content font-grey-cascade">Lorem ipsum dolor sit amet</div> -->
</div>

</div>
<?php endif; ?>