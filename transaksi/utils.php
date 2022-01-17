<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

function render_members_as_select_options($selected_id = null)
{
	global $conn;

	$query = mysqli_query($conn, "SELECT * FROM `member`");

	while ($data = mysqli_fetch_assoc($query)) {
?>
		<option value="<?= $data['id'] ?>" <?= $selected_id === $data['id'] ? "selected" : "" ?>><?= $data['nama'] ?></option>
	<?php
	}
}

function render_as_radio_buttons($name, $keys, $selected_key = null)
{
	foreach ($keys as $key) {
		$radio_id = $name . "-" . $key . "-radio";
	?>
		<div class="form-check">
			<input class="form-check-input" type="radio" name="<?= $name ?>" id="<?= $radio_id ?>" value="<?= $key ?>" <?= $selected_key === $key ? "checked" : "" ?>>
			<label class="form-check-label" for="<?= $radio_id ?>"><?= titleize($key) ?></label>
		</div>
<?php
	}
}

function render_paket_as_select_options($selected_id = null) {
	global $conn;

	$query = mysqli_query($conn, "SELECT * FROM `paket`");

	while ($data_paket = mysqli_fetch_assoc($query)) {
		?>
			<option value="<?= $data_paket['id']?>" <?= $selected_id === $data_paket['id'] ? "selected" : "" ?>>
				<?= titleize($data_paket['jenis']) . " @" . $data_paket['harga'] ?>
			</option>
		<?php
	}
}
