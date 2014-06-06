<?php
require 'apieducar.inc.php';

$term=filter_input(INPUT_GET, 'qry', FILTER_SANITIZE_STRING);


if (!empty($term)) {

    //Examino el término por la existencia de un espacio, en dicho caso lo
    //redirijo al subsistema que determinará el URL único y correcto para un sujeto
    if (strpos($term, ' ')) {
        $ctx=getUrlCtx();
        header("Location: http://{$ctx['host']}{$ctx['path']}/redirect.php?qry=$term");
        exit();
    }

   //Sanitizamos convenciones internas previo a consulta
   $term=sanitize($term);

   $response = getRecurso($term);
   $data=$response->result->data[0];
   
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>tarea.guru - <?php echo $term; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body style="text-align: center; padding-top: 50px;">
<a href="https://github.com/julpar/tareaguru"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>

<p><img src="guru.jpg" align="center"/></p>

<?php if (empty($term)) { ?>
<form name="simple_bar" method="get" action="redirect.php" >
    <div align="center">      
    <input type="text" name="qry" size="30" maxlength="50"><input type="submit" value="Ayudame con la tarea!">
    </div>
</form>
<?php } else if ($data===null) { ?>

<p>No encontré nada :'(...</p>

<?php } else {  ?>
<p>Aqui tienes...</p>

<!--
<blockquote>
<?php echo print_r($data); ?>
</blockquote>
-->

<iframe frameborder="0" scrolling="no" width="800" height="400"
        src="http://www.educ.ar/Dinamico/UnidadHtml/obtenerSitio?rec_id=<?php echo $data->id ?>" id="resultado">
   <p>iframes no soportados :'(</p>
</iframe>

<form name="simple_bar" method="get" action="redirect.php" >
    <div align="center">      
    <input type="text" name="qry" size="30" maxlength="50"><input type="submit" value="ayudame otra vez!">
    </div>
</form>

<p/>Podes compartir esta respuesta con este link <a href="/<?php echo $term; ?>">tarea.guru/<?php echo $term; ?></a>
<?php } ?>
</body>
</html>