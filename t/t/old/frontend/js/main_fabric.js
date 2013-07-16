var DOWNLOAD_PDF_URL = SERVER_URL + 'download_pdf_fabric.php';

var canvas, el;

$(document).ready(function(){
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
	
	canvas = new fabric.Canvas('canvas_container');
	canvas.setWidth(500);
	canvas.setHeight(500);
	
	var circle = new fabric.Circle(
	{
		radius: 40,
		left: 250,
		top: 250,
		stroke: '#558CB1',  
		strokeWidth: 2
	});
	
	
	circle.setGradient('fill', 
	{
		x1: circle.width / 2,
		y1: circle.height / 2,
		x2: circle.width / 2,
		y2: -circle.height / 2,
		colorStops: {
			0: '#526c7a',
			1: '#64a0c1'
		}
	});
	
	var text = new fabric.Text($('#textDemoInput').val(), 
	{
		left: 100, 
		top: 100,
		fontFamily: 'Arial',
		fontSize: 24
	});
	
	$('#textDemoInput').keyup(function(e){
		if (!e.altKey && !e.ctrlKey && !e.shiftKey) {
			text.setText($('#textDemoInput').val());
			canvas.renderAll();
		}
	});
	
	fabric.Image.fromURL('img/1.png', function(oImg) {
		oImg.setOptions({
			left: 345,
			top: 150,
			stroke: '#0AA55A',  
			strokeWidth: 2
		});
		canvas.add(oImg);
	});
	
	canvas.add(circle, text);
	
	$("#downloadPdf").click(function(){
		sendAjaxRequest(DOWNLOAD_PDF_URL, {data: JSON.stringify(canvas.toDatalessObject())},
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