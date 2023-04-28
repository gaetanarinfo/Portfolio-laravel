$('[data-toggle="popover"]').popover()

// Download CV

$('#download-cv').on('click', function (e) {
    e.preventDefault();

    var href = $(this).attr('href')

    window.open(href, '_blank');

})

// ------------ //

// Save Color Theme

$(document).on('click', '.color-item', function (e) {

    e.preventDefault();

    var classes = $(this).data('class');

    localStorage.setItem('theme', classes);

    setCookie('theme', classes, 31);

})

if (localStorage.getItem('theme') != null) {
    $('.color-item[data-class="' + localStorage.getItem('theme') + '"]').addClass('selected');
} else {
    $('.color-item.bg-theme-red').addClass('selected');
}

function setCookie(name, value, days) {

    var expires = "";

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// ------------ //

$('.color-item').click(function () {
    var cls = $(this).data('class');
    $('.btn-back_to_top').removeAttr('class').addClass(cls + ' btn-back_to_top');
});

// Forms

$('#submit-contact').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
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
                $('#submit-contact')[0].reset();

                $('#submit-contact').fadeOut(600);

                setTimeout(() => {
                    $('.page-contact .loader-form').removeClass('hidden');
                }, 750);

                setTimeout(() => {
                    $('.page-contact .loader-form').addClass('hidden');
                }, 2500);

                setTimeout(() => {

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                    $('#submit-contact').fadeIn(600);

                }, 2500);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// ------------ //

// Methode Get Pages Routes

setTimeout(() => {
    var $grid = $('.gridder').isotope({
        itemSelector: '.grid-item',
        percentPosition: true
    });

    // filter items on button click
    $('.filterable-button').on('click', 'button', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
            filter: filterValue
        });
    });
}, 600);

$.ajax({
    url: '/newsAll',
    type: 'GET',
    data: {},
    success: function (data) { $('#blog-grid').html(data); },
    error: function (error) { console.log(error); }
})

$(document).on('click', '.d-flex .input-group:first-child .nice-select ul li.option', function (e) {

    e.preventDefault();

    var input_search = $('#search-blog').val(),
        select_categorie = $(this).data('value'),
        select_trie = $('#select-trie').val()

    $("#select-categorie option").filter(function () {
        return $(this).attr('selected') !== "";
    }).removeAttr("selected");

    if ($('#select-categorie option[value="' + select_categorie + '"]').html() == select_categorie) {
        $('#select-categorie option[value="' + select_categorie + '"]').attr("selected", "selected");
    }

    $.ajax({
        url: '/search-blog',
        type: 'POST',
        data: {
            search: input_search,
            categorie: select_categorie,
            trie: select_trie
        },
        success: function (data) {

            if (data != "") {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html('<div class="empty-search-img"><img src="../img/4076402.png" /></div><div class="empty-search text-danger"><h3>Désolé, aucun article ne correspond à votre recherche !</h3></div>');
                }, 1200);
            }

        },
        error: function (error) { console.log(error); }
    })

})

$(document).on('click', '.d-flex .input-group:last-child .nice-select ul li.option', function (e) {

    e.preventDefault();

    var input_search = $('#search-blog').val(),
        select_categorie = $('#select-categorie').val(),
        select_trie = $(this).data('value')

    $("#select-trie option").filter(function () {
        return $(this).attr('selected') !== "";
    }).removeAttr("selected");

    if ($('#select-trie option[value="' + select_trie + '"]').html() == select_trie) {
        $('#select-trie option[value="' + select_trie + '"]').attr("selected", "selected");
    }

    $.ajax({
        url: '/search-blog',
        type: 'POST',
        data: {
            search: input_search,
            categorie: select_categorie,
            trie: select_trie
        },
        success: function (data) {

            if (data != "") {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html('<div class="empty-search-img"><img src="../img/4076402.png" /></div><div class="empty-search text-danger"><h3>Désolé, aucun article ne correspond à votre recherche !</h3></div>');
                }, 1200);
            }

        },
        error: function (error) { console.log(error); }
    })

})

