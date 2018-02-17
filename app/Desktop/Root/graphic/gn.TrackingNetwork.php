<?php
	#Importar constantes.
	include ($_SERVER['DOCUMENT_ROOT']."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/app/core/ic.const.php");

    @session_start();
    @$_SESSION['call'] = "off";

    include (PF_CONNECT_SERVER);
    include (PD_DESKTOP_ROOT_PHP."/gn.ssh.class.php");

    $CN = new ConnectSSH();
    $CN->ConnectDB($H, $U, $P, $D, $X);

    $R = $CN->getAllHost();
?>

<!-- Required .creating-admin-panels wrapper-->
<div class="creating-admin-panels">

    <!-- Create Row -->
    <div class="row">

        <!-- Create Column with required .admin-grid class -->
        <div class="col-md-12 admin-grid">

            <!-- Create Panel with required unique ID -->
            <div class="panel" id="p1">
                <div class="panel-heading">
                    <span class="panel-icon"><i class="fa fa-desktop"></i></span>
                    <span class="panel-title">Autodescubrimiento de dispositivos en Red</span>
                    

                    <div class="container_options_controls" style="position: absolute; top: 0; right: 100px;">
                        <button type="button" class="btn btn-primary ladda-button progress-button" data-style="expand-right">
                            <span class="ladda-label">Tracking Network</span>
                        </button>
                    </div>

                    <input type="button" onclick="javascript: StartTracking();" class="btn_tracking btn btn-warning waves-effect" value="Sondear" />
                </div>
                <div class="panel-body">
                

                    <label style="display: none; position: absolute; right: 50px;" id="retardo_temporal">Retardo de tiempo: 12.45 seg.</label>

                    <div class="here_write">
                        <?php
                            if (@$R->num_rows > 0){
                                include (PD_DESKTOP_ROOT_PHP."/vis/images.php");
                            }
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Column -->

    </div>
    <!-- End Row -->

</div>
<!-- End .admin-panels Wrapper -->

<script type="text/javascript" src="<?php echo PDS_DESKTOP_ROOT_JS; ?>/gn.TrackingNetwork.js"></script>