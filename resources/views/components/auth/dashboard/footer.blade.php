<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>

            <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session
                en cours.</div>

            <div class="modal-footer">
                <button class="btn btn-warning font-weight-bold" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-success font-weight-bold" href="/logout">Déconnexion</a>
            </div>

        </div>

    </div>

</div>

@if ($user->admin >= 1)
    <!-- Edit user Modal-->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title"></h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="px-5">

                        <div class="mt-4 mr-4 ml-4 mb-0 text-center">

                            <label>
                                <input type="file" id="avatar_input" accept="image/*" name="avatar_input"
                                    style="display: none">
                                <img id="avatar" src="{{ URL::asset('img/profil/default.svg') }}" class="img-fluid"
                                    style="max-width: 150px;width: 150px;">
                                <div class="mt-2" id="delete-image">
                                    <span class="delete-image" id="del-1">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                </div>
                                <div class="avatar-cam"><i class="fa-solid fa-camera-rotate"></i></div>
                            </label>

                            <span class="error_avatar"></span>

                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-form-label">Prénom :</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                            <span class="error-text text-danger firstname_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="col-form-label">Nom :</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                            <span class="error-text text-danger lastname_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Adresse email :</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <span class="error-text text-danger email_error"></span>
                        </div>

                        <div class="form-group">

                            <label for="active" class="col-form-label">Statut du compte :</label>

                            <select class="form-control" name="active" id="active">
                                <option value="0">Inactif</option>
                                <option value="1">Actif</option>
                            </select>

                            <span class="error-text text-danger active_error"></span>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="edit-user" data-user="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>

    <!-- Delete user Modal-->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Voulez vous vraiment supprimer l'utilisateur ?</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">Attention cette action est irréversible !</div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="delete-user" data-user="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>

    <!-- Add user Modal-->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Créer un utilisateur</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="px-5">

                        <div class="mt-4 mr-4 ml-4 mb-0 text-center">

                            <label>
                                <input type="file" id="avatar_add_input" accept="image/*" name="avatar_add_input"
                                    style="display: none">
                                <img id="avatar_add" src="{{ URL::asset('img/profil/default.svg') }}"
                                    class="img-fluid" style="max-width: 150px;width: 150px;">
                                <div class="mt-2" id="delete-add-image">
                                    <span class="delete-add-image" id="del-add-1">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                </div>
                                <div class="avatar-cam"><i class="fa-solid fa-camera-rotate"></i></div>
                            </label>

                            <span class="error_add_avatar"></span>

                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-form-label">Prénom :</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                            <span class="error-text text-danger firstname_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="col-form-label">Nom :</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                            <span class="error-text text-danger lastname_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Adresse email :</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <span class="error-text text-danger email_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">Mot de passe :</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="error-text text-danger password_error"></span>
                        </div>

                        <div class="form-group">

                            <label for="active" class="col-form-label">Statut du compte :</label>

                            <select class="form-control" name="active" id="active">
                                <option value="0">Inactif</option>
                                <option value="1">Actif</option>
                            </select>

                            <span class="error-text text-danger active_error"></span>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="add-user" data-user="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>

    <!-- Delete projets Modal-->
    <div class="modal fade" id="deleteProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Voulez vous vraiment supprimer le projet ?</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">Attention cette action est irréversible !</div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="delete-projet" data-projet="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>

    <!-- Edit projet Modal-->
    <div class="modal fade" id="editProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title"></h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="px-5">

                        <div class="mt-4 mr-4 ml-4 mb-0 text-center">

                            <label>
                                <input type="file" id="image_input" accept="image/*" name="image_input"
                                    style="display: none">
                                <img id="image-projet" src="{{ URL::asset('img/projets/default.png') }}"
                                    class="img-fluid" style="max-width: 230px;">
                                <div class="mt-2" id="delete-image-projet">
                                    <span class="delete-image-projet" id="del-1-projet">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                </div>
                                <div class="avatar-cam"><i class="fa-solid fa-camera-rotate"></i></div>
                            </label>

                            <span class="error_image_projet"></span>

                        </div>

                        <div class="form-group">
                            <label for="title" class="col-form-label">Title :</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="error-text text-danger title_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="categorie" class="col-form-label">Catégorie :</label>
                            <input type="text" class="form-control" id="categorie" name="categorie">
                            <span class="error-text text-danger categorie_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-form-label">Lien <b>(https://google.com)</b> :</label>
                            <input type="text" class="form-control" id="url" name="url">
                            <span class="error-text text-danger url_error"></span>
                        </div>

                        <div class="row">

                            <div class="col">

                                <div class="form-group">

                                    <label for="active" class="col-form-label">Statut du projet :</label>

                                    <select class="form-control" name="active" id="active">
                                        <option value="0">Inactif</option>
                                        <option value="1">Actif</option>
                                    </select>

                                    <span class="error-text text-danger active_error"></span>

                                </div>

                            </div>

                            <div class="col">

                                <div class="form-group">
                                    <label for="prix" class="col-form-label">Prix (€) :</label>
                                    <input type="text" class="form-control" id="prix" name="prix">
                                    <span class="error-text text-danger prix_error"></span>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="edit-projet" data-projet="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>

    <!-- Add projet Modal-->
    <div class="modal fade" id="addProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Ajouter un nouveau projet</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="px-5">

                        <div class="mt-4 mr-4 ml-4 mb-0 text-center">

                            <label>
                                <input type="file" id="image_input_add" accept="image/*" name="image_input_add"
                                    style="display: none">
                                <img id="image-projet-add" src="{{ URL::asset('img/projets/default.png') }}"
                                    class="img-fluid" style="max-width: 230px;">
                                <div class="mt-2" id="delete-image-projet-add">
                                    <span class="delete-image-projet-add" id="del-1-projet-add">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                </div>
                                <div class="avatar-cam"><i class="fa-solid fa-camera-rotate"></i></div>
                            </label>

                            <span class="error_image_projet_add"></span>

                        </div>

                        <div class="form-group">
                            <label for="title" class="col-form-label">Title :</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="error-text text-danger title_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="categorie" class="col-form-label">Catégorie :</label>
                            <input type="text" class="form-control" id="categorie" name="categorie">
                            <span class="error-text text-danger categorie_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-form-label">Lien <b>(https://google.com)</b> :</label>
                            <input type="text" class="form-control" id="url" name="url">
                            <span class="error-text text-danger url_error"></span>
                        </div>

                        <div class="row">

                            <div class="col">

                                <div class="form-group">

                                    <label for="active" class="col-form-label">Statut du projet :</label>

                                    <select class="form-control" name="active" id="active">
                                        <option value="0">Inactif</option>
                                        <option value="1">Actif</option>
                                    </select>

                                    <span class="error-text text-danger active_error"></span>

                                </div>

                            </div>

                            <div class="col">

                                <div class="form-group">
                                    <label for="prix" class="col-form-label">Prix (€) :</label>
                                    <input type="text" class="form-control" id="prix" name="prix">
                                    <span class="error-text text-danger prix_error"></span>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                    <a id="add-projet" data-projet="" class="btn btn-success font-weight-bold"
                        href="#">Valider</a>
                </div>

            </div>

        </div>

    </div>
@endif

<!-- Toast -->
<div aria-live="polite" aria-atomic="true" style="position: relative;">

    <div class="toast toast-form-contact" style="position: fixed;bottom: 1rem;right: 1rem;z-index: 99999;">

        <div class="toast-header">

            <div class="svg"></div>

            <strong class="title mr-auto"></strong>

            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

        <div class="toast-body">
        </div>

    </div>

</div>
