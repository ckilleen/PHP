<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Message Board Data</title>
	<style>
		h1 {
			color: black;
			/* background: white; */
			font-size: 40px;
			font-family: "serif", "Times New Roman", "bookman";
			text-shadow: 4px 4px 8px white;
		}
		/* unvisited link */
		a:link {
			color: darkblue;
			/* background: white; */
			font-size: 20px;
			font-family: "bookman", "Times New Roman", "serif";
			/* text-shadow: 2px 2px 4px black; */
		}

		/* visited link */
		a:visited {
			color: darkblue;
			/* background: white; */
			font-size: 20px;
			font-family: "bookman", "Times New Roman", "serif";
			/* text-shadow: 2px 2px 4px black; */
		}

		/* mouse over link */
		a:hover {
			color: hotpink;
			/* background: white; */
			font-size: 20px;
			font-family: "bookman", "Times New Roman", "serif";
			/* text-shadow: 2px 2px 4px black; */
		}

		/* selected link */
		a:active {
			color: red;
			/* background: white; */
			font-size: 20px;
			font-family: "bookman", "Times New Roman", "serif";
			/* text-shadow: 2px 2px 4px black; */
		}
	</style>
</head>
<body>
	<h1>Message Board</h1>
	<?php

		echo '<body style="background-color:#ffd1dc">';

		if(isset($_GET['action'])){
			if((file_exists("MessageBoard/messages.txt")) && (filesize("MessageBoard/messages.txt") != 0 )){
				$MessageArray = file("MessageBoard/messages.txt");
				switch($_GET['action']){
					case "Delete First":
						array_shift($MessageArray);
						break;
					case "Delete Last":
						array_pop($MessageArray);
						break;
					case "Delete Message":
						if(isset($_GET['message']))
							array_splice($MessageArray, $_GET['message'], 1);
						break;
					case "Remove Duplicates":
						$MessageArray = array_unique($MessageArray);
						$MessageArray = array_values($MessageArray);
						break;
					case "Sort Ascending":
						sort($MessageArray);
						break;
					case "Sort Descending":
						rsort($MessageArray);
						break;
				} // end of switch statement
				if(count($MessageArray) > 0){
					$NewMessages = implode($MessageArray);
					$MessageStore = fopen("MessageBoard/messages.txt", "wb");
					if($MessageStore === false){
						echo "There was an error updating the message file\n";
					}
					else{
						fwrite($MessageStore, $NewMessages);
						fclose($MessageStore);
					}
				}
				else
					unlink("MessageBoard/messages.txt");
			}
		}
		// Check if the messages file exists or is empty first
		if((!file_exists("MessageBoard/messages.txt")) || (filesize("MessageBoard/messages.txt") == 0)) {
			echo "<p>There are no messages posted.</p>\n";
		}
		else{
			$MessageArray = file("MessageBoard/messages.txt");
			echo "<table style=\"background-color: #afeeee\"border=\"1\" width=\"100%\">\n";
			$count = count($MessageArray);
			foreach ($MessageArray as $Message) {
				$CurrMsg = explode("~", $Message);
				$KeyMessageArray[] = $CurrMsg;
			}


			for($i = 0; $i < $count; ++$i){

				echo "<tr>\n";
				echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . ($i + 1) . "</td>\n";
				echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject:</span>" . htmlentities($KeyMessageArray[$i][0]) . "<br/>\n";
				echo "<span style=\font-weight: bold\">Name:</span> " . htmlentities($KeyMessageArray[$i][1]) . "<br/>\n";
				echo "<span style=\text-decoration: underline; font-weight: bold\">Message:</span><br/>\n" . htmlentities($KeyMessageArray[$i][2]) . "<br/>\n";
				echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?action=Delete%20Message&message=$i'>" . 
				"Delete  This Message</a></td>\n";

				echo "</tr>\n";
			}
			echo "</table>\n";
		}
	?>
	<p><a href="postMessage.php">Post New Message</a><br/>
	<a href="MessageBoard.php?action=Sort%20Ascending">Sort Messages A-Z</a></br/>
	<a href="MessageBoard.php?action=Sort%20Descending">Sort Messages Z-A</a></br/>
	<a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br/>
	<a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br/>
	<a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicate Messages</a><br/>
	</p>
</body>
</html>