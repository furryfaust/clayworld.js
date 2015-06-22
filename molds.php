<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
		<?php session_start(); ?>
		<style>

		.ui.vertical.menu {
			position: relative;
			margin-left: 2%;
		}

		</style>
		<div class="ui secondary pointing menu">
            <a class="item">
                <i class="home icon"></i> home
            </a>
            <a class="item" href="lab.php">
                <i class="lab icon"></i> lab
            </a>
            <a class="item" href="molds.php">
                <i class="circle icon"></i> molds
            </a>
            <div class="right menu">
                <a class="item" id="session">
                    <i class="user icon"></i> 
                    <?php
                        if (isset($_SESSION['token'])) {
                            echo 'log out';
                        } else {
                            echo 'sign in';
                        }
                    ?>
                </a>
            </div>
        </div>
	</head>
	<body>
		<div class="ui vertical menu">
		  <a class="active teal item">
		    All
		  </a>
		  <a class="item">
		    Verified
		  </a>
		  <a class="item">
		    Unverified
		  </a>
		  <div class="item">
		    <div class="ui transparent icon input">
		      <input type="text" placeholder="Search molds...">
		      <i class="search icon"></i>
		    </div>
		  </div>
		</div>
	</body>
</html>