$(document).on('keyup', '#search-blog', function (e) {

    e.preventDefault();

    var input_search = $(this).val(),
        select_categorie = $('#select-categorie').val()
    select_trie = $('#select-trie').val()

    $.ajax({
        url: '/search-blog',
        type: 'POST',
        data: {
            search: input_search,
            categorie: select_categorie,
            trie: select_trie
        },
        success: function (data) {

            if (data != "") {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="post-grid"><div class="loader-form"><img src="../img/loader.svg" alt=""></div></div>');

                setTimeout(() => {
                    $('#blog-news-search').html('<div class="empty-search-img"><img src="../img/4076402.png" /></div><div class="empty-search text-danger"><h3>Désolé, aucun article ne correspond à votre recherche !</h3></div>');
                }, 1200);
            }

        },
        error: function (error) { console.log(error); }
    })

})

// ------------ //

// Form Newsletter

$('#newsletter-form').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
        success: function (data) {
            if (data.status == 0) {
                $.each(data.error, function (prefix, val) {
                    $('.' + prefix + '_error_newsletter').text(val[0]);
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
                $('#newsletter-form')[0].reset();

                $('#newsletter-form').fadeOut(600);

                setTimeout(() => {
                    $('.vg-footer .loader-form').removeClass('hidden');
                }, 750);

                setTimeout(() => {
                    $('.vg-footer .loader-form').addClass('hidden');
                }, 2500);

                setTimeout(() => {

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                    $('#newsletter-form').fadeIn(600);

                }, 2500);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// ------------ //

// Github

$.ajax({
    url: '/github-api',
    type: 'GET',
    data: {},
    success: function (data) {

        if (data.message != undefined && data.profil.message.indexOf("API rate limit exceeded for") != -1) {

            setTimeout(() => {
                $('#loader-github').addClass('hidden');
                $('#error-github').fadeIn(300);
                $('#error-github .error-message').html(data.profil.message);
            }, 2500);

        } else {

            setTimeout(() => {

                var arrays = data.repos

                data = data.profil

                var avatar_url = data.avatar_url,
                    name = data.name,
                    bio = data.bio,
                    public_repos = data.public_repos,
                    followers = data.followers,
                    following = data.following,
                    localisation = data.location,
                    created_at = data.created_at,
                    updated_at = data.updated_at

                // Assume the default locale is 'en' (just in case, I'll set it for the snippet)
                moment.locale('fr');

                // I have this string that's in the French locale

                // Parsing it fails
                var created = moment(created_at).format('DD/MM/YYYY à HH:mm');
                var updated = moment(updated_at).format('DD/MM/YYYY à HH:mm');

                $('.bloc-user-github #avatar_url').attr('src', avatar_url);
                $('.bloc-user-github .name').html(name);
                $('.bloc-user-github .bio').html(bio);
                $('.bloc-user-github .public_repos').html(public_repos)
                $('.bloc-user-github .followers').html(followers)
                $('.bloc-user-github .following').html(following)
                $('.bloc-user-github .localisation').html(localisation)
                $('.bloc-user-github .created_at').html(created)
                $('.bloc-user-github .updated_at').html(updated)

                var projets = false,
                    color_projet = "text-danger",
                    icone_projet = "fa-xmark",
                    projet_name = ""


                $.each(arrays, function (key, value) {

                    projet_name = value.name;

                    if (value.visibility != "public") {
                        projets = "Privé";
                        color_projet = "text-danger";
                        icone_projet = "fa-xmark";
                    } else {
                        projets = "Public";
                        color_projet = "text-success";
                        icone_projet = "fa-check";
                    }

                    $('.timeline-list').append('<li><div class="title"><i class="fa-solid fa-chevron-right mr-2"></i>' + value.name + '</div><div class="details"><small class="fg-theme"><i class="fa-solid fa-code mr-2 text-success"></i> Langage utilisé ' + value.language + '</small><ul class="timeline-none mt-2 pr-md-5"><li><i class="fa-solid ' + icone_projet + ' ' + color_projet + ' mr-2"></i><span class="' + color_projet + '">Projets ' + projets + '</span></li><li><i class="fa-solid fa-eye mr-2 text-warning"></i>' + value.watchers_count + ' vues</li><li><i class="fa-solid fa-code-branch mr-2 text-primary"></i>' + value.forks + ' forks</li><li><i class="fa-solid fa-code-branch mr-2 text-primary"></i>Branch default <b>' + value.default_branch + '</b></li><li><a class="text-danger" target="_blank" href="https://github.com/' + value.full_name + '#readme"><i class="fa-solid fa-book-open mr-2 text-danger"></i>Readme</a></li><li><i class="fa-solid fa-clock text-info mr-2"></i> Crée le ' + moment(value.created_at).format('DD/MM/YYYY à HH:mm') + '</li><li><i class="fa-solid fa-arrows-rotate text-info mr-2"></i> Modifier le ' + moment(value.updated_at).format('DD/MM/YYYY à HH:mm') + '</li><li><i class="fa-solid fa-arrows-rotate text-info mr-2"></i> Dernier push ' + moment(value.pushed_at).format('DD/MM/YYYY à HH:mm') + '</li></ul><div style="text-align: center;"><a target="_blank" href="https://github.com/' + value.full_name + '" class="btn btn-theme mt-3 mr-3">Voir le dépôt</a><a role="button" data-toggle="modal" data-target="#codeModal" class="btn btn-modal-code btn-theme mt-3" data-https="https://github.com/' + value.full_name + '" data-name="' + value.name + '">Code</a></div></div></li>');
                })

                $('#loader-github').addClass('hidden');
                $('.page-github .page-blog').removeClass('hidden');
                $('.bloc-user-github').fadeIn(300);
                $('.page-github .widget-grid').fadeIn(300);

                $(document).on('click', '#codeModal .footer-content', function (e) {

                    e.preventDefault();

                    location.href = 'https://github.com/gaetanarinfo/' + projet_name + '/archive/refs/heads/main.zip';

                })

                $(document).on('click', '.btn-modal-code', function (e) {

                    e.preventDefault();

                    var https = $(this).data('https'),
                        name = $(this).data('name'),
                        title = $(this).data('name')

                    $('#codeModal .modal-title .title').html(title);
                    $('#codeModal #httpsSpan').html(https);
                    $('#codeModal #cliSpan').html('gh repo clone gaetanarinfo/' + name);
                    $('#codeModal #inputHttps').val(https);
                    $('#codeModal #inputCli').val('gh repo clone gaetanarinfo/' + name);

                    $('.input-group-text-https').find('i').removeClass('fa-solid').removeClass('fa-check').addClass('fa-regular').addClass('fa-clipboard');
                    $('.input-group-text-cli').find('i').removeClass('fa-solid').removeClass('fa-check').addClass('fa-regular').addClass('fa-clipboard');

                })

            }, 2500);

        }

    },
    error: function (error) { console.log(error); }
})

$(document).on('click', '.page-github .nice-select ul li.option', function (e) {

    e.preventDefault();

    $('.timeline-list').html('');

    $('#loader-github').removeClass('hidden');
    $('.page-github .page-blog').addClass('hidden');
    $('.bloc-user-github').fadeOut(300);

    var input_search = $('#search-blog').val(),
        select_trie = $(this).data('value')

    $("#select-trie option").filter(function () {
        return $(this).attr('selected') !== "";
    }).removeAttr("selected");

    if ($('#select-trie option[value="' + select_trie + '"]').html() == select_trie) {
        $('#select-trie option[value="' + select_trie + '"]').attr("selected", "selected");
    }

    $.ajax({
        url: '/github-api',
        method: 'POST',
        data: {
            select: select_trie
        },
        success: function (data) {

            if (data.message != undefined && data.profil.message.indexOf("API rate limit exceeded for") != -1) {

                setTimeout(() => {
                    $('#loader-github').addClass('hidden');
                    $('#error-github').fadeIn(300);
                    $('#error-github .error-message').html(data.profil.message);
                }, 2500);

            } else {

                setTimeout(() => {

                    var arrays = data.repos

                    data = data.profil

                    var avatar_url = data.avatar_url,
                        name = data.name,
                        bio = data.bio,
                        public_repos = data.public_repos,
                        followers = data.followers,
                        following = data.following,
                        localisation = data.location,
                        created_at = data.created_at,
                        updated_at = data.updated_at

                    // Assume the default locale is 'en' (just in case, I'll set it for the snippet)
                    moment.locale('fr');

                    // I have this string that's in the French locale

                    // Parsing it fails
                    var created = moment(created_at).format('DD/MM/YYYY à HH:mm');
                    var updated = moment(updated_at).format('DD/MM/YYYY à HH:mm');

                    $('.bloc-user-github #avatar_url').attr('src', avatar_url);
                    $('.bloc-user-github .name').html(name);
                    $('.bloc-user-github .bio').html(bio);
                    $('.bloc-user-github .public_repos').html(public_repos)
                    $('.bloc-user-github .followers').html(followers)
                    $('.bloc-user-github .following').html(following)
                    $('.bloc-user-github .localisation').html(localisation)
                    $('.bloc-user-github .created_at').html(created)
                    $('.bloc-user-github .updated_at').html(updated)


                    var projets = false,
                        color_projet = "text-danger",
                        icone_projet = "fa-xmark";

                    $.each(arrays, function (key, value) {

                        if (value.visibility != "public") {
                            projets = "Privé";
                            color_projet = "text-danger";
                            icone_projet = "fa-xmark";
                        } else {
                            projets = "Public";
                            color_projet = "text-success";
                            icone_projet = "fa-check";
                        }

                        $('.timeline-list').append('<li><div class="title"><i class="fa-solid fa-chevron-right mr-2"></i>' + value.name + '</div><div class="details"><small class="fg-theme"><i class="fa-solid fa-code mr-2 text-success"></i> Langage utilisé ' + value.language + '</small><ul class="timeline-none mt-2 pr-md-5"><li><i class="fa-solid ' + icone_projet + ' ' + color_projet + ' mr-2"></i><span class="' + color_projet + '">Projets ' + projets + '</span></li><li><i class="fa-solid fa-eye mr-2 text-warning"></i>' + value.watchers_count + ' vues</li><li><i class="fa-solid fa-code-branch mr-2 text-primary"></i>' + value.forks + ' forks</li><li><i class="fa-solid fa-code-branch mr-2 text-primary"></i>Branch default <b>' + value.default_branch + '</b></li><li><a class="text-danger" target="_blank" href="https://github.com/' + value.full_name + '#readme"><i class="fa-solid fa-book-open mr-2 text-danger"></i>Readme</a></li><li><i class="fa-solid fa-clock text-info mr-2"></i> Crée le ' + moment(value.created_at).format('DD/MM/YYYY à HH:mm') + '</li><li><i class="fa-solid fa-arrows-rotate text-info mr-2"></i> Modifier le ' + moment(value.updated_at).format('DD/MM/YYYY à HH:mm') + '</li><li><i class="fa-solid fa-arrows-rotate text-info mr-2"></i> Dernier push ' + moment(value.pushed_at).format('DD/MM/YYYY à HH:mm') + '</li></ul><div style="text-align: center;"><a target="_blank" href="https://github.com/' + value.full_name + '" class="btn btn-theme mt-3 mr-3">Voir le dépôt</a><a role="button" data-toggle="modal" data-target="#codeModal" class="btn btn-modal-code btn-theme mt-3" data-https="https://github.com/' + value.full_name + '" data-name="' + value.name + '">Code</a></div></div></li>');
                    })

                    $('#loader-github').addClass('hidden');
                    $('.page-github .page-blog').removeClass('hidden');
                    $('.bloc-user-github').fadeIn(300);
                    $('.page-github .widget-grid').fadeIn(300);

                    $(document).on('click', '.btn-modal-code', function (e) {

                        e.preventDefault();

                        var https = $(this).data('https'),
                            name = $(this).data('name'),
                            title = $(this).data('name')

                        $('#codeModal .modal-title .title').html(title);
                        $('#codeModal #httpsSpan').html(https);
                        $('#codeModal #cliSpan').html('gh repo clone gaetanarinfo/' + name);
                        $('#codeModal #inputHttps').val(https);
                        $('#codeModal #inputCli').val('gh repo clone gaetanarinfo/' + name);

                        $('.input-group-text-https').find('i').removeClass('fa-solid').removeClass('fa-check').addClass('fa-regular').addClass('fa-clipboard');
                        $('.input-group-text-cli').find('i').removeClass('fa-solid').removeClass('fa-check').addClass('fa-regular').addClass('fa-clipboard');

                    })

                }, 1500);

            }

        },
        error: function (error) { console.log(error); }
    })


})

// ------------ //

// Auth User

// Rester connecté
$('.page-login  #connect_login').change(function () {
    $('.page-login  #connect_login').val($(this).is(':checked'));
})

if (localStorage.getItem('email') == null && localStorage.getItem('password') == null) {
    $('.page-login  #connect_login').click(function () {
        localStorage.setItem('email', $('#email').val())
        localStorage.setItem('password', $('#password').val())
    });
    $('.page-login  #connect_login').prop('checked', false);
    $('.page-login  #connect_login').val('false');
} else {
    $('.page-login  #connect_login').click(function () {
        localStorage.removeItem('email')
        localStorage.removeItem('password')
    });
    $('.page-login  #connect_login').prop('checked', true);
    $('.page-login  #connect_login').val('true');
}

if (localStorage.getItem('email') !== null && localStorage.getItem('password') !== null) {
    $('.page-login #email').val(localStorage.getItem('email'))
    $('.page-login #password').val(localStorage.getItem('password'))
    $('.page-login #connect_login').prop('checked', true);

    $('#email').change(function () {
        localStorage.setItem('email', $('#email').val())
    })

    $('#password').change(function () {
        localStorage.setItem('password', $('#password').val())
    })
}

$('#form-login').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
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
                $('#form-login')[0].reset();

                $('#form-login').fadeOut(100);
                $('.forgot-password').fadeOut(100)

                setTimeout(() => {
                    $('.page-login #loader-login').removeClass('hidden');
                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                }, 100);

                setTimeout(() => {
                    location.href = '/dashboard';
                }, 2500);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });

})

