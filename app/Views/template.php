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
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/charts/apexcharts.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/extensions/toastr.min.css') ?>">
   <!-- END: Vendor CSS-->

   <!-- BEGIN: Theme CSS-->
   <?= $this->renderSection('vendorCSS') ?>
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.min.css') ?>">

   <!-- BEGIN: Page CSS-->
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/core/menu/menu-types/vertical-menu.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/plugins/charts/chart-apex.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/plugins/extensions/ext-component-toastr.min.css') ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/pages/app-invoice-list.min.css') ?>">
   <!-- END: Page CSS-->

   <!-- BEGIN: Custom CSS-->
   <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
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
            <ul class="nav navbar-nav bookmark-icons">
               <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon" data-feather="mail"></i></a></li>
               <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon" data-feather="message-square"></i></a></li>
               <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon" data-feather="calendar"></i></a></li>
               <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon" data-feather="check-square"></i></a></li>
            </ul>
            <ul class="nav navbar-nav">
               <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon text-warning" data-feather="star"></i></a>
                  <div class="bookmark-input search-input">
                     <div class="bookmark-input-icon"><i data-feather="search"></i></div>
                     <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0" data-search="search">
                     <ul class="search-list search-list-bookmark"></ul>
                  </div>
               </li>
            </ul>
         </div>
         <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="javascript:void(0);" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="javascript:void(0);" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="javascript:void(0);" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="javascript:void(0);" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
            </li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon" data-feather="search"></i></a>
               <div class="search-input">
                  <div class="search-input-icon"><i data-feather="search"></i></div>
                  <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="-1" data-search="search">
                  <div class="search-input-close"><i data-feather="x"></i></div>
                  <ul class="search-list search-list-main"></ul>
               </div>
            </li>
            <li class="nav-item dropdown dropdown-cart mr-25"><a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="shopping-cart"></i><span class="badge badge-pill badge-primary badge-up cart-item-count">6</span></a>
               <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                     <div class="dropdown-header d-flex">
                        <h4 class="notification-title mb-0 mr-auto">My Cart</h4>
                        <div class="badge badge-pill badge-light-primary">4 Items</div>
                     </div>
                  </li>
                  <li class="scrollable-container media-list">
                     <div class="media align-items-center"><img class="d-block rounded mr-1" src="<?= base_url('app-assets/images/pages/eCommerce/1.png') ?>" alt="donuts" width="62">
                        <div class="media-body"><i class="ficon cart-item-remove" data-feather="x"></i>
                           <div class="media-heading">
                              <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html"> Apple watch 5</a></h6><small class="cart-item-by">By Apple</small>
                           </div>
                           <div class="cart-item-qty">
                              <div class="input-group">
                                 <input class="touchspin-cart" type="number" value="1">
                              </div>
                           </div>
                           <h5 class="cart-item-price">$374.90</h5>
                        </div>
                     </div>
                     <div class="media align-items-center"><img class="d-block rounded mr-1" src="<?= base_url('app-assets/images/pages/eCommerce/7.png') ?>" alt="donuts" width="62">
                        <div class="media-body"><i class="ficon cart-item-remove" data-feather="x"></i>
                           <div class="media-heading">
                              <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html"> Google Home Mini</a></h6><small class="cart-item-by">By Google</small>
                           </div>
                           <div class="cart-item-qty">
                              <div class="input-group">
                                 <input class="touchspin-cart" type="number" value="3">
                              </div>
                           </div>
                           <h5 class="cart-item-price">$129.40</h5>
                        </div>
                     </div>
                     <div class="media align-items-center"><img class="d-block rounded mr-1" src="<?= base_url('app-assets/images/pages/eCommerce/2.png') ?>" alt="donuts" width="62">
                        <div class="media-body"><i class="ficon cart-item-remove" data-feather="x"></i>
                           <div class="media-heading">
                              <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html"> iPhone 11 Pro</a></h6><small class="cart-item-by">By Apple</small>
                           </div>
                           <div class="cart-item-qty">
                              <div class="input-group">
                                 <input class="touchspin-cart" type="number" value="2">
                              </div>
                           </div>
                           <h5 class="cart-item-price">$699.00</h5>
                        </div>
                     </div>
                     <div class="media align-items-center"><img class="d-block rounded mr-1" src="<?= base_url('app-assets/images/pages/eCommerce/3.png') ?>" alt="donuts" width="62">
                        <div class="media-body"><i class="ficon cart-item-remove" data-feather="x"></i>
                           <div class="media-heading">
                              <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html"> iMac Pro</a></h6><small class="cart-item-by">By Apple</small>
                           </div>
                           <div class="cart-item-qty">
                              <div class="input-group">
                                 <input class="touchspin-cart" type="number" value="1">
                              </div>
                           </div>
                           <h5 class="cart-item-price">$4,999.00</h5>
                        </div>
                     </div>
                     <div class="media align-items-center"><img class="d-block rounded mr-1" src="<?= base_url('app-assets/images/pages/eCommerce/5.png') ?>" alt="donuts" width="62">
                        <div class="media-body"><i class="ficon cart-item-remove" data-feather="x"></i>
                           <div class="media-heading">
                              <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html"> MacBook Pro</a></h6><small class="cart-item-by">By Apple</small>
                           </div>
                           <div class="cart-item-qty">
                              <div class="input-group">
                                 <input class="touchspin-cart" type="number" value="1">
                              </div>
                           </div>
                           <h5 class="cart-item-price">$2,999.00</h5>
                        </div>
                     </div>
                  </li>
                  <li class="dropdown-menu-footer">
                     <div class="d-flex justify-content-between mb-1">
                        <h6 class="font-weight-bolder mb-0">Total:</h6>
                        <h6 class="text-primary font-weight-bolder mb-0">$10,999.00</h6>
                     </div><a class="btn btn-primary btn-block" href="app-ecommerce-checkout.html">Checkout</a>
                  </li>
               </ul>
            </li>
            <li class="nav-item dropdown dropdown-notification mr-25"><a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span class="badge badge-pill badge-danger badge-up">5</span></a>
               <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                     <div class="dropdown-header d-flex">
                        <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                        <div class="badge badge-pill badge-light-primary">6 New</div>
                     </div>
                  </li>
                  <li class="scrollable-container media-list"><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-15.jpg') ?>" alt="avatar" width="32" height="32"></div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">Congratulation Sam 🎉</span>winner!</p><small class="notification-text"> Won the monthly best seller badge.</small>
                           </div>
                        </div>
                     </a><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-3.jpg') ?>" alt="avatar" width="32" height="32"></div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">New message</span>&nbsp;received</p><small class="notification-text"> You have 10 unread messages</small>
                           </div>
                        </div>
                     </a><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar bg-light-danger">
                                 <div class="avatar-content">MD</div>
                              </div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">Revised Order 👋</span>&nbsp;checkout</p><small class="notification-text"> MD Inc. order updated</small>
                           </div>
                        </div>
                     </a>
                     <div class="media d-flex align-items-center">
                        <h6 class="font-weight-bolder mr-auto mb-0">System Notifications</h6>
                        <div class="custom-control custom-control-primary custom-switch">
                           <input class="custom-control-input" id="systemNotification" type="checkbox" checked="">
                           <label class="custom-control-label" for="systemNotification"></label>
                        </div>
                     </div><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar bg-light-danger">
                                 <div class="avatar-content"><i class="avatar-icon" data-feather="x"></i></div>
                              </div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">Server down</span>&nbsp;registered</p><small class="notification-text"> USA Server is down due to hight CPU usage</small>
                           </div>
                        </div>
                     </a><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar bg-light-success">
                                 <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i></div>
                              </div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">Sales report</span>&nbsp;generated</p><small class="notification-text"> Last month sales report generated</small>
                           </div>
                        </div>
                     </a><a class="d-flex" href="javascript:void(0)">
                        <div class="media d-flex align-items-start">
                           <div class="media-left">
                              <div class="avatar bg-light-warning">
                                 <div class="avatar-content"><i class="avatar-icon" data-feather="alert-triangle"></i></div>
                              </div>
                           </div>
                           <div class="media-body">
                              <p class="media-heading"><span class="font-weight-bolder">High memory</span>&nbsp;usage</p><small class="notification-text"> BLR Server using high memory</small>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="javascript:void(0)">Read all notifications</a></li>
               </ul>
            </li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder">John Doe</span><span class="user-status">Admin</span></div><span class="avatar"><img class="round" src="<?= base_url('app-assets/images/portrait/small/avatar-s-11.jpg') ?>" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item" href="page-profile.html"><i class="mr-50" data-feather="user"></i> Profile</a><a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a><a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="page-account-settings.html"><i class="mr-50" data-feather="settings"></i> Settings</a><a class="dropdown-item" href="page-pricing.html"><i class="mr-50" data-feather="credit-card"></i> Pricing</a><a class="dropdown-item" href="page-faq.html"><i class="mr-50" data-feather="help-circle"></i> FAQ</a><a class="dropdown-item" href="page-auth-login-v2.html"><i class="mr-50" data-feather="power"></i> Logout</a>
               </div>
            </li>
         </ul>
      </div>
   </nav>
   <ul class="main-search-list-defaultlist d-none">
      <li class="d-flex align-items-center"><a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Files</h6>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
               <div class="mr-75"><img src="<?= base_url('app-assets/images/icons/xls.png') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
               </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
               <div class="mr-75"><img src="<?= base_url('app-assets/images/icons/jpg.png') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
               </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
               <div class="mr-75"><img src="<?= base_url('app-assets/images/icons/pdf.png') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
               </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
            <div class="d-flex">
               <div class="mr-75"><img src="<?= base_url('app-assets/images/icons/doc.png') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
               </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
         </a></li>
      <li class="d-flex align-items-center"><a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Members</h6>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
               <div class="avatar mr-75"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-8.jpg') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
               </div>
            </div>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
               <div class="avatar mr-75"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-1.jpg') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
               </div>
            </div>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
               <div class="avatar mr-75"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-14.jpg') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
               </div>
            </div>
         </a></li>
      <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
            <div class="d-flex align-items-center">
               <div class="avatar mr-75"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-6.jpg') ?>" alt="png" height="32"></div>
               <div class="search-data">
                  <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
               </div>
            </div>
         </a></li>
   </ul>
   <ul class="main-search-list-defaultlist-other-list d-none">
      <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="mr-75" data-feather="alert-circle"></span><span>No results found.</span></div>
         </a></li>
   </ul>
   <!-- END: Header-->


   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
         <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= base_url('html/ltr/vertical-menu-template/index.html') ?>"><span class="brand-logo">
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
                     </svg></span>
                  <h2 class="brand-text">Vuexy</h2>
               </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
         </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
         <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="<?= $url_active == 'dashboard' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url() ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            <li class="<?= $url_active == 'user' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('user') ?>"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="User">User</span></a>
            </li>
            <li class="<?= $url_active == 'teacher' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('teacher') ?>"><i data-feather="user-check"></i><span class="menu-title text-truncate" data-i18n="Guru">Guru</span></a>
            </li>
            <li class="<?= $url_active == 'student' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('student') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Siswa">Siswa</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="trello"></i><span class="menu-title text-truncate" data-i18n="Kelas/Jurusan">Kelas/Jurusan</span></a>
               <ul class="menu-content">
                  <li class="<?= $url_active == 'classes' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('classes') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Kelas">Kelas</span></a>
                  </li>
                  <li class="<?= $url_active == 'major' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('major') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Jurusan">Jurusan</span></a>
                  </li>
                  <li class="<?= $url_active == 'schoolyear' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('schoolyear') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Tahun Pelajaran">Tahun Pelajaran</span></a>
                  </li>
               </ul>
            </li>
            <li class="<?= $url_active == 'subject' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('subject') ?>"><i data-feather="book-open"></i><span class="menu-title text-truncate" data-i18n="Mata Pelajaran">Mata Pelajaran</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Invoice</span></a>
               <ul class="menu-content">
                  <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">List</span></a>
                  </li>
                  <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Preview</span></a>
                  </li>
                  <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">Edit</span></a>
                  </li>
                  <li><a class="d-flex align-items-center" href="app-invoice-add.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">Add</span></a>
                  </li>
               </ul>
            </li>
            <li class=" navigation-header"><span data-i18n="E-Learning">E-Learning</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="<?= $url_active == 'bank_question' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('bank_question') ?>"><i data-feather="align-justify"></i><span class="menu-title text-truncate" data-i18n="Bank Soal">Bank Soal</span></a>
            </li>
            <li class="<?= $url_active == 'question' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('question') ?>"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Daftar Soal">Daftar Soal</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Tugas">Tugas</span></a>
               <ul class="menu-content">
                  <li class="<?= $url_active == 'e-learning/assignment' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('assignment') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Instruksi">Instruksi</span></a>
                  </li>
                  <li class="<?= $url_active == 'e-learning/assignment_result' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('assignment_result') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Hasil Instruksi">Hasil Instruksi</span></a>
                  </li>
                  <li class="<?= $url_active == 'quiz' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('quiz') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Quiz">Quiz</span></a>
                  </li>
                  <li class="<?= $url_active == 'quiz_result' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('quiz_result') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Hasil Quiz">Hasil Quiz</span></a>
                  </li>
               </ul>
            </li>
            <li class="<?= $url_active == 'e-learning/material' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('material') ?>"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Materi">Materi</span></a>
            </li>
            <li class="<?= $url_active == 'e-learning/announcement' ? 'active' : null ?> nav-item"><a class="d-flex align-items-center" href="<?= base_url('announcement') ?>"><i data-feather="info"></i><span class="menu-title text-truncate" data-i18n="Pengumuman">Pengumuman</span></a>
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
      <p class="clearfix mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ml-25" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
   </footer>
   <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
   <!-- END: Footer-->


   <!-- BEGIN: Vendor JS-->
   <script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
   <script src="<?= base_url('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>"></script>
   <!-- BEGIN Vendor JS-->

   <!-- BEGIN: Page Vendor JS-->
   <?= $this->renderSection('vendorJS') ?>
   <script src="<?= base_url('app-assets/vendors/js/charts/apexcharts.min.js') ?>"></script>
   <script src="<?= base_url('app-assets/vendors/js/extensions/toastr.min.js') ?>"></script>
   <script src="<?= base_url('app-assets/vendors/js/extensions/moment.min.js') ?>"></script>
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