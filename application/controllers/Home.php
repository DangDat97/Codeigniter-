<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
{
parent::__construct();
$this->load->model('M_general');

}



	public function index()
	{
echo 'hihi';
	}

	


}
