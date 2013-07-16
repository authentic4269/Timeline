var DOWNLOAD_PDF_URL = SERVER_URL + 'download_pdf.php';

var paper, el;
function load_projects() { 
	$.getJSON("/backend/get_projects.php", function(data) {
		if (data.error.code == 0) {
			projects = data.data.projects;
			var i;
			var html = "";
			for (i = 0; i < projects.length; i++) {
				html = html + '<option value="' + projects[i]['id'] + '">' + projects[i]['title'] + '</option>';
			}
			$('#project_selector').html(html);
		}
		else  {
			alert("there was an error");
		}
	});
}

function get_events(id) {
	$.getJSON("/backend/get_event_info.php", {projectId: id}, function(data) {
		if data.error.code == 0 {
			return data.data;
		} 
		else {
			alert("there was an error");
		}
	});
}

$(document).ready(function(){
	load_projects();
	w=$(window).width();
	h=$(window).height();
	$('#loader span').css('top',h/2-75);
	$('#loader span').css('left',w/2-75);
	
	$(window).resize(function(){
		w=$(window).width();
		h=$(window).height();
		$('#loader span').css('top',h/2-75);
		$('#loader span').css('left',w/2-75);
	});
	
	$('project_selector').change(function(event) {
		val = $(this).find("option:selected").attr('value');
		data = get_events(val);
		html = "";
		var i = 0;
		for(i = 0; i < data.length; i++) {
			html = html + "<option value=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
		}
		$('event_selector').html(html);
	});
	
	paper = new Raphael($('#canvas_container')[0], 500, 500);
	
	var circ = paper.circle(250, 250, 40);  
	circ.attr({
		fill: '90-#526c7a-#64a0c1',
		//fill: '#558CB1',
		//fill: 'url(img/1.jpg)',
		stroke: '#558CB1',  
		'stroke-width': 2
	});
	circ.drag(function (dx, dy) {
		this.attr({
			cx: Math.min(Math.max(x + dx, 41), 459),
			cy: Math.min(Math.max(y + dy, 41), 459)
		});
	}, function () {
		x = this.attr("cx");
		y = this.attr("cy");
	});
	
	circ.node.onmouseover = function() {  
		this.style.cursor = 'pointer';  
	}
	
	var text = paper.text(100, 100, $('#textDemoInput').val());
	text.attr({'font-size': 24});
	text.drag(function (dx, dy) {
		this.attr({
			x: Math.min(Math.max(x + dx, 50), 450),
			y: Math.min(Math.max(y + dy, 10), 490)
		});
	}, function () {
		x = this.attr("x");
		y = this.attr("y");
	});
	
	text.node.onmouseover = function() {  
		this.style.cursor = 'pointer';  
	}
	
	$('#textDemoInput').keyup(function(e){
		if (!e.altKey && !e.ctrlKey && !e.shiftKey) {
			text.attr({'text': $('#textDemoInput').val()});
		}
	});
	
	var rect = paper.rect(270, 100, 150, 100);  
	rect.attr({
		//fill: '90-#526c7a-#64a0c1',
		//fill: '#0AA55A',
		fill: 'url(img/1.png)',
		stroke: '#0AA55A',  
		'stroke-width': 2
	});
	rect.drag(function (dx, dy) {
		this.attr({
			x: Math.min(Math.max(x + dx, 0), 350),
			y: Math.min(Math.max(y + dy, 0), 400)
		});
	}, function () {
		x = this.attr("x");
		y = this.attr("y");
	});
	
	rect.node.onmouseover = function() {  
		this.style.cursor = 'pointer';  
	}
	
	$("#downloadPdf").click(function(){
		sendAjaxRequest(DOWNLOAD_PDF_URL, {data: paper.toJSON()},
		function (response) {
			if(response.length != 0)
			{
				window.open(response);
			}
			//callback(response.data.moved);
		},
		function (response) {
			//callback(false);
		})
	})
});