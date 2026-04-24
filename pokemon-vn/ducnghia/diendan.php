<?PHP
echo'
<ul class="NB_list-group deschat fixtop fixbot">';

$x = mysql_query("SELECT * FROM `forum` WHERE `type` = '1' OR `type` = '3' ORDER BY `time` DESC LIMIT  5");
while($xx = mysql_fetch_assoc($x)){
$t = mysql_fetch_assoc(mysql_query("SELECT `time` FROM `forum` WHERE `refid` = $xx[id] AND `type` = 2 ORDER BY `id` ASC LIMIT 1"));
$cmt = mysql_num_rows(mysql_query("SELECT * FROM `forum` WHERE `type` = 2 AND `refid` = {$xx[id]}"));
echo '<li class="list-group-item" style="background: rgba(255, 255, 255, 0.33);"><a href="javascript:node(\'/admin.php?ducnghia=php/nghia&id='.$xx[id].'#title\')"><i class="fa fa-comments"></i> '.BBCODE($xx['text'],1).' </a><br>
<small><i class="fa fa-clock-o"></i> <b>'.ducnghia_us($xx[user_id]).' , '.display_date($t['time']).' ['.$cmt.']</b></small></li>';
}
echo '</ul> </div>';