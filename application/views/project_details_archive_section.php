<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#archive_files_div" aria-expanded="false">Archive Files</button>
    </div>
    
    <div class="multi-collapse collapse" id="archive_files_div" aria-expanded="false">
        <div class="row" style="margin: 20px">
            <?php if(in_array($designation_id, [1,6])): ?>
            <div class="col-md-12">
                <h4>Archive Files</h4>
                <?php foreach ($project_archive_group as $key1): ?>
                <?php $project_archive_files_by_group = $this->projectmodel->get_project_archive_files_by_group($project->project_id, $key1->project_archive_group_id); ?>
                <div class="groups" style="padding-left: 20px;">
                    <h6><?php echo $key1->group_name ?></h6>
                    <ul class="list-group project_files_list">
                        <?php if(count($project_archive_files_by_group) == 0): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No Files
                        </li>
                        <?php else: ?>
                        <?php foreach ($project_archive_files_by_group as $key): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="<?php echo 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" width="50" alt="">
                                <?php echo $key->file_name ?>
                                <span class="badge badge-primary"><?php echo $key->type ?></span>
                            </span>
                            <a data-id="<?php echo $key->project_files_id ?>" class="btn btn-sm btn-circle btn-primary recover_archive">Recover</a>
                        </li>
                        <?php endforeach ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
                <div class="groups" style="padding-left: 20px;">
                    <h6>Ungrouped</h6>
                    <ul class="list-group project_files_list">
                        <?php if(count($project_archive_files) == 0): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No Files
                        </li>
                        <?php else: ?>
                        <?php foreach ($project_archive_files as $key): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="<?php echo 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" width="50" alt="">
                                <?php echo $key->file_name ?>
                                <span class="badge badge-primary"><?php echo $key->type ?></span>
                            </span>
                            <a data-id="<?php echo $key->project_files_id ?>" class="btn btn-sm btn-circle btn-primary recover_archive">Recover</a>
                        </li>
                        <?php endforeach ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.recover_archive', function(e){
        // var file_id = $(this).val();
        e.preventDefault();
        var file_id = $(this).data('id');
        $.ajax({
            url: "<?php echo base_url('Project_controller/recover_archive/') ?>"+"/"+file_id,
            success:function(data){
                swal('File recovered');
                setTimeout(function(){
                   location.reload(true);
                }, 2000);
            }
        });
    });
</script>