<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="content-language" content="en, ru"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7"/>
    <meta http-equiv="X-UA-Compatible" content="chrome=1"/>

    <?php
    foreach ($styles as $v)
    {
        echo HTML::style($v, array(
                'rel'     => 'stylesheet',
                'type'    => 'text/css',
                'media'   => 'screen, projection',
                'charset' => 'utf-8'
            )) . PHP_EOL;
    }
    foreach ($scripts as $v)
    {
        echo HTML::script($v, array(
                'type'     => 'text/javascript',
                'language' => 'javascript',
                'charset'  => 'utf-8'
            )) . PHP_EOL;
    }
    ?>
    <title><?php echo $title; ?></title>
</head>
<body>
<?php echo Menu::factory('default')
               ->render(); ?>

<?php echo isset($breadcrumbs) ? $breadcrumbs : null; ?>

<div class="main <?php echo isset($containerClass) ? $containerClass : null; ?>">
    <?php echo $content; ?>
</div>
<script type="text/javascript">

    $(document).ready(function () {

    });

</script>

</body>
</html>