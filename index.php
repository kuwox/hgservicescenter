<?php
require_once('lib/core.lib.php');
include("includes/header.php");
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="lib/js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'images/slider/loading.gif',
				play: 5500,
				pause: 4500,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
	</script>


    <div id="content">

     <!--begin slider -->

     <div id="example">
			
        <div id="slides">
				<div class="slides_container">
			 <div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-0.jpg" alt="H&G Services Center c.a."></a>
				  </div>                
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-1.jpg" alt="H&G Services Center c.a."></a>
					</div>
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-2.jpg" alt="H&G Services Center c.a."></a>
					</div>
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-3.jpg" alt="H&G Services Center c.a."></a>
					</div>    
				<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-4.jpg" alt="H&G Services Center c.a."></a>
					</div>
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-5.jpg" alt="H&G Services Center c.a."></a>
					</div>  
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-6.jpg" alt="H&G Services Center c.a."></a>
					</div>    
				<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-7.jpg" alt="H&G Services Center c.a."></a>
					</div>
					<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-8.jpg" alt="H&G Services Center c.a."></a>
					</div>      
                    <div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-9.jpg" alt="H&G Services Center c.a."></a>
					</div>    
				<div class="slide">
						<a href="#" title="H&G Services Center c.a." target="_self"><img src="images/slider/slide-10.jpg" alt="H&G Services Center c.a."></a>
					</div>                                                   
				</div>
				<a href="#" class="prev"><img src="images/slider/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="images/slider/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
		</div>
			<!--<img src="images/slider/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">-->
		</div>
       </div> 
     <!-- end slider -->
     
      
       </div> <!-- End content -->

    
    
            
     <?
include("includes/footer.php");
?>
     

