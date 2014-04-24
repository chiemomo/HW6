<?php

function count_letters($input){
	$results = array();
	$results['A'] = 0;
	$results['G'] = 0;
	$results['T'] = 0;
	$results['C'] = 0;
	
	for ($i = 0; $i < strlen($input); $i++) {

		$next_character = $input[$i]; //current character
		
		//increment by 1 for each letter
		if ( isset($results[$next_character]) )
			$results[$next_character] ++; //increment
		else {
			echo "The character is not one of the 4 nucleic acids.<br>";
		}
	}
	
	return $results;
	
}

//first, check if we have both post and get data
if ($_GET){

	//next, check that the 'command' has been passed with $_GET data
	if (isset($_GET['command'])){
		
		//for each possible command, generate a response
		if ($_GET['command'] == 'get_letters'){
			//dummy response -- ideally this comes a MySQL database
			$letters = array("A","G","T","C");
			
			//convert to JSON format
			$json_response = json_encode($letters);
			
			//echo the response -- the client will pick it up 
			echo $json_response;
		}
		else if ($_GET['command'] == 'count_letters') {
		
			if ($_POST) {
			
				if ( isset($_POST['sequence']) ) {
				
					$counts = count_letters($_POST['sequence']);
					//print_r($counts);
				
					$json_response = json_encode($counts);
					echo $json_response;

				}
			
			}
		
		}
		else if ($_GET['command'] == 'count_string') {
		
			if ($_POST) {
			
				if ( isset($_POST['sequence']) ) {
				
					$string = strlen($_POST['sequence']);
					//print_r($counts);
				
					$json_response = json_encode($string);
					echo $json_response;

				}
			
			}
		
		}
		
	}
	

}

?>