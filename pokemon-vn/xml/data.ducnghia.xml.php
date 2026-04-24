<?php
	header("Content-Type: text/xml; charset=utf-8");
include_once('../templates/config.php');
	include_once('../templates/lib.php');
	include_once('../templates/includes/Array2XML.php');
class mapg {
    public function __construct(...$args) {
        $this->mapg(...$args);
    }
		public $id = 0;
	
		public function mapg($id) {
			$user = mysql_fetch_array(mysql_query("SELECT * FROM `bando` WHERE `id` = '" . mysql_real_escape_string($id) . "'"));

			foreach($user as $key => $value) {
				$this->{$key} = $value;
			}


			$this->data = json_decode($this->data);
			if (!isset($this->data)) {
				$this->data = new stdClass();
			}
			



		
		}
	}
		$m = new mapg(1);

while($i <=70) {
	    $i2 = 0;
	    while($i2 <=70) {
	        $data = 'y'.$i.'x'.$i2.'';
	      $msg.= ''.$m->data->$data.',';  
	        $i2++;
	    }
	    
	    $datamap = '['.$msg.'],';
	    
	    $i++;
	    
	    
	}


	


$results['ducnghia_datamap'] = array(
					'data'=>$datamap
				);		
				
$results['ducnghia_pokemon'] = array(
					'datapkm'=>'HIHI'
				);						
				
       


	$xml = Array2XML::createXML('map', $results);
	die(preg_replace('~\s*(<([^-->]*)>[^<]*<!--\2-->|<[^>]*>)\s*~', '$1', $xml->saveXML()));
?>
