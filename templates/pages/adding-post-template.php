<main class="page__main page__main--adding-post">
      <div class="page__main-section">
        <div class="container">
          <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
          <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
                  <ul class="adding-post__tabs-list filters__list tabs__list">
                      <li class="adding-post__tabs-item filters__item">
                          <a class="adding-post__tabs-link filters__button filters__button--photo tabs__item button
                            <?= $_POST['content_type'] == 'photo' ? 'filters__button--active tabs__item--active': ''?>" href="#">
                              <svg class="filters__icon" width="22" height="18">
                                  <use xlink:href="#icon-filter-photo"></use>
                              </svg>
                              <span>Фото</span>
                          </a>
                      </li>
                      <li class="adding-post__tabs-item filters__item">
                          <a class="adding-post__tabs-link filters__button filters__button--video tabs__item button
                           <?= $_POST['content_type'] == 'video' ? 'filters__button--active tabs__item--active': ''?>" href="#">
                              <svg class="filters__icon" width="24" height="16">
                                  <use xlink:href="#icon-filter-video"></use>
                              </svg>
                              <span>Видео</span>
                          </a>
                      </li>
                      <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--text tabs__item button
                          <?= $_POST['content_type'] == 'text' ? 'filters__button--active tabs__item--active': ''?>" href="#">
                              <svg class="filters__icon" width="20" height="21">
                                  <use xlink:href="#icon-filter-text"></use>
                              </svg>
                              <span>Текст</span>
                          </a>
                      </li>
                      <li class="adding-post__tabs-item filters__item">
                          <a class="adding-post__tabs-link filters__button filters__button--quote tabs__item button
                          <?= $_POST['content_type'] == 'quote' ? 'filters__button--active tabs__item--active': ''?>" href="#">
                              <svg class="filters__icon" width="21" height="20">
                                  <use xlink:href="#icon-filter-quote"></use>
                              </svg>
                              <span>Цитата</span>
                          </a>
                      </li>
                      <li class="adding-post__tabs-item filters__item">
                          <a class="adding-post__tabs-link filters__button filters__button--link tabs__item button
                          <?= $_POST['content_type'] == 'link' ? 'filters__button--active tabs__item--active': ''?>" href="#">
                              <svg class="filters__icon" width="21" height="18">
                                  <use xlink:href="#icon-filter-link"></use>
                              </svg>
                              <span>Ссылка</span>
                          </a>
                      </li>
                  </ul>
              </div>
            <div class="adding-post__tab-content">
              <section class="adding-post__photo tabs__content <?= $_POST['content_type'] == 'photo' ? 'tabs__content--active' : ''?>">
                <h2 class="visually-hidden">Форма добавления фото</h2>
                <form class="adding-post__form form"  method="post" enctype="multipart/form-data">
                  <input class="visually-hidden" name="content_type" value="photo">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['photo-heading']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="photo-heading" type="text" name="photo-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["photo-heading"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                        <div class="form__input-section <?= isset($errors['photo-url']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["photo-url"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                        <div class="form__input-section <?= isset($errors['photo-tags']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="photo-tags" type="text" name="photo-tags" placeholder="Введите теги">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["photo-tags"] ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($errors)):?>
                      <div class="form__invalid-block">
                        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                        <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                          <li class="form__invalid-item"><?= $error ?></li>
                        <?php endforeach;?>
                        </ul>
                      </div>
                      <?php endif;?>
                  </div>
                  <div class="adding-post__input-file-container form__input-container form__input-container--file">
                  <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                      <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="userpic-file-photo" title=" ">
                      <div class="form__file-zone-text">
                        <span>Перетащите фото сюда</span>
                      </div>
                    </div>
                    </div>
                    <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">
                      <div class="dz-preview dz-file-preview">
                        <div class="registration__image-wrapper form__file-wrapper"><img class="form__image" src="" alt=""
                                                                                          data-dz-thumbnail></div>
                        <div class="registration__file-data form__file-data"><span
                          class="registration__file-name form__file-name dz-filename" data-dz-name></span>
                          <button class="registration__delete-button form__delete-button button" type="button" data-dz-remove>
                            <span>Удалить</span>
                            <svg class="registration__delete-icon form__delete-icon" xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 18 18" width="12" height="12">
                              <path
                                d="M18 1.3L16.7 0 9 7.7 1.3 0 0 1.3 7.7 9 0 16.7 1.3 18 9 10.3l7.7 7.7 1.3-1.3L10.3 9z"/>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__video tabs__content <?= $_POST['content_type'] == 'video' ? 'tabs__content--active' : ''?>">
                <h2 class="visually-hidden">Форма добавления видео</h2>
                <form class="adding-post__form form" method="post" enctype="multipart/form-data">
                  <input class="visually-hidden" name="content_type" value="video">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['video-heading']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="video-heading" type="text" name="video-heading" placeholder="Введите заголовок" value="<?= getPostVal('video-heading')?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["video-heading"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['video-url']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="video-url" type="text" name="video-url" placeholder="Введите ссылку" value="<?= getPostVal('video-url')?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["video-url"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                        <div class="form__input-section <?= isset($errors['video-tags']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="video-tags" type="text" name="photo-tags" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["video-tags"] ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($errors)):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                        <li class="form__invalid-item"><?= $error ?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif; ?>
                  </div>

                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__text tabs__content <?= $_POST['content_type'] == 'text' ? 'tabs__content--active' : ''?>">
                <h2 class="visually-hidden">Форма добавления текста</h2>
                <form class="adding-post__form form" method="post">
                <input class="visually-hidden" name="content_type" value="text">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['text-heading']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="text-heading" type="text" name="text-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["text-heading"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="text-text">Текст поста <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['text-text']) ? "form__input-section--error": ""?>">
                          <textarea class="adding-post__textarea form__textarea form__input" id="text-text" name="text-text" placeholder="Введите текст публикации"></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["text-text"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="text-tags">Теги</label>
                        <div class="form__input-section <?= isset($errors['text-tags']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="text-tags" type="text" name="text-tags" placeholder="Введите теги">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["text-tags"] ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($errors)): ?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                      <?php foreach($errors as $error): ?>  
                      <li class="form__invalid-item"><?= $error?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__quote tabs__content <?= $_POST['content_type'] == 'quote' ? 'tabs__content--active' : ''?>">
                <h2 class="visually-hidden">Форма добавления цитаты</h2>
                <form class="adding-post__form form" method="post">
                <input class="visually-hidden" name="content_type" value="quote">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors["quote-heading"]) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="quote-heading" type="text" name="quote-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["quote-heading"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="quote-text">Текст цитаты <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['quote-text']) ? "form__input-section--error": ""?>">
                          <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" name="quote-text" id="cite-text" placeholder="Текст цитаты"></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["quote-text"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['quote-author']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["quote-author"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-tags">Теги</label>
                        <div class="form__input-section <?= isset($errors['quote-tags']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="quote-tags" type="text" name="quote-tags" placeholder="Введите теги">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["quote-tags"] ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($errors)): ?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                      <?php foreach($errors as $error): ?>  
                      <li class="form__invalid-item"><?= $error?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__link tabs__content <?= $_POST['content_type'] == 'link' ? 'tabs__content--active' : ''?>">
                <h2 class="visually-hidden">Форма добавления ссылки</h2>
                <form class="adding-post__form form" method="post">
                <input class="visually-hidden" name="content_type" value="link">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['link-heading']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="link-heading" type="text" name="link-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["link-heading"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-text">Ссылка <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?= isset($errors['link-text']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="text-link" type="text" name="link-text">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["link-text"] ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                        <div class="form__input-section <?= isset($errors['link-tags']) ? "form__input-section--error": ""?>">
                          <input class="adding-post__input form__input" id="link-tags" type="text" name="link-tags" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $errors["link-tags"] ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($errors)): ?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                      <?php foreach($errors as $error): ?>  
                      <li class="form__invalid-item"><?= $error?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </div>
      </div>
    </main>