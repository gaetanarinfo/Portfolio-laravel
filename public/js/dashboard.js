// Call the dataTables jQuery plugin
$(document).ready(function () {

    var fichier = [],
        name_file = [],
        fichier_add = [],
        name_file_add = [],
        fichier_projet = [],
        name_file_projet = [],
        fichier_add_projet = [],
        name_file_add_projet = [],
        file_size = 250000;

    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
    });

    $(document).on('click', '.modal-btn', function (e) {

        $('#delete-user').attr('data-user', $(this).data('user'));
        $('#edit-user').attr('data-user', $(this).data('user'));

        if ($(this).attr('data-edit') == "1") {

            $('#editUserModal .modal-title').html('Editer l\'utilisateur ' + $(this).data('firstname') + ' ' + $(this).data('lastname'));

            // Form dynamic with modal
            $('#editUserModal #avatar').attr('src', 'img/profil/' + $(this).data('avatar'));
            $('#editUserModal #firstname').val($(this).data('firstname'));
            $('#editUserModal #lastname').val($(this).data('lastname'));
            $('#editUserModal #email').val($(this).data('email'));
            $('#editUserModal #active').val($(this).data('active')).change();

        }

    })

    $(document).on('click', '.modal-projet-btn', function (e) {

        $('#delete-projet').attr('data-projet', $(this).data('projet'));
        $('#edit-projet').attr('data-projet', $(this).data('projet'));

        if ($(this).attr('data-edit') == "1") {

            $('#editProjetModal .modal-title').html('Editer le projet ' + $(this).data('firstname') + ' ' + $(this).data('lastname'));

            // Form dynamic with modal
            $('#editProjetModal #image-projet').attr('src', 'img/projets/' + $(this).data('image'));
            $('#editProjetModal #title').val($(this).data('title'));
            $('#editProjetModal #categorie').val($(this).data('categorie'));
            $('#editProjetModal #url').val($(this).data('url'));
            $('#editProjetModal #prix').val($(this).data('prix'));
            $('#editProjetModal #active').val($(this).data('active')).change();

        }

    })

    // Delete user -> route
    $('#delete-user').on('click', function (e) {

        e.preventDefault();

        var user_id = $(this).data('user');

        $.ajax({
            url: '/show-users/delete',
            method: 'post',
            data: {
                user_id: user_id
            },
            success: function (data) {

                if (data.status == 0) {

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#deleteUserModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        $('#td_user_' + user_id).fadeOut(300);
                    }, 500);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Edit user avatar
    $('#avatar_input').on('change', function (e) {

        let that = e.currentTarget

        if (name_file.length < 2) {

            $.each($('#avatar_input').prop('files'), (index, item) => {
                fichier.push(item);
            })

            for (i = 0; i < fichier.length; i++) {

                if (name_file.length < 2) {

                    if (fichier[i].size < file_size) {

                        if (name_file.indexOf(fichier[i].name) == -1) {

                            $('.error_avatar').hide();

                            name_file.push(fichier[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 250 && image.height <= 250) {

                                        $('#avatar').attr('src', e.target.result);
                                        $('#delete-image').show();
                                        $('#avatar_input').attr('class', 'disabled');
                                        $('#avatar_input').prop("disabled", true);

                                        $('.error_avatar').html('');

                                    } else {

                                        name_file = [];
                                        fichier = [];

                                        $('.error_avatar').show();
                                        $('.error_avatar').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.error_avatar').show();
                        $('.error_avatar').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Edit user -> route
    $('#edit-user').on('click', function (e) {

        e.preventDefault();

        var user_id = $(this).data('user'),
            form = [],
            form_data = new FormData(),
            firstname = $('#editUserModal #firstname').val(),
            lastname = $('#editUserModal #lastname').val(),
            email = $('#editUserModal #email').val(),
            active = $('#editUserModal #active').val()

        if (fichier.length == 1) {
            for (let i = 0; i < fichier.length; i++) {
                if ($.inArray(fichier[i].name, name_file) !== -1) form_data.append('file_' + i, fichier[i]);
            }
        }

        form.forEach(e => {

            if (e.name != "user_id") form_data.append(e.name, e.value);
            if (e.name != "firstname") form_data.append(e.name, e.value);
            if (e.name != "lastname") form_data.append(e.name, e.value);
            if (e.name != "email") form_data.append(e.name, e.value);
            if (e.name != "active") form_data.append(e.name, e.value);

        });

        form_data.append('user_id', user_id);
        form_data.append('firstname', firstname);
        form_data.append('lastname', lastname);
        form_data.append('email', email);
        form_data.append('active', active);

        $.ajax({
            url: '/show-users/edit',
            method: 'post',
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data) {

                if (data.status == 0) {

                    $.each(data.error, function (prefix, val) {
                        $('.' + prefix + '_error').text(val[0]);
                    });

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#editUserModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        location.reload()
                    }, 2100);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Add user avatar
    $('#avatar_add_input').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_add.length < 2) {

            $.each($('#avatar_add_input').prop('files'), (index, item) => {
                fichier_add.push(item);
            })

            for (i = 0; i < fichier_add.length; i++) {

                if (name_file_add.length < 2) {

                    if (fichier_add[i].size < file_size) {

                        if (name_file_add.indexOf(fichier_add[i].name) == -1) {

                            $('.error_avatar').hide();

                            name_file_add.push(fichier_add[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 250 && image.height <= 250) {

                                        $('#avatar_add').attr('src', e.target.result);
                                        $('#delete-add-image').show();
                                        $('#avatar_add_input').attr('class', 'disabled');
                                        $('#avatar_add_input').prop("disabled", true);

                                        $('.error_add_avatar').html('');

                                    } else {

                                        name_file_add = [];
                                        fichier_add = [];

                                        $('.error_add_avatar').show();
                                        $('.error_add_avatar').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.error_add_avatar').show();
                        $('.error_add_avatar').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Add user -> route
    $('#add-user').on('click', function (e) {

        e.preventDefault();

        var form = [],
            form_data = new FormData(),
            firstname = $('#addUserModal #firstname').val(),
            lastname = $('#addUserModal #lastname').val(),
            email = $('#addUserModal #email').val(),
            active = $('#addUserModal #active').val(),
            password = $('#addUserModal #password').val()

        if (fichier_add.length == 1) {
            for (let i = 0; i < fichier_add.length; i++) {
                if ($.inArray(fichier_add[i].name, name_file_add) !== -1) form_data.append('file_' + i, fichier_add[i]);
            }
        }

        form.forEach(e => {

            if (e.name != "firstname") form_data.append(e.name, e.value);
            if (e.name != "lastname") form_data.append(e.name, e.value);
            if (e.name != "email") form_data.append(e.name, e.value);
            if (e.name != "active") form_data.append(e.name, e.value);
            if (e.name != "password") form_data.append(e.name, e.value);

        });

        form_data.append('firstname', firstname);
        form_data.append('lastname', lastname);
        form_data.append('email', email);
        form_data.append('active', active);
        form_data.append('password', password);

        $.ajax({
            url: '/show-users/add',
            method: 'post',
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: form_data,
            beforeSend: function (e) {
                $(document).find('.error-text').text('');
                $(document).find('.error-text').hide();
            },
            success: function (data) {

                if (data.status == 0) {

                    $.each(data.error, function (prefix, val) {
                        $('#addUserModal .' + prefix + '_error').show();
                        $('#addUserModal .' + prefix + '_error').text(val[0]);
                    });

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#addUserModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        location.reload()
                    }, 2100);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Suppression de l'image utilisateur

    $(document).on('click', '#del-1', function (e) {

        e.preventDefault();

        $('#avatar').attr('src', 'img/profil/default.svg');
        $('#delete-image').hide();
        $('#avatar_input').removeAttr('class');
        $('#avatar_input').prop("disabled", false);

        $('.error_avatar').html('');

        fichier = [];
        name_file = [];

    })

    $(document).on('click', '#del-add-1', function (e) {

        e.preventDefault();

        $('#avatar_add').attr('src', 'img/profil/default.svg');
        $('#delete-add-image').hide();
        $('#avatar_add_input').removeAttr('class');
        $('#avatar_add_input').prop("disabled", false);

        $('.error_add_avatar').html('');

        fichier_add = [];
        name_file_add = [];

    })

    // Delete projet -> route
    $('#delete-projet').on('click', function (e) {

        e.preventDefault();

        var projet_id = $(this).data('projet');

        $.ajax({
            url: '/show-projets/delete',
            method: 'post',
            data: {
                projet_id: projet_id
            },
            success: function (data) {

                if (data.status == 0) {

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#deleteProjetModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        $('#td_projet_' + projet_id).fadeOut(300);
                    }, 500);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Edit image projet
    $('#image_input').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_projet.length < 2) {

            $.each($('#image_input').prop('files'), (index, item) => {
                fichier_projet.push(item);
            })

            for (i = 0; i < fichier_projet.length; i++) {

                if (name_file_projet.length < 2) {

                    if (fichier_projet[i].size < file_size) {

                        if (name_file_projet.indexOf(fichier_projet[i].name) == -1) {

                            $('.error_image_projet').hide();

                            name_file_projet.push(fichier_projet[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 2500 && image.height <= 2500) {

                                        $('#image-projet').attr('src', e.target.result);
                                        $('#delete-image-projet').show();
                                        $('#image_input').attr('class', 'disabled');
                                        $('#image_input').prop("disabled", true);

                                        $('.error_image_projet').html('');

                                    } else {

                                        name_file_projet = [];
                                        fichier_projet = [];

                                        $('.error_image_projet').show();
                                        $('.error_image_projet').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.error_image_projet').show();
                        $('.error_image_projet').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Edit projet -> route
    $('#edit-projet').on('click', function (e) {

        e.preventDefault();

        var projet_id = $(this).data('projet'),
            form = [],
            form_data = new FormData(),
            title = $('#editProjetModal #title').val(),
            url = $('#editProjetModal #url').val(),
            categorie = $('#editProjetModal #categorie').val(),
            prix = $('#editProjetModal #prix').val(),
            active = $('#editProjetModal #active').val()

        if (fichier_projet.length == 1) {
            for (let i = 0; i < fichier_projet.length; i++) {
                if ($.inArray(fichier_projet[i].name, name_file_projet) !== -1) form_data.append('file_' + i, fichier_projet[i]);
            }
        }

        form.forEach(e => {

            if (e.name != "projet_id") form_data.append(e.name, e.value);
            if (e.name != "title") form_data.append(e.name, e.value);
            if (e.name != "url") form_data.append(e.name, e.value);
            if (e.name != "prix") form_data.append(e.name, e.value);
            if (e.name != "categorie") form_data.append(e.name, e.value);
            if (e.name != "active") form_data.append(e.name, e.value);

        });

        form_data.append('projet_id', projet_id);
        form_data.append('title', title);
        form_data.append('url', url);
        form_data.append('prix', prix);
        form_data.append('categorie', categorie);
        form_data.append('active', active);

        $.ajax({
            url: '/show-projets/edit',
            method: 'post',
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data) {

                if (data.status == 0) {

                    $.each(data.error, function (prefix, val) {
                        $('.' + prefix + '_error').text(val[0]);
                    });

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#editUserModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        location.reload()
                    }, 2100);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Suppression de l'image projet

    $(document).on('click', '#del-1-projet', function (e) {

        e.preventDefault();

        $('#image-projet').attr('src', 'img/projets/default.png');
        $('#delete-image-projet').hide();
        $('#image_input').removeAttr('class');
        $('#image_input').prop("disabled", false);

        $('.error_image_projet').html('');

        fichier_projet = [];
        name_file_projet = [];

    })

    $(document).on('click', '#del-1-projet-add', function (e) {

        e.preventDefault();

        $('#image-projet-add').attr('src', 'img/projets/default.png');
        $('#delete-image-projet-add').hide();
        $('#image_input_add').removeAttr('class');
        $('#image_input_add').prop("disabled", false);

        $('.error_image_projet_add').html('');

        fichier_add_projet = [];
        name_file_add_projet = [];

    })

    // Add projet -> route
    $('#add-projet').on('click', function (e) {

        e.preventDefault();

        var form = [],
            form_data = new FormData(),
            title = $('#addProjetModal #title').val(),
            url = $('#addProjetModal #url').val(),
            categorie = $('#addProjetModal #categorie').val(),
            prix = $('#addProjetModal #prix').val(),
            active = $('#addProjetModal #active').val()

        if (fichier_add_projet.length == 1) {
            for (let i = 0; i < fichier_add_projet.length; i++) {
                if ($.inArray(fichier_add_projet[i].name, name_file_add_projet) !== -1) form_data.append('file_' + i, fichier_add_projet[i]);
            }
        }

        form.forEach(e => {

            if (e.name != "title") form_data.append(e.name, e.value);
            if (e.name != "url") form_data.append(e.name, e.value);
            if (e.name != "prix") form_data.append(e.name, e.value);
            if (e.name != "categorie") form_data.append(e.name, e.value);
            if (e.name != "active") form_data.append(e.name, e.value);

        });

        form_data.append('title', title);
        form_data.append('url', url);
        form_data.append('prix', prix);
        form_data.append('categorie', categorie);
        form_data.append('active', active);

        $.ajax({
            url: '/show-projets/add',
            method: 'post',
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: form_data,
            beforeSend: function (e) {
                $(document).find('.error-text').text('');
                $(document).find('.error-text').hide();
            },
            success: function (data) {

                if (data.status == 0) {

                    $.each(data.error, function (prefix, val) {
                        $('#addProjetModal .' + prefix + '_error').show();
                        $('#addProjetModal .' + prefix + '_error').text(val[0]);
                    });

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                } else {

                    setTimeout(() => {

                        $('.toast-form-contact .svg').html(data.icone)
                        $('.toast-form-contact .title').html(data.title);
                        $('.toast-form-contact .toast-body').html(data.msg)
                        $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                        $('.toast-form-contact').toast({
                            delay: 10000
                        });

                        $('.toast-form-contact').toast('show');
                        $('#addProjetModal').modal('hide');

                    }, 400);

                    setTimeout(() => {
                        location.reload()
                    }, 2100);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });

    })

    // Add projet image
    $('#image_input_add').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_add_projet.length < 2) {

            $.each($('#image_input_add').prop('files'), (index, item) => {
                fichier_add_projet.push(item);
            })

            for (i = 0; i < fichier_add_projet.length; i++) {

                if (name_file_add_projet.length < 2) {

                    if (fichier_add_projet[i].size < file_size) {

                        if (name_file_add_projet.indexOf(fichier_add_projet[i].name) == -1) {

                            $('.error_avatar').hide();

                            name_file_add_projet.push(fichier_add_projet[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 2500 && image.height <= 2500) {

                                        $('#image-projet-add').attr('src', e.target.result);
                                        $('#delete-image-projet-add').show();
                                        $('#image_input_add').attr('class', 'disabled');
                                        $('#image_input_add').prop("disabled", true);

                                        $('.error_image_projet_add').html('');

                                    } else {

                                        name_file_add_projet = [];
                                        fichier_add_projet = [];

                                        $('.error_image_projet_add').show();
                                        $('.error_image_projet_add').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.error_image_projet_add').show();
                        $('.error_image_projet_add').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

});


