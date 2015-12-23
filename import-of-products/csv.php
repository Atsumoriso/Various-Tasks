<?php
function validateFileType($file_type) {
		$filename = $_FILES["csv_file"]["name"];
		$file_type = array('csv');
    	$current_file_type = substr(strrchr($filename, '.'), 1);

	    if(!in_array($current_file_type, $file_type)){
	        return false;
	    } else {
	    	return true;
	    }
    }

function downloadCsv(){

/*Validating photo - checking if downloaded, size, type*/
if (isset($_FILES['csv_file'])) 
{
    /*checking photo size*/
    if($_FILES["csv_file"]["size"] > 1024*1024)
    {
      	echo "<p>Слишком большой файл.</p>";
      	exit;
    }
    /*Checking photo type*/
    elseif (validateFileType($_FILES["csv_file"]["type"]) == false) 
    {
    	echo "Файл должен быть в формате CSV";
      	exit;
    }


    /*Checking/creating image folder*/
    $dir = "download_to";
    if(!is_dir($dir)) mkdir($dir); 

    /*checking if photo downloaded correctly*/
    if(is_uploaded_file($_FILES["csv_file"]["tmp_name"]))
    {
      if($_FILES['csv_file']['error'] == 0){
        // Если файл загружен успешно, перемещаем его из временной директории в конечную
        move_uploaded_file($_FILES["csv_file"]["tmp_name"], "download_to/".$_FILES["csv_file"]["name"]);
        $_FILES["csv_file"]["tmp_name"] = "/import-of-products/download_to/";
      }
    }
    echo "CSV file downloaded successfully!<br>";
    //var_dump($_FILES['csv_file']);
} else {
	echo "Вы не выбрали файл.";
}
}


function getContent(){
	$filename = "download_to/products.csv";
	$handle = fopen("download_to/products.csv", "r");

	$contents = fread($handle, 8192);

	fclose($handle);
	return $contents;

}

/**
* Function takes data form csv file, proccesses it, creates and modifies array - prepares 
* data for futher writing to files by product, returns modified array  
*/
function createArray(){
	//$array = array_diff($array, array(''));

	//разбили данные на массив -> один продукт - одна строка
	$raw_data_1 = explode("\n", getContent());

    //создаем массив и записываем каждый товар в подмассив
	$raw_data_2 = [];
	foreach ($raw_data_1 as $value) {
		$value = explode(";", $value);
		$value = array_push($raw_data_2, $value);
	}

	// var_dump($raw_data_2);
	// echo "<br><br>";
return $raw_data_2;
}


/** 
* Function to replace " " with "-" in id;
*/
function replaceCommaToDot($subject){
    return str_replace(",",".", $subject);
}

/**
* Function to replace "," in prices with "." in prices
*/
function replaceSpaceToHyphen($subject){
    return str_replace(" ","-", $subject);
}

