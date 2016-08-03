+function(t){"use strict"
function o(){var t=document.createElement("gg"),o={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"}
for(var e in o)if(void 0!==t.style[e])return{end:o[e]}
return!1}t.fn.emulateTransitionEnd=function(o){var e=!1,i=this
t(this).one("ggTransitionEnd",function(){e=!0})
var n=function(){e||t(i).trigger(t.support.transition.end)}
return setTimeout(n,o),this},t(function(){t.support.transition=o(),t.support.transition&&(t.event.special.ggTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(o){if(t(o.target).is(this))return o.handleObj.handler.apply(this,arguments)}})})}(jQuery),+function(t){"use strict"
function o(o){return this.each(function(){var i=t(this),n=i.data("gg.tooltip"),r="object"==typeof o&&o;(n||"destroy"!=o)&&(n||i.data("gg.tooltip",n=new e(this,r)),"string"==typeof o&&n[o]())})}var e=function(t,o){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",t,o)}
e.VERSION="2.0",e.TRANSITION_DURATION=150,e.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="ggtooltip" role="tooltip"><div class="arrow-shadow"><div class="arrow"></div></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0},backcolor:"#00ffcc",textcolor:"#000000",bordercolor:"#0066cc"},e.prototype.init=function(o,e,i){this.enabled=!0,this.type=o,this.$element=t(e),this.options=this.getOptions(i),this.$viewport=this.options.viewport&&t(this.options.viewport.selector||this.options.viewport)
for(var n=this.options.trigger.split(" "),r=n.length;r--;){var s=n[r]
if("hover focus"==s)this.$element.on("hover focus."+this.type,this.options.selector,t.proxy(this.toggle,this))
else if("manual"!=s){var p="hover"==s?"mouseenter":"focusin",a="hover"==s?"mouseleave":"focusout"
this.$element.on(p+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(a+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.getOptions=function(o){return o=t.extend({},this.getDefaults(),this.$element.data(),o),o.delay&&"number"==typeof o.delay&&(o.delay={show:o.delay,hide:o.delay}),o},e.prototype.getDelegateOptions=function(){var o={},e=this.getDefaults()
return this._options&&t.each(this._options,function(t,i){e[t]!=i&&(o[t]=i)}),o},e.prototype.enter=function(o){var e=o instanceof this.constructor?o:t(o.currentTarget).data("gg."+this.type)
return e&&e.$tip&&e.$tip.is(":visible")?void(e.hoverState="in"):(e||(e=new this.constructor(o.currentTarget,this.getDelegateOptions()),t(o.currentTarget).data("gg."+this.type,e)),clearTimeout(e.timeout),e.hoverState="in",e.options.delay&&e.options.delay.show?void(e.timeout=setTimeout(function(){"in"==e.hoverState&&e.show()},e.options.delay.show)):e.show())},e.prototype.leave=function(o){var e=o instanceof this.constructor?o:t(o.currentTarget).data("gg."+this.type)
return e||(e=new this.constructor(o.currentTarget,this.getDelegateOptions()),t(o.currentTarget).data("gg."+this.type,e)),clearTimeout(e.timeout),e.hoverState="out",e.options.delay&&e.options.delay.hide?void(e.timeout=setTimeout(function(){"out"==e.hoverState&&e.hide()},e.options.delay.hide)):e.hide()},e.prototype.show=function(){var o=t.Event("show.gg."+this.type)
if(this.hasContent()&&this.enabled){this.$element.trigger(o)
var i=t.contains(this.$element[0].ownerDocument.documentElement,this.$element[0])
if(o.isDefaultPrevented()||!i)return
var n=this,r=this.tip(),s=this.getUID(this.type)
this.setContent(),r.attr("id",s),this.$element.attr("aria-describedby",s),this.options.animation&&r.addClass("fade")
var p="function"==typeof this.options.placement?this.options.placement.call(this,r[0],this.$element[0]):this.options.placement,a=/\s?auto?\s?/i,l=a.test(p)
l&&(p=p.replace(a,"")||"top"),r.detach().css({top:0,left:0,display:"block"}).addClass(p).data("gg."+this.type,this),this.options.container?r.appendTo(this.options.container):r.insertAfter(this.$element)
var h=this.getPosition(),c=r[0].offsetWidth,f=r[0].offsetHeight
if(l){var d=p,g=this.options.container?t(this.options.container):this.$element.parent(),u=this.getPosition(g)
p="bottom"==p&&h.bottom+f>u.bottom?"top":"top"==p&&h.top-f<u.top?"bottom":"right"==p&&h.right+c>u.width?"left":"left"==p&&h.left-c<u.left?"right":p,r.removeClass(d).addClass(p)}var v=this.getCalculatedOffset(p,h,c,f)
this.applyPlacement(v,p)
var y=function(){var t=n.hoverState
n.$element.trigger("shown.gg."+n.type),n.hoverState=null,"out"==t&&n.leave(n)}
t.support.transition&&this.$tip.hasClass("fade")?r.one("ggTransitionEnd",y).emulateTransitionEnd(e.TRANSITION_DURATION):y()}},e.prototype.applyPlacement=function(o,e){var i=this.tip(),n=i[0].offsetWidth,r=i[0].offsetHeight,s=parseInt(i.css("margin-top"),10),p=parseInt(i.css("margin-left"),10)
isNaN(s)&&(s=0),isNaN(p)&&(p=0),o.top=o.top+s,o.left=o.left+p,t.offset.setOffset(i[0],t.extend({using:function(t){i.css({top:Math.round(t.top),left:Math.round(t.left)})}},o),0),i.addClass("in")
var a=i[0].offsetWidth,l=i[0].offsetHeight
"top"==e&&l!=r&&(o.top=o.top+r-l)
var h=this.getViewportAdjustedDelta(e,o,a,l)
h.left?o.left+=h.left:o.top+=h.top
var c=/top|bottom/.test(e),f=c?2*h.left-n+a:2*h.top-r+l,d=c?"offsetWidth":"offsetHeight"
i.offset(o),this.replaceArrow(f,i[0][d],c),this.setStyles(e)},e.prototype.replaceArrow=function(t,o,e){t>0&&(this.arrow().css(e?"left":"top",50*(1-t/o)+"%").css(e?"top":"left",""),this.arrowShadow().css(e?"left":"top",50*(1-t/o)+"%").css(e?"top":"left",""))},e.prototype.setContent=function(){var t=this.tip(),o=this.getTitle()
t.find(".tooltip-inner")[this.options.html?"html":"text"](o),t.removeClass("fade in top bottom left right")},e.prototype.setStyles=function(t){var o=this.tip()
o.find(".tooltip-inner").css({background:this.options.backcolor,color:this.options.textcolor,"border-color":this.options.bordercolor}),o.find(".arrow").css("border-"+t+"-color",this.options.backcolor),o.find(".arrow-shadow").css("border-"+t+"-color",this.options.bordercolor)},e.prototype.hide=function(o){function i(){"in"!=n.hoverState&&r.detach(),n.$element.removeAttr("aria-describedby").trigger("hidden.gg."+n.type),o&&o()}var n=this,r=this.tip(),s=t.Event("hide.gg."+this.type)
if(this.$element.trigger(s),!s.isDefaultPrevented())return r.removeClass("in"),t.support.transition&&this.$tip.hasClass("fade")?r.one("ggTransitionEnd",i).emulateTransitionEnd(e.TRANSITION_DURATION):i(),this.hoverState=null,this},e.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},e.prototype.hasContent=function(){return this.getTitle()},e.prototype.getPosition=function(o){o=o||this.$element
var e=o[0],i="BODY"==e.tagName,n=e.getBoundingClientRect()
null==n.width&&(n=t.extend({},n,{width:n.right-n.left,height:n.bottom-n.top}))
var r=i?{top:0,left:0}:o.offset(),s={scroll:i?document.documentElement.scrollTop||document.body.scrollTop:o.scrollTop()},p=i?{width:t(window).width(),height:t(window).height()}:null
return t.extend({},n,s,p,r)},e.prototype.getCalculatedOffset=function(t,o,e,i){return"bottom"==t?{top:o.top+o.height,left:o.left+o.width/2-e/2}:"top"==t?{top:o.top-i,left:o.left+o.width/2-e/2}:"left"==t?{top:o.top+o.height/2-i/2,left:o.left-e}:{top:o.top+o.height/2-i/2,left:o.left+o.width}},e.prototype.getViewportAdjustedDelta=function(t,o,e,i){var n={top:0,left:0}
if(!this.$viewport)return n
var r=this.options.viewport&&this.options.viewport.padding||0,s=this.getPosition(this.$viewport)
if(/right|left/.test(t)){var p=o.top-r-s.scroll,a=o.top+r-s.scroll+i
p<s.top?n.top=s.top-p:a>s.top+s.height&&(n.top=s.top+s.height-a)}else{var l=o.left-r,h=o.left+r+e
l<s.left?n.left=s.left-l:h>s.width&&(n.left=s.left+s.width-h)}return n},e.prototype.getTitle=function(){var t,o=this.$element,e=this.options
return t=o.attr("data-original-title")||("function"==typeof e.title?e.title.call(o[0]):e.title)},e.prototype.getUID=function(t){do t+=~~(1e6*Math.random())
while(document.getElementById(t))
return t},e.prototype.tip=function(){return this.$tip=this.$tip||t(this.options.template)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},e.prototype.arrowShadow=function(){return this.$arrowShadow=this.$arrowShadow||this.tip().find(".arrow-shadow")},e.prototype.enable=function(){this.enabled=!0},e.prototype.disable=function(){this.enabled=!1},e.prototype.toggleEnabled=function(){this.enabled=!this.enabled},e.prototype.toggle=function(o){var e=this
o&&(e=t(o.currentTarget).data("gg."+this.type),e||(e=new this.constructor(o.currentTarget,this.getDelegateOptions()),t(o.currentTarget).data("gg."+this.type,e))),e.tip().hasClass("in")?e.leave(e):e.enter(e)},e.prototype.destroy=function(){var t=this
clearTimeout(this.timeout),this.hide(function(){t.$element.off("."+t.type).removeData("gg."+t.type)})}
var i=t.fn.ggtooltip
t.fn.ggtooltip=o,t.fn.ggtooltip.Constructor=e,t.fn.ggtooltip.noConflict=function(){return t.fn.ggtooltip=i,this}}(jQuery),+function(t){"use strict"
function o(o){return this.each(function(){var i=t(this),n=i.data("gg.popover"),r="object"==typeof o&&o;(n||"destroy"!=o)&&(n||i.data("gg.popover",n=new e(this,r)),"string"==typeof o&&n[o]())})}var e=function(t,o){this.init("popover",t,o)}
if(!t.fn.ggtooltip)throw new Error("ggPopover requires ggtooltip.js")
e.VERSION="1.0",e.DEFAULTS=t.extend({},t.fn.ggtooltip.Constructor.DEFAULTS,{placement:"right",trigger:"hover focus",content:"",template:'<div class="ggpopover" role="tooltip"><div class="arrow"><div class="after"></div></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',titleBackcolor:"#f7f7f7",titleBordercolor:"#ebebeb",titleTextcolor:"#000000",contentBackcolor:"#ffffff",contentTextcolor:"#000000",bordercolor:"#cccccc",arrowcolor:"#ffffff"}),e.prototype=t.extend({},t.fn.ggtooltip.Constructor.prototype),e.prototype.constructor=e,e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.setContent=function(){var t=this.tip(),o=this.getTitle(),e=this.getContent()
t.find(".popover-title")[this.options.html?"html":"text"](o),t.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof e?"html":"append":"text"](e),t.removeClass("fade top bottom left right in"),t.find(".popover-title").html()||t.find(".popover-title").hide()},e.prototype.setStyles=function(t){var o=this.tip()
this.getTitle()
o.find(".popover-title").css({"background-color":this.options.titleBackcolor,color:this.options.titleTextcolor,"border-bottom-color":this.options.titleBordercolor}),o.find(".popover-content").css({"background-color":this.options.contentBackcolor,color:this.options.contentTextcolor}),o.find(".arrow").css("border-"+t+"-color",this.options.bordercolor),o.find(".arrow > .after").css("border-"+t+"-color",this.options.arrowcolor),o.css({"border-color":this.options.bordercolor})},e.prototype.hasContent=function(){return this.getTitle()||this.getContent()},e.prototype.getContent=function(){var t=this.$element,o=this.options
return t.attr("data-content")||("function"==typeof o.content?o.content.call(t[0]):o.content)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},e.prototype.tip=function(){return this.$tip||(this.$tip=t(this.options.template)),this.$tip}
var i=t.fn.ggpopover
t.fn.ggpopover=o,t.fn.ggpopover.Constructor=e,t.fn.ggpopover.noConflict=function(){return t.fn.ggpopover=i,this}}(jQuery)
