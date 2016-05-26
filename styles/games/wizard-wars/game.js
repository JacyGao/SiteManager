/*
	Wizard Wars
	(C) Mark Wilcox 
	More games at www.spacemonsters.co.uk
*/

var GAMETITLE = "WIZARDWARS";
var SCOREFONT = "Arial, Sans-Serif";
var IPHONEHACK = true;
var ISPORTRAIT = true;

var GAMEWIDTH = 320;
var GAMEHEIGHT = 480;
var GAMEMODE = "PORTRAIT";
var DEFAULTFONTSIZE = 18;
var SCOREFONTSCALE = 1.1;
var CREDITSSCALE = 0.8;
var SCREENROTATIONBANNER = false;

/* ===================================== */
/*				ADVERTISING				 */
/* ===================================== */
var ADVERTS		= false;
var PARTNERSPLIT = 0;
var PARTNERURL = "";

function setAdverts(show,pick)
{
	if (!ADVERTS) return;
	if (show)
	{
		g.banad.style.display = "block";
	} else {
		g.banad.style.display = "none";
	}
	if (pick)
	{
		pickAdURL();
	}
};

var g = {}; // Define the global namespace.
g.characterset = new Image(); g.characterset.src = "library/characterset.gif";
var m = { // Game media namespace.
	spritesheets : [],
	player : null,
	monster : [],
	numbers : null,
	explosion : [],
	playermissile : [],
	spark : [],
	entity : [],
	marker : [],
	chest : [],
	zoltar : []
};

var gameaudio = []; 

g.checkSum = gamedata.imageFiles.length; // + gamedata.audioFiles.length;
g.checkCount = 0;
g.imageData = [];
g.audioData = [];

g.loadingImage = new Image(); g.loadingImage.src = "library/loading.gif";


function createSprites()
{
	// Load game media
	for (var a=0;a<imglib.length;a++)
	{
		m.spritesheets[imglib[a].sheetname] = new spritesheet(imglib[a]);
	}
	g.titlescreen = new Image(); g.titlescreen.src = g.imageData[0].src; // Always the first one.
	g.gamebackdrops = [];
	g.gamebackdrops[0] = new Image(); g.gamebackdrops[0].src = "library/gamebackdrop.png";
	g.wizardicon = new Image(); g.wizardicon.src = "library/wizardicon.png";
	g.walltops = new Image(); g.walltops.src = "library/walltops.png";
	g.staricon = new Image(); g.staricon.src = "library/staricon.png";
	g.gameover = new Image(); g.gameover.src = "library/gameover.png";
	g.levelicon = new Image(); g.levelicon.src = "library/level.png";
	g.hiscore = new Image(); g.hiscore.src = "library/hiscore.png";
	g.levelcomplete = new Image(); g.levelcomplete.src = "library/levelcomplete.png";
	g.playpause = new Image(); g.playpause.src = "library/playpause.png";
	g.pregame = new Image(); g.pregame.src = "library/pregame.png";
	g.volumecontrol = new Image(); g.volumecontrol.src = "library/volumecontrols.png";
	g.splash = new Image(); g.splash.src = "library/splash.png";

	m.player = new sprite("player", "player", m.spritesheets["playersheet"], 0, 0, 8, 4, 1);
	m.numbers = new sprite("numbers", "numbers", m.spritesheets["numberssheet"], 0, 0, 0, 0, 1);
	for (var a=0;a<5;a++) m.monster[a] = new sprite("monster"+a, "monster", m.spritesheets["monstersheet"], 0, 0, 2, 0, 0);
	for (var a=0;a<1;a++) m.zoltar[a] = new sprite("zoltar"+a, "zoltar", m.spritesheets["zoltarsheet"], 0, 0, 2, 0, 0);
	for (var a=0;a<8;a++) m.explosion[a] = new sprite("explosion"+a, "explosion", m.spritesheets["explosionsheet"], 0, 0, 2, 0, 0);
	for (var a=0;a<80;a++) m.entity[a] = new sprite("entity"+a, "entity", m.spritesheets["entitysheet"], 0, 0, 0, 0, 0);
	for (var a=0;a<40;a++) m.spark[a] = new sprite("spark"+a, "spark", m.spritesheets["sparksheet"], 0, 0, 2, 0, 0);
	for (var a=0;a<10;a++) m.marker[a] = new sprite("marker"+a, "marker", m.spritesheets["markersheet"], 0, 0, 0, 0, 0);
	for (var a=0;a<10;a++) m.playermissile[a] = new sprite("playermissile"+a, "playermissile", m.spritesheets["playermissilesheet"], 0, 0, 8, 0, 0);

	initTouch();
	initHiScore();
	setSplash();

	g.ticker = setTimeout("loop()", 0);
};

function rnd(threshold)
{
	return Math.floor(Math.random()*threshold) + 1;
};

function preCache() {
	for (var a=0;a<gamedata.imageFiles.length;a++)
	{
		g.imageData[a] = new Image();
		g.imageData[a].src = gamedata.imageFiles[a];
		g.imageData[a].onload = check;
	}
};

