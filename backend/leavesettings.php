<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="css/styleguide.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
  <div class="setting-leave">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Setting</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-3">Leave</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-4">Setting</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-5">Setting</div>
          </div>
          <div class="frame">
            <div class="div-3">
              <button class="button">
                <img class="img" src="img/plus.svg" /> <button class="button-2">Add Leave Type</button>
              </button>
            </div>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="tab-lines">
            <div class="container-2">
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-4">Setting</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-3">Policy</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-3">Approval</div>
                </div>
              </div>
            </div>
          </div>
          <div class="attendance-info">
            <div class="container-3">
              <div class="heading-wrapper">
                <div class="div-2">
                  <div class="text-wrapper-6">Leave Type</div>
                </div>
              </div>
              <div class="notice">
                <div class="label"><img class="img-3" src="img/warning.svg" /></div>
                <div class="container-4">
                  <div class="text">
                    <div class="title-2">Note</div>
                    <p class="description">
                      <span class="span">Any type of change will be effective on the next day.<br />To understand how leave settings
                        work, please checkout the
                      </span>
                      <span class="text-wrapper-7">documentation</span>
                      <span class="span">.<br />You must setup the cron job in your hosted server for assigning work shift, generating
                        payslip, sending bulk emails, assigning leaves and renew holidays.<br />Remained leave will
                        not carry forward to next leave year.</span>
                    </p>
                  </div>
                </div>
                <img class="img-3" src="img/close.svg" />
              </div>
              <div class="table">
                <div class="frame-wrapper">
                  <div class="input-wrapper">
                    <div class="input">
                      <div class="text-2">
                        <img class="img" src="img/search.svg" />
                        <input class="placeholder" placeholder="Search" type="text" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table-pagination">
                  <div class="table-sample">
                    <div class="table-cell">
                      <div class="label-wrapper">
                        <div class="div-wrapper">
                          <div class="label-2">Name</div>
                        </div>
                      </div>
                      <div class="component">
                        <div class="div-wrapper">
                          <div class="label-2">Type</div>
                        </div>
                      </div>
                      <div class="component">
                        <div class="div-wrapper">
                          <div class="label-2">Amount</div>
                        </div>
                      </div>
                      <div class="component">
                        <div class="div-wrapper">
                          <div class="label-2">Enabled</div>
                        </div>
                      </div>
                      <div class="component">
                        <div class="div-wrapper">
                          <div class="label-2">Allow monthly earning</div>
                        </div>
                      </div>
                      <div class="component">
                        <div class="div-wrapper">
                          <div class="label-2">Action</div>
                        </div>
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-2">
                          <img class="ellipse" src="img/ellipse-534-4.png" />
                          <div class="text-wrapper-8">Jeremy Neigh</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Melnichenko Alexandr</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Design</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Active</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="checkbox"></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/edit-5.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-2">
                          <img class="ellipse" src="img/ellipse-534.png" />
                          <div class="text-wrapper-8">Annette Black</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Shurenkova Larisa</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Product</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Inactive</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="check-small-wrapper"><img class="check-small" src="img/check-small.svg" /></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/edit-2.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-2">
                          <img class="ellipse" src="img/ellipse-534-5.png" />
                          <div class="text-wrapper-8">Theresa Webb</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Kachurovskiy Vadim</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Marketing</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Inactive</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="checkbox"></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/edit.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-3">
                          <img class="ellipse" src="img/ellipse-534-2.png" />
                          <div class="text-wrapper-8">Kathryn Murphy</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Nebrat Eugene</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Support</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Active</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="check-small-wrapper"><img class="check-small" src="img/check-small.svg" /></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/edit-3.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-3">
                          <img class="ellipse" src="img/image.png" />
                          <div class="text-wrapper-8">Courtney Henry</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Shevchenko Oleg</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Operations</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Active</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="check-small-wrapper"><img class="check-small" src="img/check-small.svg" /></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/image.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                    <div class="table-cell-2">
                      <div class="profile-wrapper">
                        <div class="profile-2">
                          <img class="ellipse" src="img/ellipse-534-3.png" />
                          <div class="text-wrapper-8">Jane Cooper</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Kiseleva Olga</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">HR</div>
                        </div>
                      </div>
                      <div class="component-2">
                        <div class="div-wrapper">
                          <div class="text-wrapper-9">Inactive</div>
                        </div>
                      </div>
                      <div class="component-3">
                        <div class="checkbox"></div>
                      </div>
                      <div class="component-3">
                        <img class="img-3" src="img/edit-4.svg" /> <img class="img-3" src="img/delete.svg" />
                      </div>
                    </div>
                  </div>
                  <div class="pagination">
                    <div class="pagination-2">
                      <div class="div-3">
                        <div class="chevron-left-wrapper"><img class="img" src="img/chevron-left.svg" /></div>
                        <button class="button-3">
                          <div class="text-wrapper-10">Prev</div>
                        </button>
                        <button class="button-4">
                          <div class="text-wrapper-11">Next</div>
                        </button>
                      </div>
                      <div class="div-2">
                        <div class="input-page">
                          <div class="text-wrapper-12">Page:</div>
                          <button class="button-5">
                            <div class="text-wrapper-10">1</div>
                          </button>
                        </div>
                        <div class="pages-amount">
                          <div class="pages-amount-2">of</div>
                          <div class="pages-amount-3">100</div>
                        </div>
                      </div>
                      <button class="button-6">
                        <div class="text-wrapper-10">10</div>
                        <img class="img" src="img/chevron-down.svg" />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
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