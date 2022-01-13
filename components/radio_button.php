<?php
function radio_button($name, $value, $checked = false)
{
?>
	<div class="form-check">
		<input class="form-check-input" type="radio" name="<?= $name ?>" value="<?= $value ?>" id="<?= $name . "-" . $value . "-radio" ?>" <?= $checked ? "checked" : "" ?>>
		<label class="form-check-label" for="<?= $name . "-" . $value . "-radio" ?>"><?= ucwords(str_replace("_", " ", $value)) ?></label>
	</div>
<?php
}
?>
