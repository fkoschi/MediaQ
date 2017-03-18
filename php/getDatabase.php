<?php
	
	session_start();
	
//////////////////////////////////////////////variables
    $allSeasons = array();
    $allSeasonsMarkers = array();
    $videoUrl = 'http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/video_content/';
    require_once('../db.php');
    $DB = new db;
    $con = $DB->connect();
    $radius = 100;
    $queryLat = $_POST['lat'];
    $queryLon = $_POST['lon'];
    $deltaLat = rad2deg(asin(sqrt(sin($radius/(12742*1000))*sin($radius/(12742*1000)))))*2;
    $deltaLon = rad2deg(asin(sqrt((sin($radius/(12742*1000))*sin($radius/(12742*1000)))/(cos(deg2rad($queryLat))*cos(deg2rad($queryLat))))))*2;

//////////////////////////////////////////////functions   
    
	function get_distance_in_meter($lat1, $lon1, $lat2, $lon2) {
		$latDist = deg2rad($lat2-$lat1);
		$lonDist = deg2rad($lon2-$lon1);
		$a = sin($latDist/2) * sin($latDist/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDist/2) * sin($lonDist/2);
		return 2*6371000*asin(sqrt($a));
	}
	
	function angle_from_coordinates($lat1, $lon1, $lat2, $lon2) {
		$dLon = $lon2 - $lon1;
		$y = sin($dLon) * cos($lat2);
		$x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
		$brng = rad2deg(atan2($y, $x));
		$brng = ($brng + 360) % 360;
		$brng = 360 - $brng;
		
		if($brng > 180) {
			$brng -= 360;
		}
		return $brng;
	}
	
	function point_in_fov($lat1, $lon1, $lat2, $lon2, $radius, $thetaX, $alpha) {
		//object, position, radius...
		$angle = angle_from_coordinates($lat2, $lon2, $lat1, $lon1);
		$radius = ($radius * 10)*100;
		$dist = get_distance_in_meter($lat1, $lon1, $lat2, $lon2);
		
		if($dist > $radius) {
			return false;
		} else if ($lat1 == $lat2 && $lon1 == $lon2) {
			return false;
		} else if (abs($angle - $thetaX) < $alpha/2) {
			return true;
		}
		return false;
	}
	
	function trajectory_in_array($array, $traj) {
		if(array_key_exists($traj, $spring)) {
			return true;
		} else {
			return false;
		}
	}
	
	function sql_one_candidate_per_trajectory($con, $queryLat, $queryLon, $deltaLat, $deltaLon) {
//  	$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha from VIDEO_METADATA where Plat > '".$queryLat."'-'".$deltaLat."' and Plat < '".$queryLat."'+'".$deltaLat."' and Plng > '".$queryLon."'-'".$deltaLon."' and Plng < '".$queryLon."'+'".$deltaLon."' ;";
// 		$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha from VIDEO_METADATA where Plat > '".$lat."'-'".$deltaLat."' and Plat < '".$lat."'+'".$deltaLat."' and Plng > '".$lon."'-'".$deltaLon."' and Plng < '".$lon."'+'".$deltaLon."' LIMIT 20;";
// 		$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha, TimeCode from VIDEO_METADATA where Plat > '".$queryLat."'-'".$deltaLat."' and Plat < '".$queryLat."'+'".$deltaLat."' and Plng > '".$queryLon."'-'".$deltaLon."' and Plng < '".$queryLon."'+'".$deltaLon."' group by VideoId limit 30;";
		$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha, TimeCode from VIDEO_METADATA where Plat > '".$queryLat."'-'".$deltaLat."' and Plat < '".$queryLat."'+'".$deltaLat."' and Plng > '".$queryLon."'-'".$deltaLon."' and Plng < '".$queryLon."'+'".$deltaLon."' group by VideoId;";
		
		return mysqli_query($con, $sql);		
	}
	
	function sql_all_candidates_per_trajectory($con, $queryLat, $queryLon, $deltaLat, $deltaLon) {
// 		$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha, TimeCode from VIDEO_METADATA where Plat > '".$queryLat."'-'".$deltaLat."' and Plat < '".$queryLat."'+'".$deltaLat."' and Plng > '".$queryLon."'-'".$deltaLon."' and Plng < '".$queryLon."'+'".$deltaLon."' order by VideoId, FovNum;";
		$sql = "select VideoId, FovNum, Plat, Plng, ThetaX, R, Alpha, TimeCode from VIDEO_METADATA where Plat > '".$queryLat."'-'".$deltaLat."' and Plat < '".$queryLat."'+'".$deltaLat."' and Plng > '".$queryLon."'-'".$deltaLon."' and Plng < '".$queryLon."'+'".$deltaLon."';";
		
		return mysqli_query($con, $sql);
	}
	
	function get_season_arrays($con, $result, $allSeasons, $videoUrl, $queryLat, $queryLon, $deltaLat, $deltaLon) {
		$spring = array();
		$summer = array();
		$autumn = array();
		$winter = array();
		$springMarkers = array();
		$summerMarkers = array();
		$autumnMarkers = array();
		$winterMarkers = array();
		$sumSnippets = 0;
		
		foreach ($result as $key => $value) {
			if(point_in_fov($queryLat, $queryLon, $value['Plat'], $value['Plng'], $value['R'], $value['ThetaX'], $value['Alpha'])) {
				$point = array();
				$point['VideoURL']	= $videoUrl . $value['VideoId'];;
				$point['VideoId']	= $value['VideoId'];
				$point['Plat']		= $value['Plat'];
				$point['Plng']		= $value['Plng'];
				$point['FovNum']	= $value['FovNum'];
				
				//compute corresponding season
				$videoId = explode('_', $point['VideoId']);
				$month=$videoId[2];
				if($point['Plat']>0) {
					$north=true;
				} else {
					$north=false;
				}
				//0 = spring, 1 = summer, 2 = autumn, 3 = winter
				$season = get_season($month, $north);
				
				$seasonArray = get_season_array($season, $spring, $summer, $autumn, $winter);
				
				//compute start of video snippet
				if($value['FovNum'] == 1) {
					$point['SnippetStart'] = 0;
				} else {
					$sql = "select TimeCode from VIDEO_METADATA where VideoId = '".$point['VideoId']."' and FovNum = '1';";
					$timeAtOne = mysqli_fetch_row(mysqli_query($con, $sql))[0];					
					$point['SnippetStart'] = time_ms_to_string($value['TimeCode'] - $timeAtOne);
				}
				
				//compute stop of video snippet
				$sql = "select TimeCode from VIDEO_METADATA where VideoId = '".$point['VideoId']."' and FovNum = '".$point['FovNum']."'+1;";
				$timeSuccessor = mysqli_fetch_row(mysqli_query($con, $sql))[0];
				$point['SnippetStop'] = time_ms_to_string($point['SnippetStart'] + ($timeSuccessor - $value['TimeCode']));		
				$point['SnippetDuration'] = $point['SnippetStop']-$point['SnippetStart'];
					
		    	//add to specified season
		    	if(($point['SnippetStart'] != $point['SnippetStop']) && ($point['SnippetDuration'] > 2000)) {
		    		if($season == 0) {
		    				array_push($spring, $point);
		    		} else if($season == 1) {
		    				array_push($summer, $point);
		    		} else if($season == 2) {
		    				array_push($autumn, $point);
		    		} else if($season == 3) {
		    				array_push($winter, $point);
		    		}
		    	}

		    	$sumSnippets+=$point['SnippetDuration'];
// 		    	if($sumSnippets > 30000) {
// 		    		break;
// 		    	}
			}
	    }    

	    array_push($allSeasons, $spring);
	    array_push($allSeasons, $summer);
	    array_push($allSeasons, $autumn);
	    array_push($allSeasons, $winter);

    	return $allSeasons;
	}
	
	function point_relevant_for_video($point) {
		if($point['SnippetDuration'] < 2000) {
			return false;
		}
		return true;
	}
	
	function time_ms_to_string($ms) {
		return $ms;
	}
	
	function get_season($month, $north) {
		//0 = spring, 1 = summer, 2 = autumn, 3 = winter
		$season=-1;
		
		if(1 <= $month && $month <= 3) {
			if($north) {
				$season = 3;
			} else {
				$season = 1;
			}
		} else if(4 <= $month && $month <= 6) {
			if($north) {
				$season = 0;
			} else {
				$season = 2;
			}
		} else if(7 <= $month && $month <= 9) {
			if($north) {
				$season = 1;
			} else {
				$season = 3;
			}
		} else if(10 <= $month && $month <= 12) {
			if($north) {
				$season = 2;
			} else {
				$season = 0;
			}
		}
		
		return $season;
	}
	
	function get_season_array($season, $spring, $summer, $autumn, $winter) {
		if($season == 0) {
			return $spring;
		} else if($season ==1 ) {
			return $summer;
		} else if($season == 2) {
			return $autumn;
		} else if($season == 3) {
			return $winter;
		}
	}
	
