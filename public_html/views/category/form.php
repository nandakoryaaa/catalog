<h2>Редактирование категории</h2>
<form
	method="post"
	action="/controllers/category.php?action=update&id=<?=$model['id']?>"
>
	<input
		type="text" name="title" size="64"
		maxlength="255"
		value="<?=$model['title']?>"
	>
	<br><br>
	<input type="submit" value="Соxранить">
</form>