function check() {
	g.checkCount ++;
	var pc = Math.round((g.checkCount / g.checkSum) * 100);
	var bar = Math.round(g.canvaswidth * (pc / 100));
	g.ctx.clearRect(140,150,32,16);
	g.ctx.fillStyle = "rgb(16,16,16)";
	g.ctx.fillRect(0,200,g.canvaswidth,16);
	g.ctx.fillStyle = "rgb(80,80,80)";
	g.ctx.fillRect(0,200,bar,16);
	if (g.checkCount >= g.checkSum)
	{
		createSprites();
	}
};


function rnd(threshold)
{
	return Math.floor(Math.random()*threshold) + 1;
};

function init()
{
	try
	{
		g.canvas = document.querySelector('canvas');
		g.ctx = g.canvas.getContext('2d');
		g.canvas.setAttribute('class', 'canvas');

		g.ori = 0;

		g.banad = document.getElementById("banad");

		g.nextthink = 0;

		g.console = document.getElementById('console');
		g.console.style.display = 'none';
		g.console.style.textAlign = 'left';
		write("Console ready.");
		BrowserDetect.init();
		write("Browser: " + BrowserDetect.browser + " " + BrowserDetect.version);
		write("OS: " + BrowserDetect.OS);
		
		g.orientate = document.getElementById("orientate");
		g.game = document.getElementById("game");

		var br = new String(BrowserDetect.OS);
		g.framedelay = 30;
		g.ISIPHONE = false;
		if (br.indexOf("iPhone") != -1)
		{
			//if (IPHONEHACK) { g.framedelay = 0; }
			g.ISIPHONE = true;
		}

		setAdverts(false,true);

		g.pausemode = 0;
		g.audiomode = 1;
		preCache();

		scale();
	}
	catch (e)
	{
		write(e.message);
	}
};

function scale()
{
	sizeHandler();
};

function sizeHandler () {

	if (!document.getElementById('game'))
	{
		return;
	}

	g.gamecanvas = document.getElementById('game');

	window.setTimeout(function() {
		window.scrollTo(0, 1);

		var rw = GAMEWIDTH;
		var rh = GAMEHEIGHT;
		var w = window.innerWidth;
		var h = window.innerHeight;

		g.factorx = w / rw;
		g.factory = h / rh;

		var multiplier = Math.min((h / rh), (w / rw));
		var actualCanvasWidth = rw * multiplier;
		var actualCanvasHeight = rh * multiplier;

		g.canvaswidth = rw;
		g.canvasheight = rh;
		g.canvas.width = g.canvaswidth;
		g.canvas.height = g.canvasheight;

		g.canvaspadding = 32;
		g.displaypadding = 0;

		g.textcentre = g.canvaswidth / 2;
		g.canvascentre = g.canvasheight / 2;
		g.horizon = g.canvasheight / 2;

		g.widthratio = w / g.canvaswidth;
		g.heightratio = h / g.canvasheight;

		if (w > h)
		{
			document.getElementById('orientate').style.display = "none";
			g.gamecanvas.style.display = "block";
			g.gamecanvas.style.width = actualCanvasWidth + "px";
			g.gamecanvas.style.height = actualCanvasHeight + "px";
			g.gamecanvas.style.position = "relative";
			g.gamecanvas.style.margin = "0px auto 0px auto";
		}
		else
		{
			if (w == 320)
			{
				multiplier = 1;
				document.getElementById('orientate').style.display = "none";
				g.gamecanvas.style.display = "block";
				g.gamecanvas.style.width = "320px";
				g.gamecanvas.style.height = "480px";
				g.gamecanvas.style.position = "absolute";
				g.gamecanvas.style.left = "0px";
				g.gamecanvas.style.top = "0px";
			}
			else if (w > 320)
			{
				document.getElementById('orientate').style.display = "none";
				g.gamecanvas.style.display = "block";
				g.gamecanvas.style.width = actualCanvasWidth + "px";
				g.gamecanvas.style.height = actualCanvasHeight + "px";
				g.gamecanvas.style.position = "relative";
				g.gamecanvas.style.margin = "0px auto 0px auto";
			}
		}
	}, 1000);

};

window.addEventListener('resize', function(evt) { sizeHandler(); }, false);
window.addEventListener('orientationchange', function(evt) { sizeHandler(); }, false);

function initTouch()
{
	if(checkForTouch()) {
		if (document.body.addEventListener)
		{
			document.body.addEventListener('touchmove', touchMove, false);
			document.body.addEventListener('touchstart', touchStart, false);
		} else {
			window.addEventListener('touchmove', touchMove, false);
			window.addEventListener('touchstart', touchStart, false);
		}
	} else {
		window.addEventListener('mousemove', mouseMove, false);
		window.addEventListener('mouseup', mouseUp, false);
		write("No touch capability.");
	}
};

function initHiScore()
{
	m.player.hiscore = 0;
	if (typeof localStorage.key == "function")
	{
		if (localStorage.getItem(GAMETITLE + "-hiscore") != null)
		{
			m.player.hiscore = localStorage.getItem(GAMETITLE + "-hiscore");
		}
	}
};

function sfx(o)
{
	if (g.audiomode > 0)
	{
		o.play();
	}
};