//////////////////////////////////////////////main part
	
	//get one candidate per trajectory and compute the snippet
// 	$result = sql_one_candidate_per_trajectory($con, $queryLat, $queryLon, $deltaLat, $deltaLon);
	
	//get all candidates, sort per trajectory, compute snippets
	$result = sql_all_candidates_per_trajectory($con, $queryLat, $queryLon, $deltaLat, $deltaLon);
	
	//compute allSeasons-array
	$allSeasons = get_season_arrays($con, $result, $allSeasons, $videoUrl, $queryLat, $queryLon, $deltaLat, $deltaLon);
    
	//send output, store as global variable
    echo json_encode($allSeasons);
    $_SESSION['allSeasons'] = $allSeasons;
    
    
//////////////////////////////////////////////end	

    // 	function add_candidate_to_arrays($videoFiles, $VideoId, $i, $current) {
    // 		if(!array_contains_trajectory($videoFiles, $VideoId)) {
    // 			array_push($videoFiles[$i], $current);
    // 		} else {
    // 			$i+=1;
    // 			$t = array();
    // 			array_push($current);
    // 			array_push($videoFiles[i], $current);
    // 		}
    
    // 	}
    
    // 	function array_contains_trajectory($videoFiles, $VideoId) {
    // 		if($videoFiles !== '0' && empty($videoFiles)) {
    // 			return false;
    // 		}
    // 		end($videoFiles);
    // 		$last_id=key($videoFiles);
    // 		$reset($videoFiles);
    
    // 		if(strcmp($videoFiles[last_id][0]['VideoId'], $VideoId == 0)) {
    // 			return true;
    // 		}
    
    
    // 	function sql_to_array($result, $videoUrl) {
    // 		foreach ($result as $key => $value) {
    // 			$result[$key]['VideoUrl'] 	  = $videoUrl . $value['VideoId'];
    // // 			$video_files[$key]['VideoId']	  = $value['VideoId'];
    // // 			$video_files[$key]['Plat'] 	      = $value['Plat'];
    // // 			$video_files[$key]['Plng'] 	      = $value['Plng'];
    // // 			$video_files[$key]['FovNum'] 	  = $value['FovNum'];
    // // 			$video_files[$key]['ThetaX'] 	  = $value['ThetaX'];
    // // 			$video_files[$key]['R'] 		  = $value['R'];
    // // 			$video_files[$key]['Alpha'] 	  = $value['Alpha'];
    // // 			$video_files[$key]['TimeCode']	  = $value['TimeCode'];
    // 		}
    
    // 		return $result;
    // 	}
    
    
    	//	function sql_to_array_per_trajectory($result, $videoUrl, $queryLat, $queryLon) {
    	// 		$videoFiles = array();
    	// 		$resultIndex = 0;
    	// 		$videoFilesIndex = 0;
    	// 		$previousVideoId;
    	// 		foreach ($result as $key => $value) {
    	// 			$current[$key]['Plat'] 	      = $value['Plat'];
    	// 			$current[$key]['Plng'] 	      = $value['Plng'];
    	// 			$current[$key]['ThetaX'] 	  = $value['ThetaX'];
    	// 			$current[$key]['R'] 		  = $value['R'];
    	// 			$current[$key]['Alpha'] 	  = $value['Alpha'];
    		
    	// 			if(point_in_fov($queryLat, $queryLon, $value['Plat'], $value['Plng'], $value['R'], $value['ThetaX'], $value['Alpha'])) {
    	// 				$current[$key]['VideoUrl'] 	  = $videoUrl . $value['VideoId'];
    	// 				$current[$key]['VideoId']	  = $value['VideoId'];
    	// 				$current[$key]['FovNum'] 	  = $value['FovNum'];
    	// 				$current[$key]['TimeCode']	  = $value['TimeCode'];
    
    	// 				if($resultIndex==0) {
    	// 					$t = array();
    	// 					array_push($t, $current);
    	// 					array_push($videoFiles[0], $current);
    	// 				} else {
    	// 					if(strcmp($previousVideoId, $current[$key]['VideoId']) == 0) {
    	// 						array_push($videoFiles[$videoFilesIndex], $current);
    	// 					} else {
    	// 						$videoFilesIndex+=1;
    	// 						$t = array();
    	// 						array_push($t, $current);
    	// 						array_push($videoFiles[$videoFilesIndex], $current);
    	// 					}
    	// 				}
    	// 				$previousVideoId = $current[$key]['VideoId'];
    	// 			}
    	// 			$resultIndex+=1;
    	// 		}
    	// 		return $videoFiles;
    	// 	}

    // 	function get_season_arrays2($allSeasons, $videoUrl, $con, $queryLat, $queryLon, $deltaLat, $deltaLon) {
    // 		$spring = array();
    // 		$summer = array();
    // 		$autumn = array();
    // 		$winter = array();
    
    // 		$result = sql_all_candidates_per_trajectory($con, $queryLat, $queryLon, $deltaLat, $deltaLon);
    
    // 		$videoFiles = sql_to_array_per_trajectory($result, $videoUrl, $queryLat, $queryLon);
    
    // 		return $videoFiles;
    // 	}
    	
    	
    // 		return false;
    // 	}
    
    
    // 	function get_predecessor_on_trajectory($videoId, $fovNum, $seasonArray) {
    // 		$predecessor = end($seasonArray);
    // 		reset($seasonArray);
    
    // 		if((strcmp($predecessor['VideoId'], $videoId) == 0) && ($predecessor['FovNum'] == $fovNum-1)) {
    // 			return true;
    // 		} else {
    // 			return false;
    // 		}
    // 	}
    
    
    // 1. There are three points: North Pole, P and Query. We need to compute angle Query,P,NorthPole
    //    Honestly I don't know at the moment if this is the correct formulae as we are computing this angle on the earth's surface, that's to say not in a layer!?
    // 	$NorthLat = 90;
    // 	$NorthLon = 0;
    // 	$thetaarray = array();
    // 	foreach ($video_files as &$value) {
    // 		$Plat = $value['Plat'];
    // 		$Plon = $value['Plng'];
    // 		$a = get_distance_in_meters($NorthLat, $NorthLon, $Plat, $Plon);
    // 		$b = get_distance_in_meters($Plat, $Plon, $queryLat, $queryLon);
    // 		$c = get_distance_in_meters($queryLat, $queryLon, $NorthLat, $NorthLon);
    // 		$theta = acos((a*a + b*b - c*c)/(2*a*b));
    // 		array_push($thetaarray, $theta);
    // 	}
    
    // 2. If absolute value(angle - thetaX) > alpha -> object is visible, else delete candidate
    
    // 3. get first point of trajectory (FovNum=1) and the following point (FovNum++) via sql
    // 4. with help of timecode (i guess these are milliseconds?) compute interval when the extract starts and stops
    // 5. add refering to months (already implemented) to the array.
    // 6. i think the best way to store them is for every extract we save VideoID, Plat, Plng and the time interval(start and stop)
    //    With help of them we can draw a marker for every extract and with the interval the videos can be concatenated. Maybe it is worth thinking about joining extracts with the same VideoID.

    // 	$downloadPathsFile = "./ffmpeg-download/downloadPaths.txt";
    // 	$fh = fopen($downloadPathsFile, 'a') or die("can't open file");
	// $hello = "".$value['VideoId']."\n";
    //	fwrite($fh, $hello);
    // 	fclose($fh);
?>
