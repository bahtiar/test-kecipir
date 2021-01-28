<?php
class TextAnalizer
{

    public function __construct() {
    }
    
    public function index()
    {
        $countNumber = [$this->getCount(1000000), $this->getCount(1000000000), $this->getCount(1000000000000)];
        echo render('digit.php',['countNumber' => $countNumber]);
    }

    public function getCount($digits)
    {
        if($digits < 10){
            $count = $digits;
        } else {
            $reduction = $this->reduction(strlen($digits));
            // $count = (strlen($digits)*$digits)-($reduction);
            $count = (($digits+$reduction)/strlen($digits));
        }
        // return $count;
        return substr(number_format($count, 0, "", ""), -1, 1);
    }

    public function reduction($length)
    {
        $count = 0;
        $nine = 9;
        for($i=1;$i< $length; $i++):
            $count += (int) $nine;
            $nine .= 9; 
        endfor;
        return (int)$count;
    }

}