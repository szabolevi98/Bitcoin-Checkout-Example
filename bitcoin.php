<?php
	// Bitcoin Checkout Example code in PHP
	// https://github.com/szabolevi98/bitcoin-checkout-example
	ini_set("allow_url_fopen", true);
	$myAddress = "PUTHEREYOURADDRESSTORECEIVE";
	$euro = 30;
	$recvBTC = file_get_contents("https://blockchain.info/tobtc?currency=EUR&value=$euro"); //You can change to USD too
	$recvSatoshi = $recvBTC*100000000;
	$requiredConfirm = 3;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$sqlConn = mysqli_connect("127.0.0.1", "root", "password");
		$hashName = mysqli_real_escape_string($sqlConn, $_POST['hashName']);
		if (empty($hashName)) {
			echo "<script>alert('What are you doing?')</script>";
		} else {
			$check = mysqli_query($sqlConn, "SELECT * FROM bitcoin_log WHERE transaction='$hashName'");
			if (mysqli_num_rows($check)==0) {
				$received = file_get_contents("https://blockchain.info/q/txresult/$hashName/$myAddress");
				if ($received) {
					if ($received >= ($recvSatoshi*0.95)) { //Let them 5% difference because BTC price constantly changing, but you can remove this...
						$confStr = file_get_contents("https://blockchain.info/tx/$hashName?show_adv=false&format=json");
						$confJson = json_decode($confStr, true);
						$blockHeight = $confJson['block_height'];
						if ($blockHeight && is_numeric($blockHeight))
						{
							$currentCount = file_get_contents("https://blockchain.info/q/getblockcount");
							$confirmation = $currentCount - $blockHeight+1;
							if ($confirmation >= $requiredConfirm) {
								mysqli_query($sqlConn, "INSERT INTO test.bitcoin_log (transaction, username) VALUES ('$hashName', '".$_SESSION['id']."');"); //Please change $_SESSION['id'] with your variable!
								// mysqli_query($sqlConn, "UPDATE users SET `something` = `something` + $euro WHERE `username` = '".$_SESSION['id']."' LIMIT 1;"); //Just example, do what you want...
								echo "<script>alert('Thank you for your $euro euro purchase in bitcoin!')</script>";
							} else {
								echo "<script>alert('Transaction does not have $requiredConfirm confirmation! Please wait and try again!')</script>";
							}
						} else {
							echo "<script>alert('Transaction does not have any confirmation yet!')</script>";
						}
					} else {
						echo "<script>alert('Transaction exists, but you sent low amount. Please email us.')</script>";
					}

				} else {
					echo "<script>alert('Transaction does not exist!')</script>";
				}
			} else {
				echo "<script>alert('Somebody already gained this transaction, please email us to get help!')</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bitcoin Checkout Example</title>
</head>
<body>
	<div id="container">
		<h2>Bitcoin Checkout Example</h2>
		<span>Please send <b><?php echo $recvSatoshi/100000000 ?></b> BTC to <b><?php echo $myAddress ?></b>
		<br>Then add below the transaction hash id to get your order:</span>
		<form action="" method="post">
			<input type="text" name="hashName" id="hashName" placeholder="Transaction hash id" required>
			<input type="submit" value="Submit!">
		</form>
	</div>
</body>
</html>
