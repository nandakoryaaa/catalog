<p>Заметка #<?=$data['id']?></p>
<p><?=$data['date']?></p>
<h2><?=$data['title']?></h2>
<p><?=$data['content']?></p>
<a href="/controllers/note.php">Назад</a>
<a href="/controllers/note.php?action=update&id=<?=$data['id']?>">Редактировать</a>
<a href="/controllers/note.php?action=delete&id=<?=$data['id']?>">Удалить</a>