<?php
include("../adminCPgestione/conf/config.php");
include("../adminCPgestione/include/functions.php");
include("../adminCPgestione/include/connection_db.php");

$idcatesel = $_GET['device']; // questa variabile deve prendere il valore poi dalla selezione del blocco sopra Quale iDevice vuoi vendere? 

$conta_modello = 0;
$SQLmodello = $db->query("SELECT * FROM " . $prefix . "prodotti WHERE id_categoria=" . $idcatesel . " ORDER BY nome_prodotto");
while ($row_modello = $db->fetchNextArray($SQLmodello)) {


    $img_modello = $dir_img_prodotti . "prod-" . $row_modello['id_prodotto'] . "-" . $row_modello['id_categoria'] . $row_modello['est'];
    ?>                                                            

<div class="modello" value="<?php echo $conta_modello; ?>" data-prod="<?php echo $row_modello['id_prodotto']; ?>" onclick="setCaratteristiche($(this))">
        <div class="immagine_modello" ><img src="<?php echo $img_modello; ?>" alt="<?php echo $row_modello['nome_prodotto']; ?>" /></div>
        <div><?php echo $row_modello['nome_prodotto']; ?></div>
    </div>
<!--
    <div class="caratteristica" value="<?php echo $conta_modello; ?>" style="display: none;"><h3 class="label_caratteristica"><span class="descrizione_caratteristica"></span></h3></div>
-->
    <?php
    $conta_modello ++;
}

