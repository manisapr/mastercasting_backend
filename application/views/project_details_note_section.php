<div class="panel panel-default" id="note_panel">
    <div class="panel-heading">
        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#notes" aria-expanded="false" aria-controls="notes">Notes</button>
        <button style="float: right;" class="btn collapsed" type="button" data-toggle="collapse" data-target="#create_note" aria-expanded="false" aria-controls="create_note">Create Notes</button>
    </div>
    <div class="collapse multi-collapse" id="create_note">
        <div class="form msg-frm" style="padding: 20px !important" aria-expanded="false">
            <form id="create_note_form" method="POST">
                <input type="hidden" name="note[project_id]" value="<?php echo $project->project_id; ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="note[note]" placeholder="Create Note">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-circle green">Save Note</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="collapse multi-collapse" id="notes" aria-expanded="false">
        <div class="form msg-frm" style="padding: 20px !important">
            <table class="table" id="notes_table">
                <?php if(!empty($project_notes)): ?>
                <?php foreach ($project_notes as $key) : ?>
                <tr>
                    <td>
                        <?php echo $this->db->get_where('user', ['id' => $key->user_id])->row()->name ?>: <?php echo date('m/d/Y',strtotime($key->created_at)) ?> <?php echo $key->note ?>
                        <button class="btn btn-sm btn-circle btn-danger pull-right delete_note" value="<?php echo $key->project_note_id ?>">delete</button>    
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td>No Notes</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>


 <!-- note script -->
<script>
    $(document).on('submit', '#create_note_form', function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $('#create_note_form input[name="note[note]"]').val('');
        $.ajax({
            url: "<?php echo base_url('Project_controller/create_note/') ?>",
            data: form,
            type: 'POST',
            success:function(data){
                swal('Note added')
                $("#notes_table").load(location.href + ' #notes_table');
            }
        });
    });  
</script>
<script>
    $(document).on('click', '.delete_note', function(){
        var note_id = $(this).val();
        $.ajax({
            url: "<?php echo base_url('Project_controller/delete_note/') ?>"+note_id,
            success:function(data){
                swal('Note deleted')
                $("#notes_table").load(location.href + ' #notes_table');
            }
        });
    });
</script>
<!-- end note script -->
