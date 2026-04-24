<?PHP
 
include_once('../templates/config.php');
include_once('../templates/ducnghia.php');

if(isset($_GET[skill])) {
    mysql_query("INSERT INTO `levelen` SET 
 `level` = '".$_POST[level]."', `wild_id` = '".$_POST[id]."',`wat` = 'att', `aanval` = '".$_POST[aanval]."'");       
}

if(isset($_GET[add])) {
    $id = $_POST[id];
    $on = $_POST[onclick];
    $code = $_POST[ma];
    $na = $_POST[ten];
    $npcs = new npcs($id);
    $npcs->add($code,'id',$code);
    
    $npcs->add($code,'name',$na);
    $npcs->add($code,'onclick',$on);
    
    echo'Thành công : '.$on.' - '.$na.' ';
}

if(isset($_GET[xoa])) {
    $id = $_POST[id];
    $on = $_POST[onclick];
    $na = $_POST[ten];
        $code = $_POST[ma];

    $npcs = new npcs($id);
    $npcs->xoa($code);
    echo'Xóa : '.$on.'  ';
}