			<?php
                 $currentPage = pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME); 
                 $isTemplateActive = in_array($currentPage, ['forms.php', 'table.php']);
            ?>

            <?php 
            
            if($role == "Admin"){
            ?>
            <nav id="sidebar">
				<div class="p-4 pt-5">
		  		    <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/bsu.jpg);"></a>
                <center>
                    <p><?= $fullname ." || ".$role; ?></p>
                </center>
	        <ul class="list-unstyled components mb-5">

	          <li  class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
	              <a href="dashboard"><i class="fas fa-home"></i> Dashboard</a>
	          </li>

              <li>
                <a href="#requestSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>">
                   <i class="fas fa-file"></i> Manage Request
                </a>
                
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="requestSubmenu">
                    <li class="<?= $currentPage == 'adminmonitorrequest' ? 'active' : '' ?>">
                        <a href="adminmonitorrequest">Track Request</a>
                    </li>
                    <li class="<?= $currentPage == 'adminrequesthistory' ? 'active' : '' ?>">
                        <a href="adminrequesthistory">Tracking Request History</a>
                    </li>
                </ul>
              </li>

              <li>
                <a href="#orderSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>">
                    <i class="fas fa-file"></i> Manage Orders
                </a>
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="orderSubmenu">
                    <li class="<?= $currentPage == 'adminmonitororder' ? 'active' : '' ?>">
                        <a href="adminmonitororder">Tracking Orders</a>
                    </li>
                    <li class="<?= $currentPage == 'adminordersHistory' ? 'active' : '' ?>">
                        <a href="adminordersHistory">Tracking Orders History</a>
                    </li>
                </ul>
	          </li>

              <li>
                <a href="#package" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>" class="dropdown-toggle"><i class="fas fa-box"></i>  Package Status</a>
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="package" >
                    <li class="<?= $currentPage == 'adminpickupOrders' ? 'active' : '' ?>">
                        <a href="adminpickupOrders">Pick-up Package</a>
                    </li>
                    <li class="<?= $currentPage == 'adminpickupPackage' ? 'active' : '' ?>">
                        <a href="adminpickupPackage">Recieved Package</a>
                    </li>
                </ul>
	          </li>

              <li>
                <a href="#userSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>" class="dropdown-toggle"><i class="fas fa-users"></i> Manage System Users</a>
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="userSubmenu">
                    <li class="<?= $currentPage == 'adminunverifiedstaff' ? 'active' : '' ?>">
                        <a href="adminunverifiedstaff">Unverified Staff</a>
                    </li>
                    <li class="<?= $currentPage == 'adminunverifiedadmins' ? 'active' : '' ?>">
                        <a href="adminunverifiedadmins">Unverified Admin</a>
                    </li>
                    <li class="<?= $currentPage == 'adminverifieduser' ? 'active' : '' ?>">
                        <a href="adminverifieduser">Verified Users List</a>
                    </li>
                    <li class="<?= $currentPage == 'adminaddusers' ? 'active' : '' ?>">
                        <a href="adminaddusers">Add New User</a>
                    </li>
                </ul>
	          </li>

                            
              <li>
                <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>" class="dropdown-toggle"><i class="fas fa-print"></i> System Reports</a>
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="reportSubmenu">
                    <li class="<?= $currentPage == 'adminPrintRequest' ? 'active' : '' ?>">
                        <a href="adminPrintRequest">PMS Request Reports</a>
                    </li>
                    <li class="<?= $currentPage == 'adminPrintOrders' ? 'active' : '' ?>">
                        <a href="adminPrintOrders">PMS Order Reports</a>
                    </li>
                </ul>
	          </li>
              <li>
                <a href="#profileSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>" class="dropdown-toggle"><i class="fas fa-user"></i>  Profile</a>
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="profileSubmenu">
                    <li class="<?= $currentPage == 'profile' ? 'active' : '' ?>">
                        <a href="profile">User Account</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
	          </li>


            <li>
                <a href="#tempSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>">
                    System Template
                </a>
                
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="tempSubmenu">
                    <li class="<?= $currentPage == 'forms' ? 'active' : '' ?>">
                        <a href="forms">Forms</a>
                    </li>
                    <li class="<?= $currentPage == 'table' ? 'active' : '' ?>">
                        <a href="table">Table</a>
                    </li>
                </ul>
            </li>


	        </ul>
	        <div class="footer">
	        	<p>Copyright &copy; PMS-Developers <script>document.write(new Date().getFullYear());</script></p>
	        </div>
	      </div>
    	</nav>

        <?php }
        else{
        ?>
            <nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/bsu.jpg);"></a>
                <center>
                    <p><?= $fullname ." || ".$role; ?></p>
                </center>
	        <ul class="list-unstyled components mb-5">

	          <li  class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
	              <a href="dashboard"><i class="fas fa-home"></i> Dashboard</a>
	          </li>

              <li class="<?= ($currentPage == 'requestnow') ? 'active' : '' ?>">
                <a href="requestnow"><i class="fas fa-pencil"></i> Request Now</a>
	          </li>
              <li class="<?= ($currentPage == 'userpickupPackage') ? 'active' : '' ?>">
                <a href="userpickupPackage"><i class="fas fa-box"></i>  Pick-up Package</a>
	          </li>

              <li>
                <a href="#tempSubmenu" data-toggle="collapse" aria-expanded="<?= $isTemplateActive ? 'true' : 'false' ?>" class="dropdown-toggle <?= $isTemplateActive ? '' : '' ?>">
                   <i class="fas fa-clock"></i> Order and Request History
                </a>
                
                <ul class="collapse list-unstyled <?= $isTemplateActive ? 'show' : '' ?>" id="tempSubmenu">
                    <li class="<?= $currentPage == 'userOrders' ? 'active' : '' ?>">
                        <a href="userOrders">Track Orders</a>
                    </li>
                    <li class="<?= $currentPage == 'userrequesthistory' ? 'active' : '' ?>">
                        <a href="userrequesthistory">Request History</a>
                    </li>
                </ul>
              </li>
                            
              <!-- <li>
                <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-print"></i> System Reports</a>
                <ul class="collapse list-unstyled" id="reportSubmenu">
                    <li>
                        <a href="#">PMS Request Reports</a>
                    </li>
                </ul>
	          </li> -->

              <li>
                <a href="#profileSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i>  Profile</a>
                <ul class="collapse list-unstyled" id="profileSubmenu">
                    <li>
                        <a href="#">User Account</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
	          </li>
              
	        </ul>
	        <div class="footer">
	        	<p>Copyright &copy; PMS-Developers <script>document.write(new Date().getFullYear());</script></p>
	        </div>
	      </div>
    	</nav>

        <?php }?>