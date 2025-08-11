<?php

function triSelection(&$tab){
    $length = count($tab);

    for($i=0;$i<$length-1;$i++){
        $minIndex = $i;
        for($j=$i+1;$j<$length;$j++){
            if ($tab[$j]<$tab[$minIndex]) {
                # code...
                $minIndex = $j;
            }
        }
        if ($minIndex != $i) {
            # code...
            $temp = $tab[$i];
            echo $temp.'<br/>';
            $tab[$i]=$tab[$minIndex];
            $tab[$minIndex]=$temp;
        }
    }

}

$table = array(150,130,569,10,167);
triSelection($table);

echo "Tableau trier <br/> ".implode("/ <br/>", $table);


?>