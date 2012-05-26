<?php 
class Contextresolver 
{
  	function _construct()
	{
	 
	}
	
	function _init(&$object)
	{
	  $this->object_ref = $object; 
	  $this->class_name = get_class($object);
	  $this->context_arr = $this->getContext();
	}
	
	function _init_by_class_name($class_name)
	{
	   try{
	   $this->object_ref = new $class_name; 
	   $this->class_name = get_class($this->object_ref);
	   $this->context_arr = $this->getContext();	
	   }
	   catch(Exception $e)
	   {
		 return NULL;   
	   }
	}
	
	function getithParameter($method,$i,$class=NULL)
    {
	   if($class!=NULL){
	    try
         {
	         $p = new ReflectionParameter(array($class,$method),$i);
		     return $p;
	     }
        catch(Exception $e){
	             return NULL;
	     };
	  }
	  else
	   return NULL;
    }
	
	
	
	function getContext()
	{
	   $context = array();
	   $context["class"] = $this->class_name;
	   $k = 0;
	   $methods = get_class_methods($this->class_name);
	   foreach($methods as $method)
	   {
	     $method_con["name"] = $method;
		 $params = array();
		 $temp_param = "";
		  for($i=0 ; $i<20 ; $i++)
		      {
				 $temp_param = $this->getithParameter($method,$i,$this->class_name);
				   if($temp_param != NULL)
				   $params[] = $temp_param;
			  } 
			 $method_con["params"] = $params;
			 $context["methods"][$k] = $method_con; 
	     $k++;
	   }
	   return $context;
	 }
	
	
	function print_context()
	{
	  	$tab = "&nbsp;&nbsp;&nbsp;";
		echo "<pre>";
		  echo "<strong>CLASS</strong>::".$this->context_arr["class"];
		  $temp_class_name = $this->class_name;
		  while(get_parent_class($temp_class_name))
		  { 
		    $temp_class_name = get_parent_class($temp_class_name);
		    echo " <br>".$tab."Child of :: ".$temp_class_name." ";
		  }
		  echo "<br><br>";
		  echo "<strong>MEHTODS</strong>::<br>";
		  $k=0;
		  foreach($this->context_arr["methods"] as $method)
		  {
			  
			  echo $tab.$k."). ".$method['name']."<br>";
			  echo $tab.$tab."<strong>PARAMS::</strong>";
			  if(count($method["params"])<2)
			  echo "void <br>";
			  else
			  echo "<br>";
			  foreach($method["params"] as $param)
			  {
				  echo $tab.$tab.$tab.$param."<br>";
			  }
			  $k++;
		  }
		echo "</pre>";
	}
	
}

?>