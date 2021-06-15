<main class="page__main page__main--profile">
      <h1 class="visually-hidden">Профиль</h1>
      <div class="profile profile--default">
        <div class="profile__user-wrapper">
          <?=$profileTab?>
        </div>
        <div class="profile__tabs-wrapper tabs">
          <div class="container">
            <div class="profile__tabs filters">
              <b class="profile__tabs-caption filters__caption">Показать:</b>
              <ul class="profile__tabs-list filters__list tabs__list">
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button<?=$pagePar=="posts"? " filters__button--active tabs__item tabs__item--active button" : " tabs__item button"?>"
                    href="profile.php?id=<?=$profile['id']?>&par=posts">
                    Посты
                  </a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button<?=$pagePar=="likes"? " filters__button--active tabs__item tabs__item--active button" : " tabs__item button"?>" 
                    href="profile.php?id=<?=$profile['id']?>&par=likes">Лайки</a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button<?=$pagePar=="subs"? " filters__button--active tabs__item tabs__item--active button" : " tabs__item button"?>" 
                    href="profile.php?id=<?=$profile['id']?>&par=subs">Подписки</a>
                </li>
              </ul>
            </div>
            <div class="profile__tab-content">
                <section class="profile__posts tabs__content tabs__content<?= $pagePar=="posts"? "--active": ""?>">
                  <h2 class="visually-hidden">Публикации</h2>
                  <?php foreach($posts as $post){
                  $postDisplay = include_template("post-on-page-template.php", [
                            'post' => $post,
                            'profile'=> $profile,
                            'page' => $page
                        ]); 
                      print($postDisplay);
                      } ?>
                </section>
              
                <section class="profile__likes tabs__content<?= $pagePar=="likes"? "--active": ""?>">
                  <h2 class="visually-hidden">Лайки</h2>
                  <ul class="profile__likes-list">
                    <?php foreach($likes as $like):?>
                      <li class="post-mini post-mini--<?=$like['content_type']?> post user">
                        <div class="post-mini__user-info user__info">
                          <div class="post-mini__avatar user__avatar">
                            <a class="user__avatar-link" href="profile.php?id=<?=$like['author']?>&par=posts">
                              <img class="post-mini__picture user__picture" src="<?=$like["profile_pic"]?>" alt="Аватар пользователя">
                            </a>
                          </div>
                          <div class="post-mini__name-wrapper user__name-wrapper">
                            <a class="post-mini__name user__name" href="profile.php?id=<?=$like['author']?>&par=posts">
                              <span><?=$post['login']?></span>
                            </a>
                            <div class="post-mini__action">
                              <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                              <time class="post-mini__time user__additional" datetime="<?=$like['date_created']?>"><?=ago($like['date_created'])?> назад</time>
                            </div>
                          </div>
                        </div>
                        <div class="post-mini__preview">
                          <a class="post-mini__link" href="post-details.php?id=<?=$like['id']?>&par=posts&con=default" title="Перейти на публикацию">
                          <?php switch($like['content_type']):
                            case("photo"):?> 
                              <span class="visually-hidden">Фото</span>
                              <div class="post-mini__image-wrapper">
                                <img class="post-mini__image" src="<?=$like["content"]?>" width="109" height="109" alt="Превью публикации">
                              </div>
                            <?php break;?>
                            <?php case("video"):?>
                              <span class="visually-hidden">Видео</span>
                              <div class="post-mini__image-wrapper">
                                <img class="post-mini__image" src="<?=embed_youtube_cover($like['content'])?>" width="109" height="109" alt="Превью публикации">
                                <span class="post-mini__play-big">
                                  <svg class="post-mini__play-big-icon" width="12" height="13">
                                    <use xlink:href="#icon-video-play-big"></use>
                                  </svg>
                                </span>
                              </div>
                            <?php break;?>
                            <?php case("text"):?> 
                              <span class="visually-hidden">Текст</span>
                              <svg class="post-mini__preview-icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                              </svg>
                            <?php break;?>
                            <?php case("quote"):?>
                              <span class="visually-hidden">Цитата</span>
                              <svg class="post-mini__preview-icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                              </svg>
                            <?php break;?>
                            <?php case("link"):?>
                              <span class="visually-hidden">Ссылка</span>
                              <svg class="post-mini__preview-icon" width="21" height="18">
                                <use xlink:href="#icon-filter-link"></use>
                              </svg>
                            <?php break;
                             endswitch;?>
                            </a>
                        </div> 
                      </li>
                    <?php endforeach;?>
                  </ul>
                </section>
              
                <section class="profile__subscriptions tabs__content<?= $pagePar=="subs"? "--active": ""?>">
                  <h2 class="visually-hidden">Подписки</h2>
                  <ul class="profile__subscriptions-list">
                    <?php foreach($subs as $sub):?>
                      <li class="post-mini post-mini--photo post user">
                        <div class="post-mini__user-info user__info">
                          <div class="post-mini__avatar user__avatar">
                            <a class="user__avatar-link" href="profile.php?id=<?=$sub['id']?>&par=posts">
                              <img class="post-mini__picture user__picture" src="<?=$sub['profile_pic']?>" alt="Аватар пользователя">
                            </a>
                          </div>
                          <div class="post-mini__name-wrapper user__name-wrapper">
                            <a class="post-mini__name user__name" href="profile.php?id=<?=$sub['id']?>&par=posts">
                              <span><?=$post['login']?></span>
                            </a>
                            <time class="post-mini__time user__additional" datetime="2014-03-20T20:20"><?=ago($sub['reg_date'])?> на сайте</time>
                          </div>
                        </div>
                        <div class="post-mini__rating user__rating">
                          <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                            <span class="post-mini__rating-amount user__rating-amount"><?=$sub['posts_num']?></span>
                            <span class="post-mini__rating-text user__rating-text">публикаций</span>
                          </p>
                          <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                            <span class="post-mini__rating-amount user__rating-amount"><?=$sub['subs_num']?></span>
                            <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                          </p>
                        </div>
                        <div class="post-mini__user-buttons user__buttons">
                          <form action="subscribe.php" class="post-mini__user-buttons user__buttons">
                            <input class="visually-hidden" name="profileId" value=<?=$sub['id']?> >
                            <!-- если зарег пользователь подписан на данный профиль -->
                            <?php if(array_search($sub['id'], $_SESSION['subs'])):?>
                              <button class="post-mini__user-button user__button user__button--subscription button button--quartz" type="submit">
                                Отписаться
                              </button>
                            <?php else:?>
                              <button class="post-mini__user-button user__button user__button--subscription button button--main" type="submit">
                                  Подписаться
                              </button>
                            <?php endif;?>
                          </form>
                        </div>
                      </li>
                    <?php endforeach;?>
                  </ul>
                </section>
            </div>
          </div>
        </div>
      </div>
    </main>