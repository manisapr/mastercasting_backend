<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<div class="row">
    <div class="col-md-2">
        <h4 class="text-center date_sort">Today</h4>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <td>Slots</td>
                <!-- <td>Jobs</td> -->
                <td>Action</td>
            </thead>
            <tbody>
                <?php for ($i=0; $i < 6; $i++): ?>
                <tr>
                    <td>Slot <?php echo $i+1 ?></td>
                    <!-- <td><?php //echo isset($cad_slots_date[$i]->project_id) ? 'J'.$cad_slots_date[$i]->project_id : '' ?></td> -->
                    <?php if($i < $slots->slots): ?>
                    <td><input class="slot_check" value="<?php echo $i ?>" checked type="checkbox" data-toggle="toggle" data-size="mini"></td>
                    <?php else: ?>
                    <td><input class="slot_check" value="<?php echo $i ?>" type="checkbox" data-toggle="toggle" data-size="mini"></td>
                    <?php endif; ?>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2">
      <h4 style="margin-top: 45px; text-align: center;">Jobs</h4>
      <ul id="sortable4" class="list-group list-unstyled" style="text-align: center;">
        <?php for ($i=0 ; $i < 6; $i++): ?>
        <?php if(isset($cad_slots_date[$i]->project_id)){
          switch ($cad_slots_date[$i]->cad_progress) {
            case 'In Progress':
              $cad_progress_class = 'list-group-item-info';
              break;
            case 'On Hold':
              $cad_progress_class = 'list-group-item-danger';
              break;
            case '3D Printing Only':
              $cad_progress_class = 'list-group-item-info';
              break;
            case 'Ready':
              $cad_progress_class = 'list-group-item-success';
              break;
          }
        } ?>
        <li class="list-group-item <?php echo isset($cad_slots_date[$i]->project_id) ? $cad_progress_class.' filled' : 'empty' ?>" data-id="<?php echo isset($cad_slots_date[$i]->project_id) ? $cad_slots_date[$i]->cad_slot_id : '' ?>"><?php echo isset($cad_slots_date[$i]->project_id) ? 'J'.$cad_slots_date[$i]->project_id.' ('.$cad_slots_date[$i]->cad_progress.') ' : 'Empty' ?></li>
        <?php endfor; ?>
      </ul>
    </div>
    <div class="col-md-8">
        <div id="calendar"></div>
        <p class="text-info" style="margin: 5px 0;">*Please Drag and drop to change date</p>
        <p class="text-info" style="margin: 5px 0;">*Please Drag and drop to sort jobs</p>
        <p class="text-info" style="margin: 5px 0;">*Select any date on calendar to view the date wise jobs</p>
    </div>
</div>


