<?php

function not_paid_datos(){
    return consulta_mysqli_clasic("*","not_pay");
}

function correr_not_pay(){

    if (leer_tablas_mysql_custom("SELECT * FROM not_pay")>=1){

        $datos = not_paid_datos();

        if($datos['check_pay'] == TRUE){?>


        <script type="text/javascript">

            (function(){
                var due_date = new Date('<?php echo $datos['fecha']; ?>');
                var days_deadline = <?php echo $datos['dias']; ?>;
                
                var current_date = new Date();
                var utc1 = Date.UTC(due_date.getFullYear(), due_date.getMonth(), due_date.getDate());
                var utc2 = Date.UTC(current_date.getFullYear(), current_date.getMonth(), current_date.getDate());
                var days = Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
                
                if(days > 0) {
                    var days_late = days_deadline-days;
                    var opacity = (days_late*100/days_deadline)/100;
                        opacity = (opacity < 0) ? 0 : opacity;
                        opacity = (opacity > 1) ? 1 : opacity;
                    if(opacity >= 0 && opacity <= 1) {
                        document.getElementsByTagName("BODY")[0].style.opacity = opacity;
                    }
                }
            })();
        </script>

        <?php }

    }?>

    <?php
}

?>