<!-- <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule</h4>
    </div>
    <div class="modal-body">
        <div class="row clearfix">
            <label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
            <div class="fileUpload blue-btn btn width100">
                <span><i class="fa fa-cloud-upload"></i> Upload Image</span>
                <input type="file" class="uploadlogo" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()" />
            </div>
            <label class="control-label" style="color:#000;"><a href="<?php //echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a></label>
        </div>
        <div class="row clearfix">
            <div class="col-md-12"> -->
                <table class="view_table addschedule">
                    <thead>
                        <tr>
                            <th style="text-align: center;vertical-align: middle;" width="60">Sr. No.</th>
                            <th style="text-align: center;vertical-align: middle;">Type</th>
                            <th style="text-align: center;vertical-align: middle;">Event</th>
                            <th style="text-align: center;vertical-align: middle;" width="120">Date</th>
                            <th style="text-align: center;vertical-align: middle;" width="130">Cost (In &#x20B9;)</th>
                            <th style="text-align: center;vertical-align: middle;" width="200">Tax(%)</th>
                        </tr>
                    </thead>
                    <tbody id="schedule_table">
                        <?php $k=1; $i=2; $schedule_id=1;
                        if(isset($p_schedule)){
                            foreach($p_schedule as $row){
                                //$sch_id=$p_schedule[$i]['schedule_id'];
                                $event_type=$p_schedule[$i]['event_type'];
                                $event_name=$p_schedule[$i]['event_name'];
                                $basic_cost=$p_schedule[$i]['basic_cost'];
                                $event_date=$p_schedule[$i]['event_date'];
                                $tax_master=array();
                                $j=0;
                                if(isset($p_schedule[$i]['tax_type'])){
                                    for($j=0;$j<count($p_schedule[$i]['tax_type']);$j++ ){
                                        //$p_schedule[$i]['tax_id'][$j];
                                        $tax_master[]=$p_schedule[$i]['tax_type'][$j];
                                    }
                                }   ?>

                                <tr id="repeat_schedule_<?php echo $k; ?>"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle"><?php echo $k; ?></td>
                                <input type="hidden" name="sch_id[]" class="form-control" value="<?php //echo $sch_id;?>" style="border:none;"/>
                                <td><input type="text" name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
                                <td><input type="text" name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
                                <!-- <td><input type="text" name="sch_pay_type[]" class="form-control" value="<?php //echo $p_schedule[$i]['sch_pay_type'];?>" style="border:none; text-align:left;"/></td>
                                <td><input type="radio" name="sch_agree_value[0]" id="sch_agree_yes_1" value="yes" <?php //if(($p_schedule[$i]['sch_agree_value'])=='yes'){echo 'checked';}?> >Yes &nbsp;&nbsp;<input type="radio" name="sch_agree_value[0]" id="sch_agree_no_1" value="no"  <?php //if(($p_schedule[$i]['sch_agree_value'])=='no'){ echo 'checked';}?>>No</td> -->
                                <td><input type="text" name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none; text-align:left; background:#ffffff; color:rgb(44, 44, 44)!important;"/></td>
                                <td><input type="text" name="sch_basiccost[]" value="<?php echo $basic_cost;?>" class="form-control format_number sch_basiccost" style="border:none; text-align:right;"/></td>
                                <td>
                                    <!-- <select name="sch_tax_<?php //echo $schedule_id;?>[]" multiple class="form-control full-width select2" data-placeholder="Select Tax" data-init-plugin="select2"> -->
                                    <select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="full-width select3" data-placeholder="Select Tax" data-init-plugin="select2">
                                    <?php $schedule_id++;
                                    if(isset($tax_details)){
                                        //print_r($tax_id);
                                        foreach($tax_details as $row){
                                            if(in_array($row->tax_name, $tax_master)){
                                                //echo "hi";
                                                $selected="selected='selected'";
                                            }
                                            else{
                                                $selected='';
                                            }
                                            echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                        }
                                    };?>
                                    </select>
                                </td>
                                </tr>
                        <?php $i++; 
                                $k++;
                            }   
                        } ?>                                                    
                    </tbody>
                </table>
            <!-- </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success repeat-schedule" id="schedule_btn" style=" ">+</button>
        <button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
        <button class="btn btn-default-danger pull-right mb-control-close" onclick="closetemp(); return false;">Close</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
    </div>
    </div>
</div>