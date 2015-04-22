<?php

	include 'init.php';
	includeHeader();

?>

<!--<img src = "images/frontPagePic.jpg" class="frontPagePic" border="1">-->

<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
        <li data-target="#myCarousel" data-slide-to="5"></li>
        <li data-target="#myCarousel" data-slide-to="6"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="images/slide7.jpg">
        </div>
        <div class="item">
          <img class="second-slide" src="images/slide2.jpg">
        </div>
        <div class="item">
          <img class="third-slide" src="images/slide3.jpg">
        </div>
        <div class="item">
          <img class="third-slide" src="images/slide4.jpg">
        </div>
        <div class="item">
          <img class="third-slide" src="images/slide5.jpg">
        </div>
        <div class="item">
          <img class="third-slide" src="images/slide6.jpg">
        </div>
        <div class="item">
          <img class="third-slide" src="images/slide1.jpg">
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        
      </a>
    </div><!-- /.carousel -->

<?php

	include 'footer.html';

?>