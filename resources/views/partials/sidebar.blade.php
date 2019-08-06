<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">GELVIC</a>
    </div>
    <!-- /.navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-gears fa-fw"></i> Project Order(PO) <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ action('ProjectOrderController@index') }}">Production</a>
                        </li>
                        <li>
                            <a href="{{ action('ProjectOrderController@project') }}">Project</a>
                        </li>
                        <li>
                            <a href="{{ action('ProjectOrderController@archive') }}">Archive</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="{{ action('ManpowerController@index') }}"><i class="fa fa-users fa-fw"></i> Manpower</a>
                </li>
                <li>
                    <a href="{{ action('EquipmentController@index') }}"><i class="fa fa-wrench fa-fw"></i> Equipment</a>
                </li>
                <li>
                    <a href="{{ action('PayrollController@index') }}"><i class="fa fa-money fa-fw"></i> Payroll</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>