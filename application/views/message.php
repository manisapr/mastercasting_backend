            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php include 'inc/sidebar.php'; ?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Message</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                               <!-- TASK HEAD -->
                               <form id="fileupload" action="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/server/php/" method="POST" enctype="multipart/form-data" class="form-horizontal">
	                                <!-- TASK HEAD -->
                                <div class="tabbable-line">
                                    <ul class="nav nav-tabs ">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab"> Comments </a>
                                        </li>
                                        <li>
                                            <a href="#tab_2" data-toggle="tab"> Project Status </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <!-- TASK COMMENTS -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <ul class="media-list">
                                                        <li class="media">
                                                            <a class="pull-left" href="javascript:;">
                                                                <img class="todo-userpic" src="<?php echo base_url();?>assets/assets/pages/media/users/avatar8.jpg" width="27px" height="27px"> </a>
                                                            <div class="media-body todo-comment">
                                                                <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                                                <p class="todo-comment-head">
                                                                    <span class="todo-comment-username">Christina Aguilera</span> &nbsp;
                                                                    <span class="todo-comment-date">17 Sep 2014 at 2:05pm</span>
                                                                </p>
                                                                <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra
                                                                    turpis. </p>
                                                                <!-- Nested media object -->
                                                                <div class="media">
                                                                    <a class="pull-left" href="javascript:;">
                                                                        <img class="todo-userpic" src="<?php echo base_url();?>assets/assets/pages/media/users/avatar4.jpg" width="27px" height="27px"> </a>
                                                                    <div class="media-body">
                                                                        <p class="todo-comment-head">
                                                                            <span class="todo-comment-username">Carles Puyol</span> &nbsp;
                                                                            <span class="todo-comment-date">17 Sep 2014 at 4:30pm</span>
                                                                        </p>
                                                                        <p class="todo-text-color"> Thanks so much my dear! </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a class="pull-left" href="javascript:;">
                                                                <img class="todo-userpic" src="<?php echo base_url();?>assets/assets/pages/media/users/avatar5.jpg" width="27px" height="27px"> </a>
                                                            <div class="media-body todo-comment">
                                                                <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                                                <p class="todo-comment-head">
                                                                    <span class="todo-comment-username">Andres Iniesta</span> &nbsp;
                                                                    <span class="todo-comment-date">18 Sep 2014 at 9:22am</span>
                                                                </p>
                                                                <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Scelerisque ante sollicitudin commodo Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum
                                                                    in vulputate at, tempus viverra turpis.
                                                                    <br> </p>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a class="pull-left" href="javascript:;">
                                                                <img class="todo-userpic" src="<?php echo base_url();?>assets/assets/pages/media/users/avatar6.jpg" width="27px" height="27px"> </a>
                                                            <div class="media-body todo-comment">
                                                                <button type="button" class="todo-comment-btn btn btn-circle btn-default btn-sm">&nbsp; Reply &nbsp;</button>
                                                                <p class="todo-comment-head">
                                                                    <span class="todo-comment-username">Olivia Wilde</span> &nbsp;
                                                                    <span class="todo-comment-date">18 Sep 2014 at 11:50am</span>
                                                                </p>
                                                                <p class="todo-text-color"> Cras sit amet nibh libero, in gravida nulla. Scelerisque ante sollicitudin commodo Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum
                                                                    in vulputate at, tempus viverra turpis.
                                                                    <br> </p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- END TASK COMMENTS -->
                                            <!-- TASK COMMENT FORM -->
                                            <!-- <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="button" class="pull-right btn btn-sm btn-circle green"> &nbsp; Submit &nbsp; </button>
                                                </div>
                                            </div> -->
                                            <!-- END TASK COMMENT FORM -->
                                        </div>
                                        <div class="tab-pane" id="tab_2">
                                            <ul class="todo-task-history">
                                                <li>
                                                    <div class="todo-task-history-date"> 20 Jun, 2014 at 11:35am </div>
                                                    <div class="todo-task-history-desc"> Task created </div>
                                                </li>
                                                <li>
                                                    <div class="todo-task-history-date"> 21 Jun, 2014 at 10:35pm </div>
                                                    <div class="todo-task-history-desc"> Task category status changed to "Top Priority" </div>
                                                </li>
                                                <li>
                                                    <div class="todo-task-history-date"> 22 Jun, 2014 at 11:35am </div>
                                                    <div class="todo-task-history-desc"> Task owner changed to "Nick Larson" </div>
                                                </li>
                                                <li>
                                                    <div class="todo-task-history-date"> 30 Jun, 2014 at 8:09am </div>
                                                    <div class="todo-task-history-desc"> Task completed by "Nick Larson" </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- == -->
                                <div class="form msg-frm">
	                                    <div class="form-group">
	                                        <div class="col-md-8 col-sm-8">
	                                            <div class="todo-taskbody-user">
	                                                
	                                                <span class="todo-username pull-left todo_comen">Comment</span>
	                                                <button type="button" class="todo-username-btn btn btn-circle btn-default btn-sm">&nbsp;edit&nbsp;</button>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4 col-sm-4">
	                                            <div class="todo-taskbody-date pull-right">
	                                                <button type="button" class="todo-username-btn btn btn-circle btn-default btn-sm">&nbsp; Complete &nbsp;</button>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <!-- END TASK HEAD -->
	                                    <!-- TASK TITLE -->
	                                    <div class="form-group">
	                                        <div class="col-md-12">
	                                            <input type="text" class="form-control todo-taskbody-tasktitle" placeholder="Task Title..."> </div>
	                                    </div>
	                                    <!-- TASK DESC -->
	                                    <div class="form-group">
	                                        <div class="col-md-12">
	                                            <textarea class="form-control todo-taskbody-taskdesc" rows="8" placeholder="Task Description..."></textarea>
	                                        </div>
	                                    </div>
	                                    <!-- END TASK DESC -->
	                                    <!-- TASK DUE DATE -->
	                                    <div class="form-group">
	                                        <div class="col-md-12">
	                                            <div class="input-icon">
	                                                <i class="fa fa-calendar"></i>
	                                                <input type="text" class="form-control todo-taskbody-due" placeholder="Due Date..."> </div>
	                                        </div>
	                                    </div>
	                                    <!-- TASK TAGS -->
	                                    <div class="form-group">
	                                        <div class="col-md-12">
	                                            <select class="form-control todo-taskbody-tags">
	                                                <option value="Pending">Pending</option>
	                                                <option value="Completed">Completed</option>
	                                                <option value="Testing">Testing</option>
	                                                <option value="Approved">Approved</option>
	                                                <option value="Rejected">Rejected</option>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <!-- TASK TAGS -->
	                                    <div>
		                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		                                    <div class="row fileupload-buttonbar">
		                                        <div class="col-lg-7">
		                                            <!-- The fileinput-button span is used to style the file input field as button -->
		                                            <span class="btn green fileinput-button">
		                                                <i class="fa fa-plus"></i>
		                                                <span> Add files... </span>
		                                                <input type="file" name="files[]" multiple=""> </span>
		                                            <button type="submit" class="btn blue start">
		                                                <i class="fa fa-upload"></i>
		                                                <span> Start upload </span>
		                                            </button>
		                                            <button type="reset" class="btn warning cancel">
		                                                <i class="fa fa-ban-circle"></i>
		                                                <span> Cancel upload </span>
		                                            </button>
		                                            <button type="button" class="btn red delete">
		                                                <i class="fa fa-trash"></i>
		                                                <span> Delete </span>
		                                            </button>
		                                            <input type="checkbox" class="toggle">
		                                            <!-- The global file processing state -->
		                                            <span class="fileupload-process"> </span>
		                                        </div>
		                                        <!-- The global progress information -->
		                                        <div class="col-lg-5 fileupload-progress fade">
		                                            <!-- The global progress bar -->
		                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
		                                                <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
		                                            </div>
		                                            <!-- The extended global progress information -->
		                                            <div class="progress-extended"> &nbsp; </div>
		                                        </div>
		                                    </div>
		                                    <!-- The table listing the files available for upload/download -->
		                                    <table role="presentation" class="table table-striped clearfix">
		                                        <tbody class="files"> </tbody>
		                                    </table>
		                                </div>
		                                <div class="panel panel-success">
		                                    <div class="panel-heading">
		                                        <h3 class="panel-title">Notes</h3>
		                                    </div>
		                                    <div class="panel-body">
		                                        <ul>
		                                            <li>The maximum file size for uploads in this demo is 999 KB (default file size is unlimited).</li>
		                                        </ul>
		                                    </div>
		                                </div>
	                                    
	                                    <div class="form-actions right todo-form-actions">
	                                        <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
	                                        <button class="btn btn-circle btn-sm btn-default">Cancel</button>
	                                    </div>
	                                </form>
	                            </div>
                            </div>
                        </div>
                        <!-- The blueimp Gallery widget -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                            <div class="slides"> </div>
                            <h3 class="title"></h3>
                            <a class="prev"> ‹ </a>
                            <a class="next"> › </a>
                            <a class="close white"> </a>
                            <a class="play-pause"> </a>
                            <ol class="indicator"> </ol>
                        </div>
                        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
                        <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                            <tr class="template-upload fade">
                                <td>
                                    <span class="preview"></span>
                                </td>
                                <td>
                                    <p class="name">{%=file.name%}</p>
                                    <strong class="error label label-danger"></strong>
                                </td>
                                <td>
                                    <p class="size">Processing...</p>
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                </td>
                                <td> {% if (!i && !o.options.autoUpload) { %}
                                    <button class="btn blue start" disabled>
                                        <i class="fa fa-upload"></i>
                                        <span>Start</span>
                                    </button> {% } %} {% if (!i) { %}
                                    <button class="btn red cancel">
                                        <i class="fa fa-ban"></i>
                                        <span>Cancel</span>
                                    </button> {% } %} </td>
                            </tr> {% } %} </script>
                        <!-- The template to display files available for download -->
                        <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                            <tr class="template-download fade">
                                <td>
                                    <span class="preview"> {% if (file.thumbnailUrl) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                                            <img src="{%=file.thumbnailUrl%}">
                                        </a> {% } %} </span>
                                </td>
                                <td>
                                    <p class="name"> {% if (file.url) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
                                        <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
                                    <div>
                                        <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
                                <td>
                                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                </td>
                                <td> {% if (file.deleteUrl) { %}
                                    <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                                        <i class="fa fa-trash-o"></i>
                                        <span>Delete</span>
                                    </button>
                                    <input type="checkbox" name="delete" value="1" class="toggle"> {% } else { %}
                                    <button class="btn yellow cancel btn-sm">
                                        <i class="fa fa-ban"></i>
                                        <span>Cancel</span>
                                    </button> {% } %} </td>
                            </tr> {% } %} </script>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include 'inc/footer.php'; ?>
            <!-- END FOOTER -->
        
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/pages/scripts/form-fileupload.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>