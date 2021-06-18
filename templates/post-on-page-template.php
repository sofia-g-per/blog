<article class="<?=$page?>__post post post-<?=$post['content_type']?>">
        <!-- вынести хедеры и/или футеры из switchcase-ов в страницы-->
    <?php switch($page):
        case('popular'):?>
            <header class="post__header"> 
                <h2>
                    <a href='post-details.php?id=<?=$post['id']?>'>
                        <?= !$post['repost']? $post['title'] : "Репост: ".$post['title']?> 
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
                        <?php if(strlen($post['content']) > 200 && $page != 'post-details'): ?>
                            <?= substr($post['content'], 0, 200).'...' ?>
                        <?php else:?>
                            <?= $post['content'] ?>
                        <?php endif;?>
                        </p>
                        <cite><?= $post['quote_author'] ?></cite>
                    </blockquote>
            <?php break; ?>
            
            <?php case('link'):?>
                <!--содержимое для поста-ссылки-->
                <div class="post-link__wrapper">
                    <a class="post-link__external" href="http://<?=$post['content']?>" title="Перейти по ссылке">
                            <div class="post-link__info">
                                <span>
                                    <?= substr($post['content'], 0, 20).'...' ?>
                                </span>
                            </div>
                            <?php if($page !== 'popular'):?>
                            <svg class="post-link__arrow" width="11" height="16">
                                <use xlink:href="#icon-arrow-right-ad"></use>
                            </svg>
                            <?php endif;?>
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
                <div class="post-video__block">
                    <div class="post-video__preview">
                        <img alt="youtube cover" src="<?=embed_youtube_cover($post['content']); ?>">
                    </div>
                    <?php if($page != 'popular'):?>
                        <div class="post-video__control">
                            <button class="post-video__play post-video__play--paused button button--video" >
                                <span class="visually-hidden">Запустить видео</span>
                            </button>
                            <div class="post-video__scale-wrapper">
                                <div class="post-video__scale">
                                    <div class="post-video__bar">
                                        <div class="post-video__toggle">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button">
                                <span class="visually-hidden">Полноэкранный режим</span>
                            </button>
                        </div>
                    <?php endif;?>
                    <a class="post-video__play-big button" href="<?=$post['content']?>">
                        <svg class="post-video__play-big-icon" width="27" height="28">
                            <use xlink:href="#icon-video-play-big"></use>
                        </svg>
                        <span class="visually-hidden">Запустить проигрыватель</span>
                    </a>
                </div>
            <?php break;
            case('text'):?>
            <?php if(strlen($post['content']) > 300 && $page != 'post-details'): ?>
                <!-- укороченная версия поста -->
                <p> <?= substr($post['content'], 0, 300).'...'?></p>
                <div class="post-text__more-link-wrapper">
                    <a class="post-text__more-link" href="post-details.php?id=<?=$post['id']?>">Читать далее</a>
                </div>
                
                <?php else:?>
                    <p> <?= $post['content']?></p>
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
                    <form action="post-details.php?id=<?=$post['id']?>">
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
                        <li><a href="search-tag.php?search=<?=$hashtag?>">#<?=$hashtag?></a></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
    </footer> 
    <?php if($page =='profile' && $post['comments_num'] > 0):?>
        <div class="comments">
            <?php if(isset($_GET['comments']) && $_GET['comments'] == $post['id']):?>
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
                    <ul class="comments__list">
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
                    </ul>
                </div>
            <?php else:?>
                <a class="comments__button button" href="profile.php?id=<?=$post['author']?>&par=posts&comments=<?=$post['id']?>">
                    Показать комментарии
                </a>
            <?php endif;?>
        </div>
    <?php endif;?>
</article>
