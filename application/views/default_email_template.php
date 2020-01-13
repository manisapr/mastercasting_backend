<html>

<head>
    <meta charset="UTF-8">
    <title>Message</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        /*box-sizing: border-box;*/
        font-size: 20px;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }
    p{
        padding: 0 20px;
        font-size: 14px;
    }
    a{
        font-size: 14px;
    }
    p.msg{
        padding: 20px;
    }
    .job_link{
        text-decoration: none;
        background: #ACB5C3;
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 10px;
        color: #FAFCFB;
    }
    </style>
</head>

<body style="margin: 0; padding: 30px 0;font-family: \'Poppins\', sans-serif; font-weight:300; line-height: 1.5;font-size:14px;">
    <div style="display: flex; justify-content: center; align-items: center; height: auto">
        <table class="card" style="width: auto; margin: auto" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table style="width: 100%" cellpadding="0" cellspacing="0" style="padding: 30px 10px;">
                        <tr>
                            <td style="text-align: center;">
                                <a title="Visit Mastercastingandcad" href="<?php echo base_url() ?>"><img src="<?php echo base_url('/assets/admin/images/logo1.png') ?>" width="150" alt="" /></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="padding: 20px 20px 10px 20px; font-size: 20px;"><b>Hello <?php echo isset($name) ? $name : '' ?>,</b></p>
                    <!-- <p style="padding: 0 20px 20px 20px">
                    </p> -->
                    <?php echo $html ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;padding: 20px;font-size: 10px!important;color: #6c757d!important;background-color: rgba(0,0,0,.03);border-top: 1px solid rgba(0,0,0,.125);">
                    <p style="font-size: 12px;">*THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL</p>
                    <p><a title="Visit Mastercastingandcad" style="text-decoration: underline;color: #6c757d!important;font-size: 12px;" href="<?php echo base_url() ?>">mastercastingandcad.com</a></p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>