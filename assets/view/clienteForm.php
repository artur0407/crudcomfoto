<?php 
	$readonly = "";
	$disabled = "";
	$textFile = "Escolher imagem (JPG/JPEG)";
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	$id     = isset($_GET['id'])     ? $_GET['id'] 	   : "";

	if (!empty($action) && !empty($id)) {
		if ($action === 'edit') {
			$titleForm = "Editar Cliente";
		} else if($action === 'view') {
			$readonly = "readonly";
			$disabled = "disabled";
			$titleForm = "Visualizar Cliente";
		}
		$clienteEdit = new model\ClienteModel();
		$cliente = $clienteEdit->get($id);
	} else {
		$titleForm = "Cadastrar Cliente";
	}

	$id 		= !empty($cliente["id"]) 	  ? $cliente["id"] 	  	: "";
	$nome 		= !empty($cliente["nome"]) 	  ? $cliente["nome"] 	: "";
	$email 		= !empty($cliente["email"])   ? $cliente["email"]   : "";
	$cpf 		= !empty($cliente["cpf"]) 	  ? $cliente["cpf"] 	: "";
	$sexo   	= !empty($cliente["sexo"]) 	  ? $cliente["sexo"] 	: "";
	$celular 	= !empty($cliente["celular"]) ? $cliente["celular"] : "";
	$imagem 	= !empty($cliente["imagem"])  ? $cliente["imagem"]  : "";
?>

<style>
	.img-thumbnail{height:350px!important; }
</style>

<div class="container">

	<h2 class="mt-2"> <?=$titleForm;?> </h2>

	<?php
		if (!empty($_SESSION["erroForm"])) { 
			viewError($_SESSION["erroForm"]);
			$_SESSION["erroForm"] = ""; 
		} 
	?>

	<?php if(!empty($imagem)) { ?>
		<img src="data:image/jpeg;base64,<?=$imagem;?>" class="ml-2 img-thumbnail float-right">
	<?php } ?>

	<div class="card">
		<div class="card-body">

	<form class="needs-validation" action="?page=clienteController&action=save" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id;?>"> 
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="nome"> Nome <span class="text-danger"> * </span> </label>
				<input type="text" class="form-control" <?=$readonly;?> id="nome" name="nome" value="<?=$nome; ?>" required>
			</div>
			<div class="form-group col-md-6">
				<label for="email"> Email <span class="text-danger"> * </span> </label>
				<input type="email" class="form-control" <?=$readonly;?> id="email" name="email" value="<?=$email; ?>" required>
			</div>
			<div class="form-group col-md-6">
				<label for="">Sexo <span class="text-danger"> * </span> </label>
				<?php if($action === 'edit' || empty($readonly)) { ?>
				<select class="form-control" name="sexo" id="sexo" required>
				<?php } else { ?>
				<select class="form-control" name="sexo" id="sexo" tabindex="-1" aria-disabled="true"
					style="background: #EEE; pointer-events: none; touch-action: none" required>
				<?php } ?>
					<option value=""> Escolha  </option>
					<option value="M" <?= $sexo=='M' ? "selected" : "" ?>>Masculino</option>
					<option value="F" <?= $sexo=='F' ? "selected" : "" ?>>Feminino </option>
				</select>
			</div>
			<div class="form-group col-md-6">
				<label for="cpf"> CPF <span class="text-danger"> * </span> </label>
				<input type="text" class="form-control" <?=$readonly;?> id="cpf"  name="cpf" value="<?=$cpf; ?>" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"  placeholder="999.999.999-99" required>
			</div>
			<div class="form-group col-md-6">
				<label for="celular"> Celular <span class="text-danger"> * </span> </label>
				<input class="form-control" type="tel" <?=$readonly;?> id="celular" name="celular" value="<?=$celular; ?>" pattern="\([0-9]{2}\)[\s][0-9]{5}-[0-9]{4}" placeholder="(99) 99999-9999" required>
			</div>
			<div class="form-group col-md-9">
				<label> Foto </label>
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="foto" name="foto" value="<?=$imagem?>" <?=$disabled;?>>
					<label class="custom-file-label" for="foto"><?=$textFile;?> </label>
				</div>
				<small class="form-text text-danger">
					Tamanho máximo permitido é 800px de largura por 800px altura.
				</small>
			</div>
		</div>
		<?php if($action === 'edit' || empty($readonly)) { ?>
			<button type="submit" class="btn btn-primary" role="button" aria-pressed="true"> Salvar </button>
		<?php } ?>
		<a href="index.php" class="btn btn-secondary" role="button" aria-pressed="true"> Voltar </a>
	</form>
		</div>
	</div>
</div>