<?php
session_start();
include_once 'functions.php';
if(!isLoggedIn()){
	header('Location:registration.php');
    exit;
} else {
	echo "";
}
checkSession();
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Интернет-магазин</title>
	<link type="text/css" rel="stylesheet" href="css/main.css"/>
</head>
<body>
<?php
/**
* Checking variable $sortBy which allows to show correctly current choice
*/
if (isset($_GET['sort'])){
	$sortBy = $_GET['sort'];
} elseif (isset($_COOKIE['sort'])) {
	$sortBy = $_COOKIE['sort'];
}

// код ниже не срабатывал полноценно при запросе ГЕТ, селектед присваивался некорректно, поэтому написал иф выше
// $sortBy = (isset($_GET['sort'])) ? $_GET['sort'] : '';
// $sortBy = (isset($_COOKIE['sort'])) ? $_COOKIE['sort'] : ''; //без этой строчки кода при возрате на страницу продукты (например, со страницы индекса), в форме не отображаются (не сохраняются) изменения 

?>
<!-- Form for sorting products -->
<div><form method="GET">
		<p><select name="sort">

		    <option value="name"<?php if(isset($sortBy) && $sortBy === "name") echo "selected";?>>Product name</option>
		    <option value="cheap"<?php if(isset($sortBy) && $sortBy == "cheap") echo "selected";?>>Price ascending</option>
		    <option value="expensive"<?php if(isset($sortBy) && $sortBy == "expensive") echo "selected";?>>Price descending</option>
   		</select>
   <input type="submit" value="sort"></p></form>
</div>
<?php

/**
* This function gets info about enabled products from files
*/
function getProductInfo(){
	//finding files & creating array with file names
	$dir = __DIR__."/products/enabled";
	$enabled_products = scandir($dir);
	array_splice($enabled_products, 0, 2); //delete path (first 2 elements)

	//creating array for every product and writing all data to one array
	$product_info = [];
	foreach ($enabled_products as $file) {
	
	    $file = file_get_contents(dirname(__FILE__).'/products/enabled/'.$file);

		//$file = file(__DIR__.'/products/enabled/'.$file); - можно и так, но тут не получилось, т.к. после $file = explode(";", $file); ругался что передаю массив на 2 параметр, а надо стринг, не стал копаться...

		$file = str_replace("\n", ";", $file);
		$file = explode(";", $file);

		foreach ($file as $value) {
			$value = explode(":", $value);
			$value = array_push($product_info, $value); // получаем 1 массив из всех продуктов
		}
	}

	//split array for sub-arrays 12 elements each (1 sub-arr for 1 product)
	$product_info = array_chunk($product_info, 12);
	return $product_info;
}


/**
* This Function displays all products by default
*/
function displayEnabledProducts($product_info){
	
	foreach ($product_info as $value) {
		//list($sku, $product_info) = explode(":", $val1); echo $sku."+".$product_info." ";
		//list($Нужная строка, $мусор) = explode("cp", $изначальная строка);
?>
<div>
	<table class="one_product_box">
	<col width="150">
   	<col width="200">
<?php 
			if ($value[7][1]) {
?>
				<tr><td>Special price!</td><td> <?php echo "USD ".$value[7][1];?> !!!</td></tr>
<?php
			}
?>
			<tr><td>Product ID</td><td> <?php echo $value[0][1];?> </td><td rowspan="9"><a href="<?php echo 'http:'.$value[11][2];?>"><img src="<?php echo 'http:'.$value[11][2];?>" height="200" title="<?php echo $value[1][1]?>"/></a></td></tr>
			<tr><td>Product name</td><td> <?php echo $value[1][1];?> </td></tr>
			<tr><td>Size</td><td> <?php echo $value[8][1];?> </td></tr>
			<tr><td>Color</td><td> <?php echo $value[10][1];?> </td></tr>
			<tr><td>Description</td><td> <?php echo $value[2][1];?> </td></tr>
			<tr><td>Availability</td><td> <?php echo $value[4][1];?> </td></tr>
<?php
			if ($value[5][1]<10) {
?>
				<tr><td>Stock</td><td><strong>LOW!</strong></td></tr>
<?php
			} else {
?>
				<tr><td>Stock</td><td>10+</td></tr>
<?php
			}
			if ($value[7][1]) {
?>
				<tr><td>Price</td><td class="strike"><?php echo "USD ".$value[6][1];?></td></tr>
				<tr><td>Special price!</td><td> <?php echo "USD ".$value[7][1];?> </td></tr>
<?php
			} else {
?>
				<tr><td>Price</td><td><?php echo "USD ".$value[6][1];?></td></tr>
<?php
			}
	}
}

