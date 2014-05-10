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
  public function testGetMinDateAmongIngredients(fridge $fridge)
  {
    $ingredients = array('bread', 'cheese', 'butter');
	$dateStr = $fridge->getMinDateAmongIngredients($ingredients);
    $this->assertEquals(strtotime('21/12/2014'), $dateStr[0]);
  }
  
  
  
}

?>