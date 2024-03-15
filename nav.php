  <nav>
            <div className="brand"><h3>Gulfshore Group</h3></div>
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
            <div className="icons">
            <?php
        if(!isset($_SESSION['user_id'])){
        ?>
         <a href="logout.php"><span>Sign In</span></a>
            <?php
            }else{
            ?>
              <i class="fa-regular fa-user"></i>
			<a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i></a>
            <?php    
            }
            ?>
            </div>
 </nav>