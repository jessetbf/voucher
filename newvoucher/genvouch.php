<?php
require_once 'script/PDOModel.php';
$pdomodel = new PDOModel();
try {
  $pdomodel->connect("localhost", "root", "Pegasus99", "feralfix");
  $result =  $pdomodel->executeQuery("SELECT MAX(VoucherNumber) AS nextvoucher FROM vouchers");
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
}
foreach ($result as $row) {
  $nextvoucher = $row['nextvoucher'] + 1;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Community Cat Vouchers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="formval/dist/css/formValidation.css">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/formvalidation/dist/css/formValidation.min.css">



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
  <div class="container">
    <img alt="BFAS Logo" src="img/BFAS-UtahLogo.jpg">
    <form action="MYaction.php" id="voucherForm" method="post" class="form-horizontal">
      <div class="form-group row mt-5">
        <label class="control-label col-xs-2 pr-3" for="numVouch"># of vouchers:</label>
        <div class="col-xs-1">
          <select name="numVouch" id="numVouch" size="1" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
          </select>
        </div>
      </div>
      <div class="form-group row pl-3">
        <div class="col-sm-2">
          <label for="vouchStart">Starting voucher #:</label>
          <input class="form-control" name="vouchStart" type="text" id="vouchStart" value="<?php echo $nextvoucher; ?>" />
        </div>
        <div class="col-sm-2">
          <label for="vouchEnd">Ending voucher #: </label>
          <input class="form-control" name="vouchEnd" type="text" id="vouchEnd" value="<?php echo $nextvoucher + 1; ?>" />
        </div>
      </div>

      <h4>Issued to:</h4>

      <div class="form-group row pl-3">
        <div class="col-sm-4">
          <label for="issuedToFirst">First name:</label>
          <input class="form-control" type="text" name="issuedToFirst" id="issuedToFirst" required />
        </div>
        <div class="col-sm-4">
          <label for="issuedToFirst">Last name:</label>
          <input class="form-control" type="text" name="issuedToLast" id="issuedToLast" required />
        </div>
      </div>

      <h4>Issued by:</h4>

      <div class="form-group row pl-3">
        <div class="col-sm-4">
          <label for="issuedByFirst">First name:</label>
          <input class="form-control" type="text" name="issuedByFirst" id="issuedByFirst" required />
        </div>
        <div class="col-sm-4">
          <label for="issuedByFirst">Last name:</label>
          <input class="form-control" type="text" name="issuedByLast" id="issuedByLast" required />
        </div>
      </div>

      <div class="form-group row pl-3">
        <div class="col-sm-3">
          <label for="program">Program:</label>
          <select class="form-control" name="program" id="program">
            <option value="TNR">TNR</option>
            <option value="SNR">SNR</option>
            <option value="So Salt Lake - SNR">So Salt Lake - SNR</option>
            <option value="WVAS - SNR">WVAS - SNR</option>
            <option value="SLCo AS - TNR">SLCo AS - TNR</option>
            <option value="Murray AS - SNR">Murray AS - SNR</option>
            <option value="So. Ogden - SNR">So. Ogden - SNR</option>
          </select>
        </div>

        <div class="form-group col-sm-2">
            <label>Copay</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" name="copay" />
            </div>
        </div>

        <div class="col-sm-2">
          <label for="expireDate">Expires:</label>
          <div class="input-group date">
            <input type="text" class="form-control" name="expireDate" id="expireDate" placeholder="MM/DD/YYYY" />
            <script>$('#expireDate').datepicker();</script>
          </div>
        </div>
      </div>


      <p><h2>Caregiver Information </h2></p>

      <div class="form-group row pl-3">
        <div class="col-sm-4">
          <label for="CaregiverFirst">First name:</label>
          <input class="form-control" type="text" name="CaregiverFirst" id="CaregiverFirst" required />
        </div>
        <div class="col-sm-4">
          <label for="CaregiverLast">Last name:</label>
          <input class="form-control" type="text" name="CaregiverLast" id="CaregiverLast" required />
        </div>
      </div>

      <div class="form-group row pl-3">
        <div class="col-sm-3">
          <label for="CaregiverDay">Day phone:</label>
          <input class="form-control" type="text" name="CaregiverDay" id="CaregiverDay" />
        </div>
        <div class="col-sm-3">
          <label for="CaregiverOther">Other phone:</label>
          <input class="form-control" type="text" name="CaregiverOther" id="CaregiverOther" />
        </div>
      </div>

      <div class="form-group col-sm-4">
        <label for="CaregiverEmail">Email</label>
        <input class="form-control" type="email" name="CaregiverEmail" id="CaregiverEmail" />
      </div>

      <h2>Colony Information </h2>

      <p>
      <div class="custom-control custom-checkbox custom-control-inline form-check">
        <input type="checkbox" class="custom-control-input" id="sameInfo" value="same">
        <label class="custom-control-label" for="sameInfo">Same as Caregiver</label>
      </div>
      </p>

      <div class="form-group row pl-3">
        <div class="col-sm-4">
          <label for="colonyAddress">Location of cats (address):</label>
          <input class="form-control" type="text" name="colonyAddress" id="colonyAddress" />
        </div>
      </div>

      <div class="form-group row pl-3">
        <div class="col-sm-3">
          <label for="colonyCity">City:</label>
          <input class="form-control" type="text" name="colonyCity" id="colonyCity" />
        </div>

        <div class="col-sm-3">
          <label for="colonyCounty">County</label>
          <select class="form-control" name="colonyCounty" id="colonyCounty" onChange="getSelectedValue(); checkVets(); ">
            <option value="">Choose County:</option>
            <option value="Beaver">Beaver</option>
            <option value="Box Elder">Box Elder</option>
            <option value="Cache">Cache</option>
            <option value="Carbon">Carbon</option>
            <option value="Daggett">Daggett</option>
            <option value="Davis">Davis</option>
            <option value="Duchesne">Duchesne</option>
            <option value="Emery">Emery</option>
            <option value="Garfield">Garfield</option>
            <option value="Grand">Grand</option>
            <option value="Iron">Iron</option>
            <option value="Juab">Juab</option>
            <option value="Kane">Kane</option>
            <option value="Millard">Millard</option>
            <option value="Morgan">Morgan</option>
            <option value="Piute">Piute</option>
            <option value="Rich">Rich</option>
            <option value="Salt Lake">Salt Lake</option>
            <option value="San Juan">San Juan</option>
            <option value="Sanpete">Sanpete</option>
            <option value="Sevier">Sevier</option>
            <option value="Summit">Summit</option>
            <option value="Tooele">Tooele</option>
            <option value="Uintah">Uintah</option>
            <option value="Utah">Utah</option>
            <option value="Wasatch">Wasatch</option>
            <option value="Washington">Washington</option>
            <option value="Wayne">Wayne</option>
            <option value="Weber">Weber</option>
          </select>
        </div>

        <div class="col-sm-2">
          <label for="colonyZip">Zip:</label>
          <input class="form-control" type="text" name="colonyZip" id="colonyZip" />
        </div>
      </div>

      <div class="col-sm-3">
        <label for="colonyTrapper">Trapper (if different than above):</label>
        <input class="form-control" type="text" name="colonyTrapper" id="colonyTrapper" />

        <div class="col-sm-7 mt-3 mb-5">
        <input class="form-control btn-style btn btn-primary" type="submit" name="Generate" value="Generate" />
        </div>
      </div>
    </form>
  </div>

  <script>
    $("#sameInfo").click(function() {
      if ($(this).is(":checked")) {
        $("#colonyAddress").val($("#CaregiverAddress").val());
        $("#colonyCity").val($("#CaregiverCity").val());
        $("#colonyCounty").val($("#CaregiverCounty").val());
        $("#colonyZip").val($("#CaregiverZip").val());
      } else {
        $("#colonyAddress").val("");
        $("#colonyCity").val("");
        $("#colonyCounty").val("");
        $("#colonyZip").val("");
      }
    });

    $("#numVouch").change(function () {
      var start = parseInt($("#vouchStart").val());
      var end = parseInt($(this).val());
      var total = start + end - 1;
      $("#vouchEnd").val(total);
    });
</script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>    
<script src="/formvalidation/dist/js/FormValidation.full.min.js"></script>
<script src="/formvalidation/dist/js/plugins/Bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(e) {
    FormValidation.formValidation(
        document.getElementById('voucherForm'),
        {
            fields: {
              issuedToFirst: {
                    validators: {
                        notEmpty: {
                            message: 'Required field'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The name must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ ]+$/,
                            message: 'The name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                issuedToLast: {
                    validators: {
                        notEmpty: {
                            message: 'Required field'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The name must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ ]+$/,
                            message: 'The name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                expireDate: {
                    validators: {
                        notEmpty: {
                            message: 'Required field'
                        }
                    }
                },
                issuedByFirst: {
                    validators: {
                        notEmpty: {
                            message: 'Required field'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The name must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ ]+$/,
                            message: 'The name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                issuedByLast: {
                    validators: {
                        notEmpty: {
                            message: 'Required field'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The name must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ ]+$/,
                            message: 'The name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                copay: {
                    validators: {
                        notEmpty: {
                            message: 'Copay is required'
                        },
                        numeric: {
                            message: 'Copay must be a number'
                        }
                    }
                },
                CaregiverEmail: {
                      validators: {
                          notEmpty: {
                            message: 'Email is required'
                          },
                          emailAddress: {
                            message: 'Not a valid email'
                          }
                      }
                },
                CaregiverDay: {
                      validators: {
                          phone: {
                            country: 'US',
                            message: 'Not a valid phone number'
                          }
                      }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                }),
            },
        }
    );
});
</script>
</body>

</html>