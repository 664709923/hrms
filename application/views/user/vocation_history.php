<table>
<?php
foreach ($vocations as $vocation) {
?>
	<tr>
	<td><?=$vocation['startTime'];?>
	</td>
	<td><?=$vocation['endTime'];?>
	</td>
	<td><?=$vocation['desp'];?>
	</td>
	</tr>
<?php
}
?>
</table>
