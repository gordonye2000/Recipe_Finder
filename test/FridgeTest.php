<?php
require_once(__DIR__. '\..\fridge.php');

class FridgeTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }

  public function testGetInstance()
  {   
	$fridge = fridge::getInstance();
    $this->assertInstanceOf('fridge', $fridge);
	return $fridge;
  }
  
  /**
     *  @depends testGetInstance
     */
  public function testReadData(fridge $fridge)
  {
    $csv = "bread,10,slices,21/12/2014\ncheese,10,slices,24/12/2014\nbutter,250,grams,25/12/2014";
	$returnArray = $fridge->readData($csv);
    $this->assertInternalType('array', $returnArray);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetAllItems(fridge $fridge) 
  {
	$items = $fridge->getAllItems();
    $this->assertInternalType('array', $items);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetAllItemsData(fridge $fridge) 
  {
	$itemData = $fridge->getAllItemsData();
    $this->assertInternalType('array', $itemData);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetUseByDateByName(fridge $fridge) 
  {
	$dateStr = $fridge->getUseByDateByName('cheese');
	$usedBy = strtotime(str_replace('/', '-', '24/12/2014'));
    $this->assertEquals($usedBy, $dateStr);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetMinDateAmongIngredients(fridge $fridge)
  {
    $ingredients = array('bread', 'cheese', 'butter');
	$dateStr = $fridge->getMinDateAmongIngredients($ingredients); 
	$usedBy = strtotime('21/12/2014');  
    $this->assertEquals($usedBy, $dateStr[0]);
  }
  
  
  
}

?>