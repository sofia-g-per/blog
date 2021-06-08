<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link<?=$pagePar=='views'?'--active':''?>" 
                            href="popular.php?page=<?=$pageNum?>&par=views&con=<?=$pageCat?>">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link<?=$pagePar=='likes_num'?'--active':''?>"
                             href="popular.php?page=<?=$pageNum?>&par=likes_num&con=<?=$pageCat?>">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link<?=$pagePar=='reg_date'?'--active':''?>"
                            href="popular.php?page=<?=$pageNum?>&par=reg_date&con=<?=$pageCat?>">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button<?=$pageCat == 'default'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=default">
                            <span>Все</span>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--photo button<?=$pageCat == 'photo'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=photo">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-photo"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--video button<?=$pageCat == 'video'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=video">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="#icon-filter-video"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--text button<?=$pageCat == 'text'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=text">
                            <span class="visually-hidden">Текст</span>
                            <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--quote button<?=$pageCat == 'quote'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=quote">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--link button<?=$pageCat == 'link'?'--active': ''?>" 
                            href="../popular.php?page=<?=$pageNum?>&par=<?=$pagePar?>&con=link">
                            <span class="visually-hidden">Ссылка</span>
                            <svg class="filters__icon" width="21" height="18">
                                <use xlink:href="#icon-filter-link"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach($posts as $post): ?>
                <article class="popular__post post post-<?=$post['content_type']?>">

                    <header class="post__header">
                        <h2>
                            <a href='../post-details.php?id=<?=$post['id']?>'><?= $post['title']?></a>
                        </h2>
                    </header>

                    <div class="post__main">
                        <?php switch($post['content_type']):
                            case('quote'):?>
                                <!--содержимое для поста-цитата -->
                                    <blockquote>
                                        <p>
                                            <?= $post['content'] ?>
                                        </p>
                                        <cite><?= $post['quote_author'] ?></cite>
                                    </blockquote>
                            <?php break; ?>
                            
                            <?php case('link'):?>
                                <!--содержимое для поста-ссылки-->
                                <div class="post-link__wrapper">
                                    <a class="post-link__external" href="http://<?=$post['content']?>" title="Перейти по ссылке">
                                        <div class="post-link__info-wrapper">
                                            <div class="post-link__icon-wrapper">
                                                <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                            </div>
                                            <div class="post-link__info">
                                                <h3><?=$post['title'] ?></h3>
                                            </div>
                                        </div>
                                        <span><?=$post['content']?></span>
                                    </a>
                                </div>
                            <?php break; ?>

                            <?php case('photo'):?>
                                <!--содержимое для поста-фото-->
                                <div class="post-photo__image-wrapper">
                                    <img src="<?= $post['content']?>" alt="Фото от пользователя" width="360" height="240">
                                </div>
                            <?php break;?>
                            
                            <?php case('video'):?>
                                <!--содержимое для поста-видео-->
                                <!-- fix !!!!! -->
                                <div class="post-video__block">
                                    <div class="post-video__preview">
                                    
                                        <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                                    </div>
                                    <a href="post-details.html" class="post-video__play-big button">
                                        <svg class="post-video__play-big-icon" width="14" height="14">
                                            <use xlink:href="#icon-video-play-big"></use>
                                        </svg>
                                        <span class="visually-hidden">Запустить проигрыватель</span>
                                    </a>
                                </div>
                            <?php break;
                            case('text'):?>
                                <p> <?= $post['content']?></p>
                                <div class="post-text__more-link-wrapper">
                                    <a class="post-text__more-link" href="#">Читать далее</a>
                                </div>
                            <?php break;?>
                        <?php endswitch;?>
                    </div>

                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="../post-details.php?id=<?=$post['id']?>" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="<?=$post['profile_pic']?>" alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?=$post['login']?></b>
                                    <time class="post__time" datetime=""><?=$post['date_created']?></time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <form action="add-like.php">
                                    <input type="text" class="visually-hidden" name="post-id" value="<?=$post['id']?>">
                                    <button class="post__indicator post__indicator--likes button" type="submit">
                                        <svg class="post__indicator-icon" width="20" height="17">
                                            <use xlink:href="#icon-heart"></use>
                                        </svg>
                                        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                            <use xlink:href="#icon-heart-active"></use>
                                        </svg>
                                        <span><?=$post['likes_num']?></span>
                                        <span class="visually-hidden">количество лайков</span>
                                    </button>
                                </form>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?=$post['comments_num']?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="popular__page-links">
            <?php if($pageNum > 0): ?>
                <a class="popular__page-link popular__page-link--prev button button--gray" href="../popular.php?page=<?= $pageNum-1?>&par=<?=$pagePar?>&con=<?=$pageCat?>">Предыдущая страница</a>
            <?php endif;?>
            <a class="popular__page-link popular__page-link--next button button--gray" href="../popular.php?page=<?=$pageNum+1?>&par=<?=$pagePar?>&con=<?=$pageCat?>">Следующая страница</a>
        </div>
    </div>
</section>

