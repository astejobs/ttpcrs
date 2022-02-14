<footer id="footer" class="section-bg">
	<div class="container">
      <div class="copyright">
        &copy; Copyright <strong>TheTestingPro<sup>TM</sup></strong>. All Rights Reserved
      </div>
    </div>
  </footer>
  <!-- End  Footer -->
<input type="hidden" value="<?php echo $activePage ?>" id="activePage">
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

 

  <!-- Vendor JS Files -->
  
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/owl-carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>  
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  
  <!-- Default Statcounter code for The Testing pro https://www.thetestingpro.com -->
  <script type="text/javascript">
    var sc_project=12587875;
    var sc_invisible=1;
    var sc_security="0589d49b";
  </script>
  <script type="text/javascript" src="https://www.statcounter.com/counter/counter.js" async></script>
  <noscript><div class="statcounter"><a title="Web Analytics Made Easy - Statcounter" href="https://statcounter.com/" target="_blank"><img class="statcounter" src="https://c.statcounter.com/12587875/0/0589d49b/1/" alt="Web Analytics Made Easy - Statcounter" referrerPolicy="no-referrer-when-downgrade"></a></div></noscript>
    <!-- End of Statcounter Code -->

  <script>
        $(document).ready(function(){
          $('.main-nav .m1').each(function(){ 
              var label = $(this).attr("label");
              var activePage = $("#activePage").val();
              if(label == activePage) {
                $(this).addClass("active");
              }
          });
        });
    
  </script>
</body>

</html>