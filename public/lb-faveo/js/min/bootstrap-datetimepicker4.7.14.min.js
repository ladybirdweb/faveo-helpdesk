/*! version : 4.7.14
 =========================================================
 bootstrap-datetimejs
 https://github.com/Eonasdan/bootstrap-datetimepicker
 Copyright (c) 2015 Jonathan Peterson
 =========================================================
 */
!function(e){"use strict"
if("function"==typeof define&&define.amd)define(["jquery","moment"],e)
else if("object"==typeof exports)e(require("jquery"),require("moment"))
else{if("undefined"==typeof jQuery)throw"bootstrap-datetimepicker requires jQuery to be loaded first"
if("undefined"==typeof moment)throw"bootstrap-datetimepicker requires Moment.js to be loaded first"
e(jQuery,moment)}}(function(e,t){"use strict"
if(!t)throw new Error("bootstrap-datetimepicker requires Moment.js to be loaded first")
var a=function(a,n){var r,i,o,d,s,p={},l=t().startOf("d"),c=l.clone(),f=!0,u=!1,h=!1,m=0,y=[{clsName:"days",navFnc:"M",navStep:1},{clsName:"months",navFnc:"y",navStep:1},{clsName:"years",navFnc:"y",navStep:10}],w=["days","months","years"],g=["top","bottom","auto"],b=["left","right","auto"],v=["default","top","bottom"],k={up:38,38:"up",down:40,40:"down",left:37,37:"left",right:39,39:"right",tab:9,9:"tab",escape:27,27:"escape",enter:13,13:"enter",pageUp:33,33:"pageUp",pageDown:34,34:"pageDown",shift:16,16:"shift",control:17,17:"control",space:32,32:"space",t:84,84:"t","delete":46,46:"delete"},C={},x=function(e){if("string"!=typeof e||e.length>1)throw new TypeError("isEnabled expects a single character string parameter")
switch(e){case"y":return-1!==o.indexOf("Y")
case"M":return-1!==o.indexOf("M")
case"d":return-1!==o.toLowerCase().indexOf("d")
case"h":case"H":return-1!==o.toLowerCase().indexOf("h")
case"m":return-1!==o.indexOf("m")
case"s":return-1!==o.indexOf("s")
default:return!1}},D=function(){return x("h")||x("m")||x("s")},T=function(){return x("y")||x("M")||x("d")},M=function(){var t=e("<thead>").append(e("<tr>").append(e("<th>").addClass("prev").attr("data-action","previous").append(e("<span>").addClass(n.icons.previous))).append(e("<th>").addClass("picker-switch").attr("data-action","pickerSwitch").attr("colspan",n.calendarWeeks?"6":"5")).append(e("<th>").addClass("next").attr("data-action","next").append(e("<span>").addClass(n.icons.next)))),a=e("<tbody>").append(e("<tr>").append(e("<td>").attr("colspan",n.calendarWeeks?"8":"7")))
return[e("<div>").addClass("datepicker-days").append(e("<table>").addClass("table-condensed").append(t).append(e("<tbody>"))),e("<div>").addClass("datepicker-months").append(e("<table>").addClass("table-condensed").append(t.clone()).append(a.clone())),e("<div>").addClass("datepicker-years").append(e("<table>").addClass("table-condensed").append(t.clone()).append(a.clone()))]},O=function(){var t=e("<tr>"),a=e("<tr>"),r=e("<tr>")
return x("h")&&(t.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","incrementHours").append(e("<span>").addClass(n.icons.up)))),a.append(e("<td>").append(e("<span>").addClass("timepicker-hour").attr("data-time-component","hours").attr("data-action","showHours"))),r.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","decrementHours").append(e("<span>").addClass(n.icons.down))))),x("m")&&(x("h")&&(t.append(e("<td>").addClass("separator")),a.append(e("<td>").addClass("separator").html(":")),r.append(e("<td>").addClass("separator"))),t.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","incrementMinutes").append(e("<span>").addClass(n.icons.up)))),a.append(e("<td>").append(e("<span>").addClass("timepicker-minute").attr("data-time-component","minutes").attr("data-action","showMinutes"))),r.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","decrementMinutes").append(e("<span>").addClass(n.icons.down))))),x("s")&&(x("m")&&(t.append(e("<td>").addClass("separator")),a.append(e("<td>").addClass("separator").html(":")),r.append(e("<td>").addClass("separator"))),t.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","incrementSeconds").append(e("<span>").addClass(n.icons.up)))),a.append(e("<td>").append(e("<span>").addClass("timepicker-second").attr("data-time-component","seconds").attr("data-action","showSeconds"))),r.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1"}).addClass("btn").attr("data-action","decrementSeconds").append(e("<span>").addClass(n.icons.down))))),i||(t.append(e("<td>").addClass("separator")),a.append(e("<td>").append(e("<button>").addClass("btn btn-primary").attr("data-action","togglePeriod"))),r.append(e("<td>").addClass("separator"))),e("<div>").addClass("timepicker-picker").append(e("<table>").addClass("table-condensed").append([t,a,r]))},E=function(){var t=e("<div>").addClass("timepicker-hours").append(e("<table>").addClass("table-condensed")),a=e("<div>").addClass("timepicker-minutes").append(e("<table>").addClass("table-condensed")),n=e("<div>").addClass("timepicker-seconds").append(e("<table>").addClass("table-condensed")),r=[O()]
return x("h")&&r.push(t),x("m")&&r.push(a),x("s")&&r.push(n),r},P=function(){var t=[]
return n.showTodayButton&&t.push(e("<td>").append(e("<a>").attr("data-action","today").append(e("<span>").addClass(n.icons.today)))),!n.sideBySide&&T()&&D()&&t.push(e("<td>").append(e("<a>").attr("data-action","togglePicker").append(e("<span>").addClass(n.icons.time)))),n.showClear&&t.push(e("<td>").append(e("<a>").attr("data-action","clear").append(e("<span>").addClass(n.icons.clear)))),n.showClose&&t.push(e("<td>").append(e("<a>").attr("data-action","close").append(e("<span>").addClass(n.icons.close)))),e("<table>").addClass("table-condensed").append(e("<tbody>").append(e("<tr>").append(t)))},S=function(){var t=e("<div>").addClass("bootstrap-datetimepicker-widget dropdown-menu"),a=e("<div>").addClass("datepicker").append(M()),r=e("<div>").addClass("timepicker").append(E()),o=e("<ul>").addClass("list-unstyled"),d=e("<li>").addClass("picker-switch"+(n.collapse?" accordion-toggle":"")).append(P())
return n.inline&&t.removeClass("dropdown-menu"),i&&t.addClass("usetwentyfour"),n.sideBySide&&T()&&D()?(t.addClass("timepicker-sbs"),t.append(e("<div>").addClass("row").append(a.addClass("col-sm-6")).append(r.addClass("col-sm-6"))),t.append(d),t):("top"===n.toolbarPlacement&&o.append(d),T()&&o.append(e("<li>").addClass(n.collapse&&D()?"collapse in":"").append(a)),"default"===n.toolbarPlacement&&o.append(d),D()&&o.append(e("<li>").addClass(n.collapse&&T()?"collapse":"").append(r)),"bottom"===n.toolbarPlacement&&o.append(d),t.append(o))},B=function(){var t,r={}
return t=a.is("input")||n.inline?a.data():a.find("input").data(),t.dateOptions&&t.dateOptions instanceof Object&&(r=e.extend(!0,r,t.dateOptions)),e.each(n,function(e){var a="date"+e.charAt(0).toUpperCase()+e.slice(1)
void 0!==t[a]&&(r[e]=t[a])}),r},j=function(){var t,r=(u||a).position(),i=(u||a).offset(),o=n.widgetPositioning.vertical,d=n.widgetPositioning.horizontal
if(n.widgetParent)t=n.widgetParent.append(h)
else if(a.is("input"))t=a.parent().append(h)
else{if(n.inline)return void(t=a.append(h))
t=a,a.children().first().after(h)}if("auto"===o&&(o=i.top+1.5*h.height()>=e(window).height()+e(window).scrollTop()&&h.height()+a.outerHeight()<i.top?"top":"bottom"),"auto"===d&&(d=t.width()<i.left+h.outerWidth()/2&&i.left+h.outerWidth()>e(window).width()?"right":"left"),"top"===o?h.addClass("top").removeClass("bottom"):h.addClass("bottom").removeClass("top"),"right"===d?h.addClass("pull-right"):h.removeClass("pull-right"),"relative"!==t.css("position")&&(t=t.parents().filter(function(){return"relative"===e(this).css("position")}).first()),0===t.length)throw new Error("datetimepicker component should be placed within a relative positioned container")
h.css({top:"top"===o?"auto":r.top+a.outerHeight(),bottom:"top"===o?r.top+a.outerHeight():"auto",left:"left"===d?t.css("padding-left"):"auto",right:"left"===d?"auto":t.width()-a.outerWidth()})},H=function(e){"dp.change"===e.type&&(e.date&&e.date.isSame(e.oldDate)||!e.date&&!e.oldDate)||a.trigger(e)},I=function(e){h&&(e&&(s=Math.max(m,Math.min(2,s+e))),h.find(".datepicker > div").hide().filter(".datepicker-"+y[s].clsName).show())},F=function(){var t=e("<tr>"),a=c.clone().startOf("w")
for(n.calendarWeeks===!0&&t.append(e("<th>").addClass("cw").text("#"));a.isBefore(c.clone().endOf("w"));)t.append(e("<th>").addClass("dow").text(a.format("dd"))),a.add(1,"d")
h.find(".datepicker-days thead").append(t)},L=function(e){return n.disabledDates[e.format("YYYY-MM-DD")]===!0},Y=function(e){return n.enabledDates[e.format("YYYY-MM-DD")]===!0},W=function(e,t){return!!e.isValid()&&((!n.disabledDates||!L(e)||"M"===t)&&(!(n.enabledDates&&!Y(e)&&"M"!==t)&&((!n.minDate||!e.isBefore(n.minDate,t))&&((!n.maxDate||!e.isAfter(n.maxDate,t))&&("d"!==t||-1===n.daysOfWeekDisabled.indexOf(e.day()))))))},q=function(){for(var t=[],a=c.clone().startOf("y").hour(12);a.isSame(c,"y");)t.push(e("<span>").attr("data-action","selectMonth").addClass("month").text(a.format("MMM"))),a.add(1,"M")
h.find(".datepicker-months td").empty().append(t)},z=function(){var t=h.find(".datepicker-months"),a=t.find("th"),n=t.find("tbody").find("span")
t.find(".disabled").removeClass("disabled"),W(c.clone().subtract(1,"y"),"y")||a.eq(0).addClass("disabled"),a.eq(1).text(c.year()),W(c.clone().add(1,"y"),"y")||a.eq(2).addClass("disabled"),n.removeClass("active"),l.isSame(c,"y")&&n.eq(l.month()).addClass("active"),n.each(function(t){W(c.clone().month(t),"M")||e(this).addClass("disabled")})},A=function(){var e=h.find(".datepicker-years"),t=e.find("th"),a=c.clone().subtract(5,"y"),r=c.clone().add(6,"y"),i=""
for(e.find(".disabled").removeClass("disabled"),n.minDate&&n.minDate.isAfter(a,"y")&&t.eq(0).addClass("disabled"),t.eq(1).text(a.year()+"-"+r.year()),n.maxDate&&n.maxDate.isBefore(r,"y")&&t.eq(2).addClass("disabled");!a.isAfter(r,"y");)i+='<span data-action="selectYear" class="year'+(a.isSame(l,"y")?" active":"")+(W(a,"y")?"":" disabled")+'">'+a.year()+"</span>",a.add(1,"y")
e.find("td").html(i)},V=function(){var a,r,i,o=h.find(".datepicker-days"),d=o.find("th"),s=[]
if(T()){for(o.find(".disabled").removeClass("disabled"),d.eq(1).text(c.format(n.dayViewHeaderFormat)),W(c.clone().subtract(1,"M"),"M")||d.eq(0).addClass("disabled"),W(c.clone().add(1,"M"),"M")||d.eq(2).addClass("disabled"),a=c.clone().startOf("M").startOf("week");!c.clone().endOf("M").endOf("w").isBefore(a,"d");)0===a.weekday()&&(r=e("<tr>"),n.calendarWeeks&&r.append('<td class="cw">'+a.week()+"</td>"),s.push(r)),i="",a.isBefore(c,"M")&&(i+=" old"),a.isAfter(c,"M")&&(i+=" new"),a.isSame(l,"d")&&!f&&(i+=" active"),W(a,"d")||(i+=" disabled"),a.isSame(t(),"d")&&(i+=" today"),(0===a.day()||6===a.day())&&(i+=" weekend"),r.append('<td data-action="selectDay" class="day'+i+'">'+a.date()+"</td>"),a.add(1,"d")
o.find("tbody").empty().append(s),z(),A()}},N=function(){var t=h.find(".timepicker-hours table"),a=c.clone().startOf("d"),n=[],r=e("<tr>")
for(c.hour()>11&&!i&&a.hour(12);a.isSame(c,"d")&&(i||c.hour()<12&&a.hour()<12||c.hour()>11);)a.hour()%4===0&&(r=e("<tr>"),n.push(r)),r.append('<td data-action="selectHour" class="hour'+(W(a,"h")?"":" disabled")+'">'+a.format(i?"HH":"hh")+"</td>"),a.add(1,"h")
t.empty().append(n)},R=function(){for(var t=h.find(".timepicker-minutes table"),a=c.clone().startOf("h"),r=[],i=e("<tr>"),o=1===n.stepping?5:n.stepping;c.isSame(a,"h");)a.minute()%(4*o)===0&&(i=e("<tr>"),r.push(i)),i.append('<td data-action="selectMinute" class="minute'+(W(a,"m")?"":" disabled")+'">'+a.format("mm")+"</td>"),a.add(o,"m")
t.empty().append(r)},Q=function(){for(var t=h.find(".timepicker-seconds table"),a=c.clone().startOf("m"),n=[],r=e("<tr>");c.isSame(a,"m");)a.second()%20===0&&(r=e("<tr>"),n.push(r)),r.append('<td data-action="selectSecond" class="second'+(W(a,"s")?"":" disabled")+'">'+a.format("ss")+"</td>"),a.add(5,"s")
t.empty().append(n)},U=function(){var e=h.find(".timepicker span[data-time-component]")
i||h.find(".timepicker [data-action=togglePeriod]").text(l.format("A")),e.filter("[data-time-component=hours]").text(l.format(i?"HH":"hh")),e.filter("[data-time-component=minutes]").text(l.format("mm")),e.filter("[data-time-component=seconds]").text(l.format("ss")),N(),R(),Q()},G=function(){h&&(V(),U())},J=function(e){var t=f?null:l
return e?(e=e.clone().locale(n.locale),1!==n.stepping&&e.minutes(Math.round(e.minutes()/n.stepping)*n.stepping%60).seconds(0),void(W(e)?(l=e,c=l.clone(),r.val(l.format(o)),a.data("date",l.format(o)),G(),f=!1,H({type:"dp.change",date:l.clone(),oldDate:t})):(n.keepInvalid||r.val(f?"":l.format(o)),H({type:"dp.error",date:e})))):(f=!0,r.val(""),a.data("date",""),H({type:"dp.change",date:null,oldDate:t}),void G())},K=function(){var t=!1
return h?(h.find(".collapse").each(function(){var a=e(this).data("collapse")
return!a||!a.transitioning||(t=!0,!1)}),t?p:(u&&u.hasClass("btn")&&u.toggleClass("active"),h.hide(),e(window).off("resize",j),h.off("click","[data-action]"),h.off("mousedown",!1),h.remove(),h=!1,H({type:"dp.hide",date:l.clone()}),p)):p},X=function(){J(null)},Z={next:function(){c.add(y[s].navStep,y[s].navFnc),V()},previous:function(){c.subtract(y[s].navStep,y[s].navFnc),V()},pickerSwitch:function(){I(1)},selectMonth:function(t){var a=e(t.target).closest("tbody").find("span").index(e(t.target))
c.month(a),s===m?(J(l.clone().year(c.year()).month(c.month())),n.inline||K()):(I(-1),V())},selectYear:function(t){var a=parseInt(e(t.target).text(),10)||0
c.year(a),s===m?(J(l.clone().year(c.year())),n.inline||K()):(I(-1),V())},selectDay:function(t){var a=c.clone()
e(t.target).is(".old")&&a.subtract(1,"M"),e(t.target).is(".new")&&a.add(1,"M"),J(a.date(parseInt(e(t.target).text(),10))),D()||n.keepOpen||n.inline||K()},incrementHours:function(){J(l.clone().add(1,"h"))},incrementMinutes:function(){J(l.clone().add(n.stepping,"m"))},incrementSeconds:function(){J(l.clone().add(1,"s"))},decrementHours:function(){J(l.clone().subtract(1,"h"))},decrementMinutes:function(){J(l.clone().subtract(n.stepping,"m"))},decrementSeconds:function(){J(l.clone().subtract(1,"s"))},togglePeriod:function(){J(l.clone().add(l.hours()>=12?-12:12,"h"))},togglePicker:function(t){var a,r=e(t.target),i=r.closest("ul"),o=i.find(".in"),d=i.find(".collapse:not(.in)")
if(o&&o.length){if(a=o.data("collapse"),a&&a.transitioning)return
o.collapse?(o.collapse("hide"),d.collapse("show")):(o.removeClass("in"),d.addClass("in")),r.is("span")?r.toggleClass(n.icons.time+" "+n.icons.date):r.find("span").toggleClass(n.icons.time+" "+n.icons.date)}},showPicker:function(){h.find(".timepicker > div:not(.timepicker-picker)").hide(),h.find(".timepicker .timepicker-picker").show()},showHours:function(){h.find(".timepicker .timepicker-picker").hide(),h.find(".timepicker .timepicker-hours").show()},showMinutes:function(){h.find(".timepicker .timepicker-picker").hide(),h.find(".timepicker .timepicker-minutes").show()},showSeconds:function(){h.find(".timepicker .timepicker-picker").hide(),h.find(".timepicker .timepicker-seconds").show()},selectHour:function(t){var a=parseInt(e(t.target).text(),10)
i||(l.hours()>=12?12!==a&&(a+=12):12===a&&(a=0)),J(l.clone().hours(a)),Z.showPicker.call(p)},selectMinute:function(t){J(l.clone().minutes(parseInt(e(t.target).text(),10))),Z.showPicker.call(p)},selectSecond:function(t){J(l.clone().seconds(parseInt(e(t.target).text(),10))),Z.showPicker.call(p)},clear:X,today:function(){J(t())},close:K},$=function(t){return!e(t.currentTarget).is(".disabled")&&(Z[e(t.currentTarget).data("action")].apply(p,arguments),!1)},_=function(){var a,i={year:function(e){return e.month(0).date(1).hours(0).seconds(0).minutes(0)},month:function(e){return e.date(1).hours(0).seconds(0).minutes(0)},day:function(e){return e.hours(0).seconds(0).minutes(0)},hour:function(e){return e.seconds(0).minutes(0)},minute:function(e){return e.seconds(0)}}
return r.prop("disabled")||!n.ignoreReadonly&&r.prop("readonly")||h?p:(n.useCurrent&&f&&(r.is("input")&&0===r.val().trim().length||n.inline)&&(a=t(),"string"==typeof n.useCurrent&&(a=i[n.useCurrent](a)),J(a)),h=S(),F(),q(),h.find(".timepicker-hours").hide(),h.find(".timepicker-minutes").hide(),h.find(".timepicker-seconds").hide(),G(),I(),e(window).on("resize",j),h.on("click","[data-action]",$),h.on("mousedown",!1),u&&u.hasClass("btn")&&u.toggleClass("active"),h.show(),j(),r.is(":focus")||r.focus(),H({type:"dp.show"}),p)},ee=function(){return h?K():_()},te=function(e){return e=t.isMoment(e)||e instanceof Date?t(e):t(e,d,n.useStrict),e.locale(n.locale),e},ae=function(e){var t,a,r,i,o=null,d=[],s={},l=e.which,c="p"
C[l]=c
for(t in C)C.hasOwnProperty(t)&&C[t]===c&&(d.push(t),parseInt(t,10)!==l&&(s[t]=!0))
for(t in n.keyBinds)if(n.keyBinds.hasOwnProperty(t)&&"function"==typeof n.keyBinds[t]&&(r=t.split(" "),r.length===d.length&&k[l]===r[r.length-1])){for(i=!0,a=r.length-2;a>=0;a--)if(!(k[r[a]]in s)){i=!1
break}if(i){o=n.keyBinds[t]
break}}o&&(o.call(p,h),e.stopPropagation(),e.preventDefault())},ne=function(e){C[e.which]="r",e.stopPropagation(),e.preventDefault()},re=function(t){var a=e(t.target).val().trim(),n=a?te(a):null
return J(n),t.stopImmediatePropagation(),!1},ie=function(){r.on({change:re,blur:n.debug?"":K,keydown:ae,keyup:ne}),a.is("input")?r.on({focus:_}):u&&(u.on("click",ee),u.on("mousedown",!1))},oe=function(){r.off({change:re,blur:K,keydown:ae,keyup:ne}),a.is("input")?r.off({focus:_}):u&&(u.off("click",ee),u.off("mousedown",!1))},de=function(t){var a={}
return e.each(t,function(){var e=te(this)
e.isValid()&&(a[e.format("YYYY-MM-DD")]=!0)}),!!Object.keys(a).length&&a},se=function(){var e=n.format||"L LT"
o=e.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(e){var t=l.localeData().longDateFormat(e)||e
return t.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(e){return l.localeData().longDateFormat(e)||e})}),d=n.extraFormats?n.extraFormats.slice():[],d.indexOf(e)<0&&d.indexOf(o)<0&&d.push(o),i=o.toLowerCase().indexOf("a")<1&&o.indexOf("h")<1,x("y")&&(m=2),x("M")&&(m=1),x("d")&&(m=0),s=Math.max(m,s),f||J(l)}
if(p.destroy=function(){K(),oe(),a.removeData("DateTimePicker"),a.removeData("date")},p.toggle=ee,p.show=_,p.hide=K,p.disable=function(){return K(),u&&u.hasClass("btn")&&u.addClass("disabled"),r.prop("disabled",!0),p},p.enable=function(){return u&&u.hasClass("btn")&&u.removeClass("disabled"),r.prop("disabled",!1),p},p.ignoreReadonly=function(e){if(0===arguments.length)return n.ignoreReadonly
if("boolean"!=typeof e)throw new TypeError("ignoreReadonly () expects a boolean parameter")
return n.ignoreReadonly=e,p},p.options=function(t){if(0===arguments.length)return e.extend(!0,{},n)
if(!(t instanceof Object))throw new TypeError("options() options parameter should be an object")
return e.extend(!0,n,t),e.each(n,function(e,t){if(void 0===p[e])throw new TypeError("option "+e+" is not recognized!")
p[e](t)}),p},p.date=function(e){if(0===arguments.length)return f?null:l.clone()
if(!(null===e||"string"==typeof e||t.isMoment(e)||e instanceof Date))throw new TypeError("date() parameter must be one of [null, string, moment or Date]")
return J(null===e?null:te(e)),p},p.format=function(e){if(0===arguments.length)return n.format
if("string"!=typeof e&&("boolean"!=typeof e||e!==!1))throw new TypeError("format() expects a sting or boolean:false parameter "+e)
return n.format=e,o&&se(),p},p.dayViewHeaderFormat=function(e){if(0===arguments.length)return n.dayViewHeaderFormat
if("string"!=typeof e)throw new TypeError("dayViewHeaderFormat() expects a string parameter")
return n.dayViewHeaderFormat=e,p},p.extraFormats=function(e){if(0===arguments.length)return n.extraFormats
if(e!==!1&&!(e instanceof Array))throw new TypeError("extraFormats() expects an array or false parameter")
return n.extraFormats=e,d&&se(),p},p.disabledDates=function(t){if(0===arguments.length)return n.disabledDates?e.extend({},n.disabledDates):n.disabledDates
if(!t)return n.disabledDates=!1,G(),p
if(!(t instanceof Array))throw new TypeError("disabledDates() expects an array parameter")
return n.disabledDates=de(t),n.enabledDates=!1,G(),p},p.enabledDates=function(t){if(0===arguments.length)return n.enabledDates?e.extend({},n.enabledDates):n.enabledDates
if(!t)return n.enabledDates=!1,G(),p
if(!(t instanceof Array))throw new TypeError("enabledDates() expects an array parameter")
return n.enabledDates=de(t),n.disabledDates=!1,G(),p},p.daysOfWeekDisabled=function(e){if(0===arguments.length)return n.daysOfWeekDisabled.splice(0)
if(!(e instanceof Array))throw new TypeError("daysOfWeekDisabled() expects an array parameter")
return n.daysOfWeekDisabled=e.reduce(function(e,t){return t=parseInt(t,10),t>6||0>t||isNaN(t)?e:(-1===e.indexOf(t)&&e.push(t),e)},[]).sort(),G(),p},p.maxDate=function(e){if(0===arguments.length)return n.maxDate?n.maxDate.clone():n.maxDate
if("boolean"==typeof e&&e===!1)return n.maxDate=!1,G(),p
"string"==typeof e&&("now"===e||"moment"===e)&&(e=t())
var a=te(e)
if(!a.isValid())throw new TypeError("maxDate() Could not parse date parameter: "+e)
if(n.minDate&&a.isBefore(n.minDate))throw new TypeError("maxDate() date parameter is before options.minDate: "+a.format(o))
return n.maxDate=a,n.maxDate.isBefore(e)&&J(n.maxDate),c.isAfter(a)&&(c=a.clone()),G(),p},p.minDate=function(e){if(0===arguments.length)return n.minDate?n.minDate.clone():n.minDate
if("boolean"==typeof e&&e===!1)return n.minDate=!1,G(),p
"string"==typeof e&&("now"===e||"moment"===e)&&(e=t())
var a=te(e)
if(!a.isValid())throw new TypeError("minDate() Could not parse date parameter: "+e)
if(n.maxDate&&a.isAfter(n.maxDate))throw new TypeError("minDate() date parameter is after options.maxDate: "+a.format(o))
return n.minDate=a,n.minDate.isAfter(e)&&J(n.minDate),c.isBefore(a)&&(c=a.clone()),G(),p},p.defaultDate=function(e){if(0===arguments.length)return n.defaultDate?n.defaultDate.clone():n.defaultDate
if(!e)return n.defaultDate=!1,p
"string"==typeof e&&("now"===e||"moment"===e)&&(e=t())
var a=te(e)
if(!a.isValid())throw new TypeError("defaultDate() Could not parse date parameter: "+e)
if(!W(a))throw new TypeError("defaultDate() date passed is invalid according to component setup validations")
return n.defaultDate=a,n.defaultDate&&""===r.val().trim()&&void 0===r.attr("placeholder")&&J(n.defaultDate),p},p.locale=function(e){if(0===arguments.length)return n.locale
if(!t.localeData(e))throw new TypeError("locale() locale "+e+" is not loaded from moment locales!")
return n.locale=e,l.locale(n.locale),c.locale(n.locale),o&&se(),h&&(K(),_()),p},p.stepping=function(e){return 0===arguments.length?n.stepping:(e=parseInt(e,10),(isNaN(e)||1>e)&&(e=1),n.stepping=e,p)},p.useCurrent=function(e){var t=["year","month","day","hour","minute"]
if(0===arguments.length)return n.useCurrent
if("boolean"!=typeof e&&"string"!=typeof e)throw new TypeError("useCurrent() expects a boolean or string parameter")
if("string"==typeof e&&-1===t.indexOf(e.toLowerCase()))throw new TypeError("useCurrent() expects a string parameter of "+t.join(", "))
return n.useCurrent=e,p},p.collapse=function(e){if(0===arguments.length)return n.collapse
if("boolean"!=typeof e)throw new TypeError("collapse() expects a boolean parameter")
return n.collapse===e?p:(n.collapse=e,h&&(K(),_()),p)},p.icons=function(t){if(0===arguments.length)return e.extend({},n.icons)
if(!(t instanceof Object))throw new TypeError("icons() expects parameter to be an Object")
return e.extend(n.icons,t),h&&(K(),_()),p},p.useStrict=function(e){if(0===arguments.length)return n.useStrict
if("boolean"!=typeof e)throw new TypeError("useStrict() expects a boolean parameter")
return n.useStrict=e,p},p.sideBySide=function(e){if(0===arguments.length)return n.sideBySide
if("boolean"!=typeof e)throw new TypeError("sideBySide() expects a boolean parameter")
return n.sideBySide=e,h&&(K(),_()),p},p.viewMode=function(e){if(0===arguments.length)return n.viewMode
if("string"!=typeof e)throw new TypeError("viewMode() expects a string parameter")
if(-1===w.indexOf(e))throw new TypeError("viewMode() parameter must be one of ("+w.join(", ")+") value")
return n.viewMode=e,s=Math.max(w.indexOf(e),m),I(),p},p.toolbarPlacement=function(e){if(0===arguments.length)return n.toolbarPlacement
if("string"!=typeof e)throw new TypeError("toolbarPlacement() expects a string parameter")
if(-1===v.indexOf(e))throw new TypeError("toolbarPlacement() parameter must be one of ("+v.join(", ")+") value")
return n.toolbarPlacement=e,h&&(K(),_()),p},p.widgetPositioning=function(t){if(0===arguments.length)return e.extend({},n.widgetPositioning)
if("[object Object]"!=={}.toString.call(t))throw new TypeError("widgetPositioning() expects an object variable")
if(t.horizontal){if("string"!=typeof t.horizontal)throw new TypeError("widgetPositioning() horizontal variable must be a string")
if(t.horizontal=t.horizontal.toLowerCase(),-1===b.indexOf(t.horizontal))throw new TypeError("widgetPositioning() expects horizontal parameter to be one of ("+b.join(", ")+")")
n.widgetPositioning.horizontal=t.horizontal}if(t.vertical){if("string"!=typeof t.vertical)throw new TypeError("widgetPositioning() vertical variable must be a string")
if(t.vertical=t.vertical.toLowerCase(),-1===g.indexOf(t.vertical))throw new TypeError("widgetPositioning() expects vertical parameter to be one of ("+g.join(", ")+")")
n.widgetPositioning.vertical=t.vertical}return G(),p},p.calendarWeeks=function(e){if(0===arguments.length)return n.calendarWeeks
if("boolean"!=typeof e)throw new TypeError("calendarWeeks() expects parameter to be a boolean value")
return n.calendarWeeks=e,G(),p},p.showTodayButton=function(e){if(0===arguments.length)return n.showTodayButton
if("boolean"!=typeof e)throw new TypeError("showTodayButton() expects a boolean parameter")
return n.showTodayButton=e,h&&(K(),_()),p},p.showClear=function(e){if(0===arguments.length)return n.showClear
if("boolean"!=typeof e)throw new TypeError("showClear() expects a boolean parameter")
return n.showClear=e,h&&(K(),_()),p},p.widgetParent=function(t){if(0===arguments.length)return n.widgetParent
if("string"==typeof t&&(t=e(t)),null!==t&&"string"!=typeof t&&!(t instanceof e))throw new TypeError("widgetParent() expects a string or a jQuery object parameter")
return n.widgetParent=t,h&&(K(),_()),p},p.keepOpen=function(e){if(0===arguments.length)return n.keepOpen
if("boolean"!=typeof e)throw new TypeError("keepOpen() expects a boolean parameter")
return n.keepOpen=e,p},p.inline=function(e){if(0===arguments.length)return n.inline
if("boolean"!=typeof e)throw new TypeError("inline() expects a boolean parameter")
return n.inline=e,p},p.clear=function(){return X(),p},p.keyBinds=function(e){return n.keyBinds=e,p},p.debug=function(e){if("boolean"!=typeof e)throw new TypeError("debug() expects a boolean parameter")
return n.debug=e,p},p.showClose=function(e){if(0===arguments.length)return n.showClose
if("boolean"!=typeof e)throw new TypeError("showClose() expects a boolean parameter")
return n.showClose=e,p},p.keepInvalid=function(e){if(0===arguments.length)return n.keepInvalid
if("boolean"!=typeof e)throw new TypeError("keepInvalid() expects a boolean parameter")
return n.keepInvalid=e,p},p.datepickerInput=function(e){if(0===arguments.length)return n.datepickerInput
if("string"!=typeof e)throw new TypeError("datepickerInput() expects a string parameter")
return n.datepickerInput=e,p},a.is("input"))r=a
else if(r=a.find(n.datepickerInput),0===r.size())r=a.find("input")
else if(!r.is("input"))throw new Error('CSS class "'+n.datepickerInput+'" cannot be applied to non input element')
if(a.hasClass("input-group")&&(u=a.find(0===a.find(".datepickerbutton").size()?'[class^="input-group-"]':".datepickerbutton")),!n.inline&&!r.is("input"))throw new Error("Could not initialize DateTimePicker without an input element")
return e.extend(!0,n,B()),p.options(n),se(),ie(),r.prop("disabled")&&p.disable(),r.is("input")&&0!==r.val().trim().length?J(te(r.val().trim())):n.defaultDate&&void 0===r.attr("placeholder")&&J(n.defaultDate),n.inline&&_(),p}
e.fn.datetimepicker=function(t){return this.each(function(){var n=e(this)
n.data("DateTimePicker")||(t=e.extend(!0,{},e.fn.datetimepicker.defaults,t),n.data("DateTimePicker",a(n,t)))})},e.fn.datetimepicker.defaults={format:!1,dayViewHeaderFormat:"MMMM YYYY",extraFormats:!1,stepping:1,minDate:!1,maxDate:!1,useCurrent:!0,collapse:!0,locale:t.locale(),defaultDate:!1,disabledDates:!1,enabledDates:!1,icons:{time:"glyphicon glyphicon-time",date:"glyphicon glyphicon-calendar",up:"glyphicon glyphicon-chevron-up",down:"glyphicon glyphicon-chevron-down",previous:"glyphicon glyphicon-chevron-left",next:"glyphicon glyphicon-chevron-right",today:"glyphicon glyphicon-screenshot",clear:"glyphicon glyphicon-trash",close:"glyphicon glyphicon-remove"},useStrict:!1,sideBySide:!1,daysOfWeekDisabled:[],calendarWeeks:!1,viewMode:"days",toolbarPlacement:"default",showTodayButton:!1,showClear:!1,showClose:!1,widgetPositioning:{horizontal:"auto",vertical:"auto"},widgetParent:null,ignoreReadonly:!1,keepOpen:!1,inline:!1,keepInvalid:!1,datepickerInput:".datepickerinput",keyBinds:{up:function(e){if(e){var a=this.date()||t()
this.date(e.find(".datepicker").is(":visible")?a.clone().subtract(7,"d"):a.clone().add(1,"m"))}},down:function(e){if(!e)return void this.show()
var a=this.date()||t()
this.date(e.find(".datepicker").is(":visible")?a.clone().add(7,"d"):a.clone().subtract(1,"m"))},"control up":function(e){if(e){var a=this.date()||t()
this.date(e.find(".datepicker").is(":visible")?a.clone().subtract(1,"y"):a.clone().add(1,"h"))}},"control down":function(e){if(e){var a=this.date()||t()
this.date(e.find(".datepicker").is(":visible")?a.clone().add(1,"y"):a.clone().subtract(1,"h"))}},left:function(e){if(e){var a=this.date()||t()
e.find(".datepicker").is(":visible")&&this.date(a.clone().subtract(1,"d"))}},right:function(e){if(e){var a=this.date()||t()
e.find(".datepicker").is(":visible")&&this.date(a.clone().add(1,"d"))}},pageUp:function(e){if(e){var a=this.date()||t()
e.find(".datepicker").is(":visible")&&this.date(a.clone().subtract(1,"M"))}},pageDown:function(e){if(e){var a=this.date()||t()
e.find(".datepicker").is(":visible")&&this.date(a.clone().add(1,"M"))}},enter:function(){this.hide()},escape:function(){this.hide()},"control space":function(e){e.find(".timepicker").is(":visible")&&e.find('.btn[data-action="togglePeriod"]').click()},t:function(){this.date(t())},"delete":function(){this.clear()}},debug:!1}})
