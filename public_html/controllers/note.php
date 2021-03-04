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
		$model = find_model($cn, $id);
	} else {
		$model = create_model();
	}

	if ($_POST) {
		load_model($model, $_POST);

		if ($id) {
			$query = 'update note set '
			. 'date=' . quote($cn, $model['date'])
			. ', title=' . quote($cn, $model['title'])
			. ', content=' . quote($cn, $model['content'])
			. ' where id=' . $id;
		} else {
			 $query = 'insert into note values(null'
			. ', ' . quote($cn, $model['date'])
			. ', ' . quote($cn, $model['title'])
			. ', ' . quote($cn, $model['content'])
			. ')';
		}

		$result = mysqli_query($cn, $query);

		header('Location: /controllers/note.php');
		return;
	}

	render('main', 'form', $model);
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
		'select * from note where id=' . quote($cn, $id)
	);

	$model = mysqli_fetch_assoc($resultset);
	if (!$model) {
		die("model $id not found");
	}

	return $model;
}

function view($cn, $id) {
	$model = find_model($cn, $id);
	render('main', 'view', $model);
}

function delete($cn, $id) {
	$model = find_model($cn, $id);
	$result = mysqli_query(
		$cn, 
		'delete from note where id=' . quote($cn, $id)
	);
	header('Location: /controllers/note.php');
}

function index($cn) {
	$resultset = mysqli_query(
		$cn,
		'select * from note'
	);

	render('main', 'index', $resultset);
}

function render($container, $view, $data) {
	require("../views/$container.php");
}

