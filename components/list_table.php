<?php
function extract_as_table_data($data, $converters = null)
{
	foreach ($data as $key => $value) {
		if ($key === "id") continue;

		$content = isset($converters[$key]) ? $converters[$key]($value) : $value;
?>
		<td><?= $content ?></td>
	<?php
	}
}

function list_table($mysqli_result, $converters = null)
{
	?>
	<table class="table table-striped table-borderless mt-3">
		<thead>
			<tr>
				<th> # </th>
				<?php foreach (mysqli_fetch_fields($mysqli_result) as $field) : if ($field->name === "id") continue; ?>
					<th scope="col"> <?= ucwords(str_replace("_", " ", $field->name)) ?> </th>
				<?php endforeach; ?>
				<th> Aksi </th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 0;

			while ($data = mysqli_fetch_assoc($mysqli_result)) {
				++$no;
			?>
				<tr>
					<th scope="row"><?= $no ?></th>
					<?php extract_as_table_data($data, $converters); ?>
					<td>
						<a class="btn btn-primary" class="remove-anchor" href="hapus.php?id=<?= $data["id"] ?>">Hapus</a>
						<span>|</span>
						<a class="btn btn-danger" class="edit-anchor" href="edit.php?id=<?= $data["id"] ?>">Edit</a>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<?php
}
?>
