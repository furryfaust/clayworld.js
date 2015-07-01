<html>
	<head>
		<?php session_start(); ?>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
		<div class="ui secondary pointing menu">
            <a class="item" href="index.php">
                <i class="home icon"></i> home
            </a>
            <a class="item" href="lab.php">
                <i class="lab icon"></i> lab
            </a>
            <a class="item" href="molds.php">
                <i class="circle icon"></i> molds
            </a>
            <a class="item" href="documentation.php">
              <i class="file image outline icon"></i> documentation
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
	<script>
		var session = document.getElementById("session");
        session.onclick = function() {
            if (session.innerHTML.includes("log out")) {
                window.location = "utils/logout.php";
            } else {
                window.location = "utils/auth.php?link=" + encodeURIComponent(window.location);
            }
         }
	</script>
	</body>

</html>