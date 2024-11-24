<?php 
    include("../includes/nav.php"); 
    require '../src/Database.php';

    
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | Agencia de Viajes</title>
    <link rel="stylesheet" href="../assets/CSS/cssabout.css"/>
    <link rel="stylesheet" href="../assets/CSS/style.css"/>
</head>
<body>
    <!-- Header -->
    

    <!-- Hero Section -->
    <section class="hero2 about-hero">
        <div class="container">
            <h1>Conoce Más Sobre Nuestra Agencia</h1>
            <p>Viajar es más que un destino, es una experiencia que transforma. En nuestra agencia, hacemos que cada viaje sea inolvidable.</p>
        </div>
    </section>

    <!-- Nuestra Historia -->
    <section class="about">
        <div class="container">
            <h2>Nuestra Historia</h2>
            <p>
                Fundada en 2005, nuestra agencia de viajes comenzó con un simple sueño: conectar a las personas con el mundo. 
                Desde humildes comienzos, hemos crecido para convertirnos en una de las principales agencias del país, ofreciendo 
                experiencias de viaje únicas y personalizadas.
            </p>
            <img src="../assets/images/portadaabout.png" alt="Viajeros explorando un destino exótico" class="about-img">
        </div>
    </section>

    <!-- Misión, Visión y Valores -->
    <section class="values">
        <div class="container">
            <div class="value">
                <h3>Misión</h3>
                <p>Proporcionar a nuestros clientes experiencias de viaje inolvidables, diseñadas con cuidado y atención a cada detalle.</p>
            </div>
            <div class="value">
                <h3>Visión</h3>
                <p>Ser la agencia de viajes líder a nivel internacional, reconocida por nuestro servicio excepcional y nuestra pasión por explorar.</p>
            </div>
            <div class="value">
                <h3>Valores</h3>
                <ul>
                    <li>Compromiso</li>
                    <li>Innovación</li>
                    <li>Calidad</li>
                    <li>Confianza</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Equipo -->
    <section class="team">
        <div class="container">
            <h2>Conoce a Nuestro Equipo</h2>
            <div class="team-member">
                <img src="assets/images/team1.jpg" alt="María López, CEO" class="team-img">
                <h3>Enedina Ortega</h3>
                <p>CEO y Fundadora</p>
            </div>
            <div class="team-member">
                <img src="assets/images/team2.jpg" alt="Carlos Rodríguez, Gerente de Operaciones" class="team-img">
                <h3>Allan De Roux</h3>
                <p>Gerente de Operaciones</p>
            </div>
            <div class="team-member">
                <img src="assets/images/team3.jpg" alt="Laura Gómez, Experta en Destinos" class="team-img">
                <h3>Laura Gómez</h3>
                <p>Experta en Destinos</p>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonials">
        <div class="container">
            <h2>Lo Que Dicen Nuestros Clientes</h2>
            <blockquote>
                "Gracias a esta agencia, nuestro viaje a París fue increíble. Cada detalle estuvo perfectamente organizado. ¡Volveremos a viajar con ellos!"
                <cite>- Ana Martínez</cite>
            </blockquote>
            <blockquote>
                "La atención personalizada y la pasión de este equipo hicieron que nuestra luna de miel fuera inolvidable. ¡Altamente recomendado!"
                <cite>- Luis y Andrea Gómez</cite>
            </blockquote>
        </div>
    </section>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>

