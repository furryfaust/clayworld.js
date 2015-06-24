<html>
    <head>
        <?php session_start(); ?>
        <title> clayworld.js </title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.3/semantic.min.css" />
        <script src="js/entity.js"> </script>
        <script src="js/world.js"> </script>
        <style>
        canvas[id=world] {
            border-radius: 3px;
            border: 1px solid #dddede;
            position: relative;
            left: 5px;
            top: 5px;
        }

        .ui.form {
            position: relative;
            width: 48%;
            bottom: 695px;
            left: 620px;
        }

        .buttons {
            margin-top: 330px;
        }

        #editor {
            margin-top: 10px;
            position: absolute;
            width: 90%;
            height: 300px;
            border-radius: 3px;
            border: 2px solid #dddede;
        }
        </style>
        <div class="ui secondary pointing menu">
            <a class="item">
                <i class="home icon"></i> home
            </a>
            <a class="item" href="lab.php">
                <i class="lab icon"></i> lab
            </a>
            <a class="item" href="molds.php?query=all">
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
    <script>
        function init() {
            var ratio = (function () {
                var ctx = document.getElementById("world").getContext("2d"),
                dpr = window.devicePixelRatio || 1,
                bsr = ctx.webkitBackingStorePixelRatio ||
                    ctx.mozBackingStorePixelRatio ||
                    ctx.msBackingStorePixelRatio ||
                    ctx.oBackingStorePixelRatio ||
                    ctx.backingStorePixelRatio || 1;
                return dpr / bsr;
            })();

            var canvas = document.getElementById("world");
            canvas.width = 600 * ratio;
            canvas.height = 700 * ratio;
            canvas.style.width = 600 + "px";
            canvas.style.height = 700 + "px";
            canvas.getContext("2d").setTransform(ratio, 0, 0, ratio, 0, 0);
        }
    </script>
    <body onload="init();">
        <div class="ui two column grid">
            <div class="column">
                <canvas id="world"> </canvas>
            </div>
            <div class="column">
                <div id="editor"><?php 
                        if (isset($_SESSION['code'])) {
                            echo htmlspecialchars($_SESSION['code']);
                        } else {
                            echo 'function onInit(world) {} &#13;&#10;function onUpdate(world) {}';
                        }
                    ?></div>
                <div class="buttons">
                    <button class="ui primary button" id="control"><i class="play icon"></i>run</button>
                    <button class="ui primary button" id="share"><i class="github icon"></i>share </button>
                    <button class="ui primary button" id="raw"> raw </button>
                </div>
                <h1>clayworld.js by furryfaust</h1>
                <br>
                <code> Source: https://github.com/furryfaust/clayworld.js </code>
                <br>
            </div>
        </div>
    </body>
    <script src="js/script.js"> </script>
    <script src="js/ace.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("editor");
        editor.$blockScrolling = Infinity;
        editor.setTheme("ace/theme/xcode");
        editor.getSession().setMode("ace/mode/javascript");
        editor.on("blur", function() {
            var save = new XMLHttpRequest();
            save.open("post", "utils/track.php?code=" + encodeURIComponent(editor.getSession().getValue()), false);
            save.send();
        });
        var session = document.getElementById("session");
        session.onclick = function() {
            if (session.innerHTML.includes("log out")) {
                window.location = "utils/logout.php";
            } else {
                window.location = "utils/auth.php?link=" + encodeURIComponent(window.location);
            }
         }
    </script>
</html>