function handleAudio()
{
	if (g.audiomode < 1)
	{
		soundManager.pauseAll();
	} else {
		soundManager.resumeAll();
	}
};

function checkForTouch() {		
	var d = document.createElement("div");
	d.setAttribute("ontouchmove", "return;");
	return typeof d.ontouchmove == "function" ? true : false;
};

function touch(event) {
	try
	{
		if (g.mode == "title") setGame();
		if (g.mode == "pregame" && g.resetting < 50) { setLevel(); g.mode = "levelup"; }
		var o = m.player;
		var tx = (event.pageX) / g.factorx;// - (g.canvas.offsetParent ? g.canvas.parentNode.offsetLeft : 0)) - (o.w / 2);
		var ty = (event.pageY) / g.factory;// - (g.canvas.offsetParent ? g.canvas.parentNode.offsetTop : 0)) - (o.h / 2);

		if (tx < 32 && ty < 32) g.pausemode ++; if (g.pausemode > 1) g.pausemode = 0;
		//if (tx < 64 && ty < 80)
		//{
		//	g.audiomode ++; if (g.audiomode > 1) g.audiomode = 0;
		//	handleAudio();
		//}

		if (ty > (g.canvasheight - 20)) ty = g.canvasheight - 20;
		if (g.pausemode < 1)
		{
			o.targetx = tx;
			o.targety = ty;
			spawnMarker(tx+8,ty+8);
		}
	}
	catch (e)
	{
		write("TouchError: " + e.message);
	}

};

function touchStart(event) {
	touch(event.touches[0]);
	window.scrollTo(0, 1);
	event.preventDefault();
};

function touchMove(event) {
	touch(event.touches[0]);
};

function mouseMove(event) {
	touch(event);
};

function mouseUp(event) {
};

function setSplash()
{
	g.mode = "splash";
	g.resetting = 100;
	setAdverts(false,false);
};

function setTitle()
{
	g.mode = "title";
	g.resetting = 60;
	setAdverts(true,false);
};

function setGame()
{
	setAdverts(false,false);
	g.mode = "pregame";
	m.player.score = 0;
	m.player.targetscore = 0;
	m.player.lives = 3;
	g.level = 1;
	g.resetting = 120;
	g.time = new Date();
	//sfx(gameaudio["titlemusic"]);
};

function setLevel()
{
	g.mode = "levelup";
	wipe(true);
	g.resetting = 50;
};

function setLandscape()
{
	g.oldmode = g.mode;
	g.mode = "landscape";
};

function playerStart()
{
	m.player.x = g.canvaswidth / 2 - (m.player.w / 2);
	m.player.y = g.canvasheight / 2 - (m.player.h / 2) - 64;
	m.player.targetx = m.player.x;
	m.player.targety = m.player.y;
	m.player.health = 100;
	m.player.stars = 0;
	m.player.magicpower = 0;
	m.player.row = 0;
};

function wipe(doentities)
{
	for (var a=0;a<m.monster.length;a++) m.monster[a].visible = false;
	for (var a=0;a<m.zoltar.length;a++) m.zoltar[a].visible = false;
	if (doentities) for (var a=0;a<m.entity.length;a++) { m.entity[a].visible = false; m.entity[a].x = -32; m.entity[a].y = -32; }
};

function playerDeath()
{
	m.player.dying = 40;
	wipe(true);
	m.player.lives --;
};

/* -- Game control routines -- */

function drawPlayer(o)
{
	if (!o.visible) return;
	if (o.magicpower > 0) { o.magicpower --; o.row = 1; } else { o.row = 0; }
	try
	{
		if (isNaN(o.attacking)) o.attacking = 0;
		if (o.attacking > 0)
		{
			o.attacking --;
			o.frame = o.spritesheet.attackframe;
		} else {
			g.ctx.save();
			if (o.dying > 0)
			{
				o.angle += 45; if (o.angle > 360) o.angle = 0;
				g.ctx.translate(o.x + (o.w/2),o.y + (o.h/2));
				//gl.ctx.clearRect(0-(o.w),0-(o.h),o.w*2,o.h*2);
				g.ctx.rotate(o.angle * (Math.PI / 180));
				g.ctx.drawImage(o.spritesheet.image, o.frame * o.spritesheet.framewidth, 0, o.w, o.h, -o.w/2, -o.h/2, o.w, o.h);
				o.dying --;
				if (o.dying < 1)
				{
					if (m.player.lives < 1)
					{
						setAdverts(true,false);
						g.mode = "gameover";
						g.resetting = 100;
						g.time = new Date() - g.time;
					} else {
						setLevel();
					}
				}
			} else {
				if (o.targetx < 0 && o.targety < 0) getDirection(o);
				if (isNaN(o.frame)) o.frame = o.startframe;
				o.framedelay --;
				if (o.framedelay < 0)
				{
					o.framedelay = o.framedelaymax;
					o.frame ++;
					if (o.frame >= (o.startframe + o.spritesheet.framesperdirection))
					{
						o.frame = o.startframe;
					}
					if (o.magicpower > 0 && o.magicpower < 50)
					{
						o.row ++; if (o.row > 1) o.row = 0;
					}
				}
				if (o.inpain) { o.frame = o.spritesheet.painframe; o.inpain = false; }

				g.ctx.drawImage(o.spritesheet.image, o.frame * o.spritesheet.framewidth, o.row * o.spritesheet.frameheight, o.w, o.h, o.x, o.y, o.w, o.h);
			}
			g.ctx.restore();
		}
	}
	catch (e)
	{
		write(o.frame + " - " + e.message);
	}

};

