<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<?php $comp_des = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->comp_des; ?>
<style>
    .project_files_list .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <button class="btn" type="button" data-toggle="collapse" data-target="#upload_file_input_div" aria-expanded="false" aria-controls="uploaded_file">Project Files</button>
        <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#uploaded_file" aria-expanded="false" aria-controls="uploaded_file">Upload File</button>
    </div>

    <div class="collapse multi-collapse" id="uploaded_file">
        <div class="row" style="margin: 20px">
            <div class="col-md-12">
                <div class="form-group" style="margin-top: 20px">
                    <label for="">Cad</label>
                    <div class="file-loading" id="krajee_file">
                        <input id="file-1" type="file" multiple class="file" name="file[]">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group" style="margin-top: 20px">
                    <label for="">Pic</label>
                    <div class="file-loading" id="krajee_file">
                        <input id="file-2" type="file" multiple class="file" name="file[]">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="collapse multi-collapse in show" id="upload_file_input_div">
        <div class="row" style="margin: 20px">
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="POST" action="<?php echo base_url('Project_controller/file_action/'.$this->uri->segment(3))?>">
                    <div class="row">
                        <?php if($client_approval): ?>
                        <div class="col-md-4">
                            <select class="form-control" name="action" id="file_action" required="">
                                <option value="" disabled selected>Select Action</option>
                                <?php if(in_array($designation_id, [1,6,8])): ?>
                                <option value="thumbnail">Mark as Thumbnail</option>
                                <option value="client_visible">Visible to client</option>
                                <option value="client_invisible">Invisible to client</option>
                                <?php endif; ?>
                                <?php if(in_array($designation_id, [1,6,8])): ?>
                                <option value="visible_cad">Visible To Cad</option>
                                <option value="invisible_cad">Invisible To Cad</option>
                                <?php endif; ?>
                                <?php if(in_array($designation_id, [1,6,8,9])): ?>
                                <option value="archive">Archive Files</option>
                                <option value="dropbox">Backup Files to Dropbox</option>
                                <?php endif; ?>
                                <?php if(in_array($designation_id, [1,6,8])): ?>
                                <option value="delete">Delete files</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select placeholder="Select Group" class="form-control" name="group[]" id="archive_groups" multiple="" disabled>
                            <?php foreach ($project_archive_group as $key): ?>
                            <option value="<?php echo $key->project_archive_group_id ?>"><?php echo $key->group_name ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-circle btn-md" id="add_archive_group">Add Group</button>
                        </div>
                        <div class="col-md-2 text-center">
                            <button class="btn btn-circle btn-md green">Save Action</button>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- cad file -->
                    <?php $file_types = ['cad', 'pic']; ?>
                    <?php foreach ($file_types as $file_type) : ?>

                    <h4><?php echo ucwords($file_type); ?> Files</h4>
                    <ul class="list-group project_files_list">                                                        
                        <?php foreach ($project_files as $key) : ?>
                        <?php $file = pathinfo($key->file_name); ?>
                        <?php $proj_files_user = $this->db->get_where('user', ['id' => $key->user_id])->row(); ?>
                        <?php $proj_files_user_des = $this->db->get_where('designation', ['designation_id' => $proj_files_user->designation_id])->row(); ?>
                        <?php if($key->type == $file_type): ?>
                        <?php $assign_by = $this->db->get_where('project', ['project_id' => $key->project_id])->row()->assign_by; ?>
                            <?php if(in_array($designation_id,[5,7])): // only for clients ?>
                                <?php if($key->user_id == $assign_by): ?>
                                <li class="list-group-item" title="<?php echo $key->file_name ?>">
                                    <div>
                                        <?php if(in_array($file['extension'], ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'])): ?>
                                        <img class='proj_img' src='<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>' alt='' width="75">
                                        <?php else: ?>
                                        <img class='proj_img' src='<?= base_url('/assets/images/default_file_icon.png') ?>' alt='' width="50">
                                        <?php endif; ?>
                                        <span class='badge badge-primary'><?php echo $key->file_name ?></span>
                                        <span class='badge badge-primary'><?php echo $key->type ?></span>
                                        <span class='badge bg-grey-salsa bg-font-grey-salsa'><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A') ?></span>
                                    </div>
                                    <div>
                                        <?php if($comp_des != 2): ?>
                                        <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>" class="btn btn-sm btn-default <?php echo $comp_des ?> download_btn" data-filename="<?php echo $key->file_name ?>" title="Download" download><i class="fas fa-download"></i></a>
                                        <?php endif; ?>
                                        <a class="btn btn-sm btn-default" data-fancybox="images" href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>"><i class="far fa-eye"></i></a>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($key->user_id != $assign_by && $key->client_approval == 1): ?>
                                <li class="list-group-item" title="<?php echo $key->file_name ?>">
                                    <div>
                                        <?php if(in_array($file['extension'], ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'])): ?>
                                        <img class='proj_img' src='<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>' alt='' width="75">
                                        <?php else: ?>
                                        <img class='proj_img' src='<?= base_url('/assets/images/default_file_icon.png') ?>' alt='' width="50">
                                        <?php endif; ?>
                                        <span class='badge badge-primary'><?php echo $key->file_name ?></span>
                                        <span class='badge badge-primary'><?php echo $key->type ?></span>
                                        <span class='badge bg-grey-salsa bg-font-grey-salsa'><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A') ?></span>
                                    </div>
                                    <div>
                                        <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>" class="btn btn-sm btn-default download_btn" data-filename="<?php echo $key->file_name ?>" title="Download" download><i class="fas fa-download"></i></a>
                                        <a class="btn btn-sm btn-default" data-fancybox="images" href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>"><i class="far fa-eye"></i></a>
                                    </div>
                                </li>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(in_array($designation_id,[9])): // only for cad team ?>
                                    <?php if($key->visible_cad == 1): ?>
                                    <li class="list-group-item" title="<?php echo $key->file_name ?>">
                                        <div>
                                            <input class='proj_img_chk'  name='project_files_id[]' value='<?php echo $key->project_files_id?>' type='checkbox'>
                                            <?php if(in_array($file['extension'], ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'])): ?>
                                            <img class='proj_img' src='<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>' alt='' width="75">
                                            <?php else: ?>
                                            <img class='proj_img' src='<?= base_url('/assets/images/default_file_icon.png') ?>' alt='' width="50">
                                            <?php endif; ?>
                                            <span class='badge badge-primary'><?php echo $key->file_name ?></span>
                                            <span class='badge badge-primary'><?php echo $key->type ?></span>
                                            <span class='badge bg-grey-salsa bg-font-grey-salsa'><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A') ?></span>
                                        </div>
                                        <div>
                                            <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>" class="btn btn-sm btn-default download_btn" data-filename="<?php echo $key->file_name ?>" title="Download" download><i class="fas fa-download"></i></a>
                                            <a class="btn btn-sm btn-default" data-fancybox="images" href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>"><i class="far fa-eye"></i></a>
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                <?php else:  // other team member  ?>
                                <li class="list-group-item" title="<?php echo $key->file_name ?>">
                                    <div>
                                        <input class='proj_img_chk'  name='project_files_id[]' value='<?php echo $key->project_files_id?>' type='checkbox'>
                                        <?php if(in_array($file['extension'], ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'])): ?>
                                        <img class='proj_img' src='<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>' alt='' width="75">
                                        <?php else: ?>
                                        <img class='proj_img' src='<?= base_url('/assets/images/default_file_icon.png') ?>' alt='' width="50">
                                        <?php endif; ?>
                                        <span class='badge badge-primary'><?php echo $key->file_name ?></span>
                                        <span class='badge badge-primary'><?php echo $key->type ?></span>
                                        <span class='badge badge-primary'><?php echo $proj_files_user->name; ?></span> 
                                        <span class='badge badge-primary'><?php echo $proj_files_user_des->designation_name ?></span>
                                        <span class='badge bg-purple-plum bg-font-purple-plum'><?php echo $key->visible_cad == 1 ? 'Visible To Cad' : 'Hidden to Cad' ?></span>
                                        <span class='badge badge-primary'><?php echo $key->client_approval == 1 ? 'Visible' : 'Hidden' ?></span> 
                                            
                                        <span class='badge bg-grey-salsa bg-font-grey-salsa'><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A') ?></span>
                                        <?php if($key->is_dropbox_backed_up == 1): ?>
                                        <span class="badge bg-green-turquoise bg-font-green-turquoise"><i class="fab fa-dropbox"></i> Dropbox</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>" class="btn btn-sm btn-default download_btn" data-filename="<?php echo $key->file_name ?>" title="Download" download><i class="fas fa-download"></i></a>
                                        <a class="btn btn-sm btn-default" data-fancybox="images" href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name?>"><i class="far fa-eye"></i></a>
                                        <a class="btn btn-sm btn-default delete_proj_file" data-id="<?= $key->project_files_id ?>"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <?php endforeach; ?>


                </form>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/file_input/fileinput.js')?>" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/explorer-fas/theme.min.js" type="text/javascript"></script>
<script>
    jQuery.noConflict();

    (function($){
        // var type = $('.file_input_type').val();
        // var type = document.getElementByClassName('.file_input_type');
        // $(document).on('change', '.file_input_type', function(){
        //     var type = $(this).val();
        //     alert(type);
        // });
        // alert(type);
        $("#file-1").fileinput({
            theme: 'explorer-fas',
            uploadUrl:  "<?php echo base_url('Project_controller/krajee_upload/'.$project->project_id.'/')?>"+"/"+'cad',
            uploadAsync: true,
            overwriteInitial: false,
            fileActionSettings: {
                showDrag: false,
            },
            minFileCount: 1,
            maxFileCount: 5,
            // showPreview :false,
            showUploadedThumbs: false,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true, // identify if you are sending preview data only and not the markup
            previewFileIcon: '<i class="fas fa-file"></i>',
            allowedPreviewTypes: null,
            
        });

        $('#file-1').on('filebatchselected', function(event, numFiles, label) {
            setTimeout(function(){
            swal('Please click the upload button to upload');
            }, 1000);
        });

        $('#file-1').on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
            console.log('File batch upload complete', preview, config, tags, extraData);
            setTimeout(function(){
               location.reload(true);
            }, 2000);
        });

        $("#file-2").fileinput({
            theme: 'explorer-fas',
            uploadUrl:  "<?php echo base_url('Project_controller/krajee_upload/'.$project->project_id.'/')?>"+"/"+'pic',
            uploadAsync: true,
            overwriteInitial: false,
            fileActionSettings: {
                showDrag: false,
            },
            minFileCount: 1,
            maxFileCount: 5,
            // showPreview :false,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true, // identify if you are sending preview data only and not the markup
            
        });

       $('#file-2').on('fileuploaded', function(event, previewId, index, fileId) {
            setTimeout(function(){
               location.reload(true);
            }, 2000);
        });

       $('#file-2').on('filebatchselected', function(event, numFiles, label) {
            setTimeout(function(){
            swal('Please click the upload button to upload');
            }, 1000);
        });
    })(jQuery);
</script>

<script>
    $(document).on('click', '.delete_proj_file', function(e){
        e.preventDefault();
        var val = $(this).data('id');
        swal({
          title: "Are you sure?",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "<?php echo base_url('Project_controller/delete_krajee_img/') ?>"+"/"+val,
                success:function(data){
                    swal("File deleted");
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            });
          }
        });
    });
</script>


<script>
    // $('#archive_groups').hide();
    $(document).on('change', '#file_action', function(){
        var action = $(this).val();
        if(action == 'archive')
            $('#archive_groups').removeAttr('disabled');
        else
            $('#archive_groups').attr('disabled', 'disabled');
    });

    $(document).on('click', '#add_archive_group', function(){
        swal("Enter group name:", {
            content: "input",
            // closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: "No",
            showCloseButton: true,

        })
        .then((value) => {
            if(value === '' || value === null)
                swal('Please enter a name');
            else{
                var project_id = <?php echo $project->project_id ?>;
                var group_name = encodeURIComponent(value);
                $.ajax({
                    url: "<?php echo base_url('Project_controller/add_archive_group/') ?>"+"/"+project_id+"/"+group_name,
                    success:function(data){
                        swal('Group added');
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }
                });
            }

        });
    });
</script>

<script>
    
    $(document).on('click', '.download_btn', function(e){
        e.preventDefault();
        var loc = $(this).attr("href");
        var filename = $(this).data('filename');
        $.post(
            '<?php echo base_url('Project_controller/download_activity_log') ?>', 
            {"project_id": "<?php echo $project->project_id ?>", "filename": filename}, 
            function(data){
                // alert(data);
                window.open(loc);
            }
        );
    });
</script>
