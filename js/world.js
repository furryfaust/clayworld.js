var World = function(player, width, height) {
	this.entities = [];
	this.player = player;
	this.width = width;
	this.height = height;
}

World.prototype.spawn = function(entity) {
	this.entities.push(entity);
}

World.prototype.update = function() {
	for (var i = 0; i != this.entities.length; i++) {
		this.entities[i].update(this);
	}
}