function draw(o)
{
	if (!o.visible) return;
	try
	{

		if (isNaN(o.attacking)) o.attacking = 0;
		if (o.attacking > 0)
		{
			o.attacking --;
			o.frame = o.spritesheet.attackframe;
		} else {
			if (isNaN(o.frame)) o.frame = o.startframe;
			o.framedelay --;
			if (o.framedelay < 0)
			{
				o.framedelay = o.framedelaymax;
				o.frame ++;
				if (o.frame >= (o.startframe + o.spritesheet.framesperdirection))
				{
					if (o.spritesheet.type == "explosion" || o.spritesheet.type == "marker")
					{
						remove(o);
					} else {
						o.frame = o.startframe;
					}
				}
			}
			if (o.inpain) { o.frame = o.spritesheet.painframe; o.inpain = false; }
		}
		g.ctx.save();
		g.ctx.drawImage(o.spritesheet.image, o.frame * o.spritesheet.framewidth, o.row * o.spritesheet.frameheight, o.w, o.h, o.x, o.y, o.w, o.h);
		g.ctx.restore();
	}
	catch (e)
	{
		write(o.row + " - " + o.spritesheet.type + ", " + o.frame + " - " + o.w + "x" + o.h + ", " + o.x + ", " + o.y + " :: " + e.message);
	}

};

function getDirection(o)
{
	o.direction = -1;
	if (o.moveup)
	{
		o.direction = 0; o.angle = 0; o.startframe = 4;
		if (o.moveleft) { o.direction = 7; o.angle = 315; o.startframe = 4; }
		if (o.moveright) { o.direction = 1; o.angle = 45; o.startframe = 4; }
	}
	if (o.movedown)
	{
		o.direction = 4; o.angle = 180; o.startframe = 6;
		if (o.moveleft) { o.direction = 5; o.angle = 225; o.startframe = 6; }
		if (o.moveright) { o.direction = 3; o.angle = 135; o.startframe = 6; }
	}
	if (o.moveleft)
	{
		o.direction = 6; o.angle = 270; o.startframe = 2;
		if (o.moveup) { o.direction = 7; o.angle = 315; o.startframe = 4; }
		if (o.movedown) { o.direction = 5; o.angle = 225; o.startframe = 6; }
	}
	if (o.moveright)
	{
		o.direction = 2; o.angle = 90; o.startframe = 0;
		if (o.moveup) { o.direction = 1; o.angle = 45; o.startframe = 4; }
		if (o.movedown) { o.direction = 3; o.angle = 135; o.startframe = 6; }
	}

	if (o.direction >= 0) o.lastdirection = o.direction;
};

function moveToTarget(o)
{
	if (!o.visible || o.dead || g.pausemode > 0) return;

	o.oldx = o.x;
	o.oldy = o.y;

	if (o.targetx < 0 && o.targety < 0)
	{
		switch (o.direction)
		{
		case 0:
			o.y -= o.speed;
			break;			
		case 1:
			o.y -= (o.speed / 1.5);
			o.x += (o.speed / 1.5);
			break;			
		case 2:
			o.x += o.speed;
			break;			
		case 3:
			o.y += (o.speed / 1.5);
			o.x += (o.speed / 1.5);
			break;			
		case 4:
			o.y += o.speed;
			break;			
		case 5:
			o.y += (o.speed / 1.5);
			o.x -= (o.speed / 1.5);
			break;			
		case 6:
			o.x -= o.speed;
			break;			
		case 7:
			o.y -= (o.speed / 1.5);
			o.x -= (o.speed / 1.5);
			break;			
		}
	} else {
		if (o.spritesheet.type == "entity")
		{
			if (o.y == o.targety)
			{
				if (!o.bounced)
				{
					o.bounced = true;
					o.y = o.y - 8;
					o.speed = -8;
				} else {
					o.speed = 0;
				}
			}
			if (o.dying > 0)
			{
				if (o.targetx > o.x) { o.x += o.speed; }
				if (o.targetx < o.x) { o.x -= o.speed; }
				if (o.targety < o.y) { o.y -= o.speed; }
				if (o.targety > o.y) { o.y += o.speed; }
				if (o.y < 0)
				{
					remove(o);
				}
			}
			if (o.bounced) o.speed += 2;
			if (o.y < o.targety) { o.y += o.speed; }
		} else {
			// Target co-ords set by screen touch.
			if (o.targetx > o.x) { o.x += o.speed; o.startframe = 0; }
			if (o.targetx < o.x) { o.x -= o.speed; o.startframe = 2; }
			if (o.targety < o.y) { o.y -= o.speed; o.startframe = 4; }
			if (o.targety > o.y) { o.y += o.speed; o.startframe = 6; }
		}
	}
	if (o.dying < 1)
	{
		if (o.x < g.canvaspadding) o.x = g.canvaspadding;
		if ((o.x + o.w) > (g.canvaswidth - g.canvaspadding)) o.x = g.canvaswidth - g.canvaspadding - o.w;
		if (o.y < g.canvaspadding) o.y = g.canvaspadding;
		if ((o.y + o.h) > (g.canvasheight - g.canvaspadding)) o.y = g.canvasheight - g.canvaspadding - o.h;
	}
};

