<?php


class Index extends AbstractController
{
    private $phonemodel;
    public function __construct()
    {
        $this->phonemodel = new PhoneModel();
    }

    public function index()
    {
        $data['phones'] = $this->phonemodel->allPhone();

        return Router::render('main',$data);
    }

}