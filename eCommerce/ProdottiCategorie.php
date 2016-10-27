<?php

/**
 * Description of ProdottiCategorie
 *
 * @author panduz
 */
class ProdottiCategorie {
    
    /**
     * Partendo dalla categoria passata come parametro, la funzione crea
     * l'albero con tutte le sue sotto categorie
     *                  1-aaa
     *                  /    \
     *                2-bbb   3-ccc
     *                        /   \
     *                     4-ddd   5-eee
     *                      /
     *                    6-fff
     * 
     * Partendo dalla categoria 3, la funzione ritorna l'array [3,4,6,5]
     * 
     * @global type $db
     * @global type $prefix
     * @param type $id_categoria categoria dalla quale si parte
     * @return array con gli id di tutte le categorie
     */
    public static function alberoCategorieDown($id_categoria) {

        global $db, $prefix;
        
        $res_categorie = array();
        $res_categorie[0] = $id_categoria;
        
        $stack_id_categorie = array();
        array_push($stack_id_categorie, $id_categoria);
        
        $i=1;
        while($id_categoria_qry = array_pop($stack_id_categorie))
        {   
            $SQL_categoria = $db->queryS("SELECT * FROM ".$prefix."categorie WHERE categoria_padre=".$id_categoria_qry);
              
            foreach ($SQL_categoria as $row) {
                $res_categorie[$i++] = $row['id_categoria'];
                array_push($stack_id_categorie, $row['id_categoria']);
            }
        }
        
        return $res_categorie;
    }
}
