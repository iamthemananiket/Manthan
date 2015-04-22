<?php

    include 'init.php';
    includeHeader();

	$pId = $_POST['P_id'];
	$data = array();
//	$subData = array();
	list($data/*, $subData*/) = getSingleProductDetails($pId);

?>

<!DOCTYPE html>
<html>
	
	<body>

		<div style="padding-top: 30px;">

			<div class="imageLeft" style="padding-top: 20px;">
				<img src=<?php echo '"' . ($data[2] == "" ? 'images/imageNotAvailable.jpg' : $data[2]) . '"'; ?> class="productImg">
			</div>
			
			<div style="display: inline-block; width: 40%; padding-left: 40px;">
				<ul style="list-style-type: none;">
					<li>
						<h2><?php echo $data[0] ?></h2>
					</li>
					<li style="font-size: 15px; color: rgb(150, 150, 150);">Item Code <?php echo $pId . "<br><br>"; ?></li>
					<li style="font-size: 20px; color: rgb(100, 100, 100);"><?php echo "Rs. " . $data[1]; ?></li>
					<li>
						<h4>Product Details</h4>
						<p><?php echo $data[6] == null ? "No details available" : $data[6]; ?></p>
					</li>
					<li>
						<h4>Delivery</h4>
						Delivery Charges- Rs. 100 will be charged.<br>
						Delivery Time- 3 to 5 working days<br>
					</li>
					<br>
					<li style=
						<?php echo '"float: left; '; if($data[3] != null) {echo 'width: 33%;"';} else {echo 'width: 100%;"';} ?>
					>
						<h4>Availability</h4>
						<?php
							echo $data[5] > 0 ? $data[5] : "Not available";
						?>
					</li>
					<li style="width: 33%; display: inline-block;">
						<?php if($data[3] != null) {
							echo '<h4>Color</h4>';
							echo '<div style="width: 20px; height: 20px; border: 1px solid black; background-color: ' . $data[3] . '";></div>';
						} ?>
					</li>
					<li style="width: 33%; float: right; display: inline-block;">
						<?php if($data[4] != null) {
							echo '<h4>Size</h4>';
							echo $data[4];
						} ?>
					</li>
					<br><br><br>
					<li>
						<?php
							if($data[5] > 0) {
								if(loggedIn()) { ?>
									<form enctype="multipart/form-data" action="cartUpdation.php" method="post">
										<input type="hidden" name="Cust_id" value=<?php echo '"' . $_SESSION['Cust_id'] . '"' ?>>
										<input type="hidden" name="P_id" value=<?php echo '"' . $pId . '"' ?>>
										<input type="submit" name="submit" value="Add to Cart" style="font-size: 18px;">
									</form>
							<?php } else { ?>
									<form enctype="multipart/form-data" action="newAddress.php" method="post">
										<input type="hidden" name="P_id" value=<?php echo '"' . $pId . '"' ?>>
										<input type="submit" name="submit" value="Buy Now">
									</form>
							<?php }
							}
						 ?>
					</li>
					<br><br>
				</ul>
			</div>
			
			<div class="suggestRight">

				<h3 style="border-bottom: 1px rgb(0, 0, 0); font-size: 20px;">YOU MAY ALSO LIKE</h3><br>

				<?php
					$pIdList = getSimilarProductIds($pId);
					list($idList, $nameList, $priceList, $imgUrlList) = getDetailsFromProductIds($pIdList, "sortById");
					for ($i = 0; $i < count($idList); $i++) { 
						echo '<img src="' . $imgUrlList[$i] . '" width="100px" height="100px"><br>';
						?>
						<form enctype="multipart/form-data" action="displaySingleProduct.php" method="post">
							<input type="hidden" name="P_id" value=<?php echo '"' . $idList[$i] . '"'; ?>>
							<input type="submit" name="submit" value=<?php echo '"' . $nameList[$i] . '"'; ?> id="hyperlink-style-button" style="font-size: 16px;">
						</form>
						<?php
						echo "Rs. " . $priceList[$i] . "<br><br><br>";
					}
				?>

			</div>

		</div>

	</body>

</html>

<?php

	include 'footer.html';

?>