<script src='<?php echo base_url('assets/fullcalendar/packages/core/main.js')?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/packages/interaction/main.js')?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/packages/daygrid/main.js')?>'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data.min.js" integrity="sha256-6EFCRhQs5e10gzbTAKzcFFWcpDGNAzJjkQR3i1lvqYE=" crossorigin="anonymous"></script>
<script src='<?php echo base_url('assets/fullcalendar/packages/moment-timezone/main.min.js')?>'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
              height: 320,
              plugins: [ 'interaction', 'dayGrid', 'momentTimezone'],
              timeZone: 'America/New_York',
              header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
              },
              defaultDate: '<?php date_default_timezone_set('America/Chicago'); echo date('Y-m-d') ?>',
              // defaultDate: '2019-07-15',
              defaultView: 'dayGridWeek',
              navLinks: true, // can click day/week names to navigate views
              eventLimit: true, // allow "more" link when too many events
              events: [
                <?php foreach ($cad_slots as $key): ?>
                <?php 
                  switch ($key->cad_progress) {
                    case 'In Progress':
                      $cad_progress_color = '#327ad5';
                      break;
                    case 'On Hold':
                      $cad_progress_color = '#e73d4a';
                      break;
                    case '3D Printing Only':
                      $cad_progress_color = '#327ad5';
                      break;
                    case 'Ready':
                      $cad_progress_color = '#27a4b0';
                      break;
                    case 'Waiting For Approval':
                      $cad_progress_color = '#f3c200';
                      break;
                  }

                 ?>
                {
                  id: '<?php echo $key->cad_slot_id ?>',
                  title: '<?php echo ($key->slot_order == NULL ? '0' : $key->slot_order) . ' - J' . $key->project_id?>',
                  url: '<?php echo $key->project_id ?>',
                  start: '<?php echo $key->date ?>',
                  color: '<?php echo $cad_progress_color ?>'
                },
                <?php endforeach; ?>
                <?php foreach ($vacations as $key): ?>
                {
                  id: '<?php echo $key->vacation_id ?>',
                  title: 'Vacation',
                  start: '<?php echo $key->start_date ?>',
                  end: '<?php echo date('Y-m-d', strtotime($key->end_date. ' +1 day')) ?>'
                },
                <?php endforeach; ?>
              ],
              <?php if(in_array($designation_id, [1])): ?>
              editable: true,
              <?php endif; ?>

              <?php if(in_array($designation_id, [1])): ?>
              eventDrop: function(info) {
                var originalDate = new Date(info.event.start);
                var date = originalDate.toLocaleDateString("en-US");
                if(info.event.title !== 'Vacation'){
                  $.ajax({
                    url: "<?php echo base_url('User_controller/update_cad_slot_date/') ?>"+info.event.id,
                    data: {'date' : date},
                    type: 'POST',
                    success:function(data){
                      if(data == 'no')
                        swal('PLease select another date.');
                      else
                        swal('Cad date updated.');
                        // location.reload();
                        setTimeout(function(){ location.reload(); }, 1000);
                    }
                  });
                }
              },
              <?php endif; ?>

              eventClick: function(info) {
                  info.jsEvent.preventDefault(); 
                  // if (info.event.reason) {
                  //   alert(info.event.reason);
                  // }
                  if(info.event.title == 'Vacation'){
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                    var vacation_id = info.event.id;
                    $.ajax({
                      url: "<?php echo base_url('User_controller/vacation_details/') ?>"+vacation_id,
                      success:function(data){
                        alert(data);
                      }
                    });
                  } else{

                    var project_id = info.event.url;
                    $.ajax({
                      url: "<?php echo base_url('User_controller/project_details_modal_cad_slot/') ?>"+"/"+project_id,
                      dataType: 'json',
                      success:function(data){
                        // console.log(data);
                        $('#project_details_modal').html(data.tbody_data);
                        $('#project_spec_modal').html(data.spec_data);
                        $('#go_to_project_modal_link').attr('href', '<?php echo base_url('projects/project_details/') ?>'+project_id);
                        $('#eventModal').modal('show');
                      }
                    });
                  }
              },
              dateClick: function(info) {
                $.ajax({
                  url: "<?php echo base_url('User_controller/get_cad_dates_by_date/') ?>"+info.dateStr+"/<?php echo $this->uri->segment(2) ?>",
                  dataType: 'json',
                  success:function(data){
                    $('#sortable4').html(data.html);
                    $('.date_sort').html(data.date);
                  }
                });
              }
            });

            calendar.render();
          });
</script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $('.slot_check').change(function() {
      if($(this).is(":checked"))
          var slot = 1;
      else
          var slot = 0;
      $.ajax({
          url: "<?php echo base_url('User_controller/slot_check/'.$slots->id.'/')?>"+slot,
          success:function(data){
              swal('Slots updated');
          }
      });
      
  });
    
</script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.5/js/mdb.min.js"></script>
<script>
  $("#sortable4").sortable({
    placeholder: 'drop-placeholder',
    stop: function( ) {
        var order = $("#sortable4").sortable("serialize", {key:'order[]'});
        alert( order );
    }
  });
</script> -->

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

  jQuery.noConflict();

  (function($){
    $("#sortable4").sortable(
    {
      placeholder: 'drop-placeholder',
      stop: function(ev, ui) {
          // alert($(ui.item).prev().html());
          if($(ui.item).hasClass('empty') || $(ui.item).prev().hasClass('empty')){
            $(this).sortable('cancel');
          }
      },
      update: function(event, ui) {
        // console.log(ui);
        // var curr = ui.item;
        // var currOrder = curr.data('order');
        // var prev = curr.prev();
        // var prevOrder = prev.data('order');
        if($(ui.item).hasClass('empty') || $(ui.item).prev().hasClass('empty')){
          $(this).sortable('cancel');
        } else{
          var list = $('.filled');
          var listIds = [];
          for (var i = 0; i < $('.filled').length; i++) {
            var listId = list.eq(i).data('id');
            listIds.push(listId);
            
          }

          var listIdsJson = JSON.stringify(listIds);
          
          $.ajax({
              url: "<?php echo base_url('User_controller/sort_cad_slot') ?>",
              type: 'POST',
              // dataType: 'json',
              // contentType: 'application/json',
              data: {listIds: listIdsJson},
              success: function (data) {
                listIds = [];
              }
          });

        }
        // alert(prevOrder);
      }
    }).disableSelection();
  })(jQuery);
</script>