<?php
class TextAnalizer
{

    public function __construct() {
    }
    
    public function index()
    {
        if(isset($_POST['data_string'])):
            $str = $_POST['data_string'];
            $str = str_replace(' ', '', $str);
            $data = [];
            if(strlen($str) > 0):
                $kPos = 0;
                $space = 0;
                $positionSpace = '';
                $grouping = $this->grouping(strtolower($str));
                foreach($grouping as $k => $v):
                    if($k == ' '):
                        $space = $v['count'];
                        $positionSpace = $v['position'];
                    endif;
                endforeach;
                foreach($grouping as $k => $v):
                    $position = $this->position(strtolower($str), $v['position'], $kPos, $space, $positionSpace);
                    if($position['max'] != 0):
                        $distance = $position['max'];
                    else:
                        $distance = '';
                    endif;
                        $data[] = ['value' => $v['value'],
                                   'count' =>$v['count'],
                                   'before' =>$position['before'],
                                   'after' =>$position['after'],
                                   'distance' => $distance];
                    $kPos++;
                endforeach;
            endif;
        else:
            $data = [];
        endif;
        echo render('textAnalizer.php',['data' => $data]);
    }

    public function grouping($string)
    {
        $result = str_split($string);
        $resultArray = [];
        foreach($result as $k => $v):
            if (array_key_exists($v, $resultArray)) {
                $position = $k+1;
                $resultArray[$v]['count'] =  $resultArray[$v]['count'] + 1;
                $resultArray[$v]['position'] =  $resultArray[$v]['position'] . ',' . $position;
            } else {
                    $position = $k+1;
                    $resultArray[$v] = ['position' => $position, 'value' => $v, 'count' => 1];
            }
        endforeach;

        return $resultArray;
    }

    public function position($str, $position, $kPos, $space, $positionSpace)
    {
        $before = '';
        $after = '';
        $positionArray = explode(',', $position);
        $positionASpacerray = explode(',', $positionSpace);
        $count = count($positionArray);
        $keyEnd = $count-1;
        $countFirst = $positionArray[0];
        $countEnd = $positionArray[0];
        $spaceCount = 0;

        foreach($positionArray as $key => $value):
            $checkEnd = $key + 1;
            if($value == 1 && $count == 1):
                $after .= 'tidak ada';

                $beforeY = ($key == 0) ? substr($str, $value, 1) : ', ' . substr($str, $value, 1);
                $before .= $beforeY;
            elseif($count == 1 && strlen($str) == $value):
                $positionAfter = $value - 2;
                $after .= ($positionAfter < 0) ? '' : ', ' . substr($str, $positionAfter, 1);

                $before .= 'tidak ada';
            else:
                $positionAfter = $value - 2;
                $afterX = ($positionAfter < 0) ? '' : ', ' . substr($str, $positionAfter, 1);
                $after .= $afterX;

                $before .= ($key == 0) ? substr($str, $value, 1) : ', ' . substr($str, $value, 1);
            endif;
            $countEnd = $value;

        endforeach;

        $after = (substr($after, 0, 1) == ',') ? substr($after, 2) : $after;
        $max = ($countFirst == $countEnd) ? 0 : $countEnd-($countFirst+$spaceCount);
        return ['before' => $before, 'after' => $after, 'max' => $max, 'spaceCount' => $spaceCount];
    }
}