<?php

/*
    Nombre: All in One
    Tipo: Plugin
    Función: Hacer un único backup que contenga la base de datos y los archivos de JosSecurity.
    Creador: Melchor Estrada José Luis (JOSPROX MX | Internacional).
    Web: https://josprox.com
*/
# Lo primero que haremos será crear las carpetas necesarias.

function allinone_backup(){
    $directorio_principal = (__DIR__ . "/respaldos");
    $directorio_secundario = (__DIR__ . "/respaldos/sql");
    if (!file_exists($directorio_principal)) {
        mkdir($directorio_principal);
    }
    if (!file_exists($directorio_secundario)) {
        mkdir($directorio_secundario);
    }
    return TRUE;
}

## Ahora creamos el script que nos permitirá hacer el backup sql.

function allinone_sql(){
    global $host, $user, $pass, $DB;
    set_time_limit(3000);
    $tablasARespaldar = [];
    $mysqli = new mysqli($host, $user, $pass, $DB);
    $mysqli->select_db($DB);
    $mysqli->query("SET NAMES 'utf8'");
    $tablas = $mysqli->query('SHOW TABLES');
    while ($fila = $tablas->fetch_row()) {
        $tablasARespaldar[] = $fila[0];
    }
    $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $DB . "`\r\n--\r\n\r\n\r\n";
    foreach ($tablasARespaldar as $nombreDeLaTabla) {
        if (empty($nombreDeLaTabla)) {
            continue;
        }
        $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
        $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
        $cantidadDeFilas = $mysqli->affected_rows;
        $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
        $filaDeTabla = $esquemaDeTabla->fetch_row();
        $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
        for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
            while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                //La primera y cada 100 veces
                if ($contador % 100 == 0 || $contador == 0) {
                    $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                }
                $contenido .= "\n(";
                for ($j = 0; $j < $cantidadDeCampos; $j++) {
                    $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                    if (isset($fila[$j])) {
                        $contenido .= '"' . $fila[$j] . '"';
                    } else {
                        $contenido .= '""';
                    }
                    if ($j < ($cantidadDeCampos - 1)) {
                        $contenido .= ',';
                    }
                }
                $contenido .= ")";
                # Cada 100...
                if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                    $contenido .= ";";
                } else {
                    $contenido .= ",";
                }
                $contador = $contador + 1;
            }
        }
        $contenido .= "\n\n\n";
    }
    $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

    $carpeta = __DIR__ . "/respaldos/sql";

    # Calcular un ID único
    $id = uniqid();

    # También la fecha
    $fecha = date("Y-m-d");

    # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
    $nombreDelArchivo = sprintf('%s/respaldo_%s_%s.sql', $carpeta, $fecha, $id);
    
    #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
    file_put_contents($nombreDelArchivo, $contenido);

    $resultado = TRUE;
    return $resultado;
}

## posteriormente generaremos un zip del sistema
function allinone_zip_all($option){
    ini_set('max_execution_time', 9000);
    ini_set('memory_limit', '-1');
  
    if($option == 1){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "plugins";
        $config_rest -> carpeta = "./../../plugins/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        $config_rest -> nombre_del_archivo = "config";
        $config_rest -> carpeta = "./../../config/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        $config_rest -> nombre_del_archivo = "public";
        $config_rest -> carpeta = "./../../public/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        $config_rest -> nombre_del_archivo = "resourses";
        $config_rest -> carpeta = "./../../resourses/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        $config_rest -> nombre_del_archivo = "routes";
        $config_rest -> carpeta = "./../../routes/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

    if($option == 2){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "plugins";
        $config_rest -> carpeta = "./../../plugins/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

    if($option == 3){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "config";
        $config_rest -> carpeta = "./../../config/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

    if($option == 4){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "public";
        $config_rest -> carpeta = "./../../public/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

    if($option == 5){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "resourses";
        $config_rest -> carpeta = "./../../resourses/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

    if($option == 6){
        $config_rest = new zip_select;
        $config_rest -> nombre_del_archivo = "routes";
        $config_rest -> carpeta = "./../../routes/";
        $config_rest -> ubicacion = "/respaldos";
        $config_rest -> zip();
        if($config_rest == TRUE){
            return TRUE;
        }
    }

  }

  ##Finalmente zipearemos y borraremos los datos.

  function allinone_zip_finish($option){
    if (allinone_backup() == TRUE){
        if (allinone_zip_all($option) == TRUE){
    
            if (allinone_sql() == TRUE){
        
                ini_set('max_execution_time', 9000);
                ini_set('memory_limit', '-1');
              
                # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
                $carpeta = __DIR__ . "/respaldo_all";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta);
                }
              
                    # Calcular un ID único
                    $id = uniqid();
              
                    # También la fecha
                    $fecha = date("Y-m-d");
              
                $nombre_archivo = sprintf('respaldo_%s_%s.zip',$fecha,$id);
                
                new GoodZipArchive(__DIR__ .'./respaldos/',    $carpeta . '/'. $nombre_archivo) ;
                $dirname = "./../../plugins/all in one/respaldos/";
    
                if(borrar_directorio($dirname) == TRUE){
    
                    if (file_exists(''.$carpeta.'/'.$nombre_archivo.'')) {?>
                        <center>
                            <p>Respaldo realizado con éxito</p>
                            <a class='btn btn-success' href='./../../plugins/all in one/respaldo_all/<?php echo $nombre_archivo; ?>'>Descargar</a><br><br>
                            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                                <input type="hidden" name="directorio" value="./../../plugins/all in one/respaldo_all">
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar respaldo del disco</button>
                                <br><br>
                            </form>
                        </center>
                        <?php
                    }else{
                        return FALSE;
                    }
                }
                
                
            } else {
                $resultado = "<p align='center'>Error, archivo zip no ha sido creado!! all in one all</p>";
                return $resultado;
            }
        
        }
    }
  }

  class zip_select{
    public $nombre_del_archivo;
    public $carpeta;
    public $ubicacion;

    public function zip(){
        $id = uniqid();
        $fecha = date("Y-m-d");
        $nombre_archivo = sprintf("{$this->nombre_del_archivo}_%s_%s.zip",$id,"$fecha");
        $homedir = __DIR__ . "{$this->ubicacion}";
        new GoodZipArchive(__DIR__ ."{$this->carpeta}",    $homedir . '/'. $nombre_archivo) ;
        if (file_exists(''."{$this->carpeta}".'/'.$nombre_archivo.'')){
            return TRUE;
        } else {
            return FALSE;
        }
    }
  }
  
  class GoodZipArchive extends ZipArchive {
	//@author Nicolas Heimann
	public function __construct($a=false, $b=false) { $this->create_func($a, $b);  }
	
	public function create_func($input_folder=false, $output_zip_file=false)
	{
		if($input_folder !== false && $output_zip_file !== false)
		{
			$res = $this->open($output_zip_file, ZipArchive::CREATE);
			if($res === TRUE) 	{ $this->addDir($input_folder, basename($input_folder)); $this->close(); }
			else  				{ echo 'Could not create a zip archive. Contact Admin.'; }
		}
	}
	
    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive 
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}

?>