<header>  
  <nav class="navbar navbar-default navbar-expand-md navbar-light bg-white">
    <div class="container">
      <a class="navbar-brand" href="<?php echo ROOTPATH; ?>"><span class="fa fa-user fa-2x"></span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"  aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"><?php echo $l['menu_home']; ?> <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $l['menu_about']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $l['menu_contact']; ?></a>
          </li>
        </ul>
      <ul class="navbar-nav">
        <?php if (!empty($_SESSION['user_id']) && isset($_SESSION['user_id'])) : ?>

          <?php
          echo '<li class="nav-item">';
          echo '<a class="nav-link" href="';
          echo ROOTPATH;
          echo '/users/profile/' . $_SESSION['user_id'] . '">';
          echo $_SESSION['user_name'];
          echo '</a>';
          echo '</li>';

          echo '<li class="nav-item">';
          echo '<a class="nav-link" href="';
          echo ROOTPATH;
          echo '/users/logout">';
          echo 'Logout';
          echo '</a>';
          echo '</li>';
          ?>

        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ROOTPATH; ?>/users/signup"><?php echo $l['signup']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ROOTPATH; ?>/users/login"><?php echo $l['login']; ?></a>
          </li>
        <?php endif; ?>
        <?php if (!empty($_COOKIE['lang']) && isset($_COOKIE['lang'])) : ?>
          <?php if ($_COOKIE['lang'] === 'en') : ?>
            <li class="nav-item">
                <a class="nav-link" href="?lang=ar">العربية</a>
            </li>
            <?php elseif ($_COOKIE['lang'] === 'ar'): ?>
            <li class="nav-item">
                <a class="nav-link" href="?lang=en">English</a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      </div>
    </div>
  </nav>
</header>