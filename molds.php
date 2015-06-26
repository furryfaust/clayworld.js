<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
		<?php session_start(); 
		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);
			if (!isset($_GET['query'])) {
				$_GET['query'] = "verified";
			}
			if (!isset($_GET['page'])) {
				$_GET['page'] = "0";
			}
		?>
		<style>

		.ui.vertical.menu {
			position: relative;
			margin-left: 5;
		}

		#molds {
			position: relative;
			margin-top: -177;
			margin-left: 240;
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
		  <a class="item" id="verified">
		    verified molds
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
		<div id="molds">
		<div class="ui four column grid">
		<?php
			$page = intval($_GET['page']) * 20;
			$conn = new PDO('mysql:host=localhost;dbname=clayworld', 'root', 'dbpass');
			$sql = "";
			if ($_GET['query'] == "verified") {
				$sql = "select * from molds where status=2 limit 20 offset :page";
			}
			if ($_GET['query'] == "recent") {
				$sql = "select * from molds order by id desc limit 20 offset :page";
			}
			if ($_GET['query'] == "my") {
				$sql = "select * from molds where user=:user order by id desc limit 20 offset :page";
			}
			$query = $conn->prepare($sql);
			if ($_GET['query'] == "my") {
				$query->bindParam(':user', $_SESSION['user']);
			}
			$query->bindValue(':page', $page, PDO::PARAM_INT);
			$query->execute();
			
			while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
				echo '<div class="column">
      					<div class="ui segment"><div class="ui compact basic teal button" id='
      					. $result['id'] . '>'
      				  		. htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8') . 
      					'</div><br /> by ' . $result['user'] . '</div>
    				 </div>';	
			}
		?>
		</div>
		</div>
		<script>
			var loggedIn = <?php if (isset($_SESSION['token']) { echo 'true'; } else { echo 'false'; }?>;
			<?php echo 'var query = "' . $_GET['query'] . '"' ?>;
			if (query == "verified") document.getElementById("verified").className = "teal active item"; 
			if (query == "recent") document.getElementById("recent").className = "teal active item"; 
			if (query == "my") document.getElementById("my").className = "teal active item"; 
			
			document.getElementById("verified").onclick = function() {
				window.location = "molds.php?query=verified";
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

			var buttons = document.querySelectorAll(".ui.basic.teal.button");      
			for (var i = 0; i != buttons.length; i++) {
				buttons[i].addEventListener("click", function() {
					if (loggedIn) {
						window.location = "lab.php?id=" + this.id;
					} else {
						alert("You must be logged in to view other molds!");
					}
				});
			}  	
		</script>
	</body>
</html>