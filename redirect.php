<?php
require 'apieducar.inc.php';

$term=$_REQUEST['qry'];
$term=str_replace(' ','_',$term); //reemplazo espacios por underscore para obtener url de + legibilidad

if (!empty ($term)) $extra=$term;

$ctx=getUrlCtx();

header("Location: http://{$ctx['host']}{$ctx['path']}/$extra");
exit();
?>