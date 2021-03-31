<a href="/controllers/note.php?action=update">Новая запись</a>

<table cellpadding="10">
	<tr>
		<th>ID</th>
		<th>Дата</th>
		<th>Категория<a>
		<th>Тема</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($notes as $note) : ?>
	<tr>
		<td><?=$note['id']?></td>
		<td><?=$note['date']?></td>
		<td><?php
			if ($note['cat_title']) {
				echo $note['cat_title'];
			} else {
				echo '<font color="red">Без категории</font>';
			}
		?></td>
		<td><?=$note['title']?></td>
		<td><a href="/controllers/note.php?action=view&id=<?=$note['id']?>">Просмотр</a></td>
		<td><a href="/controllers/note.php?action=update&id=<?=$note['id']?>">Редактировать</a></td>
		<td><a href="/controllers/note.php?action=delete&id=<?=$note['id']?>">Удалить</a></td>
	</tr>
	<?php endforeach ?>
</table>
