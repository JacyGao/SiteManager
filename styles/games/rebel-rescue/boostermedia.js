function pickAdURL(){
	return;
	var slotURL="";
	if (Math.random()*10000>4999){
		slotURL='http://www.spacemonsters.co.uk/games/adsense.php';
	} else {
		slotURL='[PATH TO]/boostermedia.php';
	}
	g.banad.style.display = "block";
	if (slotURL != "")
	{
		g.banad.innerHTML='<iframe src="'+slotURL+'" width="320" height="50" frameborder="0" scrolling="no">i</iframe>';
	} else {
	}
};