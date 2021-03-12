<a href="/controllers/category.php?action=update">Новая категория</a>

<table cellpadding="10">
	<tr>
		<th>ID</th>
		<th>Наименование</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($categories as $category) : ?>
	<tr>
		<td><?=$category['id']?></td>
		<td><?=$category['title']?></td>
		<td><a href="/controllers/category.php?action=view&id=<?=$category['id']?>">Просмотр</a></td>
		<td><a href="/controllers/category.php?action=update&id=<?=$category['id']?>">Редактировать</a></td>
		<td><a href="/controllers/category.php?action=delete&id=<?=$category['id']?>">Удалить</a></td>
	</tr>
	<?php endforeach ?>
</table>