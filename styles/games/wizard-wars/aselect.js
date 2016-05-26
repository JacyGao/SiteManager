function pickAdURL(){
	
	var slotURL = "adsense.html";
	var max = 10000;
	var split = PARTNERSPLIT > 0 ? Math.floor(max / (100 / PARTNERSPLIT)) : 0;
	
	if ((Math.random() * max) > split || split == 0){
		slotURL = 'adsense.html';
	} else {
		slotURL = PARTNERURL;
	}
	if (slotURL != "")
	{
		g.banad.innerHTML = '<iframe src="'+slotURL+'" width="320" height="50" frameborder="0" scrolling="no">i</iframe>';
	}

};