// ------------ //

// Auth Register

$('#form-register').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
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
                $('#form-register')[0].reset();

                $('#form-register').fadeOut(100);

                $('.page-register #loader-register').removeClass('hidden');

                $('.toast-form-contact .svg').html(data.icone)
                $('.toast-form-contact .title').html(data.title);
                $('.toast-form-contact .toast-body').html(data.msg)
                $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                $('.toast-form-contact').toast({
                    delay: 10000
                });

                $('.toast-form-contact').toast('show');

                setTimeout(() => {
                    location.href = '/dashboard';
                }, 2300);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });

})

$('.page-register #checkProtection').click(function () {

    var checked = $(this).is(':checked');

    if (checked) {
        $('.page-register  #checkProtection').prop('checked', true);
        $('.page-register  #checkProtection').val('true');
        $('.page-register .btn').removeClass('disabled');
    } else {
        $('.page-register  #checkProtection').prop('checked', false);
        $('.page-register  #checkProtection').val('false');
        $('.page-register .btn').addClass('disabled');
    }

});

// ------------ //

// Forgot password

$('#form-forgot').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
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
                $('#form-forgot')[0].reset();

                $('#form-forgot').fadeOut(600);

                setTimeout(() => {
                    $('.page-forgot #loader-forgot').removeClass('hidden');

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                }, 600);

                setTimeout(() => {
                    location.href = '/login';
                }, 2300);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });

})

