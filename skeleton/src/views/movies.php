<?php ob_start() ?>

<h1>Ma Collection</h1>

<section>
    <h2>Ajouter un nouveau titre</h2>
</section>

<input id="user" type="text" name="" id="">
<small id="userError"></small>

<?php
render('default', true, [
	'title' => 'Acceuil',
	'css' => 'index',
	'content' => ob_get_clean(),
]);
?>