<p>Заметка #<?=$note['id']?></p>
<p><?=$note['date']?></p>
<p>Категория: <?=$cat['title']?>
<h2><?=$note['title']?></h2>
<p><?=$note['content']?></p>
<a href="/controllers/note.php">Назад</a>
<a href="/controllers/note.php?action=update&id=<?=$note['id']?>">Редактировать</a>
<a href="/controllers/note.php?action=delete&id=<?=$note['id']?>">Удалить</a>