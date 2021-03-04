<h2>Добавление заметки</h2>
<form
	method="post"
	action="/controllers/note.php?action=update&id=<?=$data['id']?>"
>
	<input
		type="text" name="title" size="64"
		maxlength="255"
		value="<?=$data['title']?>"
	>
	<br><br>
	<textarea
		name="content" cols="64" rows="8"
	><?=$data['content']?></textarea>
	<br><br>
	<input type="submit" value="Соxранить">
</form>
