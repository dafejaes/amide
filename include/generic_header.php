<?php

if (isset($_SESSION['usuario'])) {
    ?>
        <div align="left" class= "nav">
            <img class="img-rounded" src="images/prueba.jpg" width="150px">
            <?php
            echo($_SESSION['usuario']['nombre'] . "(" . $_SESSION['usuario']['cargo'] . ")");
            ?>
            <img class="img-polaroid" src="images/favicon3.png" width="150px" align="right">
        </div>



    <?php
}
else {

?>
    <div align="center">
    <img src="images/favicon2.png" alt="AntioquiaMide"/>
     </div>
<?php
}

?>

