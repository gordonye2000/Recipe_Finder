<?php
/**
 * This file is used for Recipe Finder. All rights reserved.
 * Author: Gordon Ye 
 * Create Date: 2014-05-10
 * Update Date:
**/

class fridge {
	private static $_Object; 
	private $settings;
	
    /**
     * constructor : set up the variables
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
     * input items in fridge
     */
	public function readData($csv_items)
	{
		$items = str_getcsv($csv_items, "\n"); //parse the rows
		$this->settings = array();
		foreach($items as $item) {
			$i = explode(",", $item);
			$ii = array('Item'=>$i[0], 'Amount'=>$i[1], 'Unit'=>$i[2], 'Use-By'=>$i[3]); 
			$this->settings[$i[0]] = $ii;
		}
		return $this->settings;
	}
	
	/**
     * output items' name array
     */
	public function getAllItems()
	{
		return array_keys($this->settings);
	}
	
	/**
     * output items' data array
     */
	public function getAllItemsData()
	{
		return $this->settings;
	}
	
	/**
     * get item's Use-By date by name
     */
	public function getUseByDateByName($name)
	{
		return strtotime(str_replace('/', '-', $this->settings[$name]['Use-By']) );
	}
	
	/**
     * get min date among items
     */
	public function getMinDateAmongIngredients($names = array())
	{
		$dates = array();
		foreach($names as $name) {
			$dates[] = strtotime(str_replace('/', '-', $this->settings[$name]['Use-By']) );
		}
		return min($dates);
	}
	
	/**
     * get item's name by its Use-By date
     */
	public function getIngredientNameByDate($date='')
	{
		$dates = array();
		foreach($names as $name) {
			$dates[] = strtotime(str_replace('/', '-', $this->settings[$name]['Use-By']) );
		}
		return min($dates);
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


