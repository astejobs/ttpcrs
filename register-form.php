<?php
  date_default_timezone_set('Asia/Singapore');
    $tz = 'Asia/Singapore';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $today_formatted = $today->format('Y-m-d');
  require_once('header.php');
  require_once('countries.php');
  $activePage = "Home";
  if(!isset($_SESSION['ID'])) {
      header("location:login.php");
      exit;
  }
  if(isset($_SESSION['ID'])) {
    $now = time();
    if($now > $_SESSION['expire']) {
        header("location:login.php?sessionExpired=true");
        exit;
    }
  }
?>
<style>
    .iti { width: 100%; }
</style>
<link rel="stylesheet" href="assets/js/teleInput/intlTelInput.css" />
   
<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">

 <section class="main mt-5">
  <div class="container mt-5">
        <div class="row">
        <div class="col-md-12">
            <p class=" p-2 bg-dark text-white font-weight-bold text-center">PCR Test Online Registration Form</p>
        <form class="row" action="process-registration.php" method="post" id="form" autocomplete="off">
            <!-- <div class="text-center"> -->
                <!-- <h4 class="text-center mx-auto"> PCR Test Online Registration Form</h4> -->
           <!--  </div> -->
            
            <div class="col-md-12 form-group">
                <div class="col-sm-12">
                    <?php 
                        if(isset($_SESSION['msg'])) 
                        { 
                            echo "<div class='alert alert-danger'><strong>".$_SESSION['msg']."</strong> !";
                            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <span class="text-danger" id="errSpace"></span>
                </div>

                <label for="Patient Name" class="form-label"> <b>Patient Name </b><span class="text-danger">*</span> </label>
                <input type="text" class="form-control" name="patientName" placeholder="Patient Name" required />
                <small>Please ensure name is as per Passport or ID</small>
            </div>
            
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>D.O.B </b><span class="text-danger">*</span> </label>
                <div class="input-wrapper">
                    <input type="text" placeholder="DD/MM/YYYY" class="form-control" name="dobDate" id="dob_date" required />
                         
                   <!--  <span class="emf-sep">/</span>
                    <input class="js-form-day" id="dob_day" type="text" name="dobDay" size="2">
                    <span class="emf-sep">/</span>
                    <input class="js-form-year" id="dob_year" type="text" name="dobYear" size="4"> -->                    
                </div>
                <!-- <div class="span-wrapper">
                    <span for="day">DD</span> 
                    <span for="month">MM</span>
                    <span for="year">YYYY</span>
                </div> -->
            </div>

            <div class="col-md-6 form-group">
                <label for="Gender" class="control-label"> <b> Gender </b><span class="text-danger">*</span></label>
                <select class="form-control" name="gender"  required>
                    <option value="Please Select">Please Select</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="Patient Name" class="form-label"> <b>Passport / NRIC / FIN</b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="passportNumber" placeholder="" required />
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>NRIC/FIN number </b></label>
                <input type="text" class="form-control" name="nric_fin_number" placeholder="">
                <div class="emf-div-instruction">For Singaporeans / PR / WP / EP Holders Only</div>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Nationality </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="nationality" id="selectCountry" required>
                    <option value="Please Select">Please Select</option>
                    <!-- <option value="1">Singapore SG</option>
                    <option value="2">Malasiya</option>
                    <option value="3">Indonesia ID</option>
                    <option value="4">Phillipines PH</option>
                    <option value="5">Thialand TH</option>
                    <option value="6">Vietnam VN</option>
                    <option value="7">India IN</option>
                    <option value="8">China CN</option> -->
                    <?php
                        foreach ($countries as $country)
                        {
                            echo "<option value='$country'";
                            echo ">$country</option>\n";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Phone" class="control-label"> <b>Contact Number </b><span class="text-danger">*</span></label>
                <input autocomplete="false"  id="phone" type="tel" name="phone" class="form-control" />
                <input type="hidden" id="contactNumber" name="contactNumber" />
                <div class="input-group">
                    <!-- <input type="text" class="form-control col-sm-2 input-sm" placeholder="code" />
                    <span class="input-group-btn" style="width:0px;"></span> -->
                   <!--  <input type="text" class="form-control input-sm" value="test2" /> -->
                    <!-- <input type="tel" class="form-control input-sm" name="contactNumber" placeholder="Phone Number" data-error="Enter Your Phone Number"
                        required pattern="\+?\d[\d -]{8,12}\d"> -->
                    </div>
                    <!-- <small >(with 3 digit country code. SG = 065)</small> -->
            </div>
            <div class="col-md-6 form-group">
                <label for="inputEmail" class="control-label"> <b>Email Address </b><span class="text-danger">*</span> </label>
                <input type="email" class="form-control" name="email" placeholder="Enter Email Address"
                    data-error="This email address is invalid" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="inputEmail" class="control-label"> <b>Service Type </b> </label>
                <select class="form-control" name="serviceType" >
                    <option value="Please Select">Please Select</option>
                    <option value="Standard">Standard</option>
                    <option value="Express">Express</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>Test Code/Type </b></label>
                <!-- <input type="text" class="form-control" name="testType" value="PDT/PCR" placeholder=" PDT/PCR" readonly="readonly"> -->
                <select class="form-control" name="testType" >
                    <option value="Please Select">Please Select</option>
                    <option value="PDT / PCR">PDT / PCR</option>
                    <option value="PDT / SERO">PDT / SERO</option>
                    <option value="VOLUNTARY TEST">VOLUNTARY TEST</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Specimen Type</b></label>
                <select class="form-control" name="specimenType" >
                    <option value="Please Select">Please Select</option>
                    <option value="NP">NP</option>
                    <option value="OP ONLY">OP ONLY</option>
                    <option value="SERO ONLY">SERO ONLY</option>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <label for="Patient Name" class="form-label"> <b>Clinic Name and HCI No.</b><span class="text-danger">*</span> </label>
                <input type="text" class="form-control" name="clinicName" readonly="readonly" value="SAUDARA CLINIC by A+J GENERAL PHYSICIANS (18M0151)"
                    placeholder="Clinic Name and HCI No" required>
            </div>

            <div class="col-md-12 form-group">
                <label for="Patient Name" class="form-label"> <b>Performing Physician/MCR </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="performing_mcr" readonly="readonly" value="Dr Juliana Bahadin (07961H)" placeholder="Performing Physician/MCR" required>
            </div>
            <div class="col-md-12 my-3">
              <p class="text-center">
                <label for="Patient Name" class="form-label"> <strong>Date & Time of Test </strong> <span class="text-danger">*</span> </label>
              </p>
              <div class="row">
                  <div class="col-sm-6">                    
                    <label for="test_date">DD/MM/YYYY</label>                  
                  </div>
                  <div class="col-sm-6">   
                    <label for="test_date">HH:MM AM/PM</label>  
                  </div>               
              </div>
              <div class="row">
                  <div class="col-sm-6 form-group">                    
                    <input class="form-control"  id="test_datet" type="text" name="testDate" placeholder="DD/MM/YYYY" required readonly value="<?php echo $today_formatted ?>" >
                  </div>
                  <div class="col-sm-6 form-group">                    
                    <input class="form-control timepicker"  id="test_time" type="text" name="testTime" placeholder="HH:MM AM/PM" required>
                  </div>
              </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Mode Of Payment </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="paymentMode"  required>
                    <option value="Please Select">Please Select</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="NETS">NETS</option>
                    <option value="Pre-Paid(Online)">Pre-Paid(Online)</option>
                    <option value="Others">Others</option>
                </select> 
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>Payment Ref No. </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="paymentRefNo" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b> Staff Code </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="staffCode" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b>Test Location </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="testLocation" required>
                    <option value="Please Select">Please Select</option>
                    <option value="JEC">JEC</option>
                    <option value="CIR">CIR</option>
                    <option value="MAR">MAR</option>
                    <option value="BP">BP</option>
                    <option value="WP">WP</option>
                    <option value="GM">GM</option>
                    <option value="ROXY">ROXY</option>
                    <option value="CQC">CQC</option>
                    <option value="MTS">MTS</option>
                    <option value="SPEC">SPEC</option>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <P><b> Have you asked if patient has any ARI symptoms?*</b></P>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ariSymptomps" id="defaultCheck1" required>
                    <label class="form-check-label" for="defaultCheck1">
                        YES, I have asked and patient has declared no ARI symptoms
                    </label>
                </div> &nbsp;
                <P><b> Have you checked if patient has any contraindication?* </b></P>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="contraindication" id="defaultCheck2" required>
                    <label class="form-check-label" for="defaultCheck2">
                        YES, I have asked and patient has stated no contraindication
                    </label>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-info px-5" name="register">Submit</button>
            </div>

            <!-- Confirm Modal -->
            <div id="confirm" class="modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                CONFIRM TO PROCEED <br><br>
                                ALL REQUIRED INFORMATION<br>
                                COLLECTED ARE CORRECT
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-info" id="submit">Confirm</button>
                            <button type="button" data-dismiss="modal" class="btn" id="cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Confirm Modal -->
        </form>
    </div>
</div>
</div>

</section>

  </div>
</section> 


  </main><!-- End #main -->



  <?php
    require_once('footer.php');
  ?>
  <script type="text/javascript" src="assets/js/jquery.searchabledropdown-1.0.8.min.js"></script>
  <script src="assets/js/teleInput/intlTelInput.min.js"></script>

  <script>
    $(document).ready(function() {

        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
                preferredCountries: ["sg", "us", "th", "in", "ph","vn","cn"],
                hiddenInput: "contactNumberhidden",
                separateDialCode: true,
                utilsScript:"assets/js/teleInput/utils.js",
        });
        phoneInput.setPlaceholderNumberType("MOBILE");
	
      //$("#selectCountry").searchable();

      optional_config_dob = {
          maxDate: new Date().setFullYear( new Date().getFullYear() - 1 ),
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
      }
      <?php 
        $tz = 'Asia/Singapore';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $today_formatted = $today->format('d-m-Y');
        //$time_formatted = $today->format('h:i A');
        $time_formatted = date_format($today,"h:i A")
      ?>
      var tdy = "<?php echo $today_formatted ?>";console.log(tdy);
      optional_config_td = {
          defaultDate: tdy,
          maxDate: new Date().fp_incr(1),
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
          clickOpens: false,
      }
console.log("<?php echo $today_formatted ?>")
      const d = new Date();
      let minutes = d.getMinutes();
      let hour = d.getHours();
      time_config = {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i K",
        altFormat: "h:i K",
        altInput: true,
        clickOpens: false,
        defaultDate: "<?php echo $time_formatted ?>"
      }
      $("#dob_date").flatpickr(optional_config_dob);
      $("#test_date").flatpickr(optional_config_td);
      $(".timepicker").flatpickr(time_config);

        
        $('button[name="register"]').on('click', function(e) { 
            var dob_date = $("#dob_date").val();
            if(dob_date=="") {
                alert("Enter Date of birth!");
                return;
            }
            if(validatePhone(phoneInput) && validateForm()) {

                $('#confirm').modal({
                        backdrop: 'static',
                        keyboard: false
                });
                $("#submit").on('click', function(e) { //e.preventDefault(); console.log($("form").serializeArray());
                        console.log("Submitting");
                        $('#confirm').modal('hide');
                        return true;
                });
                $("#cancel").on('click', function(e){
                        console.log("Cancelling");
                        e.preventDefault();                
                });
            }
        
        });

        
    });

    
    function validatePhone(phoneInput) { 
        const phoneNumber = phoneInput.getNumber();
        var isValid = phoneInput.isValidNumber();
        if(phoneNumber!="" && isValid) {
            $("#contactNumber").val(phoneNumber);
            return true;
        }else {
            alert("Invalid Phone Number!!");
            return false;
        }
    }

    function validateForm() {
        var flag = true;
        $('select').each(function() {
           val = $(this).find(":selected").text(); 
           $(this).css("border-color","inherit");
           if(val=="Please Select") {
               flag = false;
               $(this).css("border-color","red");
               $("#errSpace").text("Please check required fields");
               $("html, body").animate({ scrollTop: 0 }, "slow");
           }
        });
        return flag;
    }

    function setDob(date) {
      console.log(date);
      var day = date.getDate();
      var month = date.getMonth() + 1; //months from 1-12
      var year = date.getFullYear();
      console.log(day +" - "+ month +" - "+ year);
      $('#dob_day').val(day);
      $('#dob_month').val(month);
      $('#dob_year').val(year);
    }
  </script>
  