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
<form method="POST" enctype="multipart/form-data">
    <div class="portlet-body">
        <div class="form-body">
        	<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="">
                        	<label for="MY_FILES"  class="bold">Files </label>
                            <input type="file" name="MY_FILES" id="MY_FILES" class="form-control" accept="application/vnd.ms-excel">
                        </div>
                    </div>
                </div>
          	</div>
          	<hr>
           	<div class="row">
                <div class="col-md-6">  
                    <div class="form-group">
                        <div class="form-group">
                            <input type="submit" name="Submit" class="btn blue" value="Submit" id="Submit">    
                            <a href="<?php echo base_url()?>assets/__download__/TEMPLATE_EMPLOYEE_PERMISSION.xls" class="btn green">Template</a>
                            <a href="<?php echo base_url()?>EmployeePermission" class="btn red">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>