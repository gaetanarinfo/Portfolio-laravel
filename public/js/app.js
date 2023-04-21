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
                $('.toast-form-contact').addClass(data.toast);

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
                    $('.toast-form-contact').addClass(data.toast);

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

$.ajax({
    url: '/projetsAll',
    type: 'GET',
    data: {},
    success: function (data) { $('.gridder').html(data); },
    error: function (error) { console.log(error); }
})

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

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

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

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

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

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

                setTimeout(() => {
                    $('#blog-news-search').html(data);
                }, 1200);

            } else {

                $('#blog-news-search').html('<div class="loader-form"><img src="../img/loader.svg" alt=""></div>');

                setTimeout(() => {
                    $('#blog-news-search').html('<div class="empty-search-img"><img src="../img/4076402.png" /></div><div class="empty-search text-danger"><h3>Désolé, aucun article ne correspond à votre recherche !</h3></div>');
                }, 1200);
            }

        },
        error: function (error) { console.log(error); }
    })

})

// ------------ //
