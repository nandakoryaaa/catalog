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
		'title' => null,
	];
}

function validate_model($model) {
	return !empty($model['title']);
}

function update($cn, $id) {
	if ($id) {
		$model = find_model($cn, $id);
	} else {
		$model = create_model();
	}

	if ($_POST) {
		load_model($model, $_POST);

		if ($id) {
			$query = 'update category set '
			. 'title=' . quote($cn, $model['title'])
			. ' where id=' . $id;
		} else {
			 $query = 'insert into category values(null'
			. ', ' . quote($cn, $model['title'])
			. ')';
		}

		$result = mysqli_query($cn, $query);

		header('Location: /controllers/category.php');
		return;
	}

	render('main', 'category/form', ['model' => html_convert($model)]);
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

function find_model($cn, $id) {
	$resultset = mysqli_query(
		$cn,
		'select * from category where id=' . quote($cn, $id)
	);

	$model = mysqli_fetch_assoc($resultset);
	if (!$model) {
		die("model $id not found");
	}

	return $model;
}

function view($cn, $id) {
	$model = find_model($cn, $id);
	$m = html_convert($model);
	render('main', 'category/view', ['model' => html_br($m)]);
}

function delete($cn, $id) {
	$model = find_model($cn, $id);
	$id = quote($cn, $id);
	mysqli_query(
		$cn, 
		'delete from category where id=' . $id
	);
	
	mysqli_query(
		$cn, 
		'update note set category_id=NULL'
		. ' where category_id=' . $id
	);
	
	header('Location: /controllers/category.php');
}

function index($cn) {
	$resultset = mysqli_query(
		$cn,
		'select * from category'
	);

	render('main', 'category/index', ['categories' => $resultset]);
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
