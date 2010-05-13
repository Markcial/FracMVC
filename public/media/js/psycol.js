$.fn.psycol = function(options){
	var defaults = $.extend({
		
	},options)
	
	var patterns = {
		string:/(\".*\")/g,
		comment:/(\/\*[.\S\s]*?\*\/)/g,
		varName:/(var .+[^=;\n])/g,
		funcName:/(function .+\(.*\)\{[.\S\s]*?\})/g
    }
	
	return this.each(function(i,el){
		var buffer = $(el).html();
		$(el).html('');
		for(var pattern in patterns){
			buffer = buffer.replace(patterns[pattern],'<span class="'+pattern+'">$1</span>');
		}
		var lines = buffer.split("\n").length-1;
		$(el).append('<ol class="psycol-line-count" />');
		var ol = $(el).find('ol.psycol-line-count');
		for(var i = 0;i< lines;i++){ ol.append('<li />'); };
		$(el).append("<code>"+buffer+"</code>");
	})
}


//(final)?\s?(partial|abstract|public|private|protected|internal)?\s?(class|interface)\s([\w\d]+)\s?(\{?)5|6
//internal class demoClass {

//} 

//