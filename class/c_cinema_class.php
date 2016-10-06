<?php
include 'c_dao_class.php';
class c_cinema extends c_base_dao{

   
    public function insert($name,$addr,$area_name,$longitude,$latitude,$c_cinema_brand,$wxid){
        $sql = "INSERT INTO `statics`.`t_cinema` ( `c_name`, `c_addr`, `c_area_name`, `c_longitude`,
     `c_latitude`, `c_cinema_brand`, `c_163id`) VALUES('$name','$addr','$area_name','$longitude','$latitude','$c_cinema_brand','$wxid') ";
        if (!mysqli_query($this->link, $sql)) {
            echo $sql;
            echo mysqli_error($this->link);
        }
    }
    
    public function update($id,$new_id){
        $sql = "update t_cinema set c_163id=$new_id where c_id=$id";
        if (!mysqli_query($this->link, $sql)) {
            echo $sql;
            echo mysqli_error($this->link);
            exit;
        }
    }
    
     public function update_meituan($id,$meituan_id,$url){
        $sql = "update t_cinema set c_meituan_url='$url',c_meituan_id='$meituan_id' where c_id=$id ";
        if (!mysqli_query($this->link, $sql)) {
            echo $sql;
            echo mysqli_error($this->link);
            exit;
        }
    }
    
}
