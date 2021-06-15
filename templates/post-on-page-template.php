<article class="<?=$page?>__post post post-<?=$post['content_type']?>">
        <!-- вынести хедеры и/или футеры из switchcase-ов в страницы-->
    <?php switch($page):
        case('popular'):?>
            <header class="post__header"> 
                <h2>
                    <a href='post-details.php?id=<?=$post['id']?>'> 
                        <?=$post['title']?> 
                    </a>
                </h2>
            </header>
        <? break;
        //используется в feed и profile 
        default: ?> 
            <!-- заголовок если пост НЕ является репостом -->
            <?if(!$post['repost']):?>
                <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?id=<?=$post['author']?>&par=posts" title="Автор">
                        <div class="post__avatar-wrapper">
                            <img class="post__author-avatar" src="<?=$post['profile_pic']?>" alt="Аватар пользователя" width="60" height="60">
                        </div>
                        <div class="post__info">
                            <b class="post__author-name"><?=$post['login']?></b>
                            <span class="post__time"><?=ago($post['date_created'])?> назад</span>
                        </div>
                    </a>
                </header> 
            <?php else:?>
                <!-- заголовок если пост является репостом -->
                <div class="post__author">
                    <a class="post__author-link" href="profile.php?id=<?=$post['author']?>&par=posts" title="Автор">
                        <div class="post__avatar-wrapper post__avatar-wrapper--repost">
                            <img class="post__author-avatar" src="<?=$post['original_author']['profile_pic']?>" alt="Аватар пользователя">
                        </div>
                        <div class="post__info">
                            <b class="post__author-name">Репост: <?=($post['original_author']['login'])?></b>
                            <time class="post__time" datetime="<?=$post['date_created']?>"><?=ago($post['date_created'])?> назад</time>
                        </div>
                    </a>
                </div>
            <?php endif;?>   
            <!-- <?php //if($pagePar == 'likes'): ?>
                <div class="post-mini__action">
                    <span class="post-mini__activity user__additional">Лайкнул публикацию</span>
                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5 минут назад</time>
                </div>
            <?php// endif;?> -->
        <?php break;
    endswitch;?>     

    <div class="post__main">
        <!-- если данный пост - репост, то его название выводится в данном заголовке -->
        <?php if ($page != 'popular' && $post['repost']):?>
            <h2><?=$post['title']?></h2>
        <?php endif; ?>

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
                        <?=embed_youtube_cover($post['content']); ?>
                    </div>
                    <!-- <a href="post-details.php?id=<?=$post['id']?>" class="post-video__play-big button">
                        <svg class="post-video__play-big-icon" width="14" height="14">
                            <use xlink:href="#icon-video-play-big"></use>
                        </svg>
                        <span class="visually-hidden">Запустить проигрыватель</span>
                    </a> -->
                    <?php if($page != 'popular'):?>
                        <div class="post-video__control">
                            <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                            <div class="post-video__scale-wrapper">
                                <div class="post-video__scale">
                                    <div class="post-video__bar">
                                        <div class="post-video__toggle"></div>
                                    </div>
                                </div>
                            </div>
                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                        </div>
                    <?php endif;?>
                    <button class="post-video__play-big button" type="button">
                        <svg class="post-video__play-big-icon" width="27" height="28">
                            <use xlink:href="#icon-video-play-big"></use>
                        </svg>
                        <span class="visually-hidden">Запустить проигрыватель</span>
                    </button>
                </div>
            <?php break;
            case('text'):?>
                <p> <?= $post['content']?></p>
                <?php if($page != 'post-details'): ?>
                    <div class="post-text__more-link-wrapper">
                        <a class="post-text__more-link" href="post-details.php?id=<?=$post['id']?>">Читать далее</a>
                    </div>
                <?php endif;?>
            <?php break;?>
        <?php endswitch;?>
    </div>
    
    <footer class="post__footer">
        <?php if($page == 'popular'):?>
            <div class="post__author">
                <a class="post__author-link" href="profile.php?id=<?=$post['author']?>&par=posts" title="Автор">
                    <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="<?=$post['profile_pic']?>"
                                alt="Аватар пользователя">
                    </div>
                    <div class="post__info">
                        <b class="post__author-name"><?=$post['login']?></b>
                        <time class="post__time" datetime="<?=$post['date_created']?>">
                            <?=ago($post['date_created'])?> назад
                        </time>
                    </div>
                </a>
            </div>
        <?php endif;?>
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
                    <form action="#">
                        <button class="post__indicator post__indicator--comments button" title="Комментарии">
                            <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-comment"></use>
                            </svg>
                            <span><?=$post['comments_num']?></span>
                            <span class="visually-hidden">количество комментариев</span>
                        </button>
                    </form> 
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
                <?php if($page == "post-details"):?>
                    <span class="post__view"><?=$post['views']?> просмотров</span>
                <?php endif;?>
                <?php if($page == "profile"):?>
                    <time class="post__time" datetime="<?=$post['date_created']?>">
                        <?=ago($post['date_created'])?> назад
                    </time>
                <?php endif;?>
            </div>
            <?php if ($page != 'popular' && isset($post['hashtags'])):?>
                <ul class="post__tags">
                    <?php foreach($post['hashtags'] as $hashtag):?>
                        <li><a href="#">#<?=$hashtag?></a></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
    </footer> 
    <?php if($page =='profile'):?>
        <div class="comments">
            <a class="comments__button button" href="#">Показать комментарии</a>
        </div>
    <?php endif;?>
</article>
