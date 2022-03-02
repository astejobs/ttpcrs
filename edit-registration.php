<?php
  require_once('header.php');
  require_once('countries.php');
  require_once('connection.php');
  $activePage = "Home";

  if(isset($_GET['id'])){
      if(empty($_GET['id'])) 
      {
        header('location:registrations.php');
      }else {
          $id = $_GET['id'];
          $sql = "SELECT * FROM registrations WHERE id='".$id."'";        
          $result = $conn->query($sql);
          if (mysqli_num_rows($result)) {            
            $row = $result->fetch_assoc();
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
        <form class="row" action="process-registration.php?update" method="post" id="form">
            <div class="text-center">
                <h4 class="text-center mx-auto"> PCR Test Online Registration Form</h4>
            </div>
            
            <div class="col-md-12 form-group">
                <div class="col-sm-12">
                    <?php
                        if(isset($_SESSION['msg'])) 
                        { 
                            echo "<div class='alert alert-success'><strong>".$_SESSION['msg']."</strong> !";
                            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
                            unset($_SESSION['msg']);
                        }
                    ?>
                </div>

                <label for="Patient Name" class="form-label"> <b>Patient Name </b><span class="text-danger">*</span> </label>
                <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>"/>
                <input type="text" class="form-control" name="patientName" value="<?php echo $row['patientName'] ?>" placeholder="Patient Name" required />
                <small>Please ensure name is as per Passport or ID</small>
            </div>
            
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>D.O.B </b><span class="text-danger">*</span> </label>
                <div class="input-wrapper">
                    <input type="text" placeholder="DD/MM/YYYY" value="<?php echo $row['dob'] ?>" class="form-control" name="dobDate" id="dob_date" required />
                         
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
                    <!-- <option value="">Please Select </option> -->
                    <option value="M"<?=$row['gender'] == 'M' ? ' selected="selected"' : '';?>>M</option>
                    <option value="F"<?=$row['gender'] == 'F' ? ' selected="selected"' : '';?>>F</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="Patient Name" class="form-label"> <b>Passport number</b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo $row['passportNumber'] ?>" name="passportNumber" placeholder="" required />
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>NRIC/FIN number </b></label>
                <input type="text" class="form-control" value="<?php echo $row['nric_fin_number'] ?>" name="nric_fin_number" placeholder="">
                <div class="emf-div-instruction">For Singaporeans / PR / WP / EP Holders Only</div>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Nationality </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="nationality" id="selectCountry" required>
                    <option>Please Select </option>
                   <!--  <option value="1">Singapore SG</option>
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
                            if ($row['nationality'] == $country)
                            {
                                echo " selected='selected'";
                            }
                            echo ">$country</option>\n";
                        }
                    ?>

                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Phone" class="control-label"> <b>Contact Number </b><span class="text-danger">*</span></label>
                <input autocomplete="false"  id="phone" type="tel" name="phone" class="form-control" />
                <input type="hidden" id="contactNumber" name="contactNumber" />
                <!-- <input type="text" class="form-control" name="contactNumber" placeholder="" data-error="Enter Your Phone Number"
                    required pattern="\+?\d[\d -]{8,12}\d" value="<?php //echo $row['contactNumber'] ?>"> -->
                <small >(with 3 digit country code. SG = 065)</small>
            </div>
            <div class="col-md-6 form-group">
                <label for="inputEmail" class="control-label"> <b>Email Address </b><span class="text-danger">*</span> </label>
                <input type="email" class="form-control" value="<?php echo $row['email'] ?>" name="email" placeholder="Enter Email Address"
                    data-error="This email address is invalid" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="inputEmail" class="control-label"> <b>Service Type </b> </label>
                <select class="form-control" name="serviceType" >
                    <!-- <option selected>Please Select </option> -->
                    <option value="Standard" <?=$row['serviceType'] == 'Standard' ? ' selected="selected"' : '';?>>Standard</option>
                    <option value="Express" <?=$row['serviceType'] == 'Express' ? ' selected="selected"' : '';?>>Express</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>Test Code/Type </b></label>
                <select class="form-control" name="testType" >
                    <!-- <option selected>Please Select </option> -->
                    <option value="PDT / PCR" <?=$row['testType'] == 'PDT / PCR' ? ' selected="selected"' : '';?>>PDT / PCR</option>
                    <option value="PDT / SERO" <?=$row['testType'] == 'PDT / SERO' ? ' selected="selected"' : '';?>>PDT / SERO</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Specimen Type</b></label>
                <select class="form-control" name="specimenType" >
                    <option>Please Select </option>
                    <option value="NP" <?=$row['specimenType'] == 'NP' ? ' selected="selected"' : '';?>>NP</option>
                    <option value="OP ONLY" <?=$row['specimenType'] == 'OP ONLY' ? ' selected="selected"' : '';?>>OP ONLY</option>
                    <option value="SERO ONLY" <?=$row['specimenType'] == 'SERO ONLY' ? ' selected="selected"' : '';?>>SERO ONLY</option>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <label for="Patient Name" class="form-label"> <b>Clinic Name and HCI No.</b><span class="text-danger">*</span> </label>
                <input type="text" class="form-control" value="<?php echo $row['clinicName'] ?>" name="clinicName" readonly="readonly"
                    placeholder="Clinic Name and HCI No" required>
            </div>

            <div class="col-md-12 form-group">
                <label for="Patient Name" class="form-label"> <b>Performing Physician/MCR </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo $row['physician_mcr'] ?>" name="performing_mcr" readonly="readonly" placeholder="Performing Physician/MCR" required>
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
                    <input class="form-control"  id="test_date"type="text" name="testDate" placeholder="DD/MM/YYYY" required>
                  </div>
                  <div class="col-sm-6 form-group">                    
                    <input class="form-control timepicker"  id="test_date" type="text" name="testTime" placeholder="HH:MM AM/PM" required>
                  </div>
              </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b> Mode Of Payment </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="paymentMode"  required>
                    <option selected>Please Select </option>
                    <option value="Credit Card"<?=$row['paymentMode'] == 'Credit Card' ? ' selected="selected"' : '';?> >Credit Card</option>
                    <option value="NETS" <?=$row['paymentMode'] == 'NETS' ? ' selected="selected"' : '';?> >NETS</option>
                    <option value="Pre-Paid(Online)"<?=$row['paymentMode'] == 'Pre-Paid(Online)' ? ' selected="selected"' : '';?>>Pre-Paid(Online)</option>
                    <option value="Others"<?=$row['paymentMode'] == 'Others' ? ' selected="selected"' : '';?>>Others</option>
                </select> 
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b>Payment Ref No. </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo $row['paymentRefNo'] ?>" name="paymentRefNo" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="Patient Name" class="form-label"> <b> Staff Code </b> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo $row['staffCode'] ?>" name="staffCode" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="Nationality" class="control-label"> <b>Test Location </b> <span class="text-danger">*</span></label>
                <select class="form-control" name="testLocation" required>
                    <option selected>Please Select </option>
                    <option value="JE"<?=$row['testLocation'] == 'JEC' ? ' selected="selected"' : '';?>>JEC</option>
                    <option value="CR"<?=$row['testLocation'] == 'CIR' ? ' selected="selected"' : '';?>>CIR</option>
                    <option value="ML"<?=$row['testLocation'] == 'MAR' ? ' selected="selected"' : '';?>>MAR</option>
                    <option value="BP"<?=$row['testLocation'] == 'BP' ? ' selected="selected"' : '';?>>BP</option>
                    <option value="WD"<?=$row['testLocation'] == 'WP' ? ' selected="selected"' : '';?>>WP</option>
                    <option value="GM"<?=$row['testLocation'] == 'GM' ? ' selected="selected"' : '';?>>GM</option>
                    <option value="GM"<?=$row['testLocation'] == 'MER' ? ' selected="selected"' : '';?>>MER</option>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <P><b> Have you asked if patient has any ARI symptoms?*</b></P>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ariSymptomps"
                     id="defaultCheck1" required <?=$row['ari_symptoms'] == 1 ? 'checked="checked"' : '';?> />
                    <label class="form-check-label" for="defaultCheck1">
                        YES, I have asked and patient has declared no ARI symptoms
                    </label>
                </div> &nbsp;
                <P><b> Have you checked if patient has any contraindication?* </b></P>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="contraindication"
                     id="defaultCheck2" required <?=$row['contraindication'] == 1 ? ' checked="checked"' : '';?> >
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
        phoneInput.setNumber("<?php echo $row['contactNumber'] ?>");

        $(document).ready(function() {
			//$("#selectCountry").searchable();
		});

      optional_config_dob = {
          maxDate: new Date().setFullYear( new Date().getFullYear() - 1 ),
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
          defaultDate: "<?php echo $row['dob'] ?>"
      }
      optional_config_td = {
          maxDate: "today",
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
          defaultDate: "<?php echo $row['testDate'] ?>",
      }

      const d = new Date();
      let minutes = d.getMinutes();
      let hour = d.getHours();
      time_config = {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        altFormat: "h:i K",
        altInput: true,
        defaultDate: "<?php echo $row['testTime'] ?>",
      }
      $("#dob_date").flatpickr(optional_config_dob);
      $("#test_date").flatpickr(optional_config_td);
      $(".timepicker").flatpickr(time_config);

    
    $('button[name="register"]').on('click', function(e) {   
        
        if(validatePhone(phoneInput)) {        
       
            $('#confirm').modal({
                    backdrop: 'static',
                    keyboard: false
            });
            $("#submit").on('click', function(e) {
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
            //$("#contactNumberErr").text("Please enter valid contact number");
            return true;
        }else {
            alert("Invalid Phone Number!!");
            return false;
        }
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

<?php
    }
?>
  