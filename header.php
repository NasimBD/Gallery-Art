<div class=" d-flex flex-column align-items-center">
   <div class="brand align-self-start d-flex flex-row justify-content-start align-items-center">
       <a href="index.php" class="text-decoration-none"><img src="../images/dove3.png" alt="" class="" width="80px"></a>
       <h2 id="mainTitle" class=" h1 text-light text-left px-1 px-sm-2 px-md-3">The Dove Gallery</h2>
   </div>
<h1 id="subTitle" class="h4 text-center">Affordable Original Paintings</h1>


<div id="headerMenu" class="btn-group btn-group-sm px-2 px-sm-3 align-self-end">

<?php  $log = (isset($_SESSION['user_levell'])) ? 'Logout' : 'Login'; ?>
<a href="<?=strtolower($log)?>.php" class="loginBtn btn btn-danger btn-sm "><?=$log?></a>


<?php if(!isset($_SESSION['user_levell'])):?>
<a href="register-page.php" class="btn btn-secondary btn-sm">Register</a>
<?php else: ?>
<a href="cart.php" class="btn btn-secondary btn-sm">Cart</a>
<?php  endif; ?>
</div>
</div>
