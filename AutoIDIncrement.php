<?php
    include('dbConnect.php');

    function autoIDIncrement($string, $table, $idcolumn) {
        global $connect;
        $query = "SELECT * from $table Order By $idcolumn DESC LIMIT 1";
        $data = mysqli_query($connect, $query);

        $count = mysqli_num_rows($data);
        if($count == 0){
            $id = $string.'-001';
            return $id;
        }
        else{
            $row = mysqli_fetch_array($data);
            $id = $row[0];
            preg_match_all('(\d+)', $id, $matches);
            // var_dump($matches);
            $num = $matches[0][0];
            $num++;
            if($num >0 && $num <= 9){
                $id = $string.'-00'.$num;
            }
            else if($num >9 && $num <= 99){
                $id = $string.'-0'.$num;
            }
            else if($num >99 && $num <= 999){
                $id = $string.'-'.$num;
            }
            return $id;
        }
    }
    

?>