 <!-- Custom fonts for this template-->
 <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
 <link
     href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
     rel="stylesheet">

 <!-- Custom styles for this template-->
 <link href="{{ URL::asset('css/dashboard.min.css') }}" rel="stylesheet">

 <link href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css" rel="stylesheet">

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

     .orders thead tr th:last-child {
         pointer-events: all !important;
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

     .card-body .card-img img {
         max-width: 350px;
     }

     .card-body .card-img {
         text-align: center;
         margin: 0 0 1.5rem 0;
     }

     .card-body .categorie {
         color: #419cca;
         font-weight: 700;
     }

     .card-body .post-author {
         font-weight: 700;
     }

     .card-body .post-date {
         font-size: 13px;
         color: #777;
         font-weight: 600;
     }

     .grid-article {
         width: 100%;
         display: flex;
         justify-content: center;
     }

     .image-article-bloc {
         max-width: 560px;
         width: 100%;
         margin-bottom: 1.5rem;
         margin-top: 1rem;
         text-align: center;
     }

     .image-article-bloc img {
         border-radius: 1rem
     }

     .delete-image-article {
         display: none;
         margin-top: 1rem;
         text-align: center;
         color: red;
         font-size: 1.50rem;
     }

     .delete-image-article i {
         cursor: pointer;
     }

     .bandeau-article-bloc {
         max-width: 560px;
         width: 100%;
         margin-bottom: 1.5rem;
         margin-top: 1rem;
         text-align: center;
     }

     .bandeau-article-bloc img {
         border-radius: 1rem
     }

     .delete-bandeau-article {
         display: none;
         margin-top: 1rem;
         text-align: center;
         color: red;
         font-size: 1.50rem;
     }

     .delete-bandeau-article i {
         cursor: pointer;
     }

     .author-article-bloc {
         margin-bottom: 1.5rem;
         margin-top: 1rem;
         text-align: center;
     }

     .author-article-bloc img {
         max-width: 100px;
         width: 100%;
     }

     .author-article-bloc img {
         border-radius: 50%
     }

     .delete-author-article {
         display: none;
         margin-top: 1rem;
         text-align: center;
         color: red;
         font-size: 1.50rem;
     }

     .delete-author-article i {
         cursor: pointer;
     }

     #mailModal .modal-body .d-flex {
         width: 100%;
         border: 0.15rem solid #cccccc78;
         padding: 1rem;
         border-radius: 0.5rem;
     }

     #mailModal .modal-body .d-flex .col-md-3 {
         border-right: 0.15rem solid #cccccc78;
         padding-right: 7rem;
     }

     #mailModal .modal-avatar {
         border-radius: 50%;
     }

     #mailModal .modal-message {
         font-size: 1rem;
         font-weight: 600;
     }

     #mailModal .modal-date {
         margin-top: 1rem;
         padding: 0 1rem;
         font-size: 13px;
         font-weight: 600;
         text-align: end;
     }

     #mailModal .modal-name {
         margin-top: 1rem;
         padding: 0 1rem;
         font-size: 13px;
         font-weight: 800;
         text-align: start;
     }

     #mailModal .modal-info {
         display: flex;
         justify-content: center;
         flex-wrap: nowrap;
     }

     .message-mail {
         padding: 1rem;
         font-weight: bold;
     }

     .icon-app {
         border-radius: 20%;
         padding: 0;
         background: white;
         box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .3), 0 1px 3px 1px rgba(60, 64, 67, .15);
     }
 </style>

 <script src="{{ URL::asset('js/jquery-sb/jquery.min.js') }}"></script>
