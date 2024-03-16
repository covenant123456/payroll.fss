<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="css/styleguide.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
  <div class="setting-payroll">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Setting</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-3">Payroll</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-4">Default Payrun</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-5">Default Payrun</div>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="tab-lines">
            <div class="container-2">
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-4">Default Payrun</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-3">Value</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-3">Manage audience</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-3">Payslip</div>
                </div>
              </div>
            </div>
          </div>
          <div class="attendance-info">
            <div class="container-3">
              <div class="heading-wrapper">
                <div class="div-2">
                  <div class="text-wrapper-6">Preference</div>
                </div>
              </div>
              <div class="notice">
                <div class="label"><img class="img-3" src="img/warning.svg" /></div>
                <div class="container-4">
                  <div class="div-3">
                    <div class="title-2">How payrun works?</div>
                    <p class="description">
                      <span class="span">Default pay run is applicable to generate pays lip for all employees (Except those are
                        updated individually) whenever it execute from
                      </span>
                      <a href="https://payday.gainhq.com/payroll/payrun" target="_blank" rel="noopener noreferrer"><span class="text-wrapper-7">Payrun</span></a>
                      <span class="span">
                        module.<br />You can set pay run individually over the default from the
                      </span>
                      <span class="text-wrapper-7">Employees</span>
                      <span class="span"> details.</span>
                    </p>
                  </div>
                </div>
                <img class="img-3" src="img/close.svg" />
              </div>
              <div class="div-3">
                <div class="container-5">
                  <div class="label-text">
                    <div class="label-2">Payrun period</div>
                  </div>
                </div>
                <div class="input">
                  <div class="text">
                    <div class="placeholder">Monthly</div>
                    <img class="img" src="img/image.svg" />
                  </div>
                </div>
              </div>
              <div class="div-3">
                <div class="container-5">
                  <div class="label-text">
                    <div class="label-2">Payrun generating type</div>
                  </div>
                </div>
                <div class="input">
                  <div class="text">
                    <div class="placeholder">Hour</div>
                    <img class="img" src="img/image.svg" />
                  </div>
                </div>
              </div>
            </div>
            <div class="buttons-2">
              <button class="primary-button"><button class="button">Save</button></button>
              <button class="secondary-button"><button class="button-2">Cancel</button></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="fontawesome/js/all.js"></script>
  <script src="js/script.js"></script>

</body>

</html>