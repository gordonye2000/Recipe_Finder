<?php
require_once(__DIR__. '\..\recipe.php');

class RecipeTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }

  public function testGetInstance()
  {   
	$recipe = recipe::getInstance();
    $this->assertInstanceOf('recipe', $recipe);
	return $recipe;
  }
  
  /**
     *  @depends testGetInstance
     */
  public function testReadData(recipe $recipe)
  {
    $json_data = '[{"name": "grilled cheese on toast","ingredients": [{ "item":"bread", "amount":"2", "unit":"slices"},{ "item":"cheese", "amount":"2", "unit":"slices"}]},{"name": "salad sandwich","ingredients": [{ "item":"bread", "amount":"2", "unit":"slices"},{ "item":"mixed salad", "amount":"200", "unit":"grams"}]}]';
	$returnArray = $recipe->readData($json_data);
    $this->assertInternalType('array', $returnArray);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetAllRecipes(recipe $recipe) 
  {
	$recipes = $recipe->getAllRecipes();
    $this->assertInternalType('array', $recipes);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetAllRecipesData(recipe $recipe) 
  {
	$recipeData = $recipe->getAllRecipesData();
    $this->assertInternalType('array', $recipeData);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetRecipeByName(recipe $recipe) 
  {
	$recipeArray = $recipe->getRecipeByName('salad sandwich');
    $this->assertInternalType('array', $recipeArray);
  }
  
  /**
	 *  @depends testGetInstance
     *  @depends testReadData
     */
  public function testGetIngredientRByecipeName(recipe $recipe)
  {
	$ingredient = $recipe->getIngredientRByecipeName('grilled cheese on toast'); 
    $this->assertInternalType('array', $ingredient);
  }
  
  
  
}

?>