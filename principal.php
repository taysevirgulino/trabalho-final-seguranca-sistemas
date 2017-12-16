<?php
session_start();
?>

<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Assinatura Digital</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
	<script type="text/javascript" src="https://cdn.rawgit.com/ricmoo/aes-js/e27b99df/index.js"></script>
	<script type="text/javascript" src="js/md5.js"></script>

	<script>
		var text;
		var resultado;
		var vetor = ['Matheus',
		'MIIBOgIBAAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQJAL151ZeMKHEU2c1qdRKS9sTxCcc2pVwoAGVzRccNX16tfmCf8FjxuM3WmLdsPxYoHrwb1LFNxiNk1MXrxjH3R6QIhAPB7edmcjH4bhMaJBztcbNE1VRCEi/bisAwiPPMq9/2nAiEA3lyc5+f6DEIJh1y6BWkdVULDSM+jpi1XiV/DevxuijMCIQCAEPGqHsF+4v7Jj+3HAgh9PU6otj2nY79nJtCYmvhoHwIgNDePaS4inApN7omp7WdXyhPZhBmulnGDYvEoGJN66d0CIHraI2SvDkQ5CmrzkW5qPaE2oO7BSqAhRZxiYpZFb5CI',
		'MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQ==', 'MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQ=='];
		window.onload = function() {
			var fileInput = document.getElementById('fileInput');
			var fileDisplayArea = document.getElementById('fileDisplayArea');

			fileInput.addEventListener('change', function(e) {
				var file = fileInput.files[0];
				var textType = /text.*/;

				if (file.type.match(textType)) {
					var reader = new FileReader();

					reader.onload = function(e) {0
						fileDisplayArea.innerText = reader.result;
					}

					reader.readAsText(file);	
				} else {
					fileDisplayArea.innerText = "File not supported!"
				}
				
			});
		}

		function assinar() {
		
			text = fileDisplayArea.innerText;

			console.log ("Esse é o texto original: ", text);
						
			// hash = b64_md5(text);
			
			// console.log ("Esse é hash: ", hash);
			
			// hmac = b64_hmac_md5(vetor[1], hash);
						
			// console.log("Esse é a Assinatura: ", hmac);

			// fileDisplayArea.innerText += "\n" + hmac;
			
			$.ajax({
				type: 'POST',
				url: 'assinar.php',
				cache: false,
				async:false,
				data: { 'data': text, 'private_key': vetor[1] },
				success : function(retorno){
						 resultado = retorno;
						 console.log("Esse é a Assinatura: ", resultado);
           		}
    		});

			var textFile = null,
  			makeTextFile = function (text) {
				var data = new Blob([text], {type: 'text/plain'});

				// If we are replacing a previously generated file we need to
				// manually revoke the object URL to avoid memory leaks.
				if (textFile !== null) {
				window.URL.revokeObjectURL(textFile);
				}

				textFile = window.URL.createObjectURL(data);

				return textFile;
			};

			var textbox = document.getElementById('textbox');

			var link = document.getElementById('downloadlink');
			textbox.value = 'TOKEN:' + resultado + '\n';
			textbox.value += 'PUBLIC:' + vetor[2];
			link.href = makeTextFile(textbox.value);
			link.style.display = 'block';
		}
	</script>
  </head>
  	<body>
		<div class="jumbotron">
			<div class="container">
				<center><h1 class="display-3">Olá <!--<?php $_SESSION['usuarioNome']?>-->, Bem-Vindo(a)!</h1>
				<br />
				<a href="#" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Faça seu Login</a></center>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Grupo de Sistema 1</h2>
					<p>Desenvolver ou utilizar um software de gerenciamento de documentos (GED) que forneça a funcionalidade de upload de documento e assinatura de documento usando o certificado digital.</p>
					<p>Luã, Leonardo, Fernando, Matheus, Tayse</p>
				</div>
				<div class="col-md-6">
					<h2>Assinatura Digital</h2>
					<div id="page-wrapper">
						<input type="file" accept='text/plain' name="Arquivo" id="fileInput"><br /><br />
						<input class="btn btn-lg btn-primary btn-block" onclick="assinar()" value="Assinar Documento" />
						<pre id="fileDisplayArea" style="display:none;"></pre>
						<br />
						<textarea id="textbox" style="display:none;"></textarea>
						<a download="assinatura.txt" id="downloadlink" style="display: none">Download</a>
					</div>
				</div>
			</div>
			<hr>
			<footer>
				<center><p>&copy; SS 2017</p></center>
			</footer>
		</div>    
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
	</body>
</html>
