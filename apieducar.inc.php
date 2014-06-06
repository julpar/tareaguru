<?php
// Author: jparedes
//Llamado a API Publica educ.ar 
function getRecurso($term) {   
 
$infografia_url = 'https://api.educ.ar/0.9/recursos/infografias/';
$secuencia_url = 'https://api.educ.ar/0.9/recursos/infografias/';
$api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';  //key

$params = array('key'=>$api_key,
              'texto'=>$term,
              'limit'=>1,
              'sort_mode'=>'asc');

    $decoded = json_decode(request($infografia_url.'?'.http_build_query($params)));
    
    if ($decoded->result->totalFound < 1)
        $decoded = json_decode(request($secuencia_url.'?'.http_build_query($params)));
   
                 
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('Ocurrió un error: ' . $decoded->response->errormessage);
    }
        
    return $decoded;
}

function request($url){

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Debug
    //curl_setopt($curl, CURLOPT_VERBOSE, true);

    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,true);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,true);

    $curl_response = curl_exec($curl);

    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('Ocurrió un error en la ejecución de llamada curl. Info adicional: ' . var_export($info,true));
    }
    curl_close($curl);
    
    return $curl_response;

}

function sanitize($qry) {
     $separador = ' ';

     if (empty($qry)) return $qry; //aseguro no nulos

     $qry=str_replace('_',$separador,$qry); //reemplazos de espacios     
     
     $terms=explode($separador,$qry); //tokenizer para hacer uppercase
     foreach ($terms as $value) {
        if (!empty($return)) $return.=' ';
        $return.=ucwords(strtolower($value));
     }
     
    return $return;
}

function pluralize ($yrs) {
    if ($yrs>1) return 'años';  else return 'año';
}

function getUrlCtx() {

    $ctx['host']  = $_SERVER['HTTP_HOST'];
    $ctx['path']  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    return $ctx;
}
?>