/**
* Function :
* 1) Creats source folders for enabled and disabled products and states access for them
* 2) Writes raw data to files by product
* Nothing is returned
*/
function saveFileByProducts(){

    $dir_for_enabled_products =  "./products/enabled/";
    if(!is_dir($dir_for_enabled_products)) mkdir($dir_for_enabled_products, 0777, true); 
    $dir_for_disabled_products =  "./products/disabled/";
    if(!is_dir($dir_for_disabled_products)) mkdir($dir_for_disabled_products, 0777, true);
    chmod('./products/', 0777);
    chmod('./products/enabled/', 0777);
    chmod('./products/disabled/', 0777);

    $raw_data_2 = createArray();
    foreach ($raw_data_2 as $key => $val1) {
        foreach ($val1 as $value) {
            //writing files with ENABLED products
            if ($raw_data_2[$key][3] == "yes") {
                $raw_data_2[$key][0] = replaceSpaceToHyphen($raw_data_2[$key][0]);
                $raw_data_2[$key][6] = replaceCommaToDot($raw_data_2[$key][6]);
                $raw_data_2[$key][7] = replaceCommaToDot($raw_data_2[$key][7]);
                $filename = $dir_for_enabled_products.$raw_data_2[$key][0];
                $str1 = "sku:".$raw_data_2[$key][0]."\n";
                file_put_contents($filename, $str1); // первый раз пишу в файл без FILE APPEND т.е. затираю предыдущие записи, если файл с таким id уже был, и далее дописываю
                $str2 = "name:".$raw_data_2[$key][1]."\n";
                $str3 = "description:".$raw_data_2[$key][2]."\n";
                $str4 = "is_enabled:".$raw_data_2[$key][3]."\n";
                $str5 = "is_in_stock:".$raw_data_2[$key][4]."\n";
                $str6 = "qty:".$raw_data_2[$key][5]."\n";
                $str7 = "price:".$raw_data_2[$key][6]."\n";
                $str8 = "special_price:".$raw_data_2[$key][7]."\n";
                $str9 = "size:".$raw_data_2[$key][8]."\n";
                $str10 = "color_id:".$raw_data_2[$key][9]."\n";
                $str11 = "color:".$raw_data_2[$key][10]."\n";
                $str12 = "image_url:"."http://cdn.richandroyal.de/media/external/D/".$raw_data_2[$key][0]."_".$raw_data_2[$key][9]."_1_455.jpg";

                $strAll = $str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11.$str12;
                file_put_contents($filename, $strAll, FILE_APPEND);
            } 
            //writing files with DISABLED products
            elseif ($raw_data_2[$key][3] == "no") {
                $raw_data_2[$key][0] = replaceSpaceToHyphen($raw_data_2[$key][0]);
                $raw_data_2[$key][6] = replaceCommaToDot($raw_data_2[$key][6]);
                $raw_data_2[$key][7] = replaceCommaToDot($raw_data_2[$key][7]);
                $filename = $dir_for_disabled_products.$raw_data_2[$key][0];
                $str1 = "sku:".$raw_data_2[$key][0]."\n";
                file_put_contents($filename, $str1); // без FILE APPEND - затираю предыдущие записи, если файл с таким id уже был, далее дописываю
                $str2 = "name:".$raw_data_2[$key][1]."\n";
                $str3 = "description:".$raw_data_2[$key][2]."\n";
                $str4 = "is_enabled:".$raw_data_2[$key][3]."\n";
                $str5 = "is_in_stock:".$raw_data_2[$key][4]."\n";
                $str6 = "qty:".$raw_data_2[$key][5]."\n";
                $str7 = "price:".$raw_data_2[$key][6]."\n";
                $str8 = "special_price:".$raw_data_2[$key][7]."\n";
                $str9 = "size:".$raw_data_2[$key][8]."\n";
                $str10 = "color_id:".$raw_data_2[$key][9]."\n";
                $str11 = "color:".$raw_data_2[$key][10]."\n";
                $str12 = "image_url:"."http://cdn.richandroyal.de/media/external/D/".$raw_data_2[$key][0]."_".$raw_data_2[$key][9]."_1_455.jpg";

                $strAll = $str2.$str3.$str4.$str5.$str6.$str7.$str8.$str9.$str10.$str11.$str12;
                file_put_contents($filename, $strAll, FILE_APPEND);
            }
        } 
    }  
    echo "Files were saved by product.<br>"; 
}

// execute
downloadCsv();
saveFileByProducts();
insertDataToDB();


function insertDataToDB()
{

    $raw_data = createArray();
    //$raw_data = array_shift($raw_data_2);
    //var_dump($raw_data);
    foreach ($raw_data as $key => $val1) {
        if($key >0)
        {
            $raw_data[$key][0] = replaceSpaceToHyphen($raw_data[$key][0]);
            $raw_data[$key][6] = replaceCommaToDot($raw_data[$key][6]);
            $raw_data[$key][7] = replaceCommaToDot($raw_data[$key][7]);

            $sku = $raw_data[$key][0];
            $name = $raw_data[$key][1];
            $description = $raw_data[$key][2];

            if($raw_data[$key][3]== 'yes')
            {
                $is_enabled = 1;
            } else
            {
                $is_enabled = 0;
            }

            if($raw_data[$key][4]== 'yes')
            {
                $is_in_stock = 1;
            } else
            {
                $is_in_stock = 0;
            }
            $quantity = $raw_data[$key][5];
            $price = $raw_data[$key][6];
            $special_price = $raw_data[$key][7];
            $size = $raw_data[$key][8];
            $color_id = $raw_data[$key][9];
            //$str11 = "color:".$raw_data[$key][10]."\n";
            $image_url = "http://cdn.richandroyal.de/media/external/D/".$raw_data[$key][0]."_".$raw_data[$key][9]."_1_455.jpg";

            $stmt = $dbh->prepare("INSERT INTO product (sku, `name`, description, is_enabled, is_in_stock, quantity, price, special_price, `size`, color_id, image_url ) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1, $sku);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $description);
            $stmt->bindParam(4, $is_enabled);
            $stmt->bindParam(5, $is_in_stock);
            $stmt->bindParam(6, $quantity);
            $stmt->bindParam(7, $price);
            $stmt->bindParam(8, $special_price);
            $stmt->bindParam(9, $size);
            $stmt->bindParam(10, $color_id);
            $stmt->bindParam(11, $image_url);
            $stmt->execute();
        }

    }
    echo "Data successfully saved to database<br>";

}




