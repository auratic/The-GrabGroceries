<?php
  	session_start();

	if(!isset($_SESSION["loggedin"])) {
		echo "
		<script>
		alert('Please login');
		location.href='login.php';
		</script>";
	}
	require '../config.php';

	if(isset($_GET["id"])) {
		$receipt_id = $_GET["id"];

		$sql = "SELECT * FROM cust_receipt WHERE receipt_id = $receipt_id";

		if ($result = mysqli_query($link, $sql)) {

			while ($row = mysqli_fetch_assoc($result)) { 
				$name = $row["receipt_name"];
				$date = $row["receipt_date"];
				$address = $row["receipt_address"];
				$grand_total = $row["payment_cost"];
				$phone = $row["receipt_phone"];
				$payment_method = $row["payment_method"];
				$fname = $row["receipt_fname"];
				$lname = $row["receipt_lname"];
			}
		}

	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
	
    <link rel="stylesheet" href="../assets/vendors/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/vendors/bootstrap-select/bootstrap-select.min.css" />

</head>

<body>

	<div class="container" style="text-align:center; margin-top: 10px">
			<button class="hidden-print btn btn-info" onclick="window.print()">Print</button>
			<button class="hidden-print btn btn-info" onclick="demoFromHTML()">Download</button>
	</div>

	<div id="content" style="width: 800px; margin: 0 auto;">

		<p id="header">INVOICE</p>
		
		<div id="identity">
			<div id="address">
				<p>
					TheGrabGroceries Sdn. Bhd <br>
					123 Dataran Pahlawan <br>
					Appleville, WI 53719 <br> <br>

					Phone: 06 888 6666
				</p>
			</div>


            <div id="logo">
				<img src="../assets/images/Logo1.png">
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">
			<div style="float:left">
				<p style="width:250%">
					<b>Mr / Mrs <?php echo $fname ." ". $lname; ?>,</b>
					<br>
					<?php echo $address; ?>
					<br><br>
					+<?php echo $phone; ?>
				</p>
			</div>

            <table id="meta" class="table table-striped table-hover table-condensed">
                <tr>
                    <td class="meta-head" style="border-top: solid black 1px">Invoice #</td>
                    <td style="border-top: solid black 1px"><p><?php echo $receipt_id; ?></p></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><p><?php echo $date; ?></p></td>
                </tr>
                <tr>
                    <td class="meta-head">Grand Total</td>
                    <td><p><?php echo $grand_total; ?></p></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items" class="table table-striped table-hover table-condensed">
		
		  <tr>
		      <th style="border-top: solid black 1px"></th>
		      <th style="border-top: solid black 1px">Item</th>
		      <th style="border-top: solid black 1px">Unit Cost</th>
		      <th style="border-top: solid black 1px">Quantity</th>
		      <th style="border-top: solid black 1px">Price</th>
		  </tr>
		  
		  <?php 
		  	$trans_sql = "SELECT * FROM cust_transaction
			  INNER JOIN item ON cust_transaction.item_id = item.item_id
			  WHERE cust_transaction.receipt_id = $receipt_id;";
			$subtotal = 0;
			  if ($trans_result = mysqli_query($link, $trans_sql)) {

				  while ($trans_row = mysqli_fetch_assoc($trans_result)) {

					  echo '
					  <tr class="item-row">
						<td class="item-name"><img src="../assets/images/items/'.$trans_row['image'].'" style="width:20%;object-fit:contain;"></td>
						<td class="description"><p>'.$trans_row['item'].'</p></td>
						<td ><p>RM'.$trans_row['cost'].'</p></td>
						<td ><p>x'.$trans_row['amount'].'</p></td>
						<td ><p>RM'.$trans_row['total_cost'].'</p></td>
				 	  </tr>
					  ';
					  $subtotal += $trans_row['total_cost'];
				  }

			  }
		  ?>

		  
		  <tr>
		      <td colspan="2" class="blank" style="border-top: solid black 1px"> </td>
		      <td colspan="2" class="total-line" style="border-top: solid black 1px">Subtotal</td>
		      <td class="total-value" style="border-top: solid black 1px"><p>RM <?php echo $subtotal; ?></p></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Shipping Cost</td>
		      <td class="total-value"><p>RM 0</p></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Grand Total</td>
		      <td class="total-value"><p>RM <?php echo $grand_total; ?></p></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Paid Using</td>
		      <td class="total-value"><p><?php echo $payment_method; ?></p></td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <p>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</p>
		</div>
	
	</div>
	<script>
    function demoFromHTML() {
        var pdf = new jsPDF();
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $("body")

        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.html(document.body, {
			callback: function (pdf) {
				pdf.save();
   			}
		});
    }
</script>
</body>

</html>