<?php
////xử lí////

///////////
    header('Content-Type: image/png');
    $img = imagecreatefrompng('pokeball_throw.png');
    imagealphablending($img, true);
    imagesavealpha($img, true);
   
 $x = ImageSX($img);
    $y = ImageSY($img);
    /////ảnh có 3 hình
  

  $background1 = imagecolorat($img, 0, 0);
    $background2 = imagecolorat($img, 1, 1);
    $img2= imagecreatetruecolor(40, 40);
    imagealphablending($img2, true);
    imagesavealpha($img2, true);

    $trans_colour = imagecolorallocatealpha($img2, 0, 0, 0, 127);
    imagefill($img2, 0, 0, $trans_colour);
    $doc = ($_GET['doc'] ?? 0);
    $trai = ($_GET['trai'] ?? 0);  ///0,34,66
    imagecopy($img2, $img, 0, 0, $trai, $doc, 40, 40);
    imagedestroy($img);
    // output cropped image to the browser
    imagepng($img2);
    
    
      



