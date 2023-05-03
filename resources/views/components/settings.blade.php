 <!-- Back to top button -->
 <div
     @if (Cookie::get('theme') !== null) class="btn-back_to_top {{ Cookie::get('theme') }}" @else class="theme-red btn-back_to_top" @endif>
     <span class="ti-arrow-up font-weight-bold"></span>
 </div>

 <!-- Setting button -->
 <div class="config">

     <div class="template-config">

         <!-- Settings -->
         <div class="d-block">
             <button class="btn btn-sm" id="paramsR" title="Paramètres"><span class="ti-settings"></span></button>
         </div>

     </div>

     <div class="set-menu">

         <p>Choisissez la couleur</p>

         <div class="color-bar" data-toggle="selected">
             <span class="color-item bg-theme-red" data-class="theme-red"></span>
             <span class="color-item bg-theme-blue" data-class="theme-blue"></span>
             <span class="color-item bg-theme-green" data-class="theme-green"></span>
             <span class="color-item bg-theme-orange" data-class="theme-orange"></span>
             <span class="color-item bg-theme-purple" data-class="theme-purple"></span>
         </div>

         <select class="custom-select d-block my-2" id="change-page">
             <option value="">Choisir la page</option>
             <option value="/">Accueil</option>
             <option value="/blog/1">Mon blog</option>
             <option value="/offers">Créer un projet</option>
             @if (Auth::check())
                 <option value="/logout">Déconnexion</option>
             @else
                 <option value="/register">S'inscrire</option>
                 <option value="/login">Se connecter</option>
             @endif
         </select>

     </div>

 </div>
