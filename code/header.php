<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Flappy Falcon</title>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1">
        <?php 
            $css_file = isset($stylesheet_url) ? $stylesheet_url : 'default.css'; 
            $add_head = isset($add_line) ? $add_line : ''; 
        ?>
        <link rel="stylesheet" href="<?php echo $css_file; ?>">
        <?php echo $add_head;?>
    </head>
    <body>