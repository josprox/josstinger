<?php
    require_once './tuits.php';

    
    if(isset($_GET['action']) && isset($_GET['page'])){

        $tuits = new Tuits();
        $page = (int)$_GET['page'];
        $data = $tuits->getData($page);
        echo json_encode($data);    
    }
?>