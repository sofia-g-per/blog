<div class="<?=$page?>__user user container">
            <div class="<?=$page?>__user-info user__info">
              <div class="<?=$page?>__avatar user__avatar">
                <img class="<?=$page?>__picture user__picture" src="<?=$profile['profile_pic']?>" alt="Аватар пользователя">
              </div>
              <div class="<?=$page?>__name-wrapper user__name-wrapper">
                <a class="<?=$page?>__name user__name" href="profile.php?id=<?=$profile['id']?>&par=posts"><?= $profile['login']?><br> </a>
                <time class="<?=$page?>__user-time user__time" datetime="<?=$profile['reg_date']?>">
                  <?= ago($profile['reg_date']);?> на сайте
                </time>
              </div>
            </div>
            <div class="<?=$page?>__rating user__rating">
              <p class="<?=$page?>__rating-item user__rating-item user__rating-item--publications">
                <span class="user__rating-amount"><?=$profile['postsNum']?></span>
                <span class="<?=$page?>__rating-text user__rating-text">публикаций</span>
              </p>
              <p class="<?=$page?>__rating-item user__rating-item user__rating-item--subscribers">
                <span class="user__rating-amount"><?=$profile['subsNum']?></span>
                <span class="<?=$page?>__rating-text user__rating-text">подписчиков</span>
              </p>
            </div>
            <div class="<?=$page?>__user-buttons user__buttons">
              <form action="subscribe.php" class="<?=$page?>__user-buttons user__buttons">
                <input class="visually-hidden" name="profileId" value=<?=$profile['id']?> >
                <!-- если зарег пользователь подписан на данный профиль -->
                <?php if(array_search($profile['id'], $_SESSION['subs'])):?>
                  <button class="<?=$page?>__user-button user__button user__button--subscription button button--quartz" type="submit">
                    Отписаться
                  </button>
                <?php else:?>
                  <button class="<?=$page?>__user-button user__button user__button--subscription button button--main" type="submit">
                      Подписаться
                  </button>
                <?php endif;?>
                <a class="<?=$page?>__user-button user__button user__button--writing button button--green" 
                  href="messages.php?id=<?=$profile['id']?>">
                  Сообщение
                </a>
              </form>
            </div>
          </div>