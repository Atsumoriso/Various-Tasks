<?php


class Tree
{
    const INTERNAL_ELEMENT = '*',
        EXTERNAL_ELEMENT = ' ';

    protected $_rows;
    
    public function __construct($rows)
    {
        $this->_rows = (int)$rows;
    }

    public function draw()
    {
        return $this->_draw();
    }

    protected function _draw()
    {
    	if(!is_numeric($this->_rows)) {
    		echo 'Not integer.';
    		return;
    	}

        if ($this->_rows <= 1) {
        	echo 'Not valid number of rows';
        	return;
        } 

    	$externalElementsInRow = $this->_rows - 1;
    	$internalElementsInRow = 1;

    	for($i=1; $i<=$this->_rows; $i++) {

            $this->_drawElement($externalElementsInRow, self::EXTERNAL_ELEMENT);
            $this->_drawElement($internalElementsInRow, self::INTERNAL_ELEMENT);
            $this->_drawElement($externalElementsInRow, self::EXTERNAL_ELEMENT);
            $this->_drawLineBreak();
    		
            $externalElementsInRow--;
    		$internalElementsInRow+=2;
    	} 
    }

    protected function _drawElement($quantity, $element)
    {
	    for($j=1; $j<=$quantity; $j++) {
            echo $element;
        }
    }

    protected function _drawLineBreak()
    {
        echo "\n";
    }
}
$tree = new Tree(15);
$tree->draw();

