var ScriptLoader = (function(){
	
	function loadScript(url, callback) {
		var script = document.createElement('script');
		script.type = 'text/javascript';

		if(script.readyState) {   // IE
			script.onreadystatechange = function() {
				if(script.readyState === 'loaded' || script.readyState === 'complete') {
					script.onreadystatechange = null;

					if(typeof callback === 'function') {
						callback();
					}
				}
			}
		} else {   // Other browsers
			script.onload = function() {
				if(typeof callback === 'function') {
					callback();
				}
			}
		}

		script.src = url;
		document.getElementsByTagName('head')[0].appendChild(script);		
	}


	return {
		load: function(urls, callback) {
			if(urls.constructor === Array) {
				var that = this,
					url = urls.shift();

				if(url){
					loadScript(url, function() {
						that.load(urls, callback);
					});
				}
				else{
					if(typeof callback === "function") {
						callback();
					}
				}
			} else {
				loadScript(urls, callback);
			}
		}
	};
})();