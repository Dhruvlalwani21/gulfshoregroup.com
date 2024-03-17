<nav id="navigation" class="navigation navigation-landscape">
<div class="nav-header">
<div className="brand"><h3>Gulfshore Group</h3></div>
	<div class="nav-toggle"></div>
	<div class="mobile_nav">
		<ul>
            <?php
            if(!isset($_SESSION['user_id'])){
            ?>
			<li><a href="javascript:;" data-toggle="modal" data-target="#login"><i class="fas fa-user-circle fa-lg"></i></a></li>
            <?php
            }else{
            ?>
			<li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i></a></li>
            <?php    
            }
            ?>
		</ul>
	</div>
</div>
<div class="nav-menus-wrapper" style="transition-property: right;">

<div className="tabs">
                <ul>
                    <li>Home</li>
                    <li>About</li>
                    <li>Contact</li>
                    <li>Cities</li>
                    <li>Buy</li>
                    <li>Sell</li>
                </ul>
            </div>
	
	<ul class="nav-menu nav-menu-social align-to-right">
        <?php
        if(!isset($_SESSION['user_id'])){
        ?>
		<li>
			<a href="javascript:;" data-toggle="modal" data-target="#login">
				<i class="fas fa-sign-in-alt mr-1"></i><span class="dn-lg">Sign In</span>
			</a>
		</li>
        <?php
        }else{
        ?>
		<li>
			<a href="logout.php">
				<i class="fas fa-sign-out-alt mr-1"></i><span class="dn-lg">Logout</span>
			</a>
		</li>
        <?php   
        }
        ?>
	</ul>
</div>
</nav>