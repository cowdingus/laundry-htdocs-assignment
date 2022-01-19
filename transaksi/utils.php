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

// Quick hack to only display one transaction row even if it has multiple detail_transaksi
function extract_transaksi_as_table_data($data, $prev_id = null, $converters = null)
{
	$id = null;

	// Descendant of previous row (had the same id)
	$is_descendant = false;
	$visible_columns_in_descendants = ["paket", "total"];

	foreach ($data as $key => $value) {
		if ($key === "id")
		{
			$id = $value;
			$is_descendant = $prev_id === $value;
			continue;
		}

		if ($is_descendant)
		{
			if (!in_array($key, $visible_columns_in_descendants)) {
				?>
				<td></td>
				<?php
			} else {
				$content = isset($converters[$key]) ? $converters[$key]($value) : titleize($value);
				?>
				<td><?= $content ?></td>
				<?php
			}
		}
		else
		{
			$content = isset($converters[$key]) ? $converters[$key]($value) : titleize($value);
			?>
			<td><?= $content ?></td>
			<?php
		}
	}

	if (!$is_descendant)
	{
		?>
		<td>
			<a class="btn btn-primary" class="remove-anchor" href="hapus.php?id=<?= $data["id"] ?>">Hapus</a>
			<span>|</span>
			<a class="btn btn-danger" class="edit-anchor" href="edit.php?id=<?= $data["id"] ?>">Edit</a>
		</td>
		<?php
	}
	else
	{
		?>
			<td></td>
		<?php
	}

	return $id;
}

function list_table_transaksi()
{
	global $conn;

	$query_transaksi = mysqli_query($conn, "SELECT t.id, m.nama as nama_member, t.tgl, t.batas_waktu, t.tgl_bayar, t.status, t.dibayar, u.nama as nama_kasir, p.jenis as paket, p.harga * d_t.qty as total FROM transaksi t, detail_transaksi d_t, paket p, member m, user u WHERE t.id_member = m.id AND t.id_user = u.id AND t.id = d_t.id_transaksi AND p.id = d_t.id_paket");
	$converters = ["status" => "status_to_badge_converter", "dibayar" => "status_to_badge_converter"];

	?>
	<table class="table table-striped table-borderless mt-3">
		<thead>
			<tr>
				<!--<th> # </th>-->
				<?php foreach (mysqli_fetch_fields($query_transaksi) as $field) : if ($field->name === "id") continue; ?>
					<th scope="col"> <?= ucwords(str_replace("_", " ", $field->name)) ?> </th>
				<?php endforeach; ?>
				<th> Aksi </th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 0;
			$prev_id = null;

			while ($data = mysqli_fetch_assoc($query_transaksi)) {
				++$no;
			?>
				<tr>
					<!--<th scope="row"><?= $no ?></th>-->
					<?php $prev_id = extract_transaksi_as_table_data($data, $prev_id, $converters); ?>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<?php
}
?>
