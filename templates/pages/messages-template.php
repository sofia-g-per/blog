<main class="page__main page__main--messages">
  <h1 class="visually-hidden">Личные сообщения</h1>
  <section class="messages tabs">
    <h2 class="visually-hidden">Сообщения</h2>
    <div class="messages__contacts">
      <ul class="messages__contacts-list tabs__list">
        <?php foreach($convos as $key=>$convo):?>
          <li class="messages__contacts-item messages__contacts-item--new">
            <a href="messages.php?id=<?=$convo['id']?>"
            class="messages__contacts-tab tabs__item <?= $active==$key? "messages__contacts-tab--active tabs__item tabs__item--active" : "tabs_item"?>">
              <div class="messages__avatar-wrapper">
                <img class="messages__avatar" src="<?=$convo['profile_pic']?>" alt="Аватар пользователя">
                <?php if($convo['unread_num']!= 0): ?>
                  <i class="messages__indicator"><?=$convo['unread_num']?></i>
                <?php endif;?>
              </div>
              <div class="messages__info">
                <span class="messages__contact-name">
                  <?=$convo['login']?>
                </span>
                <div class="messages__preview">
                  <?php if(!empty($dialogues[$key])):?>
                    <p class="messages__preview-text">
                      <?=$dialogues[$key][Count($dialogues[$key])-1]['text']?>
                    </p>
                    <time class="messages__preview-time" datetime="<?=$dialogues[$key][Count($dialogues[$key])-1]['date_created']?>">
                      <?php $date = strtotime($dialogues[$key][Count($dialogues[$key])-1]['date_created'])?>
                      <!-- если сообщение отправлено не в этот день, то выводится дата, в противном случае выводится время -->
                      <?= strtotime(time()) - $date < (24 * 60 * 60)? date('H:i', $date):date('d.m.Y', $date)?>
                    </time>
                  <?php endif;?>
                </div>
              </div>
            </a>
          </li>
        <?php endforeach;?>
      </ul>
    </div>
    
    <div class="messages__chat">
      <div class="messages__chat-wrapper">
        
        
        <?php foreach($dialogues as $key=>$dialogue):?>
          <?php if(!empty($dialogue)):?>
            <ul class="messages__list tabs__content <?=$key==$active? "tabs__content--active": ""?>">

              <?php foreach($dialogue as $message):?>
                <li class="messages__item<?=$message['sender'] == $_SESSION['user_id']? " messages__item--my": ""?>">
                  <div class="messages__info-wrapper">
                    <div class="messages__item-avatar">
                      <a class="messages__author-link" href="profile.php?id=<?=$message['sender']?>&par=posts">
                        <img class="messages__avatar" src="<?=$message['profile_pic']?>" alt="Аватар пользователя">
                      </a>
                    </div>
                    <div class="messages__item-info">
                      <a class="messages__author" href="profile.php?id=<?=$message['sender']?>&par=posts">
                        <?= $message['login']?>
                      </a>
                      <time class="messages__time" datetime="<?=$message['date_created']?>">
                        <?=ago($message['date_created'])?> назад
                      </time>
                    </div>
                  </div>
                  <p class="messages__text">
                    <?=$message['text']?>
                  </p>
                <?php endforeach;?>
              </li>

            </ul>
            <!-- если диалог пустой, то есть у пользователей нет переписки -->
          <?php else:?>
            <div class="messages__list tabs__content <?=$key==$active? "tabs__content--active": ""?>">
              <div class="no-messages__container">
                <p class="search__no-results-info">У вас ещё нет сообщений с данным пользователем.</p>
                <p class="search__no-results-desc">
                  Будьте тем, кто напишет первым!
                </p>
              </div>
            </div>
          <?php endif;?>
        <?php endforeach;?>
      </div>
      <div class="comments">
      <form class="comments__form form" method="post">
        <div class="comments__my-avatar">
          <img class="comments__picture" src="<?=$_SESSION['profile_pic']?>" alt="Аватар пользователя">
        </div>
        <div class="form__input-section<?=!empty($errors)? " form__input-section--error":""?>">
          <input type="text" class="visually-hidden" name="receipient" value="<?=$convos[$active]['id']?>">
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
      </div>
    </div>
  </section>
</main>

