<style>
.ducnghia_nhiemvu {
    background-image: url(/ducnghia/a/12.jpg);
 background-repeat: no-repeat;
    background-position: 40%;
    display: none;
    height: 100%;
    width: 250px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #232323;

    overflow-x: hidden;
    padding-top: 60px;
}

.ducnghia_nhiemvu a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 15px;
    color: #000000;
    display: block;
}

.ducnghia_nhiemvu a:hover {
    color: #FF0000;
}

.ducnghia_nhiemvu .ducnghia_dong_nhiemvu {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .ducnghia_nhiemvu {padding-top: 15px;}
  .ducnghia_nhiemvu a {font-size: 18px;}
}
</style>
<div id="ducnghia_nhiemvu_hien" class="ducnghia_nhiemvu">
  <a href="javascript:void(0)" class="ducnghia_dong_nhiemvu" onclick="ducnghia_nhiemvu_dong()">&times;</a>
    <b><a href="/index.php?page=ducnghia/nvlh"><i class="fa fa-globe" aria-hidden="true"></i> Nhiệm Vụ Thám Hiểm</b></a>
    <hr>
    <b><a href="/index.php?page=ducnghia/nvsk"><i class="fa fa-bug" aria-hidden="true"></i> Nhiệm Vụ Siêu Khó</b></a>
    <hr>
    <b><a href="/index.php?page=thanhtuu"><i class="fa fa-globe" aria-hidden="true"></i>Thành Tựu <img src="/images/hot.gif"> </b></a>
    <hr>
    
   
    
    <b><i  class="fa fa-fighter-jet" aria-hidden="true"></i>HẾT</b></a>
    <hr>
    
</div>
<script>
function ducnghia_nhiemvu() {
    document.getElementById("ducnghia_nhiemvu_hien").style.display = "block";
}

function ducnghia_nhiemvu_dong() {
    document.getElementById("ducnghia_nhiemvu_hien").style.display = "none";
}
</script>

