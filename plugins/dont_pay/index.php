<?php

/* 

    Esta es una versión mejorada de did not pay.
    Consulta el código fuente en: https://github.com/kleampa/not-paid
    Función: El siguiente código está preparado solo para el uso de JosSecurity, no sengarantiza el uso de este plugin en otros sistemas.
    Creador: Melchor Estrada José Luis (JOSPROX MX | Internacional).
    Web: https://josprox.com

*/

function check_not_paid(){
    if(leer_tablas_mysql_custom("SELECT * FROM not_pay")<1){
        
        ?>

        <h2 align="center">Vamos a activarlo</h2>
        <p align="justify">Por defecto el sistema viene desactivado para poder evitar el mal uso del sistema, si deseas activarlo por favor llene los siguientes datos.</p>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-check form-switch">
            <input class="form-check-input" name="check_pay" type="checkbox" id="flexSwitchCheckDefault" >
            <label class="form-check-label" for="flexSwitchCheckDefault">Por favor, selecciona si deseas activarlo ahorita o después</label>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="fecha" placeholder="fecha">
            <small id="fecha" class="form-text text-muted">Pon la fecha máxima.</small>
        </div>
        <div class="mb-3">
            <label for="dias" class="form-label">Dias</label>
            <input type="number"
            class="form-control" min="0" max="60" name="dias" id="dias" aria-describedby="dias" placeholder="dias">
            <small id="dias" class="form-text text-muted">Pon los días que tardará en opacarse después de la fecha máxima.</small>
        </div>
        <div class="mb-3">
          <label for="token" class="form-label">Token</label>
          <input type="password"
            class="form-control" name="token" id="token" aria-describedby="token" placeholder="Pon un token">
          <small id="token" class="form-text text-muted" required>Para poder eliminar este sistema necesitará un token, esto le asegura que, si su cliente quiere desactivar el sistema didn´t pay no pueda hacerlo sin este token.</small>
        </div>
        <button type="submit" name="create_not_pay" class="btn btn-success">Crear</button>
        </form>

    </div>

        <?php

        if(isset($_POST['create_not_pay'])){
            global $fecha;
            $conexion = conect_mysqli();
            if(isset($_POST['check_pay'])){
                $check = mysqli_real_escape_string($conexion, (string) $_POST['check_pay']);
                if ($check == "on"){
                    $check = TRUE;
                }
            }else{
                $check = FALSE;
            }
            $fecha_updated = mysqli_real_escape_string($conexion, (string) $_POST['fecha']);
            if($_POST['dias'] <= 60 OR $_POST['dias'] >= 0){
                $dias = (int)mysqli_real_escape_string($conexion, (string) $_POST['dias']);
            }elseif($_POST['dias'] > 60 OR $_POST['dias'] < 0){
                $dias = (int)60;
            }
            $token = password_hash(mysqli_real_escape_string($conexion, (string) $_POST['token']),PASSWORD_BCRYPT,["cost"=>10]);

            mysqli_close($conexion);

            insertar_datos_clasic_mysqli("not_pay","check_pay, fecha, dias, token, created_at, updated_at"," '$check', '$fecha_updated', '$dias','$token', '$fecha', NULL");
            echo "
            <script>
            Swal.fire(
                'Ya está',
                'Se configuró todo con éxito.',
                'success'
            );
            window.location.href = 'not_pay';
            </script>
            ";
        }

    }elseif(leer_tablas_mysql_custom("SELECT * FROM not_pay")>=1){ ?>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <?php
        not_paid_check(); 
        not_paid_fecha();
        not_paid_dias();
        not_paid_token();
        not_paid_submit();
        if(isset($_POST['receptor_not_paid'])){
            $conexion = conect_mysqli();
            $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
            if(isset($_POST['check_pay'])){
                $check = mysqli_real_escape_string($conexion, (string) $_POST['check_pay']);
                if ($check == "on"){
                    $check = TRUE;
                }
            }else{
                $check = FALSE;
            }
            $fecha_updated = mysqli_real_escape_string($conexion, (string) $_POST['fecha']);
            if($_POST['dias'] <= 60 OR $_POST['dias'] >= 0){
                $dias = (int)mysqli_real_escape_string($conexion, (string) $_POST['dias']);
            }elseif($_POST['dias'] > 60 OR $_POST['dias'] < 0){
                $dias = (int)60;
            }
            $token = mysqli_real_escape_string($conexion, (string) $_POST['token']);
        
            mysqli_close($conexion);
        
            $row = consulta_mysqli_where("token","not_pay","id",$id);
        
            $token_encriptado = $row['token'];
        
            if(password_verify($token,(string) $token_encriptado) == TRUE){
                actualizar_datos_mysqli("not_pay"," `check_pay` = '$check', `fecha` = '$fecha_updated', `dias` = '$dias'","id",$id);
                echo "
                <script>
                Swal.fire(
                    'Ya está',
                    'Se actualizó todo con éxito.',
                    'success'
                );
                window.location.href = 'not_pay';
                </script>
                ";
                
            }else{
                echo "
                <script>
                Swal.fire(
                    'Error',
                    'Tuvimos un error al actualizar la información, favor de checar el token',
                    'error'
                );
                </script>
                ";
            }
        }
        ?>
    </form>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php 
        not_paid_token();
        not_paid_delete();
        if(isset($_POST['eliminar_not_paid'])){
            $conexion = conect_mysqli();
            $pdo = conect_mysql();
            $id = mysqli_real_escape_string($conexion, (string) $_POST['id']);
            $token = mysqli_real_escape_string($conexion, (string) $_POST['token']);
        
            mysqli_close($conexion);
        
            $row = consulta_mysqli_where("token","not_pay","id",$id);
        
            $token_encriptado = $row['token'];
        
            if(password_verify($token,(string) $token_encriptado) == TRUE){
                eliminar_datos_con_where("not_pay","id",$id);
                echo "
                <script>
                Swal.fire(
                    'Ya está',
                    'Se eliminó con éxito.',
                    'success'
                );
                window.location.href = 'not_pay';
                </script>
                ";
            }else{
                echo "
                <script>
                Swal.fire(
                    'Oh no',
                    'No ha podido borrarlo, favor de checar el token.',
                    'error'
                );
                </script>
                ";
            }
        
        
        }
        ?>
    </form>
        <?php
        
    }
}

