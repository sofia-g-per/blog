<main class="page__main page__main--publication">
  <div class="container">
    <h1 class="page__title page__title--publication"><?= $post['title']?></h1>
    <section class="post-details">
      <h2 class="visually-hidden">Публикация</h2>
      <div class="post-details__wrapper post-<?=$post['content_type']?>">
        <div class="post-details__main-block post post--details">
          <?php 
            $postDisplay = include_template("post-on-page-template.php", [
                        'post' => $post,
                        'page' => $page]);
            print($postDisplay);
          ?>
            <!--<div class="post-details__image-wrapper post-photo__image-wrapper">
              <img src="img/rock-default.jpg" alt="Фото от пользователя" width="760" height="507"> -->
          <!-- <div class="post__indicators">
            <div class="post__buttons">
              <form action="add-like.php">
                <input type="text" class="visually-hidden" name="post-id" value="<?=$post['id']?>">
                
                <button class="post__indicator post__indicator--likes button" type="submit" title="Лайк">
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
                <span><?=$commentsNum?></span>
                <span class="visually-hidden">количество комментариев</span>
              </a>
              <form action="repost.php">
                <input type="text" class="visually-hidden" name="post-id" value="<?=$post['id']?>">
                <button class="post__indicator post__indicator--repost button" type="submit"title="Репост">
                  <svg class="post__indicator-icon" width="19" height="17">
                    <use xlink:href="#icon-repost"></use>
                  </svg>
                  <span><?=$post['repost_num']?></span>
                  <span class="visually-hidden">количество репостов</span>
              </button>
              </form>
            </div>
            <span class="post__view"><?= $post['views']?> просмотров</span>
            </div>
            <?php if(!empty($hashtags)): ?>
              <ul class="post__tags">
                <?php foreach($hashtags as $hashtag):?>
                  <li><a href="#">#<?= $hashtag?></a></li>
                <?php endforeach; ?>
              </ul>
            <? endif; ?> -->
            <div class="comments">
              <form class="comments__form form" method="post">
                <div class="comments__my-avatar">
                  <img class="comments__picture" src="<?=$_SESSION['profile_pic']?>" alt="Аватар пользователя">
                </div>
                <div class="form__input-section<?=!empty($errors)? " form__input-section--error":""?>">
                  <input type="text" class="visually-hidden" name="post-id" value="<?=$post['id']?>">
                  <textarea class="comments__textarea form__textarea form__input" name="text" 
                    placeholder="Ваш комментарий" value=<?=!empty($newComment)? $newComment['text']:""?>>
                    <?=!empty($newComment)? $newComment['text']:""?>
                  </textarea>
                  <label class="visually-hidden">Ваш комментарий</label>
                  <button class="form__error-button button" type="button">!</button>
                  <div class="form__error-text">
                    <h3 class="form__error-title">Ошибка валидации</h3>
                    <p class="form__error-desc"><?=$errors['text']?? ""?></p>
                  </div>
                </div>
                <button class="comments__submit button button--green" type="submit">Отправить</button>
              </form>
              <div class="comments__list-wrapper">
                <?php if ($commentsNum > 0):?>
                  <ul class="comments__list">
                    <?php foreach($comments as $comment):?>
                      <li class="comments__item user">
                        <div class="comments__avatar">
                          <a class="user__avatar-link" href="#">
                            <img class="comments__picture" src="<?=$comment['profile_pic']?>" alt="Аватар пользователя">
                          </a>
                        </div>
                        <div class="comments__info">
                          <div class="comments__name-wrapper">
                            <a class="comments__user-name" href="#">
                              <span><?=$comment['login']?></span>
                            </a>
                            <time class="comments__time" datetime="<?=$comment['date_created']?>">1 ч назад</time>
                          </div>
                          <p class="comments__text">
                            <?=$comment['text']?>
                          </p>
                        </div>
                      </li>
                    <?php endforeach;?>
                  </ul>
                  <a class="comments__more-link" href="#">
                    <span>Показать все комментарии</span>
                    <sup class="comments__amount"><?=$commentsNum?></sup>
                  </a>
                <?php endif;?>
              </div>
            </div>
          </div>
        <?=$profileTab?>
        <!-- <div class="post-details__user user">
          <div class="post-details__user-info user__info">
            <div class="post-details__avatar user__avatar">
              <a class="post-details__avatar-link user__avatar-link" href="#">
                <img class="post-details__picture user__picture" src="<?=$post['profile_pic'] ?>" alt="Аватар пользователя">
              </a>
            </div>
            <div class="post-details__name-wrapper user__name-wrapper">
              <a class="post-details__name user__name" href="profile.php?id=<?=$post['author']?>&par=posts">
                <span><?= $post['login']?></span>
              </a>
              <time class="post-details__time user__time" datetime="<?=$comment['date_reg']?>">5 лет на сайте</time>
            </div>
          </div>
          <div class="post-details__rating user__rating">
            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
              <span class="post-details__rating-amount user__rating-amount"><?= $followersNum?></span>
              <span class="post-details__rating-text user__rating-text">подписчиков</span>
            </p>
            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
              <span class="post-details__rating-amount user__rating-amount"><?= $post['likes_num']?></span>
              <span class="post-details__rating-text user__rating-text">публикаций</span>
            </p>
          </div>
          <div class="post-details__user-buttons user__buttons">
            <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
            <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
          </div>
        </div> -->
      </div>
    </section>
  </div>
</main>