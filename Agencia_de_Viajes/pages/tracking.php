<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Page</title>
    <link rel="stylesheet" href="../assets/CSS/style.css"/>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Barra de navegación para la página de tracking */
        #navTracking {
            background-color: #00796b; /* Cambia el color para que sea distintivo */
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Añade una sombra sutil */
        }

        #navTracking .containerNavTracking {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1000px;
            margin: auto;
            padding: 0 20px;
        }

        #navTracking h1 {
            color: #fff;
            font-size: 1.8em;
            margin: 0;
        }

        #navTracking .button {
            background-color: #ff5252;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        #navTracking .button:hover {
            background-color: #e53935;
        }

        /* Ajustes responsivos */
        @media (max-width: 600px) {
            #navTracking .containerNavTracking {
                flex-direction: column;
            }

            #navTracking h1 {
                margin-bottom: 10px;
                font-size: 1.5em;
            }

            #navTracking .button {
                padding: 8px 15px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <nav id="navTracking">
        <div class="containerNavTracking">
            <h1>Bienvenido!</h1>
            <a href="logout.php" class="button">Cerrar sesión</a>
        </div>
    </nav>
</body>
</html>
