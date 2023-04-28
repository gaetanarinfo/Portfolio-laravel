 <!-- Bootstrap core JavaScript-->
 <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

 <!-- Core plugin JavaScript-->
 <script src="{{ URL::asset('js/jquery.easing.min.js') }}"></script>

 <!-- Custom scripts for all pages-->
 <script src="{{ URL::asset('js/dashboard.min.js') }}"></script>

 <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
 <script
     src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js">
 </script>
 <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
 <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table-locale-all.min.js"></script>
 <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.min.js" integrity="sha512-GCiwmzA0bNGVsp1otzTJ4LWQT2jjGJENLGyLlerlzckNI30moi2EQT0AfRI7fLYYYDKR+7hnuh35r3y1uJzugw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 @if (Route::current()->getName() == 'add-article')
     <script src="{{ URL::asset('js/add-blog.js') }}"></script>
 @else
     <script src="{{ URL::asset('js/dashboard.js') }}"></script>
 @endif

 @if (Route::current()->getName() == 'dashboard')
 <script src="{{ URL::asset('js/chart-bar.js') }}"></script>
 @endif

 <script src="https://accounts.google.com/gsi/client" async defer></script>

 <!-- Page level plugins -->

 <!-- Page level custom scripts -->

 <script src="{{ URL::asset('js/6650c3fdcf.js') }}"></script>
