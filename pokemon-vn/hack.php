<?PHP
include_once('templates/config.php');
	include_once('templates/ducnghia.php');

 $datienhoa = array("Duskstone","Firestone","Leafstone","Moonstone","Ovalstone","Shinystone","Sunstone","Thunderstone","Waterstone","Dawnstone","Abomasite","Mewtwonite X","Mewtwonite Y","Mawilite","Beedrillite","Audinite","Medichamite","16","Pidgeotite","Steelixite","Heracronite","Houndoominite","Sceptilite","Blazikenite","Swampertite","Cameruptite","Banettite","Tyranitarite","Manectite","Aggronite","Gardevoirite","Galladite","Lopunnite","Diancite","Ampharosite","Altarianite","Latiasite","Latiosite","Charizardite Y","Charizardite X","mega","Đá Xanh","Đá Tím","Đá Vàng");

$ducnghia = $datienhoa;
echo $datienhoa[rand(0, count($datienhoa) - 1)];

