$(function(){$(".tabs a, .tabs button").click(function(a){a.preventDefault()
var s=$(this).attr("data-target")
$(this).addClass("active").parent().addClass("active"),$(this).siblings().removeClass("active"),$(this).parent("li").siblings().removeClass("active").children().removeClass("active"),$(s).addClass("active"),$(s).siblings().removeClass("active")})}),function(a){a(function(){a("body").addClass("js")})}(jQuery)