function move(o)
{
	if (!o.visible || g.pausemode > 0) return;

	switch (o.direction)
	{
	case 0:
		o.y -= o.speed;
		break;			
	case 1:
		o.y -= (o.speed / 1.5);
		o.x += (o.speed / 1.5);
		break;			
	case 2:
		o.x += o.speed;
		break;			
	case 3:
		o.y += (o.speed / 1.5);
		o.x += (o.speed / 1.5);
		break;			
	case 4:
		o.y += o.speed;
		break;			
	case 5:
		o.y += (o.speed / 1.5);
		o.x -= (o.speed / 1.5);
		break;			
	case 6:
		o.x -= o.speed;
		break;			
	case 7:
		o.y -= (o.speed / 1.5);
		o.x -= (o.speed / 1.5);
		break;			
	}
	if (o.spritesheet.type == "zoltar")
	{
		o.moveleft = false; o.moveright = false; o.moveup = false; o.movedown = false;
		if (o.x > m.player.x) o.moveleft = true;
		if (o.x < m.player.x) o.moveright = true;
		if (o.y > m.player.y) o.moveup = true;
		if (o.y < m.player.y) o.movedown = true;
		getDirection(o);
	}
	if ((o.x + o.w) < 0) remove(o); 
	if (o.x > g.canvaswidth) remove(o); 
	if ((o.y - o.h) < 0) remove(o); 
	if (o.y  > g.canvasheight) remove(o);

};

function throwStars(force,o)
{
	for (var a=0;a<m.player.stars;a++)
	{
		spawnEntityChance(force,o);
	}
};

function playerMonsterCollision(o) // Monster passed in
{
	if (!o.visible || o.dying || m.player.dead || g.pausemode > 0) return;

	var ox = o.x;
	var oy = o.y;
	var ow = o.w; 
	var oh = o.h; 

	var mx = m.player.x;
	var my = m.player.y;
	var mw = m.player.w;
	var mh = m.player.h;

	var c1 = false, c2 = false, c3 = false, c4 = false;
	
	if (ox <= (mx+mw)  &&  oy <= (my+mh)  &&  ox >= (mx)  && oy >= my) c1 = true;
	if ((ox+ow) >= mx  &&  oy >= my  &&  (ox+ow) <= (mx+mw)  &&  oy <= (my+mh)) c2 = true;
	if (ox <= (mx+mw)  &&  (oy+oh) >= my  &&  ox >= mx  &&  (oy+oh) <= (my+mh)) c3 = true;
	if (((ox + ow) >= mx) && ((ox + ow) <= (mx + mw)) && ((oy + oh) >= my) && ((oy + oh) <= (my + mh))) c4 = true; 

	if (c1 == true || c2 == true || c3 == true || c4 == true)
	{
		if (o.spritesheet.type == "monster")
		{
			remove(o);
			sparkShower(o);
			if (m.player.magicpower > 0)
			{
				m.player.targetscore += 50;
			} else {
				playerDeath();
			}
		} else if (o.spritesheet.type == "zoltar")
		{
			sparkShower(o);
			remove(o);
			if (m.player.magicpower > 0)
			{
				m.player.targetscore += 50;
			} else {
				m.player.stars = 0;
			}
			for (var a=0;a<4;a++) { spawnExplosion(o,0,a*1.5); }
		} else {
			bootMonster(o);
		}
	}
};

function bootMonster(o)
{
	if (o.dying) return;
	m.player.targetscore += 50;
	o.speed = 32;
	sparkShower(o);
	remove(o);
};

function entityCollision(o,m) // Entity and Player/Zoltar passed in
{
	if (!o.visible || m.dead || m.dying > 0 || o.dying > 0 || g.pausemode > 0) return;

	var ox = o.x;
	var oy = o.y;
	var ow = o.w; 
	var oh = o.h; 

	var mx = m.x;
	var my = m.y;
	var mw = m.w;
	var mh = m.h;

	var c1 = false, c2 = false, c3 = false, c4 = false;
	
	if (ox <= (mx+mw)  &&  oy <= (my+mh)  &&  ox >= (mx)  && oy >= my) c1 = true;
	if ((ox+ow) >= mx  &&  oy >= my  &&  (ox+ow) <= (mx+mw)  &&  oy <= (my+mh)) c2 = true;
	if (ox <= (mx+mw)  &&  (oy+oh) >= my  &&  ox >= mx  &&  (oy+oh) <= (my+mh)) c3 = true;
	if (((ox + ow) >= mx) && ((ox + ow) <= (mx + mw)) && ((oy + oh) >= my) && ((oy + oh) <= (my + mh))) c4 = true; 

	if (c1 == true || c2 == true || c3 == true || c4 == true)
	{
		if (m.spritesheet.type == "player")
		{
			if (o.row == 0) // Stars
			{
				m.stars ++;
				if (m.stars > 49)
				{
					g.level ++;
					g.mode = "endlevel";
					g.resetting = 80;
					m.score += 500;
					wipe(true);
				}
				m.targetscore += 5;
			} else {
				m.targetscore += (o.row * 10);
				if (o.row == 4)
				{
					m.magicpower = 150;
					m.row = 1;
				}
			}
			sparkShower(o);
			remove(o);
			//sfx(gameaudio['bonusitem']);
		} else if (m.spritesheet.type == "zoltar")
		{
			remove(o);
			sparkShower(o);
		}
	}
};

