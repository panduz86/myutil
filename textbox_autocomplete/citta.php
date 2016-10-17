<?php
header('Content-Type: application/json');

// $_GET["q"] contiene il valore inserito nel input

$json = array();



/* blocco da stampare all'interno di un ciclo di lettura di una query
$bus = array(
		'label' => 'Cuneo, Piemonte, Italia',  //questo e' l'ID della citta
		'value' => 'Cuneo, Piemonte, Italia', //qua e' la stringa che farai visualizzare, quindi citta regione stato
		'id'    => '1' //questo e' l'ID della citta, che nel mio esempio viene salvato nell'input id_city, il quale tu puoi poi renderlo hidden ed usarlo
						//poi in fase di salvataggio leggendolo dal post, per recuperarti la regione e lo stato del paese
);
array_push($json, $bus);
*/


$bus = array(
		'label' => 'Cuneo, Piemonte, Italia',
		'value' => 'Cuneo, Piemonte, Italia',
		'id'    => '1'
);
array_push($json, $bus);



$bus = array(
		'label' => 'Torino, Piemonte, Italia',
		'value' => 'Torino, Piemonte, Italia',
		'id'    => '2'
);
array_push($json, $bus);



$bus = array(
		'label' => 'Mondovi, Piemonte, Italia',
		'value' => 'Mondovi, Piemonte, Italia',
		'id'    => '3'
);
array_push($json, $bus);




$jsonstring = json_encode($json);
echo $_GET["callback"]."(".$jsonstring.")";

?>
