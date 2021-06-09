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
       <?=$postsContent?>
        </div>
        <div class="popular__page-links">
            <?php if($pageNum > 0): ?>
                <a class="popular__page-link popular__page-link--prev button button--gray" href="../popular.php?page=<?= $pageNum-1?>&par=<?=$pagePar?>&con=<?=$pageCat?>">Предыдущая страница</a>
            <?php endif;?>
            <a class="popular__page-link popular__page-link--next button button--gray" href="../popular.php?page=<?=$pageNum+1?>&par=<?=$pagePar?>&con=<?=$pageCat?>">Следующая страница</a>
        </div>
    </div>
</section>

