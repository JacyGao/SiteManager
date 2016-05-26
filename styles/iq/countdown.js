var up,down;

var min1,sec1;

var cmin1,csec1,cmin2,csec2;


function Minutes(data) {

	for(var i=0;i<data.length;i++) if(data.substring(i,i+1)==":") break;

	return(data.substring(0,i)); }

function Seconds(data) {

	for(var i=0;i<data.length;i++) if(data.substring(i,i+1)==":") break;

	return(data.substring(i+1,data.length)); }

function Display(min,sec) {

	var disp;

	if(min<=9) disp=" 0";

	else disp=" ";

	disp+=min+":";

	if(sec<=9) disp+="0"+sec;

	else disp+=sec;

	return(disp); }


function Down(totalTime) {
	cmin2=1*Minutes(totalTime);
	csec2=0+Seconds(totalTime);
	DownRepeat(); 
}

function DownRepeat() {

	csec2--;

	if(csec2==-1) { csec2=59; cmin2--; }

	$('timer').innerHTML=Display(cmin2,csec2);

	if((cmin2==0)&&(csec2==0)) Down('2:00');

	else down=setTimeout("DownRepeat()",1000); }