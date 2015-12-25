<?php
class Config
{
	public function data()
	{
		$family = parse_ini_file("config.ini");
  		echo "If we have ".$family['children']." children and ".$family['adult']." adults,<br>";
	}

	public function getChildren()
	{
		$family = parse_ini_file("config.ini");
		return $family['children'];
	}

	public function getAdults()
	{
		$family = parse_ini_file("config.ini");
		return $family['adult'];
	}
}

class Adult
{
	private $message="move 1 adult to the right bank\n";
	public function move()
	{
		$message="move 1 adult to the right bank\n";
		River::LogWrite($message);
	}
} 

class Fisherman extends Adult
{
	
	public function move()
	{
		$message="move fisherman to the right bank\n";
		River::LogWrite($message);
	}
	
}

class Child
{
	public function twoChildrenMove()
	{
		$message="move 2 children to right bank\n";
		River::LogWrite($message);
	}

	public function childBack()
	{
		$message="move 1 child back to the left bank\n";
		River::LogWrite($message);
	}

	public function childMove()
	{
		$message="move 2 children to the right bank\n";
		River::LogWrite($message);
	}

}

class River
{
	private $move=0; //river crossing iteration

	private function LogHeader()
	{
		$file = 'log.txt';
		$message = "Results:\n";
		file_put_contents($file, $message); //PHP 5, без FILE_APPEND, затираю предыдущие записи
		Config::data(); // display how many members of family we have
	}

	/*writing data to log file*/
	public function LogWrite($message)
	{
		$file = 'log.txt';
		$old_text = file_get_contents($file);
		file_put_contents($file, $message, FILE_APPEND); //PHP 5,  FILE_APPEND flag to add info
	}
	
	//writing number of transfers through the river to log file
	public function transfer($move)
	{ 
		$file = 'log.txt';
		$message = "Crossing #".$move.": ";
		file_put_contents($file, $message, FILE_APPEND); //PHP 5
		/* а можно так: $f = fopen("log.txt", "a+"); fwrite($f, "Crossing #".$move.": "); */
	}

	// how people cross the river
	public function crossing()
	{
		River::LogHeader(); // by inserting header delete all previous info in log file
		if(Config::getChildren()==1)
		{
			echo "Not enough children to cross the river. Are you sure you took all your kids from home?";
		}
		else if (Config::getChildren()==0) 
		{
			if (Config::getAdults()==0) 
			{
				echo "I guess all are staying at home, nobody wanted to move to the other bank, yep?";
			} 
			else 
			{
				echo "Not enough children to cross the river. Are you sure you took all your kids from home?";
			}
		} 
		else
		{
			if (Config::getAdults()>0) 
			{
				for ($i=0; $i < Config::getAdults(); $i++) 
				{ 
				$this->move++;
				$this->transfer($this->move);
				Child::twoChildrenMove();
				$this->move++;
				$this->transfer($this->move);
				Child::childBack();
				$this->move++;	
				$this->transfer($this->move);
				Adult::move();
				$this->move++;	
				$this->transfer($this->move);
				Child::childBack();
				}
			}

			if (Config::getChildren()>2) 
			{
				for ($i=0; $i < Config::getChildren()-2; $i++) //additional iterations for every child if children # more than 2
				{ 
					$this->move++;	
					$this->transfer($this->move);
					Child::childMove();
					$this->move++;	
					$this->transfer($this->move);
					Child::childBack();
				}
			}

		// move boatOwner - goes in any case
		$this->move++;
		$this->transfer($this->move);
		Child::twoChildrenMove();
		$this->move++;
		$this->transfer($this->move);
		Child::ChildBack();
		$this->move++;	
		$this->transfer($this->move);
		Fisherman::move();
		$this->move++;	
		$this->transfer($this->move);
		Child::childBack();

		//finally move 2 last children to right bank - goes in any case
		$this->move++;	
		$this->transfer($this->move);
		Child::twoChildrenMove();

		echo "they will have to cross the river ".$this->move." times.";
		}
	} /*end of function crossing*/
} /*end of class River*/

$experiment=new River();
$experiment->crossing();
