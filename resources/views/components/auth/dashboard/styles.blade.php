 <!-- Custom fonts for this template-->
 <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
 <link
     href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
     rel="stylesheet">

 <!-- Custom styles for this template-->
 <link href="{{ URL::asset('css/dashboard.min.css') }}" rel="stylesheet">

 <link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

 <style>
     .topbar.navbar-light .navbar-nav .nav-item .nav-link {
         color: #fff;
     }

     .sidebar-dark .sidebar-heading {
         color: rgb(255 255 255 / 68%);
     }

     .dropdown-menu i {
         color: #afafaf !important;
     }

     table tbody tr td {
         vertical-align: middle !important;
     }

     table thead tr th:last-child,
     table tfoot tr th:last-child,
     table tbody tr td:last-child {
         text-align: end
     }

     table thead tr th:first-child,
     table thead tr th:last-child {
         pointer-events: none !important;
     }

     .error-text {
         font-weight: 500;
         font-size: 14px;
         margin-top: 0.5rem;
         margin-bottom: 0;
         display: none;
     }

     #addUserModal #avatar_add,
     #editUserModal #avatar {
         cursor: pointer;
     }

     #addUserModal .avatar-cam,
     #editUserModal .avatar-cam {
         position: relative;
         right: -70px;
         top: -16px;
     }

     #addUserModal .avatar-cam i,
     #editUserModal .avatar-cam i {
         font-size: 2rem;
         color: rgb(11 165 11 / 82%);
     }

     #addUserModal .error_add_avatar,
     #editUserModal .error_avatar {
         display: none;
         font-weight: bold;
         color: red;
         font-size: 1rem;
     }

     #addUserModal #avatar_add,
     #editUserModal #avatar {
         border-radius: 50%;
     }

     #addUserModal .delete-add-image,
     #editUserModal .delete-image {
         font-size: 2rem;
         color: red;
         cursor: pointer;
     }

     #addUserModal #delete-add-image,
     #editUserModal #delete-image {
         display: none;
     }

     #avatar_input.disabled {
         pointer-events: none;
     }

     #addProjetModal #image-projet-add,
     #editProjetModal #image-projet {
         cursor: pointer;
     }

     #addProjetModal .avatar-cam,
     #editProjetModal .avatar-cam {
         position: relative;
         right: -146px;
         top: -60px;
     }

     #addProjetModal .avatar-cam i,
     #editProjetModal .avatar-cam i {
         font-size: 2rem;
         color: rgb(11 165 11 / 82%);
     }

     #addProjetModal .error_image_projet_add,
     #editProjetModal .error_image_projet {
         display: none;
         font-weight: bold;
         color: red;
         font-size: 1rem;
     }

     #addProjetModal .delete-image-projet-add,
     #editProjetModal .delete-image-projet {
         font-size: 2rem;
         color: red;
         cursor: pointer;
     }

     #addProjetModal #delete-image-projet-add,
     #editProjetModal #delete-image-projet {
         display: none;
     }

     #image_input.disabled {
         pointer-events: none;
     }
 </style>
