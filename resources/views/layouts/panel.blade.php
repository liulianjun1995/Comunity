<style>


    .tab{
        width: 1200px;
        padding: 0 10px;
        margin: 0 auto;
    }
    .tab span{
        display: inline-block;
        border: 1px solid #009E94;
        border-right: none;
        font-size: 10px;
    }
    .tab span a{
        display: inline-block;
        height: 36px;
        line-height: 36px;
        padding: 0 20px;
        border-right: 1px solid #009E94;
        font-size: 14px;
    }
    .tab>span>a:hover{
        color: #0b76ac;
    }
    .bg-this{
        background-color: #009E94;
        color: floralwhite;
    }
    .fly-search {
        position: relative;
        margin-left: 10px;
        display: inline-block;
        vertical-align: top;
    }
    .fly-search .icon-sousuo {
        position: absolute;
        right: 10px;
        top: 14px;
        color: #999;
        cursor: pointer;
    }
</style>


<div class="layui-tab layui-tab-brief tab">
<span style="margin-left: 13px">
   <a class="bg-this" href="#">全部</a>
   <a href="#">未结帖</a>
   <a href="#">已采纳</a>
   <a href="#">精帖</a>
</span>
    <div class="layui-input-inline" style="margin-left: 30px;width: 200px">
        <div class="fly-search" style="width: 100%">
            <i class="iconfont icon-sousuo" onclick="search($('#searchInput').val())"></i>
            <input style="height: 34px;margin-top: 6px;font-size: 14px" id="searchInput" class="layui-input" autocomplete="off" placeholder="搜索内容" maxlength="10" type="text">
        </div>
    </div>
    <a href="#" style="margin-left: 200px;color: ;">我发表的贴</a>
    <a href="#" style="margin-left: 50px">我收藏的贴</a>
    <a href="/post/add" class="layui-btn" style="float: right">发表新帖</a>
    <script>
        //监听input点击火车事件
        window.onload=function (ev) {
            $("#searchInput").keydown(function (event) {
                if(event.keyCode==13){
                    var input = $('#searchInput').val();
                    search(input);
                }
            })
        }
        //搜索
        function search(input) {
            //搜索操作
            if(input==null || input==""){
                layer.msg('请输入检索内容');
            }else{
                //搜索操作
            }
        }
    </script>
</div>


