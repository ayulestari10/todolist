<?php 
	if(isNotNullAndGreaterThanZero(getErrMsg())){
        ?>
        <div class="portlet-body">
            <div class="alert alert-danger">
                <ul>
                    <?php 
                        foreach (getErrMsg() as $err) {
                            echo "<li>".$err."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php 
	}
?> 
<?php 
	if(isNotNullAndGreaterThanZero(getSuccessMsg())){
        ?>
        <div class="portlet-body">
            <div class="alert alert-success">
                <ul>
                    <?php 
                        foreach (getSuccessMsg() as $msg) {
                            echo "<li>".$msg."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php 
	}
?>
<form method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden"  id="ID" name="ID" value="<?=$objData["ID"] ?>">
    <div class="portlet-body">
        <div class="form-body" id="bodyForm">
        	<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                            $readonly_edit_mode = "";
                            if(isset($edit_mode) && $edit_mode){
                                $readonly_edit_mode = "readonly";
                            }
                        ?>
                        <label class="bold">Employee Code <span class="font-red">*</span> </label>
                        <div class="input-group input-group-sm col-md-12" >
                            <?php if(isset($edit_mode)): ?>
                              <div class="input-group input-group-sm col-md-12" >
                                    <input type="hidden" class="form-control " readonly="" name="EMPLOYEE_CODE" id="EMPLOYEE_CODE" value="<?=$objData["EMPLOYEE_CODE"]?>" required=""> 
                                    <input class="form-control edited" type="text" id="EMPLOYEE_NAME" name="EMPLOYEE_NAME"  value="<?= (isset($objData["EMPLOYEE_NAME"]))? $objData["EMPLOYEE_NAME"] : "" ?>" readonly>
                              </div>
                            <?php else: ?>
                              <div class="input-group input-group-sm col-md-12" >
                                    <input type="hidden" class="form-control " readonly="" name="EMPLOYEE_CODE" id="EMPLOYEE_CODE" value="<?=$objData["EMPLOYEE_CODE"]?>" required=""> 

                                    <input class="form-control edited" type="text" id="EMPLOYEE_NAME" name="EMPLOYEE_NAME"  value="<?= (isset($objData["EMPLOYEE_NAME"]))? $objData["EMPLOYEE_NAME"] : "" ?>" href="#popup_employee_code" data-toggle="modal" readonly>
                                    <span class="input-group-addon" href="#popup_employee_code" data-toggle="modal" ><i class="fa fa-search font-green"></i></span>
                              </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
          	</div>
            <div class="row">
                <div class="col-md-2">  
                    <div class="form-group">
                        <label class="bold">Start Date <span class="font-red">*</span></label>
                        <input class="form-control date-picker edited" size="16" type="text"  id="START_DATE" name="START_DATE" value="<?= (isNotNullAndEmpty($objData["START_DATE"]))? $objData["START_DATE"] : date('d-m-Y') ?>"  maxlength="10" />
                    </div>
                </div>
                <div class="col-md-2">  
                    <div class="form-group">
                        <label class="bold">End Date <span class="font-red">*</span></label>
                        <input class="form-control date-picker edited" size="16" type="text"  id="END_DATE" name="END_DATE" value="<?= (isNotNullAndEmpty($objData["END_DATE"])) ? $objData["END_DATE"] : date('d-m-Y') ?>"  maxlength="10" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="PERMISSION_CODE"  class="bold">Permission <span class="font-red">*</span></label>
                        <select class="form-control" id="PERMISSION_CODE" name="PERMISSION_CODE">
                            <?php $permission = isNotNullAndEmpty($filter["PERMISSION_CODE"])? $filter["PERMISSION_CODE"] : $objData["PERMISSION_CODE"] ?>
                            <?= generateComboFromArray($Combo_permission, $permission)?>
                        </select>

                        <input type="hidden" name="STATUS" id="STATUS">
                    </div>
                </div>
            </div>
            <div class="row" id="TIME_DIV">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="TIME"  class="bold">Time</label>
                        <input type="text" name="TIME" class="form-control timepicker-24 edited" id="TIME" value="<?= (isNotNullAndEmpty($objData["TIME"])) ? $objData["TIME"] : '' ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="FILES"  class="bold">Upload Files</label><br>
                        <span class="font-red" style="font-size: 12px;"> Format file Must be pdf/jpeg/jpg/png</span>
                        <?php if($objData["FILES"]): ?>
                            <?php if(file_exists('upload_path/EmployeePermission/'.$objData["FILES"])): ?>
                                <br>
                                <a href="<?php echo base_url()?>upload_path/EmployeePermission/<?= $objData["FILES"] ?>" target="_blank">
                                    <?php  
                                        $filename = explode('_', $objData["FILES"]);
                                        $rep1     = str_replace($filename[0], '', $objData["FILES"]);
                                        echo str_replace('_', ' ', $rep1);
                                    ?>
                                </a>
                                <br><br>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="file" name="FILES" accept=".pdf, image/png, image/jpg, image/jpeg"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="DESCRIPTION"  class="bold">Description</label>
                        <textarea class="form-control edited" rows="6" id="DESCRIPTION" name="DESCRIPTION" maxlength="4000"><?php echo $objData['DESCRIPTION'] ?></textarea>
                    </div>
                </div>
            </div>
          	<hr>
           	<div class="row">
                <div class="col-md-6">  
                    <div class="form-group">
                        <div class="form-group">
                            <input type="submit" name="Submit" class="btn blue" value="Submit" id="Submit">    
                            <a href="<?php echo base_url()?>EmployeePermission" class="btn red">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- BEGIN MODAL POPUP employee_code -->
<div class="modal fade" id="popup_employee_code" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 90%; ">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" >Popup Employee Code</h4>
      </div>
      <div class="modal-body">                 
        <div class="portlet-body">
          <div class="portlet box blue-steel">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-list"></i>Employee Code List</div>
              <div class="tools"> </div>
            </div>
            <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover order-column datatable_basic" id="data_list_gudang">
                <thead>
                  <tr>
                    <th class="center" width="5%">Act</th>
                    <th class="center" width="5%">No</th>
                    <th class="center" width="15%">Employee Code</th>
                    <th class="center" width="15%">NIK</th>
                    <th class="center">Name</th>
                    <th class="center" width="15%">Org.</th>
                    <th class="center" width="15%">Pers Area Name</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      $rownum = 1;
                      if($popup_employee_code != null && count($popup_employee_code) > 0){
                        foreach ($popup_employee_code as $data) {
                    ?>
                  <tr>
                    <td class="center" style="white-space:nowrap !important">
                      <button class="btn btn-xs green-jungle" onclick="jQuery('#EMPLOYEE_CODE').val('<?php echo $data["EMPLOYEE_CODE"];  ?>'); jQuery('#EMPLOYEE_NAME').val('<?php echo $data["NAME"];  ?>'); jQuery('#NIK').val('<?php echo $data["NIK"];  ?>');" data-dismiss="modal" >Select</button>
                    </td>
                    <td class="center"> <?php echo $rownum++ ?> </td>
                    <td> <?php echo ($data["EMPLOYEE_CODE"] != null && $data["EMPLOYEE_CODE"] != "" ? $data["EMPLOYEE_CODE"]: "&nbsp;")?></td>
                    <td> <?php echo ($data["NIK"] != null && $data["NIK"] != "" ? $data["NIK"]: "&nbsp;")?></td>
                    <td> <?php echo ($data["NAME"] != null && $data["NAME"] != "" ? $data["NAME"]: "&nbsp;")?></td>
                    <td> <?php echo ($data["ORG"] != null && $data["ORG"] != "" ? $data["ORG"]: "&nbsp;")?></td>
                    <td> <?php echo ($data["PERS_AREA_NAME"] != null && $data["PERS_AREA_NAME"] != "" ? $data["PERS_AREA_NAME"]: "&nbsp;")?></td>
                  </tr>
                    <?php
                        }
                      }
                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL POPUP employee_code -->

<script type="text/javascript">
    jQuery(document).ready(function(){
        //activator datatable
        TableDatatablesResponsive.init();
        ComponentsDateTimePickers.init();

        $("#TIME_DIV").hide();

        var code = $("#PERMISSION_CODE").val();

        $.ajax(
        {
           url: "<?php echo base_url();?>Ajax/getPermission",
           type: "POST",
           data : {code: code},                   
           success: function (ajaxData)
           {
                var result = JSON.parse(ajaxData);
                
                if(result["TIME_INPUT"] == "1"){
                    $("#TIME_DIV").show();
                }
                else{
                    $("#TIME_DIV").hide();
                }
                
            },
            error: function(status)
            {
                $("#TIME_DIV").hide();
            }
        });

        $("#PERMISSION_CODE").on('change', function() {
            var code = $("#PERMISSION_CODE").val();
            console.log(code);
            $.ajax(
            {
               url: "<?php echo base_url();?>Ajax/getPermission",
               type: "POST",
               data : {code: code},                   
               success: function (ajaxData)
               {
                    var result = JSON.parse(ajaxData);
                    if(result["TIME_INPUT"] == "1"){
                        $("#TIME_DIV").show();
                    }
                    else{
                        $("#TIME_DIV").hide();
                    }
                },
                error: function(status)
                {
                    $("#TIME_DIV").hide();
                }
            });
        });

    })
</script>