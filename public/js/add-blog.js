$(document).ready(function () {

    var fichier_article = [],
    name_file_article = [],
    fichier_article_bandeau = [],
    name_file_article_bandeau = [],
    fichier_article_author = [],
    name_file_article_author = [],
    file_size = 10000000;

    // Add article image
    $('#image_article').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_article.length < 2) {

            $.each($('#image_article').prop('files'), (index, item) => {
                fichier_article.push(item);
            })

            for (i = 0; i < fichier_article.length; i++) {

                if (name_file_article.length < 2) {

                    if (fichier_article[i].size < file_size) {

                        if (name_file_article.indexOf(fichier_article[i].name) == -1) {

                            $('.image_article_error').hide();

                            name_file_article.push(fichier_article[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 2500 && image.height <= 2500) {

                                        $('.image-article').attr('src', e.target.result);
                                        $('.delete-image-article').show();
                                        $('#image_article').attr('class', 'disabled');
                                        $('#image_article').prop("disabled", true);
                                        $('.image-article-bloc').show();

                                        $('.image_article_error').html('');

                                    } else {

                                        name_file_article = [];
                                        fichier_article = [];

                                        $('.image_article_error').show();
                                        $('.image_article_error').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.image_article_error').show();
                        $('.image_article_error').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Delete image article
    $(document).on('click', '#del-1-article', function (e) {

        e.preventDefault();

        $('.image-article').attr('src', '/img/news/picture-empty.jpg');
        $('.delete-image-article').hide();
        $('#image_article').removeAttr('class');
        $('#image_article').prop("disabled", false);
        $('#image_article').val('');

        $('.image_article_error').html('');

        name_file_article = [];
        fichier_article = [];

    })

    $(document).on('click', '#del-1-bandeau', function (e) {

        e.preventDefault();

        $('.bandeau-article').attr('src', '/img/news/picture-empty.jpg');
        $('.delete-bandeau-article').hide();
        $('#bandeau_article').removeAttr('class');
        $('#bandeau_article').prop("disabled", false);
        $('#bandeau_article').val('');

        $('.bandeau_article_error').html('');

        name_file_article_bandeau = [];
        fichier_article_bandeau = [];

    })

    $(document).on('click', '#del-1-author', function (e) {

        e.preventDefault();

        $('.author-article').attr('src', '/img/news/avatar/default.svg');
        $('.delete-author-article').hide();
        $('#author_article').removeAttr('class');
        $('#author_article').prop("disabled", false);
        $('#author_article').val('');

        $('.author_article_error').html('');

        name_file_article_author = [];
        fichier_article_author = [];

    })

    // Add article image
    $('#bandeau_article').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_article_bandeau.length < 2) {

            $.each($('#bandeau_article').prop('files'), (index, item) => {
                fichier_article_bandeau.push(item);
            })

            for (i = 0; i < fichier_article_bandeau.length; i++) {

                if (name_file_article_bandeau.length < 2) {

                    if (fichier_article_bandeau[i].size < file_size) {

                        if (name_file_article_bandeau.indexOf(fichier_article_bandeau[i].name) == -1) {

                            $('.bandeau_article').hide();

                            name_file_article_bandeau.push(fichier_article_bandeau[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 2500 && image.height <= 2500) {

                                        $('.bandeau-article').attr('src', e.target.result);
                                        $('.delete-bandeau-article').show();
                                        $('#bandeau_article').attr('class', 'disabled');
                                        $('#bandeau_article').prop("disabled", true);
                                        $('.bandeau-article-bloc').show();

                                        $('.bandeau_article_error').html('');

                                    } else {

                                        name_file_article_bandeau = [];
                                        fichier_article_bandeau = [];

                                        $('.bandeau_article_error').show();
                                        $('.bandeau_article_error').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.bandeau_article_error').show();
                        $('.bandeau_article_error').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Add article avatar author
    $('#author_article').on('change', function (e) {

        let that = e.currentTarget

        if (name_file_article_author.length < 2) {

            $.each($('#author_article').prop('files'), (index, item) => {
                fichier_article_author.push(item);
            })

            for (i = 0; i < fichier_article_author.length; i++) {

                if (name_file_article_author.length < 2) {

                    if (fichier_article_author[i].size < file_size) {

                        if (name_file_article_author.indexOf(fichier_article_author[i].name) == -1) {

                            $('.author_article_error').hide();

                            name_file_article_author.push(fichier_article_author[i].name);

                            let reader = new FileReader();

                            reader.onload = (e) => {

                                const image = new Image();

                                image.src = e.target.result;
                                image.onload = () => {

                                    if (image.width <= 800 && image.height <= 800) {

                                        $('.author-article').attr('src', e.target.result);
                                        $('.delete-author-article').show();
                                        $('#author_article').attr('class', 'disabled');
                                        $('#author_article').prop("disabled", true);
                                        $('.author-article-bloc').show();

                                        $('.author_article_error').html('');

                                    } else {

                                        name_file_article_author = [];
                                        fichier_article_author = [];

                                        $('.author_article_error').show();
                                        $('.author_article_error').html('<p>Le fichier ne correspond pas aux dimension. 250 pixels par 250 pixels !</p>');

                                    }

                                };

                            }

                            reader.readAsDataURL(that.files[0]);

                        }

                    } else {

                        $('.author_article_error').show();
                        $('.author_article_error').html('<p>Le fichier est trop volumineux.</p>');

                    }

                }
            };

        }

    });

    // Add article -> route
    $('#form-add-article').on('submit', function (e) {

        e.preventDefault();

        var form = [],
            form_data = new FormData(),
            title = $('#form-add-article #title').val(),
            emailAuthor = $('#form-add-article #emailAuthor').val(),
            small_content = $('#form-add-article #small_content').val(),
            large_content = $('#form-add-article #large_content').val(),
            categorie = $('#form-add-article #categorie').val(),
            author = $('#form-add-article #author').val(),
            author_content = $('#form-add-article #author_content').val(),
            author_link = $('#form-add-article #author_link').val(),
            sourceArticle = $('#form-add-article #sourceArticle').val(),
            url_fb = $('#form-add-article #url_fb').val(),
            url_twitter = $('#form-add-article #url_twitter').val(),
            url_linkedin = $('#form-add-article #url_linkedin').val()

        if (fichier_article.length == 1) {
            for (let i = 0; i < fichier_article.length; i++) {
                if ($.inArray(fichier_article[i].name, name_file_article) !== -1) form_data.append('file_' + i, fichier_article[i]);
            }
        }

        if (fichier_article_bandeau.length == 1) {
            for (let i = 0; i < fichier_article_bandeau.length; i++) {
                if ($.inArray(fichier_article_bandeau[i].name, name_file_article_bandeau) !== -1) form_data.append('files_' + i, fichier_article_bandeau[i]);
            }
        }

        if (fichier_article_author.length == 1) {
            for (let i = 0; i < fichier_article_author.length; i++) {
                if ($.inArray(fichier_article_author[i].name, name_file_article_author) !== -1) form_data.append('filese_' + i, fichier_article_author[i]);
            }
        }

        form.forEach(e => {
            if (e.name != "title") form_data.append(e.name, e.value);
            if (e.name != "emailAuthor") form_data.append(e.name, e.value);
            if (e.name != "small_content") form_data.append(e.name, e.value);
            if (e.name != "large_content") form_data.append(e.name, e.value);
            if (e.name != "categorie") form_data.append(e.name, e.value);
            if (e.name != "author") form_data.append(e.name, e.value);
            if (e.name != "author_content") form_data.append(e.name, e.value);
            if (e.name != "author_link") form_data.append(e.name, e.value);
            if (e.name != "sourceArticle") form_data.append(e.name, e.value);
            if (e.name != "url_fb") form_data.append(e.name, e.value);
            if (e.name != "url_twitter") form_data.append(e.name, e.value);
            if (e.name != "url_linkedin") form_data.append(e.name, e.value);
        });

        form_data.append('title', title);
        form_data.append('emailAuthor', emailAuthor);
        form_data.append('small_content', small_content);
        form_data.append('large_content', large_content);
        form_data.append('categorie', categorie);
        form_data.append('author', author);
        form_data.append('author_content', author_content);
        form_data.append('author_link', author_link);
        form_data.append('sourceArticle', sourceArticle);
        form_data.append('url_fb', url_fb);
        form_data.append('url_twitter', url_twitter);
        form_data.append('url_linkedin', url_linkedin);

        console.log(sourceArticle);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
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
                        $('.' + prefix + '_error').show();
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

                    }, 600);

                    setTimeout(() => {
                        location.reload();
                    }, 2500);

                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

});
