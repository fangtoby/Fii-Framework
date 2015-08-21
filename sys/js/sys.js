$(function () {
    //表格行背景色变化
    $("#list tr:odd").addClass("list-bg1");
    $("#list tr").hover(function () {
        $(this).addClass("list-bg3");
    }, function () {
        $(this).removeClass("list-bg3");
    });

    //关闭layer
    $(".close").click(function(){
        layer.closeAll();
    });
});

//全选
function checkAll(clickObj, checkboxName){
    var n = $(clickObj).attr('name');
    var v = $(clickObj).prop('checked');
    $("input[name='"+checkboxName+"']").prop('checked', v);
    if(n) $("input[name='"+n+"']").prop('checked', v);
}

//获取列表已选复选框id
function getCheckedIds(checkboxName) {
    var str = '';
    $("input[name='"+checkboxName+"']:checked").each(function () {
        str += ',' + $(this).val();
    });
    return str;
}

//动态表单提交
function makeForm(url, method, params) {
    var formX = document.createElement("form");
    formX.id = "formX";
    formX.name = "formX";
    formX.method = method;
    formX.action = url;
    document.body.appendChild(formX);
    if (params){
        var len = params.length;
        for (var i = 0; i < len; i++) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = params[i].name;
            input.value = params[i].value;
            formX.appendChild(input);
        }
        formX.submit();
    }
    document.body.removeChild(formX);
}

//消息框,基于layer
function msg(){
    var str = arguments[0] ? arguments[0] : '';
    var icon = arguments[1] ? arguments[1] : 0;
    var time = arguments[2] ? arguments[2] : 2;
    layer.msg(str, time, {type:icon, shade:[0], rate:'top', offset:['20px','']});
}

//页面层弹出框，基于layer
function myLayer(){
    var dom = arguments[0];
    var title = arguments[1] ? arguments[1] : '';
    var shade = [];
    if (arguments[2] == 1) shade = ['0.5', '#000'];
    else shade = [0];
    var area = arguments[3] ? arguments[3] : ['auto','auto'];
    var zIndex = arguments[4] ? arguments[4] : 99990;
    var i = $.layer({type : 1, title : title, area: area, shade: shade, shadeClose: true, fix : true, zIndex: zIndex, page : {dom : dom}});
    return i;
}
