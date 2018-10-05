
<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title"><a href="index.php" style="text-decoration:none; color:White;">R.ECOS</a></span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="mdl-navigation__link" href="index.php">Marketplace</a>
        <!--<a class="mdl-navigation__link" href="how-it-works.php">How it works?</a>-->
        <!--<a class="mdl-navigation__link" href="research.php">Research</a>-->
        <!-- <a class="mdl-navigation__link" href="api-examples.php">API/Examples</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/forums/">Forums</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/helpdesk/">HelpDesk</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/docs/r-ecos/">Docs</a> -->
        <a class="mdl-navigation__link" href="stats-recos.php">Stats</a>
        

        <? if( isset($_SESSION['user_type']) && ( $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1 ) ){ ?>

          <a class="mdl-navigation__link" href="services.php">My Services</a>

        <? }//if ?>



        <? if( isset($_SESSION['user_loged']) && $_SESSION['user_loged'] == true ){ ?>

            <a class="mdl-navigation__link" href="painel.php">My Projects</a>
            <a class="mdl-navigation__link" href="logout.php">Log out</a>

        <? }else { ?>

            
            <a class="mdl-navigation__link " href="painel.php">Log in</a>
            <!-- <a class="mdl-navigation__link " href="signup.php">Sign up</a> -->

        <? }//else ?>

      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">R.ECOS</span>
    <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Marketplace</a>
        <!--<a class="mdl-navigation__link" href="how-it-works.php">How it works?</a>
        <a class="mdl-navigation__link" href="research.php">Research</a>-->
        <!-- <a class="mdl-navigation__link" href="api-examples.php">API/Examples</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/forums/">Forums</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/helpdesk/">HelpDesk</a> -->
        <!-- <a class="mdl-navigation__link" href="http://recos.online/docs/r-ecos/">Docs</a> -->
        <a class="mdl-navigation__link" href="stats-recos.php">Stats</a>
        
        <? if( isset($_SESSION['user_type']) && ( $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1 ) ){ ?>

          <a class="mdl-navigation__link" href="services.php">My Services</a>

        <? }//if ?>

        <? if( isset($_SESSION['user_loged']) && $_SESSION['user_loged'] == true ){ ?>

            <a class="mdl-navigation__link" href="painel.php">My Projects</a>
            <a class="mdl-navigation__link" href="logout.php">Log out</a>

        <? }else { ?>

            
            <a class="mdl-navigation__link " href="painel.php">Log in</a>
            <!-- <a class="mdl-navigation__link " href="signup.php">Sign up</a> -->

        <? } ?>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content">
        <!-- Your content goes here -->