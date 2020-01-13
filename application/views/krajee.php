<!DOCTYPE html>
<!-- release v5.0.2, copyright 2014 - 2019 Kartik Visweswaran -->
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Krajee JQuery Plugins - &copy; Kartik</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/explorer/theme.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container my-4">
    
    <form enctype="multipart/form-data" method="POST">
      
        <div class="form-group">
            <div class="file-loading">
                <input id="file-1" type="file" multiple class="file" name="file[]">
                <input type="hidden" value="1" name="id">
            </div>
        </div>
       
    </form>

</div>
</body>
<script>
  
   $("#file-1").fileinput({
        theme: 'fas',
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        uploadUrl:  "<?php echo base_url('Project_controller/krajee_upload/2')?>",
        uploadAsync: false,
        overwriteInitial: false,
        minFileCount: 1,
        maxFileCount: 5,
        initialPreview: [
            "http://lorempixel.com/800/460/people/1",
            "http://lorempixel.com/800/460/people/2"
        ],
        initialPreviewAsData: true // identify if you are sending preview data only and not the markup
    });
</script>
</html>