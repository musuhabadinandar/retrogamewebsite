<?PHP
include_once('../templates/config.php');
include_once('../templates/ducnghia.php');
?>
<br><div class="kengang"></div><center onclick="nap()">Nạp thẻ</center><div class="kengang"></div>


<center><b class="viptxt" id="notice_the">Sai mệnh giá và loại thẻ sẽ mất</b></center>

<center>
    
  Loại thẻ :     <select id="card_type_id">
                                    <option value="1">Viettel</option>
                                    <option value="2">Mobiphone</option>
                                    <option value="3">Vinaphone</option>
                                    <option value="4">Gate</option>
                                </select>
                           <br>     
 Mệnh giá : <select id="price_guest">
								
									<option value="0">- Chọn mệnh giá -</option>
                                    <option value="10000">10.000 - 20 ruby</option>
                                    <option value="20000">20.000 - 50 ruby</option>
                                    <option value="30000">30.000 - 75 ruby</option>
                                    <option value="50000">50.000 - 160 ruby</option>
                                    <option value="100000">100.000 - 350 ruby</option>
                                    <option value="200000">200.000 - 950 ruby</option>
                                    <option value="300000">300.000 - 2.500 ruby</option>
                                   
  <!--------<option value="0">- Chọn mệnh giá X2 nạp thẻ -</option>
                                    <option value="10000">10.000 - 40 ruby</option>
                                    <option value="20000">20.000 - 100 ruby</option>
                                    <option value="30000">30.000 - 150 ruby</option>
                                    <option value="50000">50.000 - 320 ruby</option>
                                    <option value="100000">100.000 - 700 ruby</option>
                                    <option value="200000">200.000 - 1900 ruby</option>
                                    <option value="300000">300.000 - 5000 ruby</option>                                  ------>
                                    
                                </select>     <br>  
  Mã thẻ :            <input type="text" value="" id="pin"  placeholder="Mã thẻ">                   
               <br>
               Serial : <input type="text" value="" id="seri" placeholder="Seri">
       <textarea class="none" name="note" id="note" class="form-control" >NẠP TIỀN VÀO ID GAME : <?=$datauser->id?> </textarea>        <br> 
       mã bảo mật :         
 	<input type="text" id="ma_bao_mat"  name="ma_bao_mat" placeholder="Mã bảo mật">    <img height="45" src="/napthe/securimage/securimage_show.php" id="captcha"/>
 	
 	<button onclick="napthe()">Nạp Thẻ</button>
</center>