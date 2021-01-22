var backgroundImg =[
	'url("../bgimages/animatedforest1.gif")',
	'url("../bgimages/animatedforest2.gif")',
	'url("../bgimages/animatedforest3.gif")',
	'url("../bgimages/animatedforest4.gif")',
	'url("../bgimages/animatedforest5.gif")',
	'url("../bgimages/animatedforest6.gif")'
	];

var arrayLength = backgroundImg.length;

document.documentElement.style.setProperty('--background-image1', backgroundImg[0]);
document.documentElement.style.setProperty('--background-image2', backgroundImg[1]);

var nextImgIndex = 0;

function changeBgImage() { 
	if(document.documentElement.style.getPropertyValue('--background-opacity2') == 0){
		var currentImg = document.documentElement.style.getPropertyValue('--background-image2');
		var currentImgIndex = backgroundImg.indexOf(currentImg);
		if(currentImgIndex == (arrayLength - 2)) {
			nextImgIndex = 0;
		} else if(currentImgIndex == (arrayLength - 1)) {
			nextImgIndex = 1;
		} else {
			nextImgIndex=nextImgIndex+1;
		}
		document.documentElement.style.setProperty('--background-image2', backgroundImg[nextImgIndex]);
		console.log(nextImgIndex); 
		document.documentElement.style.setProperty('--background-opacity2', 1);	
		//console.log("bg2"); 
	} else {			
		var currentImg = document.documentElement.style.getPropertyValue('--background-image1');
		var currentImgIndex = backgroundImg.indexOf(currentImg);
		if(currentImgIndex == (arrayLength - 2)) {
			nextImgIndex = 0;
		} else if(currentImgIndex == (arrayLength - 1)) {
			nextImgIndex = 1;
		} else {
			nextImgIndex=nextImgIndex+1;
		}
		document.documentElement.style.setProperty('--background-image1', backgroundImg[nextImgIndex]);
		console.log(nextImgIndex); 
		document.documentElement.style.setProperty('--background-opacity2', 0);
		//console.log("bg1"); 
	}
	var interval = document.getElementById('range').value*1000;
	//var interval = 10000;
	t = setTimeout(function(){changeBgImage()}, interval);

}

var t;
var timer_is_on = 0;

/*
var user_id = "<?php echo $album_id ?>";
var mysql = require('mysql');

var con = mysql.createConnection({
	host: "localhost",
	user: "root",
	password: "",
	database: "gallery"
});
*/

function startBgChange() {
	if (!timer_is_on) {
		timer_is_on = 1;
		changeBgImage();
	}
}

function stopBgChange() {
	clearTimeout(t);
	timer_is_on = 0;
}

/*
con.connect(function(err) {
	if (err) throw err;
	var sql = "SELECT change_bg FROM users WHERE user_id = '"+user_id+"'";
	con.query(sql, function (err, result, fields) {
		if (err) throw err;
		console.log(result);
		if (result=='1') {
			document.getElementById("checkbox").checked = true;
		} else {
			document.getElementById("checkbox").checked = false;
		}
	});
});
*/
if ( document.getElementById('accept').checked ) {
	startBgChange();
}
	// assign function to onclick property of checkbox
document.getElementById('accept').onclick = function() {
	// access properties using this keyword
	if ( this.checked ) {
		startBgChange();
		/*
		con.connect(function(err) {
			if (err) throw err;
			var sql = "UPDATE users SET change_bg = '1' WHERE user_id = '"+user_id+"'";
			con.query(sql, function (err, result) {
				if (err) throw err;
				console.log(result.affectedRows + " record(s) updated");
			});
		});
		*/
	} else {
		stopBgChange();
		/*
		con.connect(function(err) {
			if (err) throw err;
			var sql = "UPDATE users SET change_bg = '1' WHERE user_id = '"+user_id+"'";
			con.query(sql, function (err, result) {
				if (err) throw err;
				console.log(result.affectedRows + " record(s) updated");
			});
		});
		*/
	}
};

const
range = document.getElementById('range'),
rangeV = document.getElementById('rangeV'),

setValue = ()=>{
	const
	newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
	newPosition = 10 - (newValue * 0.2);

	rangeV.innerHTML = `<span>${range.value}</span>`;
	rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
};
document.addEventListener("DOMContentLoaded", setValue);
range.addEventListener('input', setValue);	
	