function not_paid_check() { 
    $datos = not_paid_datos();
	?>
    <div class="form-check form-switch">
        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
        <input class="form-check-input" name="check_pay" type="checkbox" id="flexSwitchCheckDefault" <?php if($datos['check_pay'] == TRUE){ echo "checked"; } ?>>
        <label class="form-check-label" for="flexSwitchCheckDefault">Sistema: actualmente <?php if($datos['check_pay'] == TRUE){ echo "activado"; }elseif($datos['check_pay'] != TRUE){ echo "desactivado"; } ?></label>
    </div>
	<?php

}

function not_paid_fecha() { 
    $datos = not_paid_datos();
	?>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date"
          class="form-control" name="fecha" id="fecha" aria-describedby="fecha" placeholder="fecha" value='<?php echo $datos['fecha']; ?>'>
        <small id="fecha" class="form-text text-muted">Pon la fecha máxima.</small>
    </div>
	<?php

}


function not_paid_dias() { 
    $datos = not_paid_datos();
	?>
    <div class="mb-3">
        <label for="dias" class="form-label">Dias</label>
        <input type="number"
          class="form-control" min="0" max="60" name="dias" id="dias" aria-describedby="dias" placeholder="dias" value="<?php echo $datos['dias']; ?>">
        <small id="dias" class="form-text text-muted">Pon los días que tardará en opacarse después de la fecha máxima.</small>
    </div>
	<?php

}

function not_paid_token(){
    ?>

    <div class="mb-3">
      <label for="token" class="form-label">Token</label>
      <input type="password"
        class="form-control" name="token" id="token" aria-describedby="token" placeholder="Favor de insertar el token" required>
      <small id="token" class="form-text text-muted">Para poder modificar cualquier cosa del sistema, deberás usar el token.</small>
    </div>

    <?php
}

function not_paid_submit(){
    $datos = not_paid_datos();
    ?> 

    <button type="submit" name="receptor_not_paid" class="btn btn-primary"><?php if($datos['check_pay'] == TRUE){ echo "Actualizar"; }elseif($datos['check_pay'] != TRUE){ echo "Guardar"; } ?></button>
    
    <?php
}

function not_paid_delete(){
    $datos = not_paid_datos();
    ?> 
    <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
    <button type="submit" name="eliminar_not_paid" class="btn btn-warning">Eliminar</button>
    
    <?php
}

?>
