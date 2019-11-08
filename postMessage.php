<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Message Board Exercise</title>
	<style>
		h1 {
			color: black;
			/* background: white; */
			font-size: 40px;
			font-family: "serif", "Times New Roman", "bookman";
			text-shadow: 4px 4px 8px white;
		}
		#subject {
			font-size: 20px;
			background-color: lightblue;
		}
		#name {
			font-size: 20px;
			background-color: lightblue;
		}
		#subject:hover {
			font-size: 20px;
			background-color: white;
		}
		#name:hover {
			font-size: 20px;
			background-color: white;
		}
		#text2 {
			font-size: 20px;
		}
		#text1 {
			font-size: 20px;
		}
		#message {
			font-size: 20px;
			background-color: lightblue;
		}
		#message:hover {
			font-size: 20px;
			background-color: white;
		}
		#button {
			font-size: 15px;
			background-color: #b19cd9;
			color: white;
		}

		#button:hover {
			font-size: 15px;
			background-color: white;
			color: hotpink;
		}
	</style>
</head>
<body>
	<?php

		echo '<body style="background-color:#ffd1dc">';

		if(isset($_POST['submit'])){
			$Subject = stripcslashes($_POST['subject']);
			$Name = stripcslashes($_POST['name']);
			$Message = stripcslashes($_POST['message']);
			// Replace any '~' with '-' characters
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);

			$ExistingSubjects = array();

			if(file_exists("MessageBoard/messages.txt") && filesize("MessageBoard/messages.txt") > 0){
				$MessageBoard = file("MessageBoard/messages.txt");
				$count = count($MessageBoard);
				for($i = 0; $i < $count; ++$i){
					$CurrMsg = explode("~", $MessageBoard[$i]);
					$ExistingSubjects[] = $CurrMsg[0];
				}
			}
			if(in_array($Subject, $ExistingSubjects)){
				echo "<p>The subject you entered already exists!<br/>\n";
				echo "Please enter a new subject and try again.<br/>\n";
				echo "Your message was not saved!</p>";
				$Subject = "";
			}
			else {
				$MessageRecord = "$Subject~$Name~$Message\n";

				$MessageFile = fopen("MessageBoard/messages.txt", "ab");

				if($MessageFile === FALSE){
					echo "There was an error in saving your message";
				}
				else {
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "Your message has been saved.\n";
					$Subject = "";
					$Message = "";
				}
			}
		}
		else {
			$Subject = "";
			$Name = "";
			$Message = "";
		}
	?>

	<h1>Post New Message</h1>
	<hr/>
	<form action="postMessage.php" method="POST">
		<p><span id="text1" style="font-weight: bold">Subject:</span></p>
			<input id="subject" type="text" name="subject" value="<?php echo $Subject; ?>" /></p>
		<p><span id="text2" style="font-weight: bold">Name:</span></p>
			<input id="name" type="text" name="name" value="<?php echo $Name; ?>" /></p>
		<textarea id="message" name="message" rows="6" cols="80"><?php echo $Message; ?></textarea><br/>
		<input id="button" type="submit" name="submit" value="Post Message"/>
		<input id="button" type="reset" name="reset" value="Reset Form"/>
	</form>
	<hr/>
	<p><a href="MessageBoard.php">View Messages</a></p>
	
</body>
</html>