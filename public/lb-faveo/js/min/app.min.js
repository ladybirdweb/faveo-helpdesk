/*! AdminLTE 2.0.1 app.js
 * ======================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <support@almsaeedstudio.com>
 * @version 2.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */
if("undefined"==typeof jQuery)throw new Error("AdminLTE requires jQuery")
$.AdminLTE={},$.AdminLTE.options={navbarMenuSlimscroll:!0,navbarMenuSlimscrollWidth:"3px",navbarMenuHeight:"200px",sidebarToggleSelector:"[data-toggle='offcanvas']",sidebarPushMenu:!0,sidebarSlimScroll:!0,enableBoxRefresh:!0,enableBSToppltip:!0,BSTooltipSelector:"[data-toggle='tooltip']",enableFastclick:!0,enableBoxWidget:!0,boxWidgetOptions:{boxWidgetIcons:{collapse:"fa fa-minus",open:"fa fa-plus",remove:"fa fa-times"},boxWidgetSelectors:{remove:'[data-widget="remove"]',collapse:'[data-widget="collapse"]'}},colors:{lightBlue:"#3c8dbc",red:"#f56954",green:"#00a65a",aqua:"#00c0ef",yellow:"#f39c12",blue:"#0073b7",navy:"#001F3F",teal:"#39CCCC",olive:"#3D9970",lime:"#01FF70",orange:"#FF851B",fuchsia:"#F012BE",purple:"#8E24AA",maroon:"#D81B60",black:"#222222",gray:"#d2d6de"}},$(function(){var e=$.AdminLTE.options
$.AdminLTE.layout.activate(),$.AdminLTE.tree(".sidebar"),e.navbarMenuSlimscroll&&"undefined"!=typeof $.fn.slimscroll&&$(".navbar .menu").slimscroll({height:"200px",alwaysVisible:!1,size:"3px"}).css("width","100%"),e.sidebarPushMenu&&$.AdminLTE.pushMenu(e.sidebarToggleSelector),e.enableBSToppltip&&$(e.BSTooltipSelector).tooltip(),e.enableBoxWidget&&$.AdminLTE.boxWidget.activate(),e.enableFastclick&&"undefined"!=typeof FastClick&&FastClick.attach(document.body),$('.btn-group[data-toggle="btn-toggle"]').each(function(){var e=$(this)
$(this).find(".btn").click(function(i){e.find(".btn.active").removeClass("active"),$(this).addClass("active"),i.preventDefault()})})}),$.AdminLTE.layout={activate:function(){var e=this
e.fix(),e.fixSidebar(),$(window,".wrapper").resize(function(){e.fix(),e.fixSidebar()})},fix:function(){var e=$(".main-header").outerHeight()+$(".main-footer").outerHeight(),i=$(window).height(),n=$(".sidebar").height()
$("body").hasClass("fixed")?$(".content-wrapper, .right-side").css("min-height",i-$(".main-footer").outerHeight()):i>=n?$(".content-wrapper, .right-side").css("min-height",i-e):$(".content-wrapper, .right-side").css("min-height",n)},fixSidebar:function(){return $("body").hasClass("fixed")?("undefined"==typeof $.fn.slimScroll&&console&&console.error("Error: the fixed layout requires the slimscroll plugin!"),void($.AdminLTE.options.sidebarSlimScroll&&"undefined"!=typeof $.fn.slimScroll&&($(".sidebar").slimScroll({destroy:!0}).height("auto"),$(".sidebar").slimscroll({height:$(window).height()-$(".main-header").height()+"px",color:"rgba(0,0,0,0.2)",size:"3px"})))):void("undefined"!=typeof $.fn.slimScroll&&$(".sidebar").slimScroll({destroy:!0}).height("auto"))}},$.AdminLTE.pushMenu=function(e){$(e).click(function(e){e.preventDefault(),$("body").toggleClass("sidebar-collapse"),$("body").toggleClass("sidebar-open")}),$(".content-wrapper").click(function(){$(window).width()<=767&&$("body").hasClass("sidebar-open")&&$("body").removeClass("sidebar-open")})},$.AdminLTE.tree=function(e){$("li a",$(e)).click(function(e){var i=$(this),n=i.next()
if(n.is(".treeview-menu")&&n.is(":visible"))n.slideUp("normal",function(){n.removeClass("menu-open")}),n.parent("li").removeClass("active")
else if(n.is(".treeview-menu")&&!n.is(":visible")){var o=i.parents("ul").first(),t=o.find("ul:visible").slideUp("normal")
t.removeClass("menu-open")
var s=i.parent("li")
n.slideDown("normal",function(){n.addClass("menu-open"),o.find("li.active").removeClass("active"),s.addClass("active")})}n.is(".treeview-menu")&&e.preventDefault()})},$.AdminLTE.boxWidget={activate:function(){var e=$.AdminLTE.options,i=this
$(e.boxWidgetOptions.boxWidgetSelectors.collapse).click(function(e){e.preventDefault(),i.collapse($(this))}),$(e.boxWidgetOptions.boxWidgetSelectors.remove).click(function(e){e.preventDefault(),i.remove($(this))})},collapse:function(e){var i=e.parents(".box").first(),n=i.find(".box-body, .box-footer")
i.hasClass("collapsed-box")?(e.children(".fa-plus").removeClass("fa-plus").addClass("fa-minus"),n.slideDown(300,function(){i.removeClass("collapsed-box")})):(e.children(".fa-minus").removeClass("fa-minus").addClass("fa-plus"),n.slideUp(300,function(){i.addClass("collapsed-box")}))},remove:function(e){var i=e.parents(".box").first()
i.slideUp()},options:$.AdminLTE.options.boxWidgetOptions},function(e){e.fn.boxRefresh=function(i){function n(e){e.append(s),t.onLoadStart.call(e)}function o(e){e.find(s).remove(),t.onLoadDone.call(e)}var t=e.extend({trigger:".refresh-btn",source:"",onLoadStart:function(){},onLoadDone:function(){}},i),s=e('<div class="overlay"></div><div class="loading-img"></div>')
return this.each(function(){if(""===t.source)return void(console&&console.log("Please specify a source first - boxRefresh()"))
var i=e(this),s=i.find(t.trigger).first()
s.click(function(e){e.preventDefault(),n(i),i.find(".box-body").load(t.source,function(){o(i)})})})}}(jQuery),function(e){e.fn.todolist=function(i){var n=e.extend({onCheck:function(){},onUncheck:function(){}},i)
return this.each(function(){"undefined"!=typeof e.fn.iCheck?(e("input",this).on("ifChecked",function(){var i=e(this).parents("li").first()
i.toggleClass("done"),n.onCheck.call(i)}),e("input",this).on("ifUnchecked",function(){var i=e(this).parents("li").first()
i.toggleClass("done"),n.onUncheck.call(i)})):e("input",this).on("change",function(){var i=e(this).parents("li").first()
i.toggleClass("done"),n.onCheck.call(i)})})}}(jQuery)
