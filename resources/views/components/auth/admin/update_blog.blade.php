<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="h2 mb-2 text-gray-900 font-weight-bold mb-5">Modifier l'article {{ $article->title }}</h1>

    <div class="grid-article">

        <div class="card shadow mb-4" style="width: 600px;max-width: 600px;">

            <div class="card-header py-3">

                <form id="form-edit-article" action="{{ route('edit-article-post', $article->url) }}" method="POST">

                    <div class="form-group">

                        <label for="image_article">Image de l'article</label>

                        <div class="image-article-bloc">

                            <img src="{{ URL::asset('/img/news/' . $article->image) }}" class="image-article img-fluid">

                            <div class="delete-image-article">
                                <span class="delete-image-article" id="del-1-article">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                            </div>

                        </div>

                        <input type="file" name="image_article" class="form-control-file" id="image_article">

                        <span class="error-text text-danger image_article_error"></span>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label for="image_bandeau">Bandeau de l'article</label>

                        <div class="bandeau-article-bloc">

                            <img src="{{ URL::asset('/img/news/' . $article->image_bandeau) }}"
                                class="bandeau-article img-fluid">

                            <div class="delete-bandeau-article">
                                <span class="delete-bandeau-article" id="del-1-bandeau">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                            </div>

                        </div>

                        <input type="file" name="bandeau_article" class="form-control-file" id="bandeau_article">

                        <span class="error-text text-danger bandeau_article_error"></span>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" name="title"
                            aria-describedby="title" value="{{ $article->title }}">

                        <span class="error-text text-danger title_error"></span>

                    </div>

                    <div class="form-group">

                        <label for="title">Petite description</label>
                        <textarea name="small_content" class="form-control" id="small_content" name="small_content" cols="30"
                            rows="10">{{ $article->small_content }}</textarea>
                        <span class="error-text text-danger small_content_error"></span>

                    </div>

                    <div class="form-group">

                        <label for="title">Large description</label>
                        <textarea name="large_content" class="form-control" id="large_content" name="large_content" cols="30"
                            rows="10">{{ $article->large_content }}</textarea>
                        <span class="error-text text-danger large_content_error"></span>

                    </div>

                    <hr>

                    <div class="form-group">

                        <div class="row">

                            <div class="col">

                                <label for="image_author">Avatar de l'auteur</label>

                                <div class="author-article-bloc">

                                    <img src="{{ URL::asset('/img/news/avatar/' . $article->avatar) }}"
                                        class="author-article img-fluid">

                                    <div class="delete-author-article">
                                        <span class="delete-author-article" id="del-1-author">
                                            <i class="fa-solid fa-xmark"></i>
                                        </span>
                                    </div>

                                </div>

                                <input type="file" name="author_article" class="form-control-file"
                                    id="author_article">

                                <span class="error-text text-danger author_article_error"></span>

                            </div>

                            <div class="col">

                                <div class="col">
                                    <label for="categorie">Catégorie</label>
                                    <input type="text" class="form-control" id="categorie" name="categorie"
                                        value="{{ $article->categorie }}" aria-describedby="categorie">
                                    <span class="error-text text-danger categorie_error"></span>
                                </div>

                                <div class="col mt-3">
                                    <label for="author">Auteur</label>
                                    <input type="text" class="form-control" id="author" name="author"
                                        value="{{ $article->author }}" aria-describedby="author">
                                    <span class="error-text text-danger author_error"></span>
                                </div>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label for="author_content">Description de l'auteur</label>
                        <textarea name="author_content" class="form-control" id="author_content" name="author_content" cols="30"
                            rows="10">{{ $article->author_content }}</textarea>
                        <span class="error-text text-danger author_content_error"></span>

                    </div>

                    <div class="form-group">

                        <div class="row">

                            <div class="col">
                                <label for="author_link">Lien de l'auteur</label>
                                <input type="text" class="form-control" id="author_link"
                                    aria-describedby="author_link" name="author_link"
                                    value="{{ $article->author_link }}">
                                <span class="error-text text-danger author_link_error"></span>
                            </div>

                            <div class="col">
                                <label for="source">Source de l'article</label>
                                <input type="text" class="form-control" id="source" name="source"
                                    aria-describedby="source" value="{{ $article->source }}">
                                <span class="error-text text-danger source_error"></span>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="row">

                            <div class="col">
                                <label for="url_fb">Lien facebook de l'auteur</label>
                                <input type="text" class="form-control" id="url_fb" name="url_fb"
                                    value="{{ $article->url_fb }}" aria-describedby="url_fb">
                                <span class="error-text text-danger url_fb_error"></span>
                            </div>

                            <div class="col">
                                <label for="url_twitter">Lien twitter de l'auteur</label>
                                <input type="text" class="form-control" value="{{ $article->url_twitter }}"
                                    id="url_twitter" name="url_twitter" aria-describedby="url_twitter">
                                <span class="error-text text-danger url_twitter_error"></span>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="row">

                            <div class="col">
                                <label for="url_linkedin">Lien linkedin de l'auteur</label>
                                <input type="text" class="form-control" value="{{ $article->url_linkedin }}"
                                    id="url_linkedin" name="url_linkedin" aria-describedby="url_linkedin">
                                <span class="error-text text-danger url_linkedin_error"></span>
                            </div>

                            <div class="col">
                                <label for="email">Email de l'auteur</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ $article->email }}" aria-describedby="email">
                                <span class="error-text text-danger email_error"></span>
                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-success btn-icon-split mr-2">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text font-weight-bold">Modifier l'article</span>
                    </button>

                    <a href="/show-blog" class="btn btn-warning btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <span class="text">Annuler les modifications</span>
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->
