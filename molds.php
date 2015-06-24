<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
		<?php session_start(); ?>
		<style>

		.ui.vertical.menu {
			position: relative;
			margin-left: 1%;
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
        <div class="ui vertical menu">
		  <a class="item" id="all">
		    all molds
		  </a>
		  <a class="item" id="recent">
		    recent molds
		  </a>
		  <a class="item" id="my">
		    my molds
		  </a>
		  <div class="item">
		    <div class="ui transparent icon input">
		      <input type="text" placeholder="Search molds...">
		      <i class="search icon"></i>
		    </div>
		  </div>
		</div>
	</head>
	<body>
		<script>
			<?php echo 'var query = "' . $_GET['query'] . '"' ?>;
			if (query == "all") document.getElementById("all").className = "teal active item"; 
			if (query == "recent") document.getElementById("recent").className = "teal active item"; 
			if (query == "my") document.getElementById("my").className = "teal active item"; 
			
			document.getElementById("all").onclick = function() {
				window.location = "molds.php?query=all";
			}
			document.getElementById("recent").onclick = function() {
				window.location = "molds.php?query=recent";
			}
			document.getElementById("my").onclick = function() {
				window.location = "molds.php?query=my";
			}

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