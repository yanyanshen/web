$(document).ready(function() {
    /*首页幻灯*/
    C_banner($("#banner"), $("#banner_dl"), 5000);
});
//banner
function C_banner(obj, obj1, t) {
    var items = obj.find(".banner-item");
    var bd_html = "", cfq = null, auto = null;
    var items_length = items.length;
    for (var i = 0; i < items_length; i++) {
        var pic_src = items.find("img").eq(i).attr("src");
        items.eq(i).css('background','url(' + pic_src + ') center center no-repeat');
        bd_html += '<a href="javascript:void(0)"></a>';
    }
    /*daixiaorui.com*/
    obj1.html(bd_html);
    var tool_items = obj1.find("a");

    show_item(0);
    tool_items.mouseover(function() {
        clearTimeout(cfq);
        var _this = $(this);
        cfq = setTimeout(function() {
            clearTimeout(auto);
            show_item(_this.prevAll().length);
        }, 100);
    });
    tool_items.mouseout(function() {
        clearTimeout(cfq);
    });
    function show_item(j) {
        items.fadeOut("slow");
        tool_items.removeClass("cur");
        items.eq(j).fadeIn("slow");
        tool_items.eq(j).addClass("cur");
        auto_run();
    };
    function auto_run() {
        auto = setTimeout(function() {
            var x = obj1.find("a.cur").eq(0).prevAll().length;
            if ((x + 1) < tool_items.length) {
                show_item(x + 1);
            } else {
                show_item(0);
            }
        }, t);
    };
};