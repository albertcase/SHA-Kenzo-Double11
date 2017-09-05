(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			var clientHeight = window.innerHeight;
			if (!clientWidth) return;
			if(clientWidth/clientHeight <= 640/800) {//for andriod keyboard
				if(clientWidth/clientHeight > 750/1334){
					docEl.style.fontSize = 50 * (clientHeight / 667) + 'px';
					//$('.wrapper').addClass('landscape');
				}else{
					//$('.wrapper').removeClass('landscape');
					docEl.style.fontSize = 50 * (clientWidth / 375) + 'px';
				}
			}
		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	recalc();
	//doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);