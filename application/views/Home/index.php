<?php 
	if(isset($_SESSION["err_msg"]) && $_SESSION["err_msg"] != null && count($_SESSION["err_msg"]) > 0){
        ?>
        <div class="portlet-body">
            <div class="alert alert-danger">
                <ul>
                    <?php 
                        foreach ($_SESSION["err_msg"] as $err) {
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
	if(isset($_SESSION["success_msg"]) && $_SESSION["success_msg"] != null && count($_SESSION["success_msg"]) > 0){
        ?>
        <div class="portlet-body">
            <div class="alert alert-success">
                <ul>
                    <?php 
                        foreach ($_SESSION["success_msg"] as $msg) {
                            echo "<li>".$msg."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php 
	}
?>

<div class="portlet-body">
	<h4 class=" font-Blue"><b>Hello <span class="font-yellow-gold"><?=userInformation()["GEN_NAME"]?></span> .</b><br></h4>
	<h4 class=" font-Blue"><b>Welcome to Application <span class="font-red"><?=APP_NAME?></span> PT Semen Baturaja (Persero) Tbk.</b><br></h4>
</div>

<div class="portlet-body">
    <ul style="list-style: none; list-style-type: none; padding: 0;">
        <?php  
            switch (userInformation()["GEN_GROUP"]) {
                case 'WMS_01':
                    echo '<li><a target="_blank" href="' . base_url('assets/__download__/Panduan WMS Buat transaksi Baru.pdf') . '"><h4 class="font-green"><b><u>Lihat Panduan Aplikasi WMS</u></b></h4></a></li>';
                    echo '<li><a target="_blank" href="' . base_url('assets/__download__/Panduan Penggunaan Aplikasi SMART.pdf') . '"><h4 class="font-green"><b><u>Lihat Panduan Aplikasi SMART</u></b></h4></a></li>';
                    break;

                case 'WMS_02':
                    echo '<li><a target="_blank" href="#"><h4 class="font-green"><b><u>Lihat Panduan Aplikasi WMS</u></b></h4></a></li>';
                    break;
            }
        ?>
    </ul>
</div>