<a href="/controllers/note.php?action=update">Новая запись</a>

<table cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Дата</th>
        <th>Тема</th>
        <th></th>
        <th></th>
        <th></th>
	</tr>
	<?php foreach($data as $note) : ?>
    <tr>
        <td><?=$note['id']?></td>
        <td><?=$note['date']?></td>
        <td><?=$note['title']?></td>
        <td><a href="/controllers/note.php?action=view&id=<?=$note['id']?>">Просмотр</a></td>
        <td><a href="/controllers/note.php?action=update&id=<?=$note['id']?>">Редактировать</a></td>
        <td><a href="/controllers/note.php?action=delete&id=<?=$note['id']?>">Удалить</a></td>
    </tr>
	<?php endforeach ?>
</table>