function writeTextOLD(t,x,y,ty)
{
	var sx = x;
	var grid = {};
	grid.w = 10;
	grid.h = 16;
	var text = new String(t.toUpperCase());	
	for (var a=0;a<text.length;a++)
	{
		var p = text.charCodeAt(a) - 33;
		if (p >= 0)
		{
			g.ctx.drawImage(g.characterset,p * grid.w,ty*grid.h,grid.w,grid.h,x,y,grid.w,grid.h);
		}
		x += grid.w;
		if (x > (g.canvaswidth - 32))
		{
			x = sx;
			y += grid.h;
		}
	}
};

function writeText(t,x,y,s,f)
{
	try
	{
		var sx = x;
		var grid = {};
		grid.w = 10;
		grid.h = 16;
		var text = new String(t);	
		//text = text.toUpperCase();
		var ss = "";
		g.ctx.font = "normal "+s+"px '"+f+"', Sans-Serif";
		g.ctx.textAlign = "center";
		g.ctx.fillStyle = "#ffffcc";
		g.ctx.fillText(text, x,y+8);
		
	}
	catch (e)
	{
		write("WriteText: " + e.message);
	}
};


/** ---------------------------------------------------------------- **/
/** ---------------------------------------------------------------- **/

function loop()
{
	try
	{
		clearTimeout(g.ticker);
		g.ctx.drawImage(g.gamebackdrops[0],0,0);

		switch (g.mode)
		{
			case "splash":
				g.ctx.drawImage(g.splash,0,0);
				g.resetting --;
				if (g.resetting < 0)
				{
					setTitle();
				}
			break;
			case "title":
				hiScore();
				g.ctx.drawImage(g.titlescreen,(g.canvaswidth/2)-150,(g.canvasheight/2)-150);
				writeText(textdata[4],g.textcentre,280,20,SCOREFONT);
				if (g.resetting > 0) g.resetting --;
			break;
			case "pregame":
				g.mode = "levelup"; // just pass straight through
			break;
			case "game":
				if (g.nextthink > 0) g.nextthink --;
				for (var a=0;a<m.marker.length;a++)
				{
					draw(m.marker[a]);
				}
				if (m.player.dying < 1)
				{
					for (var a=0;a<m.monster.length;a++)
					{
						move(m.monster[a]);
						draw(m.monster[a]);
						playerMonsterCollision(m.monster[a]);
					}
					for (var a=0;a<m.zoltar.length;a++)
					{
						move(m.zoltar[a]);
						draw(m.zoltar[a]);
						playerMonsterCollision(m.zoltar[a]);
					}
					for (var a=0;a<m.entity.length;a++)
					{
						moveToTarget(m.entity[a]);
						draw(m.entity[a]);
						entityCollision(m.entity[a],m.player);
						entityCollision(m.entity[a],m.zoltar[0]);
					}
				}
				drawPlayer(m.player);
				moveToTarget(m.player);
				for (var a=0;a<m.spark.length;a++)
				{
					move(m.spark[a]);
					draw(m.spark[a]);
				}

				for (var a=0;a<m.explosion.length;a++)
				{
					move(m.explosion[a]);
					draw(m.explosion[a]);
				}
				updateScore();
				updateLives();
				updateStars();
				spawnMonsterChance();
				spawnEntityChance(false, null);
				g.ctx.drawImage(g.playpause, g.pausemode * 32, 0, 32, 32, 8, 8, 32, 32);
			break;
			case "endlevel":
				for (var a=0;a<m.spark.length;a++) { move(m.spark[a]); draw(m.spark[a]); }
				g.resetting --;
				if (g.resetting < 1)
				{
					setLevel();
				}
				updateScore();
				updateLives();
				updateStars();
				writeText(textdata[2],g.textcentre,200,28,SCOREFONT);
			break;
			case "landscape":
			break;
			case "levelup":
				writeText(textdata[0] + " " + g.level,g.textcentre,200,28,SCOREFONT);
				g.resetting --;
				if (g.resetting < 1)
				{
					playerStart();
					g.mode = "game";
				}
			break;
			case "gameover":
				writeText(textdata[1],g.textcentre,200,28,SCOREFONT);
				g.resetting --;
				if (g.resetting < 1)
				{
					setTitle();
				}
				updateScore();
			break;
			case "getdata":
				writeText(textdata[3],g.textcentre,100,22,SCOREFONT);
				updateScore();
			break;
		}
		g.ticker = setTimeout("loop()", g.framedelay);
	}
	catch (e)
	{
		write("Loop: "+e.message);
	}
};

