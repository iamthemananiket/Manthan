<?php

	include 'init.php';
	includeHeader();

?>

<!--	<div class="filter">

		<h3>Filter Products By</h3>

		<form action="" method="post">

			<div style="border-top: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); line-height: 0.7em;">
				<br><b>Price</b><br><br>
				Enter a price range<br><br>
				<input type="number" min="0" name="minPrice" style="width:50px;"> to <input type="number" min="0" name="maxPrice" style="width:50px;">
				<br><br>
			</div>
			<br>

			<input type="hidden" name="P_id" value=<?php echo '"' . $idList[$i] . '"' ?>>
			<input type="submit" name="filter" value="Filter">

			<br><br>

		</form>
		
	</div>
-->

	<br>

	<form action="" method="get" style="text-align: center; padding-top: 40px; font-size: 20px;">
		<input type="hidden" name="search" value=<?php echo '"' . $_GET['search'] . '"'; ?>>
		<input type="radio" name="sort" value="sortById" <?php if($_GET['sort'] == 'sortById') echo 'checked'; ?>> Sort By ID
		<input type="radio" name="sort" value="sortByName" <?php if($_GET['sort'] == 'sortByName') echo 'checked'; ?> style="margin-left: 40px;"> Sort By Name
		<input type="radio" name="sort" value="sortByPrice" <?php if($_GET['sort'] == 'sortByPrice') echo 'checked'; ?> style="margin-left: 40px;"> Sort By Price<br><br>
		<input type="submit" value="Sort" style="padding: 6px 10px;">
	</form>

	<br><br>

	<div class="searchList">

		<?php

			if(!empty($_GET)) {
				$search = $_GET['search'];
				$sort = $_GET['sort'];
				$searchResult = array();
				$searchResult = getProductIdList($search);
				list($idList, $nameList, $priceList, $imgUrlList) = getDetailsFromProductIds($searchResult, $sort);
				for ($i = 0; $i < count($nameList); $i++) {
					?>
					<ul style="list-style-type: none; width: 24%; display: inline-block; padding: 20px 0px 20px 7px; text-align: center;">
						<li><img src= <?php echo '"' . $imgUrlList[$i] . '"' ?> id="productImageInGrid" class="img-thumbnail"></li>
						<form enctype="multipart/form-data" action="displaySingleProduct.php" method="post">
							<input type="hidden" name="P_id" value=<?php echo '"' . $idList[$i] . '"' ?>>
							<input style="padding-left: 20px;" type="submit" name="submit" value=<?php echo '"' . $nameList[$i] . '"' ?> id="hyperlink-style-button">
						</form>
						<li><?php echo "Rs. " . $priceList[$i]; ?></li>
					</ul>
					<?php
				}
			}

		?>

	</div>

<?php

	include 'footer.html';

?>