<div class="site-header">
    <div class="container">
        <a class="nav-home" id="branding">
            <img src="dummy/Logo.png" alt="" class="logo">
            <div class="logo-text">
                <h1 class="site-title">HCMG</h1>
                <small class="site-description">Ho Chi Minh Gaming laptop store</small>
            </div>
        </a> <!-- #branding -->

        <div class="right-section pull-right">
            <div id="panel-user" class="hidden">
                <a href="cart.html" class="cart"><i class="icon-cart"></i> <?php echo $_SESSION['cartNum']?> items in cart</a>
                <a href="#"><span class="icon-knight" data-placeholder="&#xe82a;"></span> <?php echo $_SESSION['User_name'];?></a>
                <a href="#" id="btn-logOut">Logout</a>
                <span id="locator"></span>
            </div>
            <div id="panel-guest">
                <a href="sign-in.html" class="login-button">Sign in</a>
                <a href="sign-up.html" class="login-button">Sign up</a>
            </div>
        </div> <!-- .right-section -->

        <div class="main-navigation">
            <button class="toggle-menu"><i class="fa fa-bars"></i></button>
            <ul class="menu">
                <li class="menu-item home current-menu-item"><a href="index.html"><i class="icon-home"></i></a>
                </li>
                <li class="menu-item"><a href="products.html">PC Game</a></li>
                <li class="menu-item"><a href="products.html">About us</a></li>
                <li class="menu-item"><a href="products.html">Game News</a></li>
                <li class="menu-item"><a href="products.html">Refund</a></li>
            </ul> <!-- .menu -->
            <div class="mobile-navigation"></div> <!-- .mobile-navigation -->
        </div> <!-- .main-navigation -->
    </div> <!-- .container -->
</div> <!-- .site-header -->