function testFPS()
{
	try
	{
		// FPS
		if (isNaN(g.fps)) g.fps = 0;
		if (g.fps) 
		{
			var d = new Date();
			var c = Math.round(1000 / (d - g.fps));
		}
		var s = new String(c);
		g.fps = new Date();
		if (c) writeString(s,220,g.canvasheight - 52);
		if (isNaN(g.testy)) g.testy = 0;
		if (isNaN(g.ave)) g.ave = 0;
		if (g.mode != "title" && g.testy < 20) 
		{ 
			g.testy ++; g.ave += c; 
			if (g.testy >= 10)
			{
				if (g.ave > 1500) g.framedelay = 42; // throttle the fast devices
			}
		}
	}
	catch (e)
	{
		write(e.message);
	}
};

function spawnMonsterChance()
{
	if (rnd(100) < (2 + (g.level)) && g.pausemode < 1) 
	{
		var x = -32; var y = -32;
		var d = 0; var s = 0; var f = 0;
		if (rnd(100) < 50)
		{
			// Ghosts and monsters that hurt the player
			y = (g.canvaspadding * 2) + rnd(g.canvasheight / 2);
			if (rnd(10) < 5)
			{
				x = -32;
				d = 2;
				f = 0;
			} else {
				x = g.canvaswidth;
				d = 6;
				f = 2;
			}
			s = 1 + rnd(3);
			var row = parseInt(m.spritesheets["monstersheet"].height) / parseInt(m.spritesheets["monstersheet"].frameheight);
			spawnMonster(x,y,d,s,f,1,rnd(row)-1);
		} else {
			// Zoltar
			if (g.nextthink > 0) return;
			if (rnd(10) < 5)
			{
				y = -32;
				d = 4;
				f = 6;
			} else {
				y = g.canvasheight;
				d = 0;
				f = 4;
			}
			x = (g.canvaswidth / 2) - 8;
			d = 0; s = g.level * 0.5; f = 4;
			if (s > 4) s = 4;
			spawnMonster(x,y,d,s,f,2,0);
		}
	}
};

function spawnMonster(x,y,d,s,f,ty,row)
{
	if (ty == 1)
	{
		for (var a=0;a<m.monster.length;a++)
		{
			if (!m.monster[a].visible)
			{
				var e = m.monster[a];
				e.visible = true;
				e.direction = d;
				e.x = x;
				e.y = y;
				e.speed = s;
				e.frame = 0;
				e.startframe = f;
				e.row = row;
				break;
			}
		}
	} else {
		for (var a=0;a<m.zoltar.length;a++)
		{
			if (!m.zoltar[a].visible)
			{
				var e = m.zoltar[a];
				e.visible = true;
				e.direction = d;
				e.x = x;
				e.y = y;
				e.speed = s;
				e.frame = 0;
				e.startframe = f;
				g.nextthink = 100;
				break;
			}
		}
	}
};

function spawnMarker(x,y)
{
	for (var a=0;a<m.marker.length;a++)
	{
		if (!m.marker[a].visible)
		{
			var e = m.marker[a];
			e.visible = true;
			e.x = x;
			e.y = y;
			e.frame = 0;
			e.startframe = 0;
			break;
		}
	}
};

function spawnExplosion(o,d,sp)
{
	for (var a=0;a<m.explosion.length;a++)
	{
		if (!m.explosion[a].visible)
		{
			var e = m.explosion[a];
			e.visible = true;
			e.direction = d;
			e.x = o.x;
			e.y = o.y;
			e.speed = sp;
			e.frame = 0;
			break;
		}
	}
};

function sparkShower(o)
{
	for (var a=0;a<8;a++)
	{
		spawnSpark(o,a,12);
	}
};

function spawnSpark(o,d,sp)
{
	for (var a=0;a<m.spark.length;a++)
	{
		if (!m.spark[a].visible)
		{
			var s = m.spark[a];
			s.visible = true;
			s.direction = d;
			s.x = o.x + (o.w/2);
			s.y = o.y + (o.h/2);
			s.spawny = o.y + 16;
			s.speed = sp;
			s.decay = 30;
			s.opacity = 1;
			break;
		}
	}
};

function spawnEntityChance(force,o)
{
	var x = 0; var y = 0;
	if ((rnd(100) < 6 || force == true) && g.pausemode < 1) 
	{
		if (o != null && o.spritesheet.type == "player")
		{
			x = (o.x-64) + rnd(128); 
			y = (o.y-64) + rnd(128);
		} else {
			x = (g.canvaspadding * 2) + rnd(g.canvaswidth / 2);;
			y = (g.canvaspadding * 4) + rnd(g.canvasheight / 2);
		}
		var row = parseInt(m.spritesheets["entitysheet"].height) / parseInt(m.spritesheets["entitysheet"].frameheight);
		var r = 0;
		if (rnd(10)<5) r = rnd(row)-1;
		if (m.player.magicpower > 0 && r == 4) r = 0; // magic power not being respawned.
		spawnEntity(x, y, r);
	}
};

