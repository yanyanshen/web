// JavaScript Document
$(function () {
    GetCity(0);//页面加载时就现实数据库第一个数据，一定要加上
    $("#selNation").change(function () {
        // 当省级改变的时候，让市级和县级文本清空
        $("#selCity option").remove();
        $("#litel option").remove();
        //获得省级的id
        var id = $("#selNation option:selected").attr("id");
        //查询该省级的市级数据
        GetCity(id, 'city');
    })
    $("#selCity").change(function () {
        // 当市级改变的时候，让县级文本清空
        $("#litel option").remove();
        //获得市级的id
        var id = $("#selCity option:selected").attr("id");
        //查询该省市级的县级数据
        GetCity(id, 'county');
    })
    //解决类似北京只有一个城市的情况
    $("#selCity").click(function () {
        $("#litel option").remove();
        var id = $("#selCity option:selected").attr("id");
        GetCity(id, 'county');
    })
});
function GetCity(pid, c) {
    var LoadCityUrl = $("#LoadCityUrl").val(); //获得后台要访问的url,这里访问的就是上面后台代码所在的类中
    //执行ajax请求
    $.ajax({ url: 'http://www.xctest.com/Home/Index/index', data: "id= " + pid, type: 'get', success: function (res) {
        var arr = eval(res); //返回的json数据一定要执行evel()方法才能使用循环读取数据，这里很重要；；；
        $.each(arr, function (key, value) {
            if (pid == "0") {//加载省级级下拉框（数据库里面省级的pid都为0）
                $("#selNation").append(" <option id='" + value.tb_AreaId + "'>" + value.AreaName + "</option>");
            }
            else {
                if (c == 'city') {//加载市级下拉框
                    $("#selCity").append(" <option id='" + value.tb_AreaId + "'>" + value.AreaName + "</option>");
                }
                else {//加载县区下拉框
                    $("#litel").append(" <option id='" + value.tb_AreaId + "'>" + value.AreaName + "</option>");
                }
            }
        })
    }
    });
}
