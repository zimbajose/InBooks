<!DOCTYPE html>
<!--
Credits to the man <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:12px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@alfonsmc10?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Alfons Morales"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:12px;width:auto;position:relative;vertical-align:middle;top:-1px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M20.8 18.1c0 2.7-2.2 4.8-4.8 4.8s-4.8-2.1-4.8-4.8c0-2.7 2.2-4.8 4.8-4.8 2.7.1 4.8 2.2 4.8 4.8zm11.2-7.4v14.9c0 2.3-1.9 4.3-4.3 4.3h-23.4c-2.4 0-4.3-1.9-4.3-4.3v-15c0-2.3 1.9-4.3 4.3-4.3h3.7l.8-2.3c.4-1.1 1.7-2 2.9-2h8.6c1.2 0 2.5.9 2.9 2l.8 2.4h3.7c2.4 0 4.3 1.9 4.3 4.3zm-8.6 7.5c0-4.1-3.3-7.5-7.5-7.5-4.1 0-7.5 3.4-7.5 7.5s3.3 7.5 7.5 7.5c4.2-.1 7.5-3.4 7.5-7.5z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Alfons Morales</span></a>
-->
<html>
    <head>
        <?php
        session_start();
        //Import codes
        foreach (glob("model/*.php") as $filename) {
            include_once $filename;
        }
        foreach (glob('view/*.php') as $filename) {
            include_once $filename;
        }
        //require 'controller.php';
        require 'lib/conexao.php';
        ?>
        


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <title>Livros Interativos</title>
        <script src="lib/JQuery.js"></script>
        <script src="lib/Materialize/js/materialize.js"></script>
        <link rel = "stylesheet" href="lib/Materialize/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="template/css/main.css">
    </head>
    <body>
        <?php
        $page = filter_input(INPUT_GET, 'page');
        switch ($page) {
            case'cebook':
                require 'template/createbook.php';
                break;
            case 'rebook':
                require 'template/readbook.php';
                break;
            case'registerpage':
                require'template/register.php';
                break;
            case'loginpage':
                require 'template/login.php';
                break;
            case 'booklist':
                require 'template/ibooklist.php';
                break;
            case 'profile':
                require 'template/profile.php';
                break;
            default:
                if(isset($_SESSION['userid'])){
                    require 'template/home.php';
                }
                else{
                    require 'template/landingpage.php';
                }
                break;
        }
        ?>
    </body>
</html>
