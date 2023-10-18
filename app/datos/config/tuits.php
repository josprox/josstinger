<?php

    require "./scroll_db.php";

    class Tuits extends Database{
        function _construct(){

        }

        function getData($section){

            include "./../../../ps-conexion/conexion.php";

            session_start();
            if (!isset($_SESSION['id_usuario'])) {
                header("Location: ./../");
            }
            $iduser = $_SESSION['id_usuario'];

            $datauser = "SELECT * FROM arg_alumno WHERE arg_alumno.id_alm = '$iduser'";
            $restdatauser = $conexion->query($datauser);
            $restfull = $restdatauser->fetch_assoc();

            $tugradgrup = $restfull['id_gg'];
            $tuespecialidad = $restfull['id_esp'];
            $tuturno = $restfull['id_turn'];

            $query = $this->connect()->prepare('SELECT maestros.nombre, maestros.img, publicaciones.titulo, publicaciones.vista FROM maestros INNER JOIN arg_public ON maestros.id = arg_public.id_mst INNER JOIN publicaciones ON arg_public.id_pbc = publicaciones.id WHERE arg_public.id_gradgrup = '.$tugradgrup.' && arg_public.id_esp = '.$tuespecialidad.' && arg_public.id_turno = '.$tuturno.' ORDER BY publicaciones.id DESC limit :section, 6');
            
            $query->execute(['section' => $section]);
            $res = [];
            $items = [];
            $n = $query->rowCount();
            if($n){
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = Array(
                        'img' => $row['img'],
                        'titulo' => $row['titulo'],
                        'vista' => $row['vista']
                    );
                    array_push($items, $item);
                
                }
                array_push($res, Array('response' => "200"));
                array_push($res, $items);
                array_push($res, Array('page' => ($section + $n)));
                return $res;
            }else{
                // error
                array_push($res, Array('response' => "400"));
                return $res;
            }
        }
    }

?>