<?php
/*
Google Maps Javascript API V3
Geocode XML
Trudelmer
Retorna Latitude, Longitude, CEP e Pais a partir de um Logradouro, número, cidade e UF
*/

function tratamentoAcentos($str){
	$str = $str;
	$caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","º","ª");
	$caracteresLimpos    = array ("A","a","O","o","a","A","e","E","i","I","o","O","u","U","c","C","a","A","e","E","i","I","o","O","u","U","a","A","e","E","i","I","o","O","u","U","A","E","I","O","U","a","e","i","o","u",".",".");
	$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
	
	return addslashes($str);
}

function geolocal($endereco,$sensor=false){
	$sensor = ($sensor) ? 'true' : 'false';
	$endereco = utf8_encode(str_replace(" ", "+", $endereco));
	$url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.$endereco.'&sensor='.$sensor;
	$xml = simplexml_load_file($url);
	$latitude = $xml->result->geometry->location->lat;
	$longitude = $xml->result->geometry->location->lng;
	$cep = $xml->result->address_component[6]->long_name;
	$pais = $xml->result->address_component[5]->long_name;
	return array('lat' => $latitude, 'lon' => $longitude, 'cep' => $cep, 'pais' => $pais);
}

// COMO USAR A FUNÇÃO ============================================

// logradouro número, cidade, uf
$end = tratamentoAcentos("Rua Rio Grande do Sul 384, Fortaleza, CE");

$endados = geolocal($end);

echo $endados['lat'] . "<br />";
echo $endados['lon'] . "<br />";
echo $endados['cep'] . "<br />";
echo $endados['pais'] . "<br />";
