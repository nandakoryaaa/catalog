<h3>Редактирование заметки</h3>
<form
	method="post"
	action="/controllers/note.php?action=update&id=<?=$model['id']?>"
>
	<label for="title">Заголовок</label><br>
	<input
		type="text" name="title" id="title" size="64"
		maxlength="255"
		value="<?=$model['title']?>"
	>
	<br><br>
	<label for="category_id">Категория</label><br>
	<select name="category_id" id="category_id">
		<?php foreach ($categories as $id => $title) : ?>
		<option value="<?=$id?>"><?=$title?></option>
		<?php endforeach ?>
	</select>
	<br><br>
	<label for="content">Контент</label><br>
	<textarea
		name="content" id="content" cols="52" rows="8"
	><?=$model['content']?></textarea>
	<br><br>
	<input type="submit" value="Соxранить">
</form>