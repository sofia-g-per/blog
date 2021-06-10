<div class="<?=$page?>__user user container">
            <div class="<?=$page?>__user-info user__info">
              <div class="<?=$page?>__avatar user__avatar">
                <img class="<?=$page?>__picture user__picture" src="<?=$profile['profile_pic']?>" alt="Аватар пользователя">
              </div>
              <div class="<?=$page?>__name-wrapper user__name-wrapper">
                <span class="<?=$page?>__name user__name"><?= $profile['login']?><br> </span>
                <time class="<?=$page?>__user-time user__time" datetime="2014-03-20">5 лет на сайте</time>
              </div>
            </div>
            <div class="<?=$page?>__rating user__rating">
              <p class="<?=$page?>__rating-item user__rating-item user__rating-item--publications">
                <span class="user__rating-amount"><?=$postsNum?></span>
                <span class="<?=$page?>__rating-text user__rating-text">публикаций</span>
              </p>
              <p class="<?=$page?>__rating-item user__rating-item user__rating-item--subscribers">
                <span class="user__rating-amount"><?=$subsNum?></span>
                <span class="<?=$page?>__rating-text user__rating-text">подписчиков</span>
              </p>
            </div>
            <div class="<?=$page?>__user-buttons user__buttons">
              <form action="subscribe.php">
                <input class="visually-hidden" name="profileId" value=<?=$profile['id']?>>
                <button class="<?=$page?>__user-button user__button user__button--subscription button button--main" type="submit">
                    Подписаться
                </button>
              </form>
              <a class="<?=$page?>__user-button user__button user__button--writing button button--green" 
                href="messsages.php?id=<?=$profile['id']?>">
                Сообщение
              </a>
            </div>
          </div>