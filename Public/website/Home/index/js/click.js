/**
 * Created by Administrator on 2017/3/27.
 */
// JavaScript Document
$("document").ready(function(){
    $("#apply_close").click(function(){
        $("#apply_box").css("display","none")
        $("#pack").css("display","block")
    });
    $("#pack").click(function(){
        $("#pack").css("display","none")
        $("#apply_box").css("display","block")
    });
});









