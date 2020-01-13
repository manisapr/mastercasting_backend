<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Teko|Poppins:300,400,500,600,700,900" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:900&display=swap" rel="stylesheet">

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
         font-weight: 400;
         line-height: normal;
         color: #000;
         font-size: 16px;
         font-family: 'Oswald', sans-serif;
         background: #fff;
        } 

        table, th, td {
          border: 0;
          border-collapse: collapse;
        }
        #main{
            width: 100%;
            padding: 0 10px;
        }
       /* b{
            font-family: 'Montserrat', sans-serif;
        }*/
        .first_row h2{
            margin-top: 5px;
        }
        .img{
            border: 1px solid grey;
            padding: 5px;
            border-radius: 3px;
        }
        .valcalu {
          color: #1BBC9B!important;
          font-weight: bolder!important;
        }
    </style>
</head>
<body>
    <table id="main">
        <tr>
            <td style="width: 45%">
                <table style="width: 100%">
                    <?php if ($project_details->estimated_approve == 1) : ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #1BBC9B!important;"><h2>Approved</h2></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><img width="150" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/assets/admin/images/logo1.png' ?>" alt=""></td>
                        <td colspan="2"> <h2 style="font-weight: bold; font-size: 24px;color: #bb1d50;"><b>Priority: <?php echo ucwords($project_details->priority) ?></b></h2></td>
                        <td></td>
                        <td colspan="1"><h2 style="font-size: 24px;color: #bb1d50"><b><?php echo $project_details->deadline != '0000-00-00' ? date('m-d', strtotime($project_details->deadline)) : 'NA' ?></b></h2></td>
                    </tr>
                    <tr class="first_row">
                        <td style=""><h2>Job id</h2><span class="valcalu">J-<?php echo $project->project_id ?></span></td>
                        <td style=""><h2>SalesRep</h2><span class="valcalu">
                            <?php
                            if ($project->asign_user != 0) :
                                $rep = $this->db->get_where('user', ['id' => $project->asign_user])->row()->representative;
                                echo $rep != '' ? $this->db->get_where('user', ['id' => $rep])->row()->name : '';
                            else :
                                echo "";
                            endif;
                            ?>
                        </span></td>
                        <td style=""><h2>Assignee</h2><span class="valcalu">
                            <?php
                            if ($project_details->assignee != '') :
                                $assignee = explode(',', $project_details->assignee);
                                foreach ($assignee as $key) {
                                    echo $this->db->get_where('user', ['id' => $key])->row()->name.' , ';
                                }
                            else :
                                echo "No Assignee";
                            endif;
                            ?>
                        </span></td>
                        <td style=""><h2>Created</h2><span class="valcalu"><?php echo date('m-d-Y', strtotime($project_details->created_at)) ?></span></td>
                        <td style=""><h2>Deadline</h2><span class="valcalu"><?php echo $project_details->deadline != '0000-00-00' ? date('m-d', strtotime($project_details->deadline)) : 'No deadline' ?></span></td>
                    </tr>
                    <tr class="first_row">
                        <td><h2>Client id</h2>
                            <span class="valcalu">
                                <?php
                                if ($project->asign_user != 0) :
                                    echo "C".$this->db->get_where('user', ['id' => $project->asign_user])->row()->dynamic_id;
                                endif;
                                ?>
                                
                            </span>
                        </td>
                        <td><h2>Client</h2>
                            <?php if (!$vendor) : ?>
                            <span class="valcalu">
                                <?php
                                if ($project->asign_user != 0) {
                                    $user = $this->db->get_where('user', ['id' => $project->asign_user])->row();
                                    if ($user->designation_id != 7) {
                                        echo $user->name;
                                    } else {
                                        echo $user->company_name.' ('.$user->name.')';
                                    }
                                }
                                ?>
                            </span>
                            <?php else : ?>
                            <span class="valcalu">Vendor Copy</span>
                            <?php endif; ?>
                        </td>
                        <td></td>
                        <td></td>
                        <?php if (count($project_files) > 0) : ?>
                        <td>
                            <img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="100">
                        </td>
                        <?php endif; ?>
                        <!-- <td><h2>Client Rep</h2><span>Sudipta Jana</span></td> -->
                        <!-- <td><h2>Trade</h2></td> -->
                    </tr>
                    <tr class="first_row">
                        <!-- <?php //if($project_details->estimated_price != 0): ?> -->
                        <?php if (!$vendor) : ?>
                        <td colspan="2"><h2 style="display: inline-block;">Price: <span class="valcalu">$<?php echo $project_details->price ?></span></h2> <br><h2 style="display: inline-block;"> <span class="valcalu"><?php echo $project_details->price_type ?></span></h2></td>
                        <?php endif; ?>
                        <!-- <?php //endif; ?> -->
                        
                        <td colspan="2"><h2 style="display: inline-block;">Po#: </h2> 
                            <?php if(strlen($project_details->po) > 10): ?>
                            <h3>
                                <span class="valcalu"><?php echo wordwrap($project_details->po,10,"<br>\n"); ?></span>
                            </h3>
                            <?php else: ?>
                                <span class="valcalu"><?php echo wordwrap($project_details->po,10,"<br>\n"); ?></span>
                            <?php endif; ?>
                        </td>
                        <td colspan="1" style="text-align: center;"><h2 style="display: inline-block;">Qty: </h2> <h2 style="display: inline-block;"><span class="valcalu"><?php echo $project_details->quantity ?></span></h2></td>
                    </tr>
                    <tr class="first_row">
                        <td colspan="2">
                            <h2>Specification:</h2>
                            <h4><span>Finish :</span> <span></span> <span style="margin:0;" class="valcalu"><?php echo $project_specification->finish ?></span></h4>
                            <h4><span>Purity / Color / Metal :</span> <span class="valcalu"><?php echo $project_specification->purity ?></span></h4>
                            <h4><span>Plating :</span> <span class="valcalu"><?php echo $project_specification->plating ?></span></h4>
                            <h4><span>Ring Size :</span> <span class="valcalu"><?php echo $project_specification->ring_size ?></span></h4>
                            <h4><span>Custom :</span> <span class="valcalu"><?php echo $project_specification->custom ?></span></h4>
                        </td>
                        <td colspan="3">
                            <!-- <?php if (count($project_files) == 1) : ?>
                            <h2>Thumbnail File</h2>
                            <img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="100">
                            <img class="img" src="<?php echo base_url('/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name) ?>" alt="" width="100">
                                 <?php endif; ?> -->
                            <h2>Extra Specification:</h2>
                            <h4>
                                <span>Wax Only :</span> <span></span> <span class="valcalu"><?php echo $project_specification->wax_only ?></span> / 
                                <span>Casting Only :</span> <span class="valcalu"><?php echo $project_specification->casting_only ?></span>
                            </h4>
                            <h4><span>Mold :</span> <span class="valcalu"><?php echo $project_specification->mold ?></span></h4>
                            <h4>
                                <span>Supply Diamonds :</span> <span class="valcalu"><?php echo $project_specification->supply_diamonds ?></span> / 
                                <span>Supply Center :</span> <span class="valcalu"><?php echo $project_specification->supply_center ?></span>
                            </h4>
                            <h4><span>Supply All Gems :</span> <span class="valcalu"><?php echo $project_specification->supply_all_gems ?> <?php $project_specification->supply_all_gems == 'Yes' ? '-' : '' ?> <?php echo $project_specification->supply_all_gems_yes ?></span></h4>
                            <h4><span>Sending my own :</span> <span class="valcalu"><?php echo $project_specification->sending_my_own ?></span></h4>
                        </td>
                    </tr>
                    <tr class="first_row" style="text-align:left;">
                        <!-- <td colspan="2" style="padding-top: 20px;"><img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="200"></td>
                        <td colspan="2" style="padding-top: 20px;"><img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="200"></td> -->
                        <td colspan="5">
                            <h2>Description</h2>
                            <p class="valcalu" style="text-align: justify;"><b><?php echo $project_details->title ?></b></p>
                            <p class="valcalu" style="text-align: justify;"><?php  echo $first_string = word_limiter($project_details->description, 80, ''); ?></p>
                            
                        </td>
                    </tr>
                    <tr class="first_row" style="text-align:center;">
                        <td colspan="5">
                            <h2><?php echo $project_specification->purity ?></h2>
                        </td>
                    </tr>
                    <tr class="first_row" style="text-align:center;">
                        <td  valign="bottom" colspan="5" style="color: #bb1d50; font-weight: bold; font-size: 15px;">
                            <?php if (strlen($first_string) < 500) {
                                    $margin = 25;
                            } else {
                                $margin = 25;
                            }
                            ?>
                            <?php if($project_ship->shipping_type == 'drop_ship'): ?>
                            <p style="margin-top: 15px; color: #337ab7">Customer - <?php echo $project_ship->customer_name ?>, Country - <?php echo $project_ship->country ?></p>
                            <?php endif; ?>
                            <p style="margin-top: 10px;">312-332-4434 - www.mastercastingandcad.com - 5 South Wabash Ave. Suite 717 Chicago, IL 60603</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%"></td>
            <td  style="width: 45%" valign="top">
                <table  style="width: 100%">
                    <?php $rest_string = trim(str_replace($first_string, "", $project_details->description));
                    $second_string = word_limiter($rest_string, 100, '');
                    ?>
                    <?php if ($second_string != '') : ?>
                    <tr>
                        <td colspan="2" style="padding-bottom: 10px">
                            <h2>Description</h2>
                            <p class="valcalu" style="text-align: justify;"><?php echo $second_string ?></p>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if (count($project_files) == 1) : ?>
                    <tr colspan="2" style="text-align: center; padding-top: 10px">
                        <td>
                            <h2>Thumbnail File</h2>
                            <img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="400">
                        </td>
                    </tr>

                    <?php elseif (count($project_files) > 1) : ?>
                    <tr colspan="2" style="text-align: center; padding-top: 10px">
                        <?php //$i = 0; foreach ($project_files as $key): ?>
                        <?php //if($i < 2): ?>
                        <td>
                            <h2>Thumbnail File</h2>
                            <img class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[0]->file_name ?>" alt="" width="400"><br>
                        </td>
                        <?php //endif; ?>
                        <?php //$i++; endforeach; ?>
                    </tr>
                    <tr colspan="2" style="text-align: center;">
                        <td>
                            <img style="margin-top: 5px" class="img" src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/mastercasting_backend/uploads/thumbnail/'.$project_files[1]->file_name ?>" alt="" width="400"><br>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
        <?php $third_string = trim(str_replace($second_string, "", $rest_string)); ?>
        <?php if ($third_string != '') : ?>
        <tr>
            <td colspan="3">
                <h2>Description</h2>
                <p class="valcalu" style="text-align: justify;"><?php echo trim(str_replace($second_string, "", $rest_string));  ?></p>
            </td>
        </tr>
        <?php endif; ?>
    </table>
    
</body>
</html>