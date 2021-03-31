<?php
$connection = mysqli_connect(
	'localhost', 'cat', 'cat123', 'cat'
);

$action = get_param('action', $_GET);
$id = (int) get_param('id', $_GET);

if ($action == 'update') {
	update($connection, $id);
} else if ($action == 'view' && $id) {
	view($connection, $id);
} else if ($action == 'delete' && $id) {
	delete($connection, $id);
} else {
	index($connection);
}

function get_param($name, $data) {
	if (isset($data[$name])) {
		return $data[$name];
	}
	return null;
}

function create_model() {
	return [
		'id' => null,
		'category_id' => null,
		'date' => date('Y-m-d H:i:s'),
		'title' => null,
		'content' => null
	];
}

function validate_model($model) {
	return $model['title'] && $model['content'];
}

function update($cn, $id) {
	if ($id) {
		$model = find_model($cn, 'note', $id);
	} else {
		$model = create_model();
	}

	if ($_POST) {
		load_model($model, $_POST);

		if ($id) {
			$query = 'update note set '
			. 'category_id=' . quote($cn, $model['category_id'])
			. ', date=' . quote($cn, $model['date'])
			. ', title=' . quote($cn, $model['title'])
			. ', content=' . quote($cn, $model['content'])
			. ' where id=' . $id;
		} else {
			 $query = 'insert into note values(null'
			. ', ' . quote($cn, $model['category_id'])
			. ', ' . quote($cn, $model['date'])
			. ', ' . quote($cn, $model['title'])
			. ', ' . quote($cn, $model['content'])
			. ')';
		}
		$result = mysqli_query($cn, $query);

		header('Location: /controllers/note.php');
		return;
	}

	$categories = get_categories($cn);

	render('main', 'note/form', [
		'model' => html_convert($model),
		'categories' => $categories
	]);
}

function load_model(&$model, $data) {
	foreach($model as $key => $value) { 
		if (isset($data[$key])) {
			$model[$key] = $data[$key];
		}
	}
}

function quote($cn, $value) {
	return "'" 
		. mysqli_real_escape_string($cn, $value)
		. "'";
}

function find_model($cn, $table, $id) {
	$resultset = mysqli_query(
		$cn,
		'select * from ' . $table . ' where id=' . quote($cn, $id)
	);

	$model = mysqli_fetch_assoc($resultset);
	if (!$model) {
		die("model $id not found");
	}

	return $model;
}

function view($cn, $id) {
	$note = find_model($cn, 'note', $id);
	$cat = null;
	if (!is_null($note['category_id'])) {
		$cat = find_model(
			$cn,
			'category',
			$note['category_id']
		);
	}
	$m = html_convert($note);
	render('main', 'note/view', [
		'note' => html_br($m),
		'cat' => $cat
	]);
}

function delete($cn, $id) {
	$model = find_model($cn, 'note', $id);
	$result = mysqli_query(
		$cn, 
		'delete from note where id=' . quote($cn, $id)
	);
	header('Location: /controllers/note.php');
}

function index($cn) {
	$resultset = mysqli_query(
		$cn,
		'select note.*, category.title as cat_title'
		. ' from note left join category'
		. ' on note.category_id = category.id'
	);

	render('main', 'note/index', [
		'notes' => $resultset
	]);
}

function get_categories($cn) {
	$resultset = mysqli_query(
		$cn,
		'select * from category'
	);

	$out = [];
	foreach($resultset as $cat) {
		$id = $cat['id'];
		$title = $cat['title'];
		$out[$id] = $title;
	}

	return $out;
}

function render($container, $view, $data) {
	extract($data);
	require("../views/$container.php");
}

function html_convert($model) {
	$out = [];
	foreach($model as $key => $value) {
		$out[$key] = htmlspecialchars($value);
	}

	return $out;
}

function html_br($model) {
	$out = [];
	foreach($model as $key => $value) {
		$out[$key] = nl2br($value);
	}

	return $out;
}
