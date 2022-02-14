<?php
require_once(__DIR__ . '/controller/main.php');
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="view/css/style.css?v=1.1.2">
	<title>Погода</title>
</head>

<body>
	<div class="container">
		<div class="box">
			<?php if (!empty($weather['icon'])) : ?>
				<div class="icon">
					<img src="https://yastatic.net/weather/i/icons/funky/dark/<?= $weather['icon']; ?>.svg" alt="">
					<h2 class="icon__city"><?= $locality; ?></h2>
				</div>
			<?php endif; ?>
			<?php foreach ($data as $fieldName => $fieldValue) : ?>
				<div class="field">
					<div class="field__name"><?= $fieldName . ':'; ?></div>
					<div class="field__value"><?= $fieldValue; ?></div>
				</div>
			<?php endforeach; ?>
			<?php if (empty($weather['temp'])) : ?>
				<form action="index.php" method="POST" class="form">
					<div class="mb-3">
						<input type="text" class="form-control" name="city" id="city" value="<?= $city; ?>" placeholder="Город">
					</div>
					<div class="form__btn">
						<button class="btn-lg btn btn-primary" type="submit">Запросить</button>
					</div>
				</form>
			<?php endif; ?>
			<?php if (!empty($error)) : ?>
				<p class="error"><?= $error; ?></p>
			<?php endif; ?>
		</div>
	</div>
</body>

</html>