<?php
$email = null;
if (Auth::instance()
        ->logged_in()
)
{
    $email = Auth::instance()
                 ->get_user()->email;
}
?>

<div class="ui fixed inverted tiered menu">
    <div class="container">

        <div class="title item">
            <a href="<?php echo Route::url('default') ?>"><b>Control Panel</b></a>
            <sup style="position: absolute; top:0; right:0; padding: 5px">
                <small>&alpha;</small>
            </sup>
        </div>

        <?php foreach ($menu['items'] as $item) : ?>
            <a class="icon item " href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a>
        <?php endforeach; ?>

        <div class="item">
            <div class="ui icon input">
                <form action="/search" method="post">
                    <input type="text" placeholder="Search..." name="query">

                </form>
                <i class="search link icon"></i>
            </div>
        </div>

        <div class="right menu">
            <div class="vertically fitted borderless item">

            </div>

            <div class="ui simple dropdown item">
                <i class="user icon"></i> <?php echo $email; ?> <i class="icon dropdown"></i>

                <div class="theme menu">
                    <div class="active item">Profile</div>
                    <a href="/auth/logout" class="item">Exit</a>
                </div>
            </div>

        </div>
    </div>


</div>