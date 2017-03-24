<!DOCTYPE html>
<html lang="es">
    <head>

	<title>Streaming de TORRENTS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="css/index.css"/>
	<link rel="stylesheet" href="themes/alertify.core.css"/>
	<link rel="stylesheet" href="themes/alertify.default.css"/>
	
	<script type="text/javascript" src="lib/alertify.js"></script>

	<script type="text/javascript">
			function descarga(){
				alertify.success("Torrent añadido, espera su descarga, por favor"); 
				return false;
			}
			
			function descargado(){
				alertify.success("Torrent descargado, que disfrutes"); 
				return false;
			}
	</script>
	
    </head>

    <body>
	
    <div class="row">
	<h2 class="titulo" id="titulo">Enlace TORRENT</h2>
	
	<div class="formulario" id="formulario">
	  <form class="col s12" action="#"  method="post">
		<div class="input-field col s10">	
		  <i class="material-icons prefix">videocam</i>
          <input id="link" type="text" name="link" placeholder="magnet:url" required>
          <label for="link"></label>
		</div>  
		
		<div class="input-field col s2">	
		<button class="btn waves-effect waves-light" type="submit" onclick="descarga();">Reproducir
		<i class="material-icons right">play_arrow</i>
		</button>
		</div>
	  
	  </form>	  
	</div>
	</div>
	
	<div class="row">
		<?php magia(); ?>
	</div>
	
<?php

ini_set('max_execution_time', 0);
function magia(){
	if(isset($_POST["link"])){
		$link = $_POST["link"];
		$randomDigit = md5(rand());
		$dir = "download/".$randomDigit."/";
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
		}
		$proc = popen("cd ".$dir." && node ../../downloadtorrent/cli.js ".$link, 'r');
		echo '<script type="text/javascript">',
        'descargado();',
        '</script>';
		while (!feof($proc))
		{
			fread($proc, 4096);
			@ flush();
		}
		$directorio = "/var/sentora/hostdata/zadmin/public_html/respuestastop_es/".$dir;
		$scan = scandir($directorio);
		$archivo = "";
		foreach ($scan as $file){
			if(!is_dir($directorio.$file)){
				$archivo = $dir.$file;
			}
		}
		?>
		<video width="640" height="480" class="centrarvideo" controls>
			<source src="<?php echo $archivo ?>" type="video/mp4" id="reproductor">
			Your browser does not support the video tag.
		</video>
		
		<?php
		fclose($proc);
	}
}
?>
	
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
	  
	</body>
</html>