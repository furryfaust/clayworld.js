var Entity = function(id, solid, width, height) {
	this.id = id;
	this.x = 0;
	this.y = 0;
	this.width = width;
	this.height = height;
	this.solid = solid;
}

Entity.prototype.update = function(world) {}

var Block = function(id, width, height) {
	Entity.call(this, id, true, width, height);
}

Block.prototype = Object.create(Entity.prototype);

var Player = function(id) {
	Entity.call(this, id, true, 25, 25);
}

Player.prototype = Object.create(Entity.prototype);

/*
	0 - UP
	1 - DOWN
	2 - LEFT
	3 - RIGHT
*/
Player.prototype.canWalk = function(world, direction) {
	var x = this.x;
	var y = this.y;
	var width = this.width;
	var height = this.height;

	switch (direction) {
		case 0:
			y--;
		break;
		case 1:
			y++;
		break;
		case 2:
			x--;
		break;
		case 3:
			x++;
		break;
	}

	if (world.entities.length > 0) {
		for (var i = 0; i != world.entities.length; i++) {
			var entity = world.entities[i];
			if (entity.solid && entity.id != this.id) {
				if (x > entity.x && x < entity.x + entity.width && y > entity.y && y < entity.y + entity.height) {
					return false;
				}
				if (x + width > entity.x && x + width < entity.x + entity.width && y > entity.y && y < entity.y
					+ entity.height) {
					return false;
				}
				if (x > entity.x && x < entity.x + entity.width && y + height > entity.y && y + height < entity.y
					+ entity.height) {
					return false;
				}
				if (x + width > entity.x && x + width < entity.x + entity.width && y + height > entity.y && y +
					height < entity.y + entity.height) {
					return false;
				}
			}
		}
	}

	return true;
}

Player.prototype.walk = function(world, direction) {
	if (this.canWalk(world, direction)) {
		switch (direction) {
			case 0:
				this.y--;
				break;
			case 1:
				this.y++;
				break;
			case 2:
				this.x--;
				break;
			case 3:
				this.x++;
				break;
		}
	}
}