<html>
	<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
	<style>
		#editor {
		    position: relative;
		    margin-left: 30%;
		    margin-top: 10px;
		    width: 600px;
		    height: 330px;
		    border-radius: 3px;
			border: 2px solid #dddede;
		}
		#action {
			position: relative;
			margin-left: 30%;
			margin-top: 10px;
		}
		#title {
			position: relative;
			margin-left: 30%;
			margin-top: 10px;
		}
	</style>
	<script>
		var isNew = <?php if (isset($_GET['id'])) {
			echo 'false';
		} else {
			echo 'true'; 
		}?>;
	</script>
	<?php session_start();
	if (!isset($_GET['id'])) {
		if (!isset($_SESSION['token'])) {
		    function randStrGen($len) {
		        $result = "";
		        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		        $charArray = str_split($chars);
		        for($i = 0; $i < $len; $i++){
		            $randItem = array_rand($charArray);
		            $result .= "".$charArray[$randItem];
		        }
		    return $result;
		    }
		    $_SESSION['state'] = randStrGen(50);
		    header("Location: https://github.com/login/oauth/authorize?client_id=-&scope=gist&state=" 
		        . $_SESSION['state']);
		    die();
		}
	} else {
		$id = $_GET['id'];

		$PDO = new PDO('mysql:host=localhost;dbname=clayworld', 'root', '-');
		$sql = "select * from molds where user=:user and id=:id";
		$query = $PDO->prepare($sql);
		$query->bindParam(':id', $id);
		$query->bindParam(':user', $_SESSION['user']);
		$query->execute();
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$_SESSION['gid'] = $result['gid'];
		} else {
			echo 'alert("You are not authorized to be here");';
			header("Location: http://furryfaust.com/clayworld/play.php");
			die();
		}
	} ?>
	</head>
	<body>
		<div class="ui input" id="title">
       		<input id="titleinput" type="text" placeholder="title" size="60"/>
        </div>
		<div id="editor"><?php 
            if (isset($_SESSION['code'])) {
                echo htmlspecialchars(urldecode($_SESSION['code']));
            } else {
                echo 'function onInit(world) {} &#13;&#10;function onUpdate(world) {}';
            }
        ?></div>
		<button class="ui primary button" id="action"> share </button>
		<script src="js/ace.min.js" type="text/javascript" charset="utf-8"></script>
    	<script>
	        var editor = ace.edit("editor");
	        editor.$blockScrolling = Infinity;
	        editor.setTheme("ace/theme/xcode");
	        editor.getSession().setMode("ace/mode/javascript");
	        editor.setReadOnly(true);

	        document.getElementById("action").onclick = function() {
	        	if (isNew) {
	        		var share = new XMLHttpRequest();
	        		share.onreadystatechange = function() {
	        			if (share.readyState == 4) {
	        				alert(share.responseText);
	        			}
	        		}
	        		share.open("GET", "utils/share.php?title=" + document.getElementById("titleinput").value
	        			+ "&code=" + encodeURIComponent(editor.getSession().getValue()), true);
	        		share.send();
	        	} else {
	        		var update = new XMLHttpRequest();

	        		update.onreadystatechange = function() {
	        			if (share.readyState == 4) {

	        			}
	        		}
	        		update.open("GET", "utils/udate.php?title", false);
	        		update.send();
	        	}
	        }
    	</script>
	</body>
</html>