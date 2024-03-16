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
          <div class="text-wrapper-4">Value</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-5">Value</div>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="tab-lines">
            <div class="container-2">
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-3">Default Payrun</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-4">Value</div>
                </div>
              </div>
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-3">Manage audience</div>
                </div>
              </div>
              <div class="tab">
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
                  <div class="text-wrapper-6">How badge value work?</div>
                </div>
              </div>
              <div class="notice">
                <div class="label"><img class="img-3" src="img/warning.svg" /></div>
                <div class="container-4">
                  <div class="div-3">
                    <div class="title-2">How payrun works?</div>
                    <p class="description">
                      <span class="span">Create badge for allowance or deduction from </span>
                      <span class="text-wrapper-7">Beneficiary badge</span>
                      <span class="span">
                        module.<br />Select badge and assign a value that will applicable for all employees (Except
                        those are updated individually) while execute payrun.<br />You can set beneficiary
                        individually over the default from the
                      </span>
                      <span class="text-wrapper-7">Employees</span>
                      <span class="span"> details.<br />You can also update beneficiaries in </span>
                      <span class="text-wrapper-7">Payslip</span>
                      <span class="span"> generated for every employee.</span>
                    </p>
                  </div>
                </div>
                <img class="img-3" src="img/close.svg" />
              </div>
              <div class="div-3">
                <div class="label-text-wrapper">
                  <div class="label-text">
                    <div class="text-wrapper-8">Allowance</div>
                  </div>
                </div>
                <div class="input">
                  <div class="filter">
                    <div class="tag-wrapper">
                      <div class="tag">
                        <div class="pill-name">
                          <div class="pill">
                            <div class="text-wrapper-9">Tag name</div>
                          </div>
                        </div>
                        <div class="pill-trigger">
                          <div class="close-wrapper"><img class="img" src="img/close-2.svg" /></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="filter-2">
                    <div class="tag-2">
                      <div class="pill-name">
                        <div class="pill">
                          <div class="text-wrapper-9">Tag name</div>
                        </div>
                      </div>
                      <div class="pill-trigger">
                        <div class="close-wrapper"><img class="img" src="img/close-2.svg" /></div>
                      </div>
                    </div>
                    <div class="text-cursor"></div>
                  </div>
                </div>
              </div>
              <div class="div-3">
                <div class="label-text-wrapper">
                  <div class="label-text">
                    <div class="text-wrapper-8">Deduction</div>
                  </div>
                </div>
                <div class="input">
                  <div class="filter">
                    <div class="tag-wrapper">
                      <div class="tag">
                        <div class="pill-name">
                          <div class="pill">
                            <div class="text-wrapper-9">Tag name</div>
                          </div>
                        </div>
                        <div class="pill-trigger">
                          <div class="close-wrapper"><img class="img" src="img/close-2.svg" /></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="filter-2">
                    <div class="tag-2">
                      <div class="pill-name">
                        <div class="pill">
                          <div class="text-wrapper-9">Tag name</div>
                        </div>
                      </div>
                      <div class="pill-trigger">
                        <div class="close-wrapper"><img class="img" src="img/close-2.svg" /></div>
                      </div>
                    </div>
                    <div class="text-cursor"></div>
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