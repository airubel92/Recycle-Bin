<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU RecycleBin | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style">
    <link rel="stylesheet" href="style_custom.css">
    <style>
        /* --- Standard Styles --- */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa; /* Body Background */
        }

        header {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo h1 { font-size: 24px; font-weight: 700; color: #2c3e50; margin: 0; }
        .logo h1 span { color: #27ae60; }
        
        .nav-links { display: flex; list-style: none; gap: 15px; margin: 0; padding: 0; }
        .nav-links a { text-decoration: none; color: #555; font-weight: 500; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover { color: #27ae60; }
        
        .auth-buttons { display: flex; align-items: center; gap: 15px; }

        /* --- Hero Banner with Background Image --- */
        .hero-banner {
            height: 65vh;
            /* আপনার ইমেজটি 'image' ফোল্ডারে 'hero-bg.jpg' নামে রাখুন */
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('image/uiu-campus.jpg'); 
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .hero-text h1 { font-size: clamp(2rem, 5vw, 3.5rem); margin-bottom: 10px; font-weight: 700; }
        .hero-text p { font-size: clamp(1rem, 2vw, 1.2rem); opacity: 0.9; }

        /* --- Body Content --- */
        .main-content { padding: 80px 10%; max-width: 1400px; margin: 0 auto; }
        .row { display: flex; align-items: center; gap: 50px; flex-wrap: wrap; }
        .left-div, .right-div { flex: 1; min-width: 320px; }
        .right-div h1 { color: #e67e22; margin-bottom: 25px; font-size: 2.5rem; }
        .right-div p { margin-bottom: 18px; line-height: 1.6; font-size: 1.1rem; color: #444; }
        .last-tag { text-align: center; margin: 60px 0; color: #2c3e50; font-weight: 600; font-size: 1.5rem; }

        /* --- Footer with Background Image --- */
        footer { 
            /* আপনার ইমেজটি 'image' ফোল্ডারে 'footer-bg.jpg' নামে রাখুন */
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('image/footer-bg.jpg'); 
            background-size: cover;
            background-position: center;
            color: #ecf0f1; 
            padding: 60px 8% 20px; 
            margin-top: 50px; 
        }

        .footer-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; }
        .footer-links ul { list-style: none; padding: 0; }
        .footer-links ul li { margin-bottom: 10px; }
        .footer-links ul li a { color: #bdc3c7; text-decoration: none; transition: 0.3s; }
        .footer-links ul li a:hover { color: #27ae60; padding-left: 5px; }
        .footer-bottom { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 14px; color: #95a5a6; }

        /* Mobile Adjustments (Responsive) */
        @media (max-width: 992px) {
            .navbar { flex-direction: column; gap: 15px; text-align: center; }
            .nav-links { justify-content: center; flex-wrap: wrap; }
            .row { flex-direction: column; }
            .left-div, .right-div { text-align: center; }
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php" style="text-decoration:none;"><h1>UIU <span>RecycleBin</span></h1></a>
        </div>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="sale.php">Marketplace</a></li>
            <li><a href="lost.php">Lost Items</a></li>
            <li><a href="found.php">Found Items</a></li>
            <li><a href="order.php">Products</a></li>
            <li><a href="giveaway.php">Giveaway</a></li>
            <li><a href="safety_tips.php">Safety Tips</a></li>
        </ul>

        <div class="user-control">
            <?php if(isset($_SESSION['valid'])) { ?>
                <div style="background: #fff; padding: 8px 20px; border-radius: 50px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); display: inline-flex; align-items: center; gap: 15px; border: 1px solid #eee;">
                    <span style="font-weight: 600; color: #2c3e50; font-size: 14px;">
                        <i class="fa-solid fa-circle-user" style="color: #27ae60;"></i> 
                        Hi, <?php echo $_SESSION['name']; ?>
                    </span>
                    <div style="width: 1px; height: 18px; background: #ddd;"></div>
                    <a href="dashboard.php" style="text-decoration: none; color: #27ae60; font-weight: 600; font-size: 13px;">Dashboard</a>
                    <a href="logout.php" style="text-decoration: none; color: #e74c3c; font-weight: 600; font-size: 13px;">Logout</a>
                </div>
            <?php } else { ?>
                <div class="auth-buttons">
                    <a href="login.php" style="text-decoration: none; color: #27ae60; font-weight: 600; margin-right: 15px;">Login</a>
                    <a href="register.php" style="background: #27ae60; color: #fff; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-weight: 600;">Register</a>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>

<section class="hero-banner">
    <div class="hero-text">
        <h1>UIU Recycle Bin</h1>
        <p>Sustainable Living & Smart Recycling for UIUians</p>
    </div>
</section>

<div id="About" style="background: linear-gradient(135deg, #f0fff4 0%, #fff5e6 100%); width: 100vw; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%); padding: 80px 0;">
    
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 5%;">
        <div class="row" style="display: flex; align-items: center; gap: 50px; flex-wrap: wrap;">
            
            <div class="left-div" style="flex: 1; min-width: 320px;">
                <img src="photo/Carosol_1.jpg" alt="UIU Campus View" style="width:100%; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
            </div>
            
            <div class="right-div" style="flex: 1; min-width: 320px;">
                <h1 style="color: #e67e22; margin-bottom: 25px; font-size: 2.5rem;">Here You’ll Find-</h1>
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-check-circle" style="color:#27ae60;"></i> A user friendly interface for students to easily list used products.</p>
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-check-circle" style="color:#27ae60;"></i> Browse and search for products at affordable prices.</p>
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-check-circle" style="color:#27ae60;"></i> Promote sustainability and reduce waste by recycling.</p>
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-check-circle" style="color:#27ae60;"></i> Secure user authentication system for safe transactions.</p>
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-check-circle" style="color:#27ae60;"></i> Reliable platform to find lost or found items within campus.</p>
            </div>
        </div>
        
        <h2 class="last-tag" style="text-align: center; margin: 60px 0 0 0; color: #2c3e50; font-weight: 600; font-size: 1.5rem;">
            So Visit Us! Embrace the power of recycling & Having A Good Time.
        </h2>
    </div>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-about">
            <h2>UIU <span>RecycleBin</span></h2>
            <p>Leading the way to a greener campus by empowering students to reuse resources and help each other.</p>
        </div>
        <div class="footer-links">
            <h3>Marketplace</h3>
            <ul>
                <li><a href="sale.php">Shop Now</a></li>
                <li><a href="lost.php">Lost Something?</a></li>
                <li><a href="found.php">Found Something?</a></li>
                <li><a href="order.php">My Purchases</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h3>Contact Info</h3>
            <p style="margin-bottom:10px;"><i class="fa-solid fa-map-marker-alt" style="color:#27ae60; margin-right:10px;"></i> United City, Madani Avenue, Dhaka</p>
            <p style="margin-bottom:10px;"><i class="fa-solid fa-envelope" style="color:#27ae60; margin-right:10px;"></i> support@uiu.ac.bd</p>
            <p><i class="fa-solid fa-phone" style="color:#27ae60; margin-right:10px;"></i> +880 123 456789</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> UIU RecycleBin | For the students, by the students.</p>
    </div>
</footer>

</body>
</html>