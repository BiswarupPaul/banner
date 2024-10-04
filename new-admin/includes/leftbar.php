 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../new-admin/dashboard.php">
    <div class="sidebar-brand-icon ">
        <!-- <i class="fas fa-user-graduate">
        <a href="../new-admin/images/logo.png"></a>
        </i> -->
        <!-- <a href="../new-admin/images/logo.png"></a> -->
        <img src="../new-admin/images/logo.png" alt="Italian Trulli" style="width: 200px; height: auto; margin-right: 10px;>
    </div>
    <div class="sidebar-brand-text mx-3">PHP Admin <sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="../new-admin/dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Posting
</div>


<li class="nav-item">
    <a class="nav-link" href="../new-admin/list-banner.php" data-toggle="collapse" data-target="#collapsebanner"
    aria-expanded="true" aria-controls="collapsebanner">
        <i class="fas fa-fw fa-images"></i>
        <span>Banners</span>
    </a>
    <div id="collapsebanner" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            
            <a class="collapse-item" href="list-banner.php"><i class="fas fa-fw fa-list"></i>
            <span>List Banner</span></a>
            <a class="collapse-item" href="home-banner.php"><i class="fa fa-home" aria-hidden="true"></i>
            <span>Home Banner</span></a>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link" href="../new-admin/list-blog.php" data-toggle="collapse" data-target="#collapseblog"
    aria-expanded="true" aria-controls="collapseblog">
        <i class="fas fa-fw fa-blog"></i>
        <span>Blog</span>
    </a>
    <div id="collapseblog" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            
            <a class="collapse-item" href="list-blogs.php"><i class="fas fa-fw fa-list"></i>
            <span>All Blog</span></a>
            <a class="collapse-item" href="list-categories.php"><i class="fas fa-fw fa-list"></i>
            <span>All Category</span></a>
            <a class="collapse-item" href="add-blogs.php"><i class="fas fa-fw fa-plus"></i>
            <span>Add Blog</span></a>
            <a class="collapse-item" href="add-categories.php"><i class="fas fa-fw fa-plus"></i>
            <span>Add Category</span></a>
        </div>
    </div>
</li>



<!-- Divider -->
<hr class="sidebar-divider">


<!-- Heading -->
<div class="sidebar-heading">
    Users
</div>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="../new-admin/tables.php">
        <i class="fas fa-user-friends"></i>
        <span>User Details</span></a>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="all-page.php">All Page</a>
            <a class="collapse-item" href="add-page.php">Add Page</a>
            <a class="collapse-item" href="thank-you.php">Thank You page</a>
        </div>
    </div>
</li>



<!-- Nav Item - Publication -->
<li class="nav-item">
    <a class="nav-link" href="../new-admin/dashboard.php">
        <i class="fa fa-book" aria-hidden="true" ></i>
        <span>Publication</span></a>
</li>

<!-- Nav Item - Setting -->
<li class="nav-item">
    <a class="nav-link" href="../new-admin/setting.php">
        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
        <span>General Setting</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div>

</ul>
<!-- End of Sidebar -->


  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">