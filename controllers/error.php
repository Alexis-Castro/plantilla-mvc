<?php
class er extends Controller
{

	function __construct()
	{

		parent::__construct();
		//echo "Error Existente";

	}

	function index()
	{

		$this->view->title = "404 Error !!";
		$this->view->msg = "Error 404 , No Existe la Página";
		$this->view->render('error/index', true);
	}
}
