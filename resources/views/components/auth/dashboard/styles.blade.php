 <!-- Custom fonts for this template-->
 <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
 <link
     href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
     rel="stylesheet">

 <!-- Custom styles for this template-->
 <link href="{{ URL::asset('css/dashboard.min.css') }}" rel="stylesheet">

 @if ($user->admin == 1)
     @if (Route::current()->getName() == 'show-agenda')
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
     @endif
 @endif

 <link href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css" rel="stylesheet">

 <script src='https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js'></script>
 <script src='https://cdn.jsdelivr.net/npm/moment-timezone@0.5.40/builds/moment-timezone-with-data.min.js'></script>

 <script src="{{ URL::asset('js/jquery-sb/jquery.min.js') }}"></script>
