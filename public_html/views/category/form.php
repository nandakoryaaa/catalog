<h2>Редактирование категории</h2>
<form
	method="post"
	action="/controllers/category.php?action=update&id=<?=$data['id']?>"
>
	<input
		type="text" name="title" size="64"
		maxlength="255"
		value="<?=$data['title']?>"
	>
	<br><br>
	<input type="submit" value="Соxранить">
</form>