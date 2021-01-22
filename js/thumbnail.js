var gallery = {
	// show selected image in lightbox
	show : function(img){
		var clone = img.cloneNode(),
			domain = clone.src.substr(0, clone.src.lastIndexOf("/",clone.src.lastIndexOf("/")-1)+1),
			image = clone.src.substr(clone.src.lastIndexOf("/")+1),
			front = document.getElementById("lfront"),
			back = document.getElementById("lback");

		clone.src = domain + "gallery/" + image;
		clone.onclick = "";
		front.innerHTML = "";
		front.appendChild(clone);
		back.classList.add("show");
	},

	// hidding lightbox
	hide : function(){
		document.getElementById("lback").classList.remove("show");
	}
};