$(document).on('click', '.forgot-password', function (e) {

    e.preventDefault();

    $('#form-login').fadeOut(300);

    setTimeout(() => {
        $('#form-forgot-new').fadeIn();
    }, 300);

})

$('#form-forgot-new').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function (e) {
            $(document).find('.error-text').text('');
        },
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
                $('#form-forgot-new')[0].reset();

                $('#form-forgot-new').fadeOut(300);

                setTimeout(() => {
                    $('.page-login #loader-login').removeClass('hidden');

                    $('.toast-form-contact .svg').html(data.icone)
                    $('.toast-form-contact .title').html(data.title);
                    $('.toast-form-contact .toast-body').html(data.msg)
                    $('.toast-form-contact').removeClass('toast-success').removeClass('toast-error').addClass(data.toast);

                    $('.toast-form-contact').toast({
                        delay: 10000
                    });

                    $('.toast-form-contact').toast('show');

                }, 400);

                setTimeout(() => {
                    location.href = '/';
                }, 2300);

            }
        },
        error: function (e) {
            console.log(e);
        }
    });

})

// Google api

$.ajax({
    url: '/google-api',
    type: 'POST',
    data: {
        youtubeur: 'bennco',
        section: 'youtube'
    },
    success: function (data) {

        var liste = data.latest_from_ben_n_co

        setTimeout(() => {

            $.each(liste, function (prefix, value) {

                var views = value.views,
                    viewsK = '',
                    published_date = value.published_date

                    published_date = published_date.replace(['days ago'], ['jours'])
                    published_date = published_date.replace(['weeks ago'], ['semaines'])
                    published_date = published_date.replace(['month ago'], ['mois'])

                if (parseInt(views) >= 1000) {
                    viewsK = 'k';
                    views = views.toString().substr(3)
                }else{
                    viewsK = '';
                    views = views
                }

                $('.youtube-api').append('<div class="d-flex bloc-flex"><div class="col" data-href="' + value.link + '"><img src="' + value.thumbnail.static + '" alt="' + value.title + '"class="fluid thumbnail-youtube"><span class="length">' + value.length + '</span></div><div class="col"><div><h5>' + value.title + '</h5></div><div class="video-info"><span class="views">' + views + viewsK + ' vues - </span><span class="published_date">' + published_date + '</span></div><div class="youtubeur-info"><a href="' + value.channel.link + '" target="_blank"><span class="thumbnail"><img src="' + value.channel.thumbnail + '" alt="' + value.channel.name + '"></span><span class="name">' + value.channel.name + '</span></a></div><p class="description">' + value.description + '</p></div>')

                $(document).on('click', '.bloc-flex .col:first-child', function (e) {

                    e.preventDefault();

                    var url = $(this).data('href');

                    window.open(url);

                 })

                $('#loader-youtube').addClass('hidden');
                $('.page-youtube .youtube-api').fadeIn(300);
            })

        }, 1500);

    },
    error: function (error) { console.log(error); }
})

$(document).on('click', '.input-group-text-https', function (e) {

    e.preventDefault();

    $(this).find('i').removeClass('fa-regular').removeClass('fa-clipboard').addClass('fa-solid').addClass('fa-check');

})

$(document).on('click', '.input-group-text-cli', function (e) {

    e.preventDefault();

    $(this).find('i').removeClass('fa-regular').removeClass('fa-clipboard').addClass('fa-solid').addClass('fa-check');

})


// ------------ //

function copyToClipboard(element_id) {

    var aux = document.createElement("div");
    aux.setAttribute("contentEditable", true);
    aux.innerHTML = document.getElementById(element_id).innerHTML;
    aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)");
    document.body.appendChild(aux);
    aux.focus();
    document.execCommand("copy");
    document.body.removeChild(aux);

}