function spawnEntity(x,y,row)
{
	for (var a=0;a<m.entity.length;a++)
	{
		if (!m.entity[a].visible)
		{
			var s = m.entity[a];
			s.visible = true;
			s.x = x;
			s.y = y - 64;
			s.targetx = x; 
			s.targety = y;
			s.direction = 4;
			s.speed = 16;
			s.bounced = false;
			s.dying = 0;
			s.row = row;
			break;
		}
	}
};

function writeString(s,x,y)
{
	var o = m.spritesheets["numberssheet"];
	for (var a=0;a<s.length;a++)
	{
		x += o.framewidth;
		var i = s.substr(a,1);
		g.ctx.drawImage(o.image, i*o.framewidth, 0, o.framewidth, o.frameheight, x, y, o.framewidth, o.frameheight);
	}
};

function hiScore()
{
	try
	{
		//g.ctx.drawImage(g.hiscore, g.displaypadding-4, 20);
		var sScore = new String();
		var sInScore = new String(m.player.hiscore);
		var ls = sInScore.length;
		var s = new String();
		
		for (var a = 0; a < (5-ls); a++) s += "0";
		for (var b = 0; b < sInScore.length; b++) s += "" + sInScore.substring(b,b+1);
		
		writeString(s,80,20);
		
	}
	catch (e)
	{
		write("HiScore:" + e.message);
	}
};

function updateScore()
{
	try
	{
		m.player.score += 1;
		if (m.player.score > m.player.targetscore) m.player.score = m.player.targetscore;
		if (m.player.score > m.player.hiscore) 
		{
			m.player.hiscore = m.player.score;
			localStorage.setItem(GAMETITLE + "-hiscore", m.player.hiscore);
		}
		var sScore = new String();
		var sInScore = new String(m.player.score);
		var ls = sInScore.length;
		var s = new String();
		
		for (var a = 0; a < (5-ls); a++) s += "0";
		for (var b = 0; b < sInScore.length; b++) s += "" + sInScore.substring(b,b+1);
		
		writeString(s,80,0);
		
	}
	catch (e)
	{
		write(e.message);
	}
};

function updateLives()
{
	g.ctx.drawImage(g.wizardicon, g.displaypadding+72, 0);

	var ph = new String();
	var ph2 = new String(m.player.lives);
	var ls = ph2.length;
	var s = new String();
	
	for (var b = 0; b < ph2.length; b++) s += ph2.substring(b,b+1);
	
	writeString(s,g.displaypadding+24,0);

};

function updateStars()
{
	g.ctx.drawImage(g.staricon, g.displaypadding+240, 8);

	var ph = new String();
	var ph2 = new String(m.player.stars);
	var ls = ph2.length;
	var s = new String();
	
	for (var b = 0; b < ph2.length; b++) s += ph2.substring(b,b+1);
	
	writeString(s,g.displaypadding+248,0);

};

function remove(o)
{
	o.visible = false;
};

function scanInput(e)
{
	if (window.event) keypress = e.keyCode;
	else if(e.which) keypress = e.which;
	if (keypress > 36 && keypress < 41) m.player.targetx = -1; m.player.targety = -1; // Keyboard has over-riden the mouse.
	switch (keypress)
	{
		case 16: // SHIFT
			break;
		case 18: // ALT
			break;
		case 32: // Space
			if (g.mode == "title") setGame();
			break;
		case 38: // Up
			m.player.moveup = true;
			break;
		case 40: // Down
			m.player.movedown = true;
			break;
		case 39: // Right
			m.player.moveright = true;
			break;
		case 37: // Left
			m.player.moveleft = true;
			break;
		case 67: // C
			//g.console.style.display = g.console.style.display == "none" ? "block" : "none";
			break;
		case 80: // P
			g.pausemode ++; if (g.pausemode > 1) g.pausemode = 0;
			break;
		case 83: // S
			g.audiomode ++; if (g.audiomode > 1) g.audiomode = 0;
			handleAudio();
			break;
		case 17: // CTRL
		case 90: // Z
			spawnMarker(m.player.x,m.player.y);
			break;
	}
};

function stopMove(e)
{
	if (window.event) // IE
	{
		keyup = e.keyCode;
	}
	else if(e.which)
	{
		keyup = e.which;
	}

	var k = 0;
	if (keyup >= 48 && keyup <= 57)
	{
		k = (48 - keyup) * -1;
	}
	switch (keyup)
	{
		case 16: // SHIFT
			break;
		case 18: // ALT
			break;
		case 32: // Space
			break;
		case 38: // Up
			m.player.moveup = false;
			break;
		case 40: // Down
			m.player.movedown = false;
			break;
		case 39: // Right
			m.player.moveright = false;
			break;
		case 37: // Left
			m.player.moveleft = false;
			break;
		case 67: // C
			break;
		case 83: // S
			break;
		case 17: // CTRL
		case 90: // Z
			break;
	}
};
