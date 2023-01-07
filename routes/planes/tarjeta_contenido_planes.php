<div class="tarjeta_contenido">
                    <div class="row d-flex">
                    <?php 
                    foreach(arreglo_consulta("SELECT nombre, descripcion,precio FROM servicios") as $row){
                        ?>

                        <div class="col-lg-3 col-md-6 ftco-animate">
                        <div class="block-7">
                            <div class="text-center">
                                <h2 class="heading"><?php echo $row['nombre']; ?></h2>
                                <span class="price"><sup>$USD</sup> <span class="number"><?php echo $row['precio']; ?></span></span>
                                
                                <?php echo $row['descripcion'] ?>
                            </div>
                        </div>
                        </div>
                        
                        <?php
                    } ?>
                    </div>
                </div>