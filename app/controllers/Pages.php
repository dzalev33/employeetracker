<?php
class Pages extends Controller {

    public function __construct()
    {

    }

    public function index(){

        $data = ['title' => 'Recruitment Task'];
        $this->view('pages/index',$data);
    }

}