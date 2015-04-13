<?php
class Statistic {

	public function createStatistics($res_array){
		//$res_name, $classifier, $parent_id
		$src = new Source();
		$array = $src->viewSource($res_array['res_id']);
		
		//get instance headers
		$headers = array_keys($array[0]);
		//count number of headers and instances
		$start_stats = array (
			'attr_size' => count($headers),
			'instances' => count($array),
			'classifier' => $res_array['classifier']
		);
		//loop through each instance
		$i = 0;
		$toXML = '';
		$toXML .= $this->writeXML(0,'start',0,$start_stats,0);
		while($i < $start_stats['attr_size']){
			$attr_stats = $this->attributeStatistics($array, $headers, $i, $start_stats['instances']);
			//bins to be created for attribute HISTOGRAM
			if(($bins = $this->createBins($attr_stats['distinct'], $attr_stats['maximum'], $attr_stats['minimum'])) != false) {
				//if bins have been created assign instance count to each bin
				$bin_values = $this->binValues($attr_stats['array'], $bins, $headers);
				//return keys as csv string
				$histogram_values = $this->getHistogramValues($bin_values);
				$toXML .= $this->writeXML($i, 'instance',$headers,  $attr_stats, $histogram_values);

			}
			$i++;
		}//end while
			$toXML .= '</attributes></statistics>';
			//save xml in directory
			$result = $this->saveXML($res_array['res_name'], $toXML);
			return array(
				'parent_id' => $res_array['res_id'],
				'res_name' => $result['res_name'],
				'location' => $result['location'],
			);
	}//end process function
	
	public function saveXML($res_name, $toXML) {
		//set variables
		$target = DATA.'/statistics/';
		$i=0;
		$parts = pathinfo($res_name);
		$name = $parts['filename'].'.xml';
		while (file_exists($target . $name)) {
			$i++;
			$name = $parts['filename'].'.'. $i.'.xml';
		}
		$xml = fopen($target.$name, 'w');
		fwrite($xml, $toXML);
		if($i == 0){
			return array(
			'res_name' => $parts['filename'],
			'location' => '/statistics/' . $name
		);
		}else {
			return array(
				'res_name' => $parts['filename'].'.'.$i,
				'location' => '/statistics/' . $name
			);
		}
	}//end function
	
	public function writeXML($i, $type, $headers, $attr_stats, $hist_array){
		if($type == 'start'){
			return '<?xml version="1.0" encoding="UTF-8"?>
			<statistics>
				<information>
					<relation></relation>
					<instances>'.$attr_stats['instances'].'</instances>
					<attribute_count>'.$attr_stats['attr_size'].'</attribute_count>
					<classifier>'.$attr_stats['classifier'].'</classifier>
				</information>
				<attributes>';
		}
		if($type == 'instance'){
			return '<attribute>
			<name>'.$headers[$i].'</name>
			<missing>'.$attr_stats['missing_values'].'</missing>
			<distinct>'.$attr_stats['distinct'].'</distinct>
			<unique>'.$attr_stats['unique'].'</unique>
			<minimum>'.$attr_stats['minimum'].'</minimum>
			<maximum>'.$attr_stats['maximum'].'</maximum>
			<mean>'.$attr_stats['mean'].'</mean>
			<graph_categories>'.$hist_array['keys'].'</graph_categories>
			<graph_values>'.$hist_array['values'].'</graph_values>
		</attribute>';
		}
	}
	
	public function getHistogramValues($bin_values) {
		//GET KEY STRING
		$array = $bin_values;
		$first_key = key($array);
		$key_str = $first_key.'-';
		unset($array[$first_key]);
		$i =0;
		foreach($array as $key => $value){
			$key_str .= $key;
			if($i < count($array)-1){
				$key_str .= ','.$key.'-';	
				$i++;
			}		
		}//end for each for key string
		//GET VALUE STRING
		$first = key($bin_values); //returns first key of string
		if($first == 0){ //if the key is zero combine with next key pair
			$value = $bin_values[0];
			unset($bin_values[$first]);
			$first = key($bin_values);
			$bin_values[$first] += $value;
		}
		$values = implode(',', $bin_values);
		//return as an array
		return array (
			'keys' => $key_str,
			'values' => $values
		);
	}//end function
	
	public function attributeStatistics($array, $headers, $i, $instances){
		//get all instances of an attribute into an array
		foreach($array as $arr){
			${$headers[$i]} []  = $arr[$headers[$i]];
		}	
		//required logic
		$mean = array_sum(${$headers[$i]})/count(${$headers[$i]}); //mean average
		$grouped_values = array_count_values(${$headers[$i]}); //groups values into key and count of the same value as value
		ksort($grouped_values); //sorts value numerically
		$unique = 0;
		foreach($grouped_values as $grouped){ //for each to discover unique value count
				if($grouped == 1){
					$unique++;
				}
			}//end for each
		//return array
		return array (
			'array' => ${$headers[$i]},
			'missing_values' => $missing_values = $instances - count(${$headers[$i]}),
			'maximum' => $maximum = max(${$headers[$i]}),
			'minimum' => $minimum = min(${$headers[$i]}),
			'mean' => $mean = number_format($mean,'3','.',''),
			'grouped_values' => $grouped_values,
			'unique' => $unique,
			'distinct' => $distinct = count($grouped_values),
			'grouped_values' => $unique,
			'values_string' => implode (',', $grouped_values),
			'keys_string' => implode (',', array_keys($grouped_values)),
		);
	}//end function
	
