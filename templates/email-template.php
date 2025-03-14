<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notification de publication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            font-size: 16px;
            background: #0073aa;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouvel article publié !</h1>
        <p><?php echo nl2br(esc_html($content)); ?></p>
        <p><a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="button">Lire l'article</a></p>
    </div>
</body>
</html>
