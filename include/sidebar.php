<div class="navbar-content">
    <!-- start: SIDEBAR -->
    <div class="main-navigation navbar-collapse collapse">
        <!-- start: MAIN MENU TOGGLER BUTTON -->
        <div class="navigation-toggler">
            <i class="clip-chevron-left"></i>
            <i class="clip-chevron-right"></i>
        </div>
        <!-- end: MAIN MENU TOGGLER BUTTON -->
        <!-- start: MAIN NAVIGATION MENU -->
        <ul class="main-navigation-menu">
            <li >
                <a href="index.php" onclick="return LoadPage('dashboard')"><i class="clip-home-3"></i>
                    <span class="title"> Dashboard </span><span class="selected"></span>
                </a>
            </li>

            <li>
                <a onclick="return LoadPage('Ticket');" href="Ticket"><i class="clip-bars"></i>
                    <span class="title"> Ticket Status </span>
                    <span class="selected"></span>
                </a>
            </li>

            <li>
                <a onclick="return LoadPage('UnAssignedList');" href="UnAssignedList"><i class="clip-user-5"></i>
                    <span class="title"> Assign Technicians </span>
                    <span class="selected"></span>
                </a>
            </li>

            <li>
                <a href="javascript:void(0)"><i class="fa fa-group"></i>
                    <span class="title"> Customers </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="return LoadPage('CustomerRegistration');" href="CustomerRegistration">
                            <i class="fa fa-plus"></i>
                            <span class="title"> New Customer </span>
                        </a>
                    </li>

                    <li>
                        <a onclick="return LoadPage('Search');" href="Search"><i class="clip-search-3"></i>
                            <span class="title">Search</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li>
                        <a onclick="return LoadPage('ViewCustomers');" href="ViewCustomers"><i class="clip-list-3"></i>
                            <span class="title">View Customers List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0)"><i class="clip-database"></i>
                    <span class="title">Manage </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="return LoadPage('Manage')" href="Manage">
                            <span class="title">Miscellaneous </span>
                        </a>
                    </li>
                    <li>
                        <a onclick="return LoadPage('Technicians')" href="Technicians">
                            <span class="title"> Technicians </span>
                        </a>
                    </li>
                    <li>
                        <a onclick="return LoadPage('Staff')" href="Staff">
                            <span class="title"> Staff </span>
                        </a>
                    </li>
                </ul>
            </li>


            <li>
                <a onclick="return LoadPage('Report')" href="Report"><i class="clip-stats"></i>
                    <span class="title">Reports</span>
                    <span class="selected"></span>
                </a>
            </li>


            <li>
                <a href="Logout.php"><i class="clip-exit"></i>
                    <span class="title">Logout</span>
                    <span class="selected"></span>
                </a>
            </li>

        </ul>
        <!-- end: MAIN NAVIGATION MENU -->
    </div>
    <!-- end: SIDEBAR -->
</div>
