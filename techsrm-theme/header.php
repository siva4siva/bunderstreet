<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
        <?php get_stylesheet_uri(); ?> 
        <?php wp_head(); ?>
    </head>

    <body>
        <div class="container-fluid theme-color">
            <div class="row justify-content-end">
                <div class="col col-12 col-xl-4 col-md-4 col-sm-12">
                    <div class="row first-nav-bar">
                        <div class="col col-3 col-md-3 col-sm-3 col-xl-3">
                            <a class="nostyle" href="#">Advertise</a>
                        </div>
                        <div class="col col-3 col-md-3 col-sm-3 col-xl-3">
                            <a class="nostyle" href="#">Sell product</a>
                        </div>
                        <div class="col col-3 col-md-3 col-sm-3 col-xl-3">
                            <a class="nostyle" href="#">Help center</a>
                        </div>
                        <div class="col col-3 col-md-3 col-sm-3 col-xl-3">
                            <a class="nostyle" href="#">Download app</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row padding-5">
                <div class="col-md-2 col-sm-12 col-12">

                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            All &nbsp;<i class="fas fa-caret-down"></i>
                        </span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon theme-button-color">
                            <span class="fa fa-search"></span>&nbsp; Search
                        </span>
                    </div>
                </div>
                <div class="offset-md-2 col-md-2 col-sm-12 col-12">
                    <div class="row justify-content-end first-nav-bar">
                        <div class="move-right margin-5">
                            <label class="unset-margin-bottom">Hello Sign in</label><br/>
                            <label>
                                My Account
                                <i class="fas fa-caret-down theme-secondary-font-color"></i>
                            </label>
                        </div>
                        <div class="vr"></div>
                        <div class="margin-15">
                            <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                        </div> 
                    </div>
                </div>
            </div>
        </div>


