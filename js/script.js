var processor;
var control = document.getElementById("control");
control.onclick = function() {
	if (control.innerHTML == " run ") {
		var canvas = document.getElementById("world");
		var ctx = canvas.getContext("2d");
		var player = new Player(0);
		player.x = 0;
		player.y = 0;
		var world = new World(player, canvas.width, canvas.height);
		eval(editor.getSession().getValue());
		onInit(world);
		processor = setInterval(function() {
			ctx.fillStyle="#FFFFFF";
			ctx.fillRect(0, 0, canvas.width, canvas.height);
			ctx.fillStyle="#000000";
			ctx.fillRect(world.player.x, world.player.y, world.player.width, world.player.height);
			ctx.fillStyle="#e88888";
			for (var i = 0; i != world.entities.length; i++) {
				var entity = world.entities[i];
				ctx.fillRect(entity.x, entity.y, entity.width, entity.height);
			}
			world.update();
			onUpdate(world);
		} , 1);
		control.innerHTML = " stop ";
	} else if (control.innerHTML == " stop ") {
		control.innerHTML = " run ";
		clearInterval(processor);
	}
}

document.getElementById("share").onclick = function() {
	window.location = "mold.php";
}

document.getElementById("raw").onclick = function() {
	window.open('data:text/js,' + encodeURIComponent(editor.getSession().getValue()));
}