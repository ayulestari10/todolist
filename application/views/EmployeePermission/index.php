<?php 
    // checkInput($list_of_data);
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


<!-- BEGIN FILTER  -->
<div class="portlet-title">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-search"></i>Search
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" id="btnCollapseExpand"> </a>
            </div>
        </div>
        <div class="portlet-body " id="SearchForm">
            <form role="form" method="POST" autocomplete="off">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="bold">Date</label>
                            <input class="form-control date-picker edited" size="16" type="text"  id="DATE" value="<?= (isset($filter["DATE"]))? $filter["DATE"] : date('d-m-Y') ?>" name="DATE"  maxlength="10">
                        </div>
                    </div>
                     <div class="col-md-3">
                        <label class="bold">Employee Code</label>
                        <div class="input-group input-group-sm col-md-12" >
                            <input type="hidden" class="form-control " readonly="" name="EMPLOYEE_CODE" id="EMPLOYEE_CODE" value="<?= isset($filter["EMPLOYEE_CODE"])? $filter["EMPLOYEE_CODE"] : "" ?>" required="">
                            <input readonly class="form-control edited" type="text" id="NAME" name="NAME"  value="<?= (isset($filter["NAME"]))? $filter["NAME"] : "" ?>" href="#popup_employee_code" data-toggle="modal" required>
                            <span class="input-group-addon span_employee"><i class="i_employee fa fa-eraser font-red"></i></span>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-1">
                         <div class="form-actions noborder">
                            <input type="submit" name="btnSearch" value="Search" class="btn blue">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END FILTER  -->

<!-- BEGIN TABLE PORTLET-->
<div class="portlet-title">
    <div class="portlet box blue">
        <div class="portlet-title">
        </div>
        <div class="portlet-body" >
            <style type="text/css">
            	table tr td{
            		white-space: nowrap !important;
            	}
            </style>
            <table class="table table-striped table-bordered table-hover order-column datatable_button2" id="data_list_UserReference1" >
                <thead>
                  <tr>
                    <th class="center" width="5%">No</th>
                    <th class="center" width="10%">ID</th>
                    <th class="center" width="10%">Employee Code</th>
                    <th class="center" width="25%">Name</th>
                    <th class="center" width="10%">Permission</th>
                    <th class="center" width="10%">Type</th>
                    <th class="center" width="10%">Start Date</th>
                    <th class="center" width="10%">End Date</th>
                    <th class="center" width="10%">Time</th>
                    <th class="center" width="10%">Files</th>
                    <!-- <th class="center" width="5%">Description</th> -->
                    <th class="center">-</th>
                  </tr>
                </thead>
                <tbody>
        			<?php
        				$rownum = 1;
                        
        				if($list_of_data != null && count($list_of_data) > 0)
        				{
        					foreach ($list_of_data as $data) 
        					{
        						?>
        							<tr id="_row_<?php echo $rownum ?>" class='row_table_data_list'>
        								<td class="center"> <?php echo $rownum++; ?></td>
                                        <td class=""> <?=$data["ID"]; ?></td>
                                        <td class=""> <?=$data["EMPLOYEE_CODE"]; ?></td>
                                        <td class=""> <?=$data["EMPLOYEE_NAME"]; ?></td>
                                        <td class=""> <?=$data["PERMISSION_NAME"]; ?></td>
                                        <td class=""> <?= (isNotNullAndEmpty($data["NAME_PT"])? $data["NAME_PT"] : "-"); ?></td>
                                        <td><?= dateInputFormat3($data["START_DATE"]) ?></td>
                                        <td><?= dateInputFormat3($data["END_DATE"]) ?></td>
                                        <td class="center"> <?=isNotNullAndEmpty($data["TIME"])? dateTimeFormat("H:i:s", $data["TIME"])  : "-" ?></td>
                                        <td class="center">
                                            <?php if(file_exists('upload_path/EmployeePermission/'.$data["FILES"])): ?>
                                                <a href="<?php echo base_url()?>upload_path/EmployeePermission/<?= $data["FILES"] ?>" target="_blank">
                                                    <?php  
                                                        $filename = explode('_', $data["FILES"]);
                                                        $rep1     = str_replace($filename[0], '', $data["FILES"]);
                                                        echo str_replace('_', ' ', $rep1);
                                                    ?>
                                                </a>
                                            <?php 
                                                else: 
                                                    echo '-';
                                                endif; ?>
                                        </td>
        								<td class="center">
                                            <a href="<?=base_url()?>EmployeePermission/edit?ID=<?=$data["ID"]?>" class="btn btn-xs blue">Edit</a>
                                            <a href="<?=base_url()?>EmployeePermission/delete?ID=<?=$data["ID"]?>" class="btn btn-xs red" onclick="return confirm('Are You Sure Want to Delete This Data?')">Delete</a>
                                        </td>
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
<div class="row">
    <div class="col-md-12">
        <a href="<?=base_url()?>EmployeePermission/create" class="btn blue">Create</a>
        <a href="<?=base_url()?>EmployeePermission/import" class="btn Green">Import</a>
    </div>
</div>
<!-- END TABLE PORTLET-->


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
                      <button class="btn btn-xs green-jungle select_employee" onclick="jQuery('#EMPLOYEE_CODE').val('<?php echo $data["EMPLOYEE_CODE"];  ?>'); jQuery('#NAME').val('<?= str_replace("'", "", $data["NAME"]) ?>'); jQuery('#NIK').val('<?php echo $data["NIK"];  ?>');" data-dismiss="modal" >Select</button>
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

<!-- BEGIN JQUERY SECTION -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        TableDatatablesResponsive.init();

        $(".i_employee").click(function(){
            $("#NAME").val("");
            $("#EMPLOYEE_CODE").val("");
        });
    });
</script>