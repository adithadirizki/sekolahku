<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
   <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
   <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
   <meta name="author" content="PIXINVENT">
   <title><?= $title ?> | SEKOLAH-KU</title>
   <link rel="apple-touch-icon" href="<?= base_url('app-assets/images/ico/apple-icon-120.png') ?>">
   <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets/images/ico/favicon.ico') ?>">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

   <!-- BEGIN: Vendor CSS-->
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/vendors.min.css') ?>">
   <!-- END: Vendor CSS-->

   <!-- BEGIN: Theme CSS-->
   <?= $this->renderSection('vendorCSS') ?>
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.min.css') ?>">

   <!-- BEGIN: Page CSS-->
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/core/menu/menu-types/vertical-menu.min.css') ?>">
   <!-- END: Page CSS-->

   <!-- BEGIN: Custom CSS-->
   <?= $this->renderSection('customCSS') ?>
   <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

   <!-- BEGIN: Header-->
   <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
      <div class="navbar-container d-flex content">
         <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
               <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
         </div>
         <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item">
               <a class="nav-link" id="logout" href="<?= base_url('logout') ?>" title="Logout"><i class="ficon text-danger" data-feather="power"></i></a>
            </li>
            <li class="nav-item dropdown dropdown-user">
               <a class="nav-link dropdown-user-link" href="javascript:void(0);">
                  <div class="user-nav d-sm-flex d-none">
                     <span class="user-name font-weight-bolder"><?= session()->fullname ?></span>
                     <span class="user-status"><?= session()->role ?></span>
                  </div>
                  <span class="avatar">
                     <img class="round" src="<?= base_url('assets/upload/' . session()->photo) ?>" alt="avatar" height="40" width="40">
                     <span class="avatar-status-online"></span>
                  </span>
               </a>
            </li>
         </ul>
      </div>
   </nav>
   <!-- END: Header-->


   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
         <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
               <a class="navbar-brand" href="<?= base_url() ?>">
                  <span class="brand-logo">
                     <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                        <defs>
                           <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                              <stop stop-color="#000000" offset="0%"></stop>
                              <stop stop-color="#FFFFFF" offset="100%"></stop>
                           </lineargradient>
                           <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                              <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                              <stop stop-color="#FFFFFF" offset="100%"></stop>
                           </lineargradient>
                        </defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                              <g id="Group" transform="translate(400.000000, 178.000000)">
                                 <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                 <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                 <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                 <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                 <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                              </g>
                           </g>
                        </g>
                     </svg>
                  </span>
                  <h2 class="brand-text">Vuexy</h2>
               </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
         </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
         <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="<?= $url_active == 'dashboard' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('dashboard') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            <li class="<?= $url_active == 'student' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('student') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Siswa">Siswa</span></a>
            </li>
            <li class="<?= $url_active == 'bankquestion' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('bankquestion') ?>"><i data-feather="align-justify"></i><span class="menu-title text-truncate" data-i18n="Bank Soal">Bank Soal</span></a>
            </li>
            <li class="<?= $url_active == 'question' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('question') ?>"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Daftar Soal">Daftar Soal</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="E-Learning">E-Learning</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Tugas">Tugas</span></a>
               <ul class="menu-content">
                  <li class="<?= $url_active == 'assignment' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('assignment') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Daftar Tugas">Daftar Tugas</span></a>
                  </li>
                  <li class="<?= $url_active == 'assignmentresult' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('assignmentresult') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Hasil Tugas">Hasil Tugas</span></a>
                  </li>
               </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="message-circle"></i><span class="menu-title text-truncate" data-i18n="Quiz">Quiz</span></a>
               <ul class="menu-content">
                  <li class="<?= $url_active == 'quiz' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('quiz') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Daftar Quiz">Daftar Quiz</span></a>
                  </li>
                  <li class="<?= $url_active == 'quizresult' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('quizresult') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Hasil Quiz">Hasil Quiz</span></a>
                  </li>
               </ul>
            </li>
            <li class="<?= $url_active == 'material' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('material') ?>"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Materi">Materi</span></a>
            </li>
            <li class="<?= $url_active == 'announcement' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('announcement') ?>"><i data-feather="info"></i><span class="menu-title text-truncate" data-i18n="Pengumuman">Pengumuman</span></a>
            </li>
         </ul>
      </div>
   </div>
   <!-- END: Main Menu-->

   <!-- BEGIN: Content-->
   <div class="app-content content ">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
         <div class="content-header row">
         </div>
         <div class="content-body">
            <section>
               <?= $this->renderSection('content') ?>
            </section>
         </div>
      </div>
   </div>
   <!-- END: Content-->

   <div class="sidenav-overlay"></div>
   <div class="drag-target"></div>

   <!-- BEGIN: Footer-->
   <footer class="footer footer-static footer-light">
      <p class="clearfix mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ml-25" href="https://github.com/adithadirizki" target="_blank">Adit Hadi Rizki</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span></p>
   </footer>
   <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
   <!-- END: Footer-->


   <!-- BEGIN: Vendor JS-->
   <script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
   <script src="<?= base_url('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>"></script>
   <!-- BEGIN Vendor JS-->

   <!-- BEGIN: Page Vendor JS-->
   <?= $this->renderSection('vendorJS') ?>
   <!-- END: Page Vendor JS-->

   <!-- BEGIN: Theme JS-->
   <script src="<?= base_url('app-assets/js/core/app-menu.min.js') ?>"></script>
   <script src="<?= base_url('app-assets/js/core/app.min.js') ?>"></script>
   <!-- END: Theme JS-->

   <!-- BEGIN: Page JS-->
   <!-- END: Page JS-->

   <script>
      $(window).on('load', function() {
         if (feather) {
            feather.replace({
               width: 14,
               height: 14
            });
         }
      })
      $('body').tooltip({
         selector: "#profile, #logout",
         placement: "auto",
         trigger: "hover"
      })
      var set_blockUI = {
         message: '<div class="spinner-border mb-50" role="status" style="width: 2.5rem;height: 2.5rem;"></div><div class="h4 font-weight-bolder">Loading...</div>',
         css: {
            backgroundColor: 'transparent',
            border: '0'
         },
         overlayCSS: {
            backgroundColor: '#fff',
            opacity: .5
         }
      };
   </script>
   <?= $this->renderSection('customJS') ?>
</body>
<!-- END: Body-->

</html>