<!DOCTYPE html>
<html>
<head>
<title> <?php echo $title ?> </title>
<link rel="stylesheet" type="text/css" href= "CSS/standard_css.css"/>
<link rel="stylesheet" type="text/css" href= "<?php echo $css_file ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src= "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"> </script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel="icon" type="image/x-icon" href="favicon.ico">
<script src="https://use.fontawesome.com/145bc8a25f.js"></script>
</head>
<body>


<div id = "nav">
    <div id = "brand_container"> <a href = '#' id = "brand">Slice of Programming</a> </div>
    <div class = "row" id = "desktop_nav">
        <div id = "desktop_links">
        <a href="?page=1" class = "menu_option col-xs-3" id = "home">Home</a>
        <a href="#" class = "menu_option col-xs-3" id = "about">About</a>
        <a href="#" class = "menu_option col-xs-3" id = "contact">Contact</a>
        <a href="#" class = "menu_option col-xs-3" id = "portfolio">Projects</a>
        </div>
        <button id = "expand_menu_button"> <i class="fa fa-angle-double-down fa-2x" aria-hidden="true"> </i> </button>
        <button id = "collapse_menu_button"> <i class="fa fa-angle-double-up fa-2x" aria-hidden="true"> </i> </button>
    </div>    
    <div id = "mobile_nav" class = "hidden">
        <ul>
            <li> <a href="?page=1" class = "menu_option" id = "home">Home</a> </li>
            <li> <a href="#" class = "menu_option" id = "about">About</a> </li>
            <li> <a href="#" class = "menu_option" id = "contact">Contact</a> </li>
            <li> <a href="#" class = "menu_option" id = "portfolio">Projects</a> </li>
            <!--<li> <button id = "collapse_menu_button"> <i class="fa fa-angle-double-up fa-2x" aria-hidden="true"> </i> </button> </li>-->
        </ul>   
    </div>
</div>


<div class = "container-fluid">
    <div id = "main">
        <div id = "subcontainer">


