<?php
    @session_start();

    #Importar constantes.
    include (@$_SESSION['getConsts']);

    include (PF_CONNECT_SERVER);
    include (PF_SSH);
    include (PD_DESKTOP_ROOT_PHP_CLASS."/gn.class.ping.php");

    $CD = new CheckDevice();

    $CN = new ConnectSSH();
    $CN->ConnectDB($H, $U, $P, $D, $X);

    // $R = $CN->getAllHost();
    $R = $CN->getHostWithOutInterfaces();
    $IPNet = $CN->getIPNet();
?>

<link rel="stylesheet" type="text/css" href="<?php echo PDS_DESKTOP_ROOT; ?>/css/vis/style.css">

<div class="mixings-get-devices" id="mixings-get-devices-id" data-example-id="contextual-panels">
    <!-- <hr class="alt short"> -->
    <div id="mix-items" class="mix-container box-wrap boxes blue">

        <section class="box-wrap boxes blue">
        <?php
            if (@$R->num_rows > 0){
                $R_Count = 1;

                while ($SwitchIPNet = @$IPNet->fetch_array(MYSQLI_ASSOC)){
                    /*Switch*/

                    ?>
                        <div class="mix category-3" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block; margin-top: 3px solid #7a7ade;">
                            <img onselectstart="return false" ondragstart="return false" src="<?php echo PDS_DESKTOP_ROOT ?>/src/vis/img/refresh-cl/news/switchs/switchicon1.png" style="margin-left: 25%; height: 130px;" />
                            
                            <?php
                                if (!empty($SwitchIPNet['alias'])){
                                    ?>
                                        <p title="<?php echo $SwitchIPNet['ip_net']; ?>" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $SwitchIPNet['ip_net']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;">
                                            <?php 
                                                echo $CN->getStringFormatSize($SwitchIPNet['alias']);
                                            ?>
                                        </p>
                                    <?php
                                } else {
                                    ?>
                                        <p title="Cambiar nombre" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $SwitchIPNet['ip_net']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;"><?php echo $SwitchIPNet['ip_net']; ?></p>
                                    <?php
                                }
                            ?>
                        </div>
                    <?php

                    ?>
                        <script type="text/javascript">
                            $('#getIdDeviceManagement<?php echo $R_Count; ?>').editable({
                                type: 'text',
                                pk: <?php echo $R_Count; ?>,
                                name: 'getIdDeviceManagement<?php echo $R_Count; ?>',
                                title: 'Editar dispositivo'
                            });

                            $('#getIdDeviceManagement<?php echo $R_Count; ?>').on('save', function(e, params) {
                                ip_addr = $('#getIdDeviceManagement<?php echo $R_Count; ?>').attr("ip_addr");
                                FunctionOnChange(ip_addr, params);
                                
                            });
                        </script>
                    <?php

                    $R_Count++;
                }

                while ($Restore = @$R->fetch_array(MYSQLI_ASSOC)) {
                    if ((bool)$Restore['router']){
                        /*Router*/
                        $IDOrderHost = implode("", explode(".", $Restore['ip_host']));
                        ?>
                            <div class="mix category-2 host<?php echo $IDOrderHost; ?>" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block;">
                                <img onselectstart="return false" ondragstart="return false" src="<?php echo PDS_DESKTOP_ROOT ?>/src/vis/img/refresh-cl/news/routers/router4.png" style="margin-left: 25%; height: 130px;" />
                                
                                <?php
                                    if (!empty($Restore['alias'])){
                                        ?>
                                            <p title="<?php echo $Restore['ip_host']; ?>" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;">
                                                <?php 
                                                    echo $CN->getStringFormatSize($Restore['alias']);
                                                ?>
                                            </p>
                                        <?php
                                    } else {
                                        ?>
                                            <p title="Cambiar nombre" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;"><?php echo $Restore['ip_host']; ?></p>
                                        <?php
                                    }
                                ?>
                            </div>
                        <?php
                    } else {
                        $getMyIPServer = $CN->getMyIPServer();
                        $IDOrderHost = implode("", explode(".", $Restore['ip_host']));

                        if ($getMyIPServer == $Restore['ip_host']){
                            ?>
                                <div class="mix category-4 host<?php echo $IDOrderHost; ?>" oncontextmenu="javascript: recvMixContainer(this)" ip_addr="<?php echo $Restore['ip_host']; ?>" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block;">
                                    <img src="<?php echo PDS_DESKTOP_ROOT ?>/src/vis/img/refresh-cl/news/servers/server1.png" style="margin-left: 16%; height: 130px;" />
                                    
                                    <?php
                                        if (!empty($Restore['alias'])){
                                            ?>
                                                <p title="<?php echo $Restore['ip_host']; ?>" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;">
                                                    
                                                    <?php 
                                                        echo $CN->getStringFormatSize($Restore['alias']);
                                                    ?>

                                                </p>
                                            <?php
                                        } else {
                                            ?>
                                                <p title="Cambiar nombre" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;"><?php echo $Restore['ip_host']; ?></p>
                                            <?php
                                        }
                                    ?>
                                </div>
                            <?php
                        } else {
                            ?>
                                <div class="mix category-1 host<?php echo $IDOrderHost; ?>" oncontextmenu="javascript: recvMixContainer(this)" ip_addr="<?php echo $Restore['ip_host']; ?>" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block;">
                                   <img onselectstart="return false" ondragstart="return false" src="<?php echo PDS_DESKTOP_ROOT ?>/src/vis/img/refresh-cl/news/computers/laptop1.png" style="margin-left: 25%; height: 130px;" />
                                    
                                    <?php
                                        if (!empty($Restore['alias'])){
                                            ?>
                                                <p title="<?php echo $Restore['ip_host']; ?>" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;" class="xedit-virtual_machine">
                                                
                                                <?php 
                                                    echo $CN->getStringFormatSize($Restore['alias']); 
                                                ?>
                                                
                                                </p>
                                            <?php
                                        } else {
                                            ?>
                                                <p title="Cambiar nombre" id="getIdDeviceManagement<?php echo $R_Count; ?>" ip_addr="<?php echo $Restore['ip_host']; ?>" style="margin-top: -10px; text-align: center; font-size: 16px;" class="xedit-virtual_machine"><?php echo $Restore['ip_host']; ?></p>
                                            <?php
                                        }
                                    ?>
                                </div>
                            <?php
                        }
                    }

                    ?>
                        <script type="text/javascript">
                            $('#getIdDeviceManagement<?php echo $R_Count; ?>').editable({
                                type: 'text',
                                pk: <?php echo $R_Count; ?>,
                                name: 'getIdDeviceManagement<?php echo $R_Count; ?>',
                                title: 'Editar dispositivo'
                            });

                            $('#getIdDeviceManagement<?php echo $R_Count; ?>').on('save', function(e, params) {
                                ip_addr = $('#getIdDeviceManagement<?php echo $R_Count; ?>').attr("ip_addr");
                                FunctionOnChange(ip_addr, params);
                                
                            });
                        </script>
                    <?php

                    $R_Count++;
                }
            }
        ?>
        </section>

        <div class="gap"></div>
        <div class="gap"></div>
    </div>
