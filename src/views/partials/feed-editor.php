<div class="box feed-new">
        <div class="box-body">
            <div class="feed-new-editor m-10 row">
                <div class="feed-new-avatar">
                    <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
                </div>
                <div class="feed-new-input-placeholder">O que você está pensando, <?=$user->name;?></div>
                <div class="feed-new-input" contenteditable="true"></div>
                <div class="feed-new-send">
                    <img src="assets/images/send.png" />
                </div>

                <form method="POST" action="<?=$base;?>/post/new>
                    <input type="hidden" name="body" />

            </div>
        </div>
    </div>