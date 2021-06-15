<main class="page__main page__main--messages">
  <h1 class="visually-hidden">Личные сообщения</h1>
  <section class="messages tabs">
    <h2 class="visually-hidden">Сообщения</h2>
    <div class="messages__contacts">
      <ul class="messages__contacts-list tabs__list">
        <?php foreach($convos as $key=>$convo):?>
          <li class="messages__contacts-item messages__contacts-item--new">
          <form>
            <input class="visually-hidden" type="text" name="active" value="<?=$key?>">
            <button class="messages__contacts-tab tabs__item <?= $active==$key? "messages__contacts-tab--active tabs__item tabs__item--active" : "tabs_item"?>" 
              href="messages.php?id=<?=$convo['id']?>">
              <div class="messages__avatar-wrapper">
                <img class="messages__avatar" src="<?=$convo['profile_pic']?>" alt="Аватар пользователя">
                <i class="messages__indicator">2</i>
              </div>
              <div class="messages__info">
                <span class="messages__contact-name">
                  <?=$convo['login']?>
                </span>
                <?php if(!empty($dialogues[$key])):?>
                  <div class="messages__preview">
                    <p class="messages__preview-text">
                      <?=$dialogues[$key][-1]['text']?>
                    </p>
                    <time class="messages__preview-time" datetime="<?=$dialogues[$key][-1]['date_created']?>">
                      <?=$dialogues[$key][-1]['date_created']?>
                    </time>
                  </div>
                <?php endif;?>
              </div>
            </button>
          </form>
          </li>
        <?php endforeach;?>
        <!-- <li class="messages__contacts-item">
          <a class="messages__contacts-tab messages__contacts-tab--active tabs__item tabs__item--active" href="#">
            <div class="messages__avatar-wrapper">
              <img class="messages__avatar" src="img/userpic-larisa.jpg" alt="Аватар пользователя">
            </div>
            <div class="messages__info">
              <span class="messages__contact-name">
                Лариса Роговая
              </span>
              <div class="messages__preview">
                <p class="messages__preview-text">
                  Озеро Байкал – огромное
                </p>
                <time class="messages__preview-time" datetime="2019-05-01T14:40">
                  14:40
                </time>
              </div>
            </div>
          </a>
        </li> -->
        <!--<li class="messages__contacts-item">
          <a class="messages__contacts-tab tabs__item" href="#">
            <div class="messages__avatar-wrapper">
              <img class="messages__avatar" src="img/userpic-mark.jpg" alt="Аватар пользователя">
            </div>
            <div class="messages__info">
              <span class="messages__contact-name">
                Марк Смолов
              </span>
              <div class="messages__preview">
                <p class="messages__preview-text">
                  Вы: Марк, ждем тебя
                </p>
                <time class="messages__preview-time" datetime="2019-01-02T14:40">
                  2 янв
                </time>
              </div>
            </div>
          </a>
        </li>
        <li class="messages__contacts-item">
          <a class="messages__contacts-tab tabs__item" href="#">
            <div class="messages__avatar-wrapper">
              <img class="messages__avatar" src="img/userpic-tanya.jpg" alt="Аватар пользователя">
            </div>
            <div class="messages__info">
              <span class="messages__contact-name">
                Таня Фирсова
              </span>
              <div class="messages__preview">
                <p class="messages__preview-text">
                  Вы: Девушка не
                </p>
                <time class="messages__preview-time" datetime="2018-09-30T14:40">
                  31 сент
                </time>
              </div>
            </div>
          </a>
        </li> -->
      </ul>
    </div>
    <div class="messages__chat">
      <div class="messages__chat-wrapper">
      <?php foreach($dialogues as $dialogue):?>
        <ul class="messages__list tabs__content tabs__content--active">
          <?php foreach($dialogue as $message):?>
            <li class="messages__item">
              <div class="messages__info-wrapper">
                <div class="messages__item-avatar">
                  <a class="messages__author-link" href="#">
                    <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                  </a>
                </div>
                <div class="messages__item-info">
                  <a class="messages__author" href="#">
                    Лариса Роговая
                  </a>
                  <time class="messages__time" datetime="2019-05-01T14:40">
                    1 ч назад
                  </time>
                </div>
              </div>
              <p class="messages__text">
                Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
              </p>
            <?php endforeach;?>
          </li>
          <!-- <li class="messages__item messages__item--my">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Антон Глуханько
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li> -->
        </ul>
        <ul class="messages__list tabs__content">
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:40">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item messages__item--my">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Антон Глуханько
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
        </ul>
        <?php endforeach;?>

        <!-- <ul class="messages__list tabs__content">
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:40">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item messages__item--my">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Антон Глуханько
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
        </ul>

        <ul class="messages__list tabs__content">
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:40">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item messages__item--my">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Антон Глуханько
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
          <li class="messages__item">
            <div class="messages__info-wrapper">
              <div class="messages__item-avatar">
                <a class="messages__author-link" href="#">
                  <img class="messages__avatar" src="img/userpic-larisa-small.jpg" alt="Аватар пользователя">
                </a>
              </div>
              <div class="messages__item-info">
                <a class="messages__author" href="#">
                  Лариса Роговая
                </a>
                <time class="messages__time" datetime="2019-05-01T14:39">
                  1 ч назад
                </time>
              </div>
            </div>
            <p class="messages__text">
              Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
            </p>
          </li>
        </ul> -->
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

