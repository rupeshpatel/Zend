<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $model = AppBinder::getModel('guestbook');
	   $model->load(1);
	   echo "<pre>";
	   $resolver = new Contextresolver();
	   $resolver->_init($model);
	   $resolver->print_context();
	   exit;
	   $data = array('email' => '','comment' => '');
	   $row = $model->createRow($data);	   $row->save(); 
		//print_r($row);
	   $resolver->_init($row);
	   $resolver->print_context();
	   exit;
	}
	public function __call($method,$params)
	{
	 // echo $_SERVER['REQUEST_URI'];
	 
	  echo file_get_contents('http://localhost:81/ZendExp/');
	 
	  exit;	
	}


}

