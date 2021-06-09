<?php foreach($posts as $post): ?>
    <article class="<?=$page?>__post post post-<?=$post['content_type']?>">

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
        <?php switch($page):
             case('popular'):?>
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
            <?php break;
            case('profile'):?>
                <footer class="post__footer">
                <div class="post__indicators">
                    <div class="post__buttons">
                    <a class="post__indicator post__indicator--likes button" href="add-like.php" title="Лайк">
                        <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                        </svg>
                        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                        <use xlink:href="#icon-heart-active"></use>
                        </svg>
                        <span><?=$post['likes_num']?></span>
                        <span class="visually-hidden">количество лайков</span>
                    </a>
                    <a class="post__indicator post__indicator--repost button" href="repost.php" title="Репост">
                        <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-repost"></use>
                        </svg>
                        <span><?=$post['repost_num']?></span>
                        <span class="visually-hidden">количество репостов</span>
                    </a>
                    </div>
                    <time class="post__time" datetime="<?=$post['date_created']?>">15 минут назад</time>
                </div>
                <?php if (isset($hashtags[$post['id']])):?>
                    <ul class="post__tags">
                        <?php foreach($hashtags[$post['id']] as $hashtag):?>
                            <li><a href="#">#<?=$hashtag?></a></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
                </footer>
                <div class="comments">
                <a class="comments__button button" href="#">Показать комментарии</a>
                </div>
            <?php break;?>
        <?php endswitch;?>
    </article>
<?php endforeach; ?>