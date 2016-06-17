/*!
 * Javascript
 */

$(function(){
	//页面加载特效
	$('#loading').fadeOut(800);
	//小工具样式
	var Sidebar		= $('#mainsidebar'),
		Widget		= Sidebar.find('.widget'),
		Widgethead	= Widget.children('.widget-title'),
		Widgetbody	= Widget.children('div');
	Widget.addClass('panel panel-default');
	Widgethead.addClass('panel-heading');
	Widgetbody.addClass('panel-body');
	//滚动到顶部或底部
	$(window).scroll(function() {
		if ($(window).scrollTop()>100){
			$('#go-foot').attr({id:"go-top"});
			document.getElementById('go-top').innerHTML='<span class="glyphicon glyphicon-chevron-up"></span>';
		} else {
			$('#go-top').attr({id:"go-foot"});
			document.getElementById('go-foot').innerHTML='<span class="glyphicon glyphicon-chevron-down"></span>';
		}
	});
	$('#go-foot').click(function(){
		if($(this).attr("id")==="go-top") {
			$('body,html').animate({scrollTop:0},1000);
		} else {
			$('body,html').animate({scrollTop:$(document).height()},1000);
		}
	});
	//离开和进入页面时改变title
	var OriginTitile = document.title;
	document.addEventListener('visibilitychange', function() {
		if (document.hidden) {
			document.title = '(>_<)我藏好了哦~';
		} else {
			document.title = OriginTitile;
		}
	});
});