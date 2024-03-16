<nav id="navigation" class="navigation navigation-landscape">
<div class="nav-header">
    <?php
    if($itsHome && $itsHome == 'Yes'){
    ?>
    <a class="nav-brand static-logo" href="/"><img src="<?php echo WEBLOGO;?>" class="logo" alt="" /></a>
    <?php
    }else{
    ?>
    <a class="nav-brand static-logo" href="/"><img src="<?php echo WEBLOGOALT;?>" class="logo" alt="" /></a>
    <?php
    }
    ?>
	<a class="nav-brand fixed-logo" href="/"><img src="<?php echo WEBLOGOALT;?>" class="logo" style="max-height: 40px;" alt="" /></a>
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
	<ul class="nav-menu">
	
		<li class=""><a href="/">Home</a></li>
		<li><a href="buy">Buy</a></li>
		<li><a href="sell">Sell</a></li>
		<li><a href="mls-search">MLS Search</a></li>
        <?php
        $selCity = "SELECT * FROM cities WHERE city_id!='' ORDER BY name ASC";  
        $cityRslts = mysqli_query($conn,$selCity);  
        $noNavCity = mysqli_num_rows($cityRslts);
        $cityData = $cityRslts->fetch_all(MYSQLI_ASSOC);
                       
        if($noNavCity>0){
        ?>
	    <li><a href="javascript:;" id="nav_top_city" onclick="slideSubMenu(this.id)">Top Cities<span class="submenu-indicator"></span></a>
			<ul class="nav-dropdown nav-submenu"> 
            <?php
            foreach ($cityData as $row){
            $nav_city_name = $row['name'];
            $nav_city_slug = $row['slug'];
            ?>
    		<li><a href="city/<?php echo $nav_city_slug;?>"><?php echo $nav_city_name;?></a></li>
            <?php
            }
            ?>
			</ul>
		</li>
        <?php
        }
        
        if(isset($_SESSION['user_id'])){
        ?>
		<li class=""><a href="settings">Settings</a></li>
        <li><a href="favorites/1">Favorites <span class="fright">(<span id="favorites_counts"><?php echo $favorites;?></span>)</span></a></li>
        <?php
        }
        ?>
		<li><a href="about-us">About Us</a></li>
		<li><a href="contact-us">Contact Us</a></li>
		
	</ul>
	
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