/**
* This Function checks GET parameter or If Cookie exists, and realizes correspondent scenario (shows current user's choice)
*/
function checkGetParameter(){

    if (isset($_GET['sort'])) {
    	$sortBy = $_GET['sort'];
    	//echo "сейчас сработал GET<br>".$sortBy; // проверка
		switch ($sortBy) {
		    case 'name':
		        setcookie("sort", "name", time() + 3600, "source-it.me/day-6/");
			 	$product_info = sortByName(getProductInfo());
		        break;
		    case 'cheap':
		        setcookie("sort", "cheap", time() + 3600, "source-it.me/day-6/");
				$product_info = sortByPriceAsc(getProductInfo());
		        break;
		    case 'expensive':
		    setcookie("sort", "expensive", time() + 3600, "source-it.me/day-6/");
				$product_info = sortByPriceDes(getProductInfo());
		        break;
		}
		exit;
	}
	if(isset($_COOKIE['sort'])){
		$sortBy = $_COOKIE['sort'];
		//echo "сейчас сработал cookie<br>".$sortBy; // проверка
		if($sortBy == "name") {
			 	$product_info = sortByName(getProductInfo());
		        exit;
		} elseif($sortBy == "cheap") {
				$product_info = sortByPriceAsc(getProductInfo());
		        exit;
		} elseif($sortBy == "expensive") {
				$product_info = sortByPriceDes(getProductInfo());
		        exit;
        }      
	 }  
	if(!isset($sortBy)){
        // default sorting - by name
    	$product_info = sortByName(getProductInfo());
	}
} 
	
checkGetParameter();

/**
*  Function to sort by product name from A to Z
*/
function sortByName($product_info){
	$product_info = getProductInfo();
 	$tmp = []; 
 	foreach($product_info as &$val) {
	    $tmp[] = &$val[1][1]; // [1][1] is name
	}
	array_multisort($tmp, $product_info); 
	// foreach($product_info as &$val) { // проверка
	// 	echo $val[1][1]."<br/>"; 
	// }
	displayEnabledProducts($product_info);
}

/**
* Function to sort by price ascending
*/
function sortByPriceAsc($product_info){
	$product_info = getProductInfo();
 	$tmp = []; 
 	foreach($product_info as &$val) {
 		if ($val[7][1]) { // if there is special price, we take it, if not - ordinary price
 			$tmp[] = &$val[7][1]; // [7][1] is special price
 		} else {
 			$tmp[] = &$val[6][1]; // [6][1] is price
 		}

	}
	array_multisort($tmp, $product_info); 
	//print_r($tmp); //проверка 1
	// foreach($product_info as &$val) { // проверка 2
	// 	if ($val[7][1]) {
 		// 	echo $val[7][1]."<br/>"; ; // [7][1] is special price
 		// } else {
 		// 	echo $val[6][1]."<br/>"; ; // [6][1] is price
 		// }
	// }
	displayEnabledProducts($product_info);
}

/**
* Function to sort by price ascending
*/
function sortByPriceDes($product_info){
	$product_info = getProductInfo();
 	$tmp = []; 
 	foreach($product_info as &$val) {
 		if ($val[7][1]) { // if there is special price, we take it, if not - ordinary price
 			$tmp[] = &$val[7][1]; // [7][1] is special price
 		} else {
 			$tmp[] = &$val[6][1]; // [6][1] is price
 		}

	}
	array_multisort($tmp, SORT_NUMERIC, SORT_DESC, $product_info); // PHP.net => Пример #2 Сортировка многомерного массива - array_multisort($ar[0], SORT_ASC, SORT_STRING, $ar[1], SORT_NUMERIC, SORT_DESC);

    //print_r($tmp); //проверка 
	displayEnabledProducts($product_info);
}




?>

	</table>
</div>
</body>
</html>