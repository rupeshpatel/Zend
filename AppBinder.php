<?php

define("BASE_PATH",realpath(dirname(__FILE__)));
define("DS","\\"); 
  
abstract class AppBinder
{
  
  
  function getModel($uri)
  {
    
	  $exeptions =array();
	 
	 $name_ex = explode("/",$uri);
 
	 $module = $name_ex[0];
	 $class_name = $name_ex[0]."_Model_".$name_ex[1];
	 $sub_path_ex = explode("_",$name_ex[1]);
	
	 $model_name = $sub_path_ex[count($sub_path_ex)-1];
	 unset($sub_path_ex[count($sub_path_ex)-1]);
	 $include_path = BASE_PATH.DS.$module.DS."models".DS.implode(DS,$sub_path_ex); 
	 
	 $model_file = $include_path.$model_name.".php";
	 
	 if(file_exists($model_file))
	 require_once($model_file);
	 else
	 $exeptions[] = "file Not Found : ".$model_file;
	  
	 $db_table_file = $include_path.DS."DbTable".DS.$model_name.".php";
	 
	 if(file_exists($db_table_file))
	 require_once($db_table_file);
	 else
	 $exeptions[] = "file Not Found : ".$db_table_file;
     
	
	 
	 if(class_exists($class_name))
	  return $model_obj = new $class_name;
	 else
	 {
	   $exeptions[] = "Class Not Found : ".$class_name;
	   return $exeptions;
	 }
  }
    
  
  
   
	function getModel($table_name,$functions=array())
   {
	   $class_defination='class TABLE_NAME extends Zend_Db_Table_Abstract
                     {
                          ////////Functions////////
						  
						 protected $name = "TABLE_NAME";
					   
					   function hello()
                      {
	                     return "Hello from Getmodel";   
                      }	 
                      }';
	   $class_defination = str_replace('TABLE_NAME',$table_name,$class_defination);	
	   foreach($functions as $function )
	   {
		     $class_defination = str_replace('////////Functions////////',$function.'////////Functions////////',$class_defination);	
	   }		  
	   eval($class_defination);
		
	   try
	   {
		 $model = new $table_name; 
	     return $model;
	   }
	   catch(Exeption $e) 
	   {
		  return "Error Occured";
	   }				  
       
   }			  	 
  
  
}
  
?>