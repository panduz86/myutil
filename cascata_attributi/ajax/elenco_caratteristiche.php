<?php
include("../adminCPgestione/conf/config.php");
include("../adminCPgestione/include/functions.php");
include("../adminCPgestione/include/connection_db.php");

$idprodesel = $_GET['idprodesel']; // questa variabile deve prendere il valore poi dalla selezione del blocco sopra Seleziona il modello

$id_gruppi_attributo = $db->query("SELECT DISTINCT tipo_attributo FROM ".$prefix."prodotti_attribute WHERE id_prodotto=".$idprodesel);

$num_totale_gruppi = $db->numRows($id_gruppi_attributo);
$numero_gruppo = 1;

while($item = $db->fetchNextArray($id_gruppi_attributo)){
    $tipo_attributo = $item['tipo_attributo'];
    
    $obj_gruppo = $db->queryUniqueObject("SELECT * FROM ".$prefix."attributi_gruppi WHERE id_gruppo=".$tipo_attributo);
    
    ?>

    <!--in base a cosa si seleziona qui si deve visualizzare il box 2 colore -->
    <div id="caratteristica<?php echo $numero_gruppo; ?>" class="caratteristica" style = "<?php echo ($numero_gruppo==1)? "display: inline;" : "display: none;"; ?>">
    <h3 class = "label_caratteristica"><span class = "titolo_caratteristica"><?php echo $obj_gruppo->nome_gruppo_attributo; ?> </span><span class = "descrizione_caratteristica"><?php echo $obj_gruppo->nome_gruppo_attributo; ?></span></h3>
    <ul class = "elenco_opzioni">

    <?php

    $conta_modello = 0;
    $SQLattr_gruppo = $db->query("SELECT * FROM ".$prefix."prodotti_attribute WHERE id_prodotto=".$idprodesel." AND tipo_attributo=".$tipo_attributo." ORDER BY default_on DESC");
    while($row_gruppo = $db->fetchNextArray($SQLattr_gruppo)){

        $info_gruppo = $db->queryUniqueObject("SELECT * FROM ".$prefix."attributi WHERE id_gruppo=".$row_gruppo['id_gruppo_attributo']);

        $nome_att = pulisci_stringa($info_gruppo->nome_attributo);

        $img_attr = $dir_img_attributi."attr-".$info_gruppo->id_attributo."-".$nome_att.$info_gruppo->est;
        ?>                                                            

            <li class="opzione" onclick="selezionaOpzione($(this),'<?php echo ($numero_gruppo==$num_totale_gruppi)? "fine": "caratteristica".($numero_gruppo+1); ?>')" data-idattr="<?php echo $row_gruppo['id_attributo_prodotto']; ?>" ><div class="wrapper_opzione"><div class="immagine_opzione"><img src="<?php echo $img_attr; ?>"></div><div class="nome_opzione"><div><?php echo $row_gruppo['label_fascia']; ?></div></div></div></li>

        <?php
        $conta_modello ++;
    }
    ?>

    </ul>
    </div>
<?php
    
    $numero_gruppo++;
}