	public function createBins($distinct, $maximum, $minimum) {
		$binNo = 13; //set automatically for graph spacing
		if($distinct > $binNo){ //if there are more distinct than the bin count
			$difference = $maximum - $minimum;
			$binInterval = $difference / $binNo;
			//set current value
			$current = $minimum;
			$bins [$minimum] = 0;
			//while statement to add intervals into an array
			while($current < $maximum) { 
				$current += $binInterval;
				$current = number_format($current,'3','.','');
				$bin_keys = array ($current => '0');
				//array_push($bins, $current);
				$bins[$current] = 0;
			}
			end($bins);
			$last = key($bins);
			if($last != $maximum){ //if checks if the last interval is maxmimum if not insert on the end
				if($last > $maximum){ 
					array_pop($bins);//deletes last element as it will be over maximum
					$bins[$maximum] = 0;
				} else {
					$bins[$maximum] = 0;
				}
			}
			return $bins;
		} else {
			return false;
		}
	}//end function create bins
	
	function binValues ($array, $bins, $headers){
		//loops through each instance
		foreach($bins as $key => $value){
			//loops through each bin to check against instance
			foreach($array as $arr){
				if($arr <= $key){
					$bins[$key] += 1;
					$array_key = array_search($arr, $array);
					unset($array[$array_key]);
				}
				
			}//end instance loop
		}//end for each
		return $bins;
	}
	
	function getChartData($cats, $values,$i){
		
		$labels = str_replace(',','","', $cats);
	
		return '
			var barChartData'.$i.' = {
				labels : ["'.$labels.'"],
				datasets : [
					{
						fillColor : "rgba(64,153,255,0.5)",
						strokeColor : "rgba(64,153,255,0.8)",
						highlightFill: "rgba(64,153,255,0.75)",
						highlightStroke: "rgba(64,153,255,1)",
						data : ['.$values.']
					}
				]
			}';
	}//end histogram function
	
	function loadCharts($i){
	
		
		return '
			var ctx'.$i.' = document.getElementById("canvas'.$i.'").getContext("2d");
			var graph'.$i.' = document.getElementById("canvas'.$i.'");
			window.myBar = new Chart(ctx'.$i.').Bar(barChartData'.$i.', {
				responsive : true,
				scaleShowGridLines : false,
				scaleShowHorizontalLines: false,
				barShowStroke : false,
				showScale: false,
				barValueSpacing : 1
			});';
	}//end histogram function
	
	public function viewStatistic ($res_id) {
		//get resource information
		$db = new Database ();
		$db->connect();
		$result = $db->query('SELECT * FROM resources WHERE resource_id ="'.$res_id.'"');
		if($result['error'] == true){
			return $result;
		}
		//get location of xml
		$resource_info = mysqli_fetch_array($result['result']);
		$location = $resource_info['location'];
		//parse xml
		$file = file_get_contents(DATA.$location);
		$xml = simplexml_load_string($file) or die("Error: Cannot create object");
		$total = $xml->information->instances;
		//for each attribute
		$i = 0;
		$loadData = '';
		$chartData = '';
		$instance_count = '';
		foreach($xml->attributes->children() as $attr){
			$instance_count = $total - $attr->missing;
			$percent = $instance_count / $total * 100;
			$percent = number_format($percent, 2, '.','');
			echo '<tr>';
			echo '<td style="text-align: center;"><p style="margin-top: 30px;">'.$attr->name . '</p></td>';
			echo '<td style="text-align: center;"><p style="margin-top: 30px;">'.'</p></td>';
			echo '<td style="text-align: center;"><p style="margin-top: 30px;">'.$instance_count. ' ('.$percent.'%)</p></td>';
			echo '<td style="text-align: center;"><p style="margin-top: 30px;">'.$attr->distinct . '</p></td>';
			echo '<td style="text-align: center;"><p style="margin-top: 30px;">'.$attr->unique . '</p></td>';
			echo '<td><canvas id="canvas'.$i.'" height="60" style="margin-right: -50px;"></canvas><td>';
			echo '<td"><a data-toggle="tooltip" title="Minimum: '.$attr->minimum . '<br>Maximum: '.$attr->maximum . '<br>Mean: '.$attr->mean . '<br> Std Dev: '.$attr->mean . '"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="margin-left: 15px; margin-top: 30px;"></span></a></td>';
			echo '</tr>';
			$chartData .= $this->getChartData($attr->graph_categories,$attr->graph_values,$i);
			$loadData .= $this->loadCharts($i);
			$i++;
		}
		
		echo '<script> '.$chartData.'
		window.onload = function(){'.$loadData.'
		}</script>';
	}//end view
 

}//end class
?>