 <!-- Caption header -->
 <div class="caption-header text-center wow zoomInDown">

     <h5 class="fw-normal">Bienvenue sur mon portfolio</h5>

     <h1 class="fw-light mb-4">Je suis <b class="fg-theme">{{ config('app.first_name') }}</b>

         {{ config('app.last_name') }}</h1>

     <div class="badge">{{ config('app.organization') }}</div>

     <div class="d-flex projets mt-5">

        <div class="img">
            <img src="{{ URL::asset('img/projet.png') }}" alt="Envie de créer un projet ?" class="img-fluid">
        </div>

         <div class="content">
             <h3 class="fw-light">Envie de créer un <a href="/offers" class="text-decoration-none"
                     title="Envie de créer un projet ?"><b class="fg-theme">projet</b></a> ?</h3>
             <a href="/offers" class="btn-lg badge mt-3" title="Envie de créer un projet ?">Cliquez-ici</a>
         </div>

     </div>

 </div>
 <!-- End Caption header -->

 <div class="floating-button"><span class="ti-mouse"></span></div>
