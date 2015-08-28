<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<script type="text/javascript">

var cookieUtil = {
	//写cookies 
	set:function(name,value,day,path) 
	{ 
		var Days = day ? day:30; 
		var _path = path ? path:'/';
	   	
	    var exp = new Date(); 
	    exp.setTime(exp.getTime() + Days*24*60*60*1000); 

	    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString() +";path="+_path; 
	},
	//读取cookies 
	get:function(name) 
	{ 
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	 
	    if(arr=document.cookie.match(reg))
	        return unescape(arr[2]); 
	    else 
	        return null; 
	},
	//删除cookies 
	del:function(name) 
	{ 
	    var exp = new Date(); 
	    exp.setTime(exp.getTime() - 1); 
	    var cval=getCookie(name); 
	    if(cval!=null) 
	        document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
	} 
}

if(cookieUtil.get('preview_hidden') != null){
	if(cookieUtil.get('preview_hidden') == 1){
		$('.preview-top-message').fadeOut();
	}
}else{
	cookieUtil.set('preview_hidden',0,360,'preview/');
}

</script>
<body>
	<div class="preview-top-message" onclick="cookieUtil.set('preview_hidden',1,360);">preview-top-message</div>
</body>
</html>