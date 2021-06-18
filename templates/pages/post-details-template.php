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
            <?php if(!empty($hashtags)): ?>
              <ul class="post__tags">
                <?php foreach($hashtags as $hashtag):?>
                  <li><a href="#">#<?= $hashtag?></a></li>
                <?php endforeach; ?>
              </ul>
            <? endif; ?>
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
                    <?php if($commentsNum > 10 && !isset($_GET['comments'])): ?>
                      <?php for($i = 0; $i <=10; $i++):?>
                        <li class="comments__item user">
                          <div class="comments__avatar">
                            <a class="user__avatar-link" href="profile.php?id=<?=$comments[$i]['author']?>&par=posts">
                              <img class="comments__picture" src="<?=$comments[$i]['profile_pic']?>" alt="Аватар пользователя">
                            </a>
                          </div>
                          <div class="comments__info">
                            <div class="comments__name-wrapper">
                              <a class="comments__user-name" href="profile.php?id=<?=$comments[$i]['author']?>&par=posts">
                                <span><?=$comments[$i]['login']?></span>
                              </a>
                              <time class="comments__time" datetime="<?=$comments[$i]['date_created']?>">
                                <?=ago($comments[$i]['date_created']);?> назад
                              </time>
                            </div>
                            <p class="comments__text">
                              <?=$comments[$i]['text']?>
                            </p>
                          </div>
                        </li>
                      <?php endfor;?>
                      <?php if($commentsNum > 10):?>
                        <a class="comments__more-link" href="post-details.php?id=<?=$post['id']?>&comments=all">
                          <span>Показать все комментарии</span>
                          <sup class="comments__amount"><?=($commentsNum - 10)?></sup>
                        </a>
                      <?php endif;?>
                      <!-- если комментариев меньше 10 или пользователь нажал на кнопку "показать все комментарии" -->
                    <?php else:?>
                        <?php foreach($comments as $comment):?>
                          <li class="comments__item user">
                            <div class="comments__avatar">
                              <a class="user__avatar-link" href="profile.php?id=<?=$comment['author']?>&par=posts">
                                <img class="comments__picture" src="<?=$comment['profile_pic']?>" alt="Аватар пользователя">
                              </a>
                            </div>
                            <div class="comments__info">
                              <div class="comments__name-wrapper">
                                <a class="comments__user-name" href="profile.php?id=<?=$comment['author']?>&par=posts">
                                  <span><?=$comment['login']?></span>
                                </a>
                                <time class="comments__time" datetime="<?=$comment['date_created']?>">
                                  <?=ago($comment['date_created']);?> назад
                                </time>
                              </div>
                              <p class="comments__text">
                                <?=$comment['text']?>
                              </p>
                            </div>
                          </li>
                      <?php endforeach;?>
                    <?endif;?>
                  </ul>
                <?php endif;?>
              </div>
            </div>
          </div>
        <?=$profileTab?>
      </div>
    </section>
  </div>
</main>