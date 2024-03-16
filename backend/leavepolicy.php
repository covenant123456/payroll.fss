<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="css/styleguide.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
  <div class="setting-leave-policy">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Setting</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-3">Leave</div>
          <img class="img" src="img/chevron-right.svg" />
          <div class="text-wrapper-4">Policy</div>
        </div>
        <div class="div-3">
          <div class="div-2">
            <div class="text-wrapper-5">Policy</div>
          </div>
          <div class="frame"></div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="tab-lines">
            <div class="container-2">
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-3">Setting</div>
                </div>
              </div>
              <div class="child-wrapper">
                <div class="child">
                  <div class="text-wrapper-4">Policy</div>
                </div>
              </div>
              <div class="tab">
                <div class="child">
                  <div class="text-wrapper-3">Approval</div>
                </div>
              </div>
            </div>
          </div>
          <div class="attendance-info">
            <div class="container-3">
              <div class="title">
                <div class="div-2">
                  <div class="text-wrapper-6">Policy</div>
                </div>
              </div>
              <div class="notice">
                <div class="label"><img class="img-3" src="img/warning.svg" /></div>
                <div class="container-4">
                  <div class="div-4">
                    <div class="title-2">Note</div>
                    <p class="description">
                      <span class="span">Any type of change will be effective on the next day.<br />To understand how leave settings
                        work, please checkout the
                      </span>
                      <a href="https://payday.gainhq.com/documentation/instruction-guide.html#appLeave" target="_blank" rel="noopener noreferrer"><span class="text-wrapper-7">documentation</span></a>
                      <span class="span">.<br />Remained leave will not carry forward to next leave year.</span>
                    </p>
                  </div>
                </div>
                <img class="img-3" src="img/close-2.svg" />
              </div>
              <div class="div-4">
                <div class="container-5">
                  <div class="label-text">
                    <div class="label-2">Start month</div>
                  </div>
                </div>
                <div class="input">
                  <div class="text">
                    <div class="placeholder">January</div>
                    <img class="img" src="img/image.svg" />
                  </div>
                </div>
              </div>
              <div class="div-4">
                <div class="div-3">
                  <div class="label-text">
                    <div class="label-2">For paid leave</div>
                  </div>
                  <p class="text-wrapper-3">(Add employment status to allow employee for auto allowance)</p>
                </div>
                <div class="input-2">
                  <div class="filter">
                    <div class="tag-wrapper">
                      <div class="tag">
                        <div class="pill-name">
                          <div class="pill">
                            <div class="text-wrapper-8">Tag name</div>
                          </div>
                        </div>
                        <div class="pill-trigger">
                          <div class="close-wrapper"><img class="img" src="img/close.svg" /></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="filter-2">
                    <div class="tag-2">
                      <div class="pill-name">
                        <div class="pill">
                          <div class="text-wrapper-8">Tag name</div>
                        </div>
                      </div>
                      <div class="pill-trigger">
                        <div class="close-wrapper"><img class="img" src="img/close.svg" /></div>
                      </div>
                    </div>
                    <div class="text-cursor"></div>
                  </div>
                </div>
              </div>
              <div class="div-4">
                <div class="div-3">
                  <div class="label-text">
                    <div class="text-wrapper-8">For unpaid leave</div>
                  </div>
                  <p class="text-wrapper-3">(Add employment status to allow employee for auto allowance)</p>
                </div>
                <div class="input-2">
                  <div class="filter">
                    <div class="tag-wrapper">
                      <div class="tag">
                        <div class="pill-name">
                          <div class="pill">
                            <div class="text-wrapper-8">Tag name</div>
                          </div>
                        </div>
                        <div class="pill-trigger">
                          <div class="close-wrapper"><img class="img" src="img/close.svg" /></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="filter-2">
                    <div class="tag-2">
                      <div class="pill-name">
                        <div class="pill">
                          <div class="text-wrapper-8">Tag name</div>
                        </div>
                      </div>
                      <div class="pill-trigger">
                        <div class="close-wrapper"><img class="img" src="img/close.svg" /></div>
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