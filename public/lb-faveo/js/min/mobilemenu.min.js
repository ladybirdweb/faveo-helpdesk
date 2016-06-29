/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.1(27-JULY-2013)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 * 	 http://github.com/mambows/mobilemenu
 */
!function(e){e.fn.mobileMenu=function(s){var a={defaultText:"Navigate to...",className:"select-menu",subMenuClass:"sub-menu",subMenuDash:"&ndash;"},n=e.extend(a,s),t=e(this)
return this.each(function(){var s,a=e(this)
a.find("ul").addClass(n.subMenuClass)
var s=e("<select />",{"class":n.className+" "+t.get(0).className}).insertAfter(a)
e("<option />",{value:"#",text:n.defaultText}).appendTo(s),a.find("a").each(function(){var a,t=e(this),u="&nbsp;"+t.text(),i=t.parents("."+n.subMenuClass),l=i.length
t.parents("ul").hasClass(n.subMenuClass)&&(a=Array(l+1).join(n.subMenuDash),u=a+u),e("<option />",{value:this.href,html:u,selected:this.href==window.location.href}).appendTo(s)}),s.change(function(){var s=e(this).val()
"#"!==s&&(window.location.href=e(this).val())})}),this}}(jQuery)
