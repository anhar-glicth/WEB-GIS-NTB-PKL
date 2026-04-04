<?php if (session()->has('message')) : ?>
	<div class="alert alert-success shadow-sm border-0 small py-2 px-3 mb-4 rounded-lg">
		<i class="fas fa-check-circle mr-1"></i> <?= session('message') ?>
	</div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
	<div class="alert alert-danger shadow-sm border-0 small py-2 px-3 mb-4 rounded-lg">
		<i class="fas fa-exclamation-triangle mr-1"></i> <?= session('error') ?>
	</div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
	<div class="alert alert-danger shadow-sm border-0 small py-2 px-3 mb-4 rounded-lg">
		<ul class="mb-0 pl-3">
		<?php foreach (session('errors') as $error) : ?>
			<li><?= $error ?></li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>
