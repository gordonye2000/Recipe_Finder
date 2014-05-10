<?php

// Magic class load : load the classes
function __autoload($class_name) {
	$name_parts = explode("_", $class_name);
	foreach ($name_parts as $key => $name) {
		if (strtolower($name) == 'class') {
			unset($name_parts[$key]);
		}
	}
	$class_name = implode("_", $name_parts);
	$class_file_name = $class_name.".php";
	require_once ($class_file_name);
}

if($_POST) {
	if(empty($_REQUEST['recipe']) ) {
		echo "Order Takeout.";
	}
	else if(empty($_REQUEST['fridge']) ) {
		echo "Please iuput fridge CSV data.";
	}
	else{
		// Get the fridge data 
		$fridge = fridge::getInstance();
		$fridge->readData($_REQUEST['fridge']);
		//$is = $fridge->getAllItems();

		// get the recipe data 
		$recipe = recipe::getInstance();
		$recipe->readData($_REQUEST['recipe']);
		$rs = $recipe->getAllRecipes();
		$recommendation = "";
		
		if($rs==null || count($rs) == 0) 
			echo "Order Takeout";
		else if( count($rs) == 1) { // one recipe is found 
			$recommendation = $rs[0]; 
		}
		else{ // more than one recipe is found
			$compare = array();
			foreach($rs as $k=>$v){
				$ingredients = $recipe->getIngredientRByecipeName($v);
				$min = $fridge->getMinDateAmongIngredients($ingredients);
				$compare[$v] = $min;
			}

			$result = array_keys($compare, min($compare));	
			$recommendation = $result[0];
		}
		
		echo ucfirst($recommendation);
		
		if(!empty($recommendation) ) { // check whether an ingredient that is past its useby date
			$r = $recipe->getRecipeByName($recommendation);
			foreach($r['ingredients'] as $i) {
				$date = $fridge->getUseByDateByName($i['item']);
				if (time() > $date)
					echo "<p>The " . $i['item'] . " is expired. It cannot be used for cooking!";
			}
		}
	}
}

echo "<p class='space'> ----------------- Input fridge and recipe data below------------------ </p>";

?>

<form action="" method="post">
  <div>Fridge CSV String: <p><textarea name="fridge"><?php if($_REQUEST['fridge']) echo $_REQUEST['fridge']; ?></textarea></p></div>
  <div>Recipe JSON Data: <p><textarea name="recipe"><?php if($_REQUEST['recipe']) echo stripslashes($_REQUEST['recipe']); ?></textarea></p></div>
  <input type="submit" value="Submit">
</form> 
<style>
textarea {
	width: 550px;
	height: 250px;
}

.space {
	margin-top: 50px;
}
</style>

</body>
</html>