</div>

<script type="text/javascript">
    $('#mix-items').mixItUp();

    // multiselect - contextual 
    $('#multiselect-contextual').multiselect({
      buttonClass: 'multiselect dropdown-toggle btn btn-primary'
    });

    $(".li_OrderDesc").click(function(){
        $(".btn_Order_Desc").click();
        $(".btn_Order_value").text("Descendente");
    });

    $(".li_OrderAsc").click(function(){
        $(".btn_Order_Asc").click();
        $(".btn_Order_value").text("Ascendente");
    });

    let popupMenux = document.getElementById("ContextMenuTest");
    let mixingsGetGevices = document.getElementById("mixings-get-devices-id");

    mixingsGetGevices.addEventListener('click', function (e) {
        $("#ContextMenuTest").css("visibility", "hidden");
        $("#ContextMenuTest_White").css("visibility", "hidden");
    });

    mixingsGetGevices.addEventListener('contextmenu', function (e) {
        let offsetX = e.offsetX;
        let offsetY = e.offsetY;

        if (e.target != this){ // 'this' is our HTMLElement
            offsetX = e.target.offsetLeft + e.offsetX;
            offsetY = e.target.offsetTop + e.offsetY;
        }

        popupMenux.style.left = offsetX + 'px';
        popupMenux.style.top = offsetY + 'px';
        
        mixingsGetGevices.appendChild(popupMenux);
        $("#ContextMenuTest").css("visibility", "hidden");
        $("#ContextMenuTest_White").css("visibility", "hidden");
        
        popupMenux.style.visibility = "visible";

        e.preventDefault();
    }, false);

</script>

<style>
    div.mixings-get-devices .mix-container .mix {
        transition: .3s all;
        transition-delay: 0s;
    }

    div.mixings-get-devices .mix-container .mix:hover {
        transition: .1s all;
        transition-delay: 0s; 
        box-shadow: 0 2px 5px #000;
    }
</style>