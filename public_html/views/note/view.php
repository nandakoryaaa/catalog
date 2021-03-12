<p>Заметка #<?=$model['id']?></p>
<p><?=$model['date']?></p>
<h2><?=$model['title']?></h2>
<p><?=$model['content']?></p>
<a href="/controllers/note.php">Назад</a>
<a href="/controllers/note.php?action=update&id=<?=$model['id']?>">Редактировать</a>
<a href="/controllers/note.php?action=delete&id=<?=$model['id']?>">Удалить</a>