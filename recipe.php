<?php
/**
 * This file is used for Recipe Finder. All rights reserved.
 * Author: Gordon Ye 
 * Create Date: 2014-05-10
 * Update Date:
**/

class recipe {
	private static $_Object; 
	private $settings;
	
    /**
     * constructor : set up the variables
     *
     * @return object
     */
	function __construct()
	{
		self::$_Object = $this;
		return self::$_Object;
	}

    /**
     * Get the module static object
     *
     * @return self
     */
    public static function getInstance() 
    {
    	$class = __CLASS__;
    	if (!isset(self::$_Object)) {
    		return new $class();
    	}	
    	return self::$_Object;
    }
	    
	/**
     * input recipe
     *
     */

	public function readData($recipe_data)
	{
		$this->settings = array();
		$this->settings = json_decode(stripslashes($recipe_data), true);
	}
	
	/**
     *
     * @return array with recipes' name
     */
	public function getAllRecipes()
	{
		$recipes = array();
		foreach($this->settings as $r) {
			$recipes[] = $r['name'];
		}
		return $recipes;
	}
	
	/**
     *
     * @return recipes' data
     */
	public function getAllRecipesData()
	{
		return $this->settings;
	}
	
	/**
     *
     * @return a specific recipe's data
     */
	public function getRecipeByName($name)
	{
		foreach($this->settings as $recipe) {
			if($recipe['name'] == strtolower($name) )
				return $recipe;
		}
	}
	
	/**
     *
     * @return ingredient array of a specific recipe
     */
	public function getIngredientRByecipeName($name)
	{
		$ingredient = array();
		foreach($this->settings as $recipe) {
			if($recipe['name'] == strtolower($name) ) {
				foreach($recipe['ingredients'] as $i) {
					$ingredient[] = $i['item'];
				}
				return $ingredient;
			}
		}
	}
	
    /**
     * Magic Get
     *
     * @param string $property Property name
     *
     * @return mixed
     */
    final public function __get($property)
    {
        return $this->__getProperty($property);
    }

    /**
     * Magic Set
     *
     * @param string $property Property name
     * @param mixed $value New value
     *
     * @return self
     */
    final public function __set($property, $value)
    {
        return $this->__setProperty($property, $value);
    }

    /**
     * Magic Isset
     *
     * @param string $property Property name
     *
     * @return boolean
     */
    final public function __isset($property)
    {
       return isset($this->settings[$property]);
    }

    /**
     * Get Property
     *
     * @param string $property Property name
     *
     * @return mixed
     */
    protected function __getProperty($property)
    {
        $value = null;

        $methodName = '__getVal' . ucwords($property);
        if(method_exists($this, $methodName)) {
            $value = call_user_func(array($this, $methodName));
        } else {
        	if (isset($this->settings[$property])) {
        		$value = $this->settings[$property];
        	}
        }

        return $value;
    }
    
    /**
     * Set Property
     *
     * @param string $property Property name
     * @param mixed $value Property value
     *
     * @return self
     */
	final protected function __setProperty($property, $value)
    {
        $methodName = '__setVal' . ucwords($property);
        if(method_exists($this, $methodName)) {
            call_user_func(array($this, $methodName), $value);
        } else {
       		$this->settings[$property] = $value;
        }
            
        return $this;
    }
	

    /**
     * Set __getValSettings Property
     *
     * @param mixed $value Property value
     *
     * @return self
     */
    private function __getValSettings(){
    	return 	$this->settings;
    }     
	
	/**
     * Display the object 
     *
     * @return void
     */
    public function printMe() {
		echo '<br />';
		echo '<pre>';
		print_r ($this);
		echo '</pre>';
	}
}


