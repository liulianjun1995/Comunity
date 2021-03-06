@extends('layouts.main')

@section('container')
  <div class="layui-container fly-marginTop fly-user-main">
  @include('home.user.main')
  <div class="fly-panel fly-panel-user">
    <div class="layui-tab layui-tab-brief">
      <ul class="layui-tab-title" id="LAY_mine">
        <li class="@if(strpos($_SERVER['REQUEST_URI'],'info')!==false) layui-this @endif">我的资料</li>
        <li class="@if(strpos($_SERVER['REQUEST_URI'],'avatar')!==false) layui-this @endif">头像</li>
        <li class="@if(strpos($_SERVER['REQUEST_URI'],'pass')!==false) layui-this @endif">密码</li>
        <li class="@if(strpos($_SERVER['REQUEST_URI'],'bind')!==false) layui-this @endif">帐号绑定</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        {{-- 我的资料 --}}
        <div class="layui-form layui-form-pane layui-tab-item @if(strpos($_SERVER['REQUEST_URI'],'info')!==false) layui-show @endif" style="margin: 10px 10px">
          <form id="infoForm">
              <div class="layui-form-item">
                  <label for="phone" class="layui-form-label">手机号</label>
                  <div class="layui-input-inline">
                      <input type="text" id="phone" name="phone" readonly autocomplete="off" value="{{ Auth::user()->phone }}" class="layui-input">
                  </div>
                  @if(!Auth::user()->phone)
                  <div class="layui-form-mid layui-word-aux">您还未验证手机号，请<a href="/user/bindPhone" style="font-size: 12px; color: #4f99cf;">验证手机号</a>。</div>
                  @else
                  <div class="layui-form-mid layui-word-aux"><span style="color: #5FB878">您已完成手机号绑定，已正式成为社区实名用户。</span> 手机号暂不支持修改。 </div>
                  @endif
              </div>
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">邮箱</label>
              <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" required readonly lay-verify="email" autocomplete="off" value="{{ Auth::user()->email }}" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">昵称</label>
              <div class="layui-input-inline">
                <input type="text" id="L_username" name="name" required readonly lay-verify="required" autocomplete="off" value="{{ Auth::user()->name }}" class="layui-input">
              </div>
              <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="radio" name="sex" value="1" title="男" @if(Auth::user()->sex == '男') checked @endif>
                  <input type="radio" name="sex" value="2" title="女" @if(Auth::user()->sex == '女') checked @endif>
                </div>
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">城市</label>
              <div class="layui-input-inline">
                <input type="text" id="L_city" name="city" autocomplete="off" value="" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label for="L_sign" class="layui-form-label">签名</label>
              <div class="layui-input-block">
                <textarea placeholder="随便写些什么刷下存在感" id="L_sign"  name="sign" autocomplete="off" class="layui-textarea" style="height: 80px;">{{ Auth::user()->sign }}</textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <button class="layui-btn" type="button" onclick="changeInfo()">确认修改</button>
            </div>
          </form>
        </div>
        {{-- 头像 --}}
        <div class="layui-form layui-form-pane layui-tab-item @if(strpos($_SERVER['REQUEST_URI'],'avatar')!==false) layui-show @endif" style="margin: 10px 10px">
          <div class="layui-form-item">
            <div class="avatar-add">
              <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
              <button type="button" class="layui-btn upload-img">
                <i class="layui-icon">&#xe67c;</i>上传头像
              </button>
              <img class="img-upload-view" src="{{ Auth::user()->avatar }}">
              <span class="loading"></span>
            </div>
          </div>
        </div>
        {{-- 密码 --}}
        <div class="layui-form layui-form-pane layui-tab-item @if(strpos($_SERVER['REQUEST_URI'],'pass')!==false) layui-show @endif" style="margin: 10px 10px">
          <form action="/user/repass" method="post">
            <div class="layui-form-item">
              <label for="L_nowpass" class="layui-form-label">当前密码</label>
              <div class="layui-input-inline">
                <input type="password" id="L_nowpass" name="nowpass" required lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">新密码</label>
              <div class="layui-input-inline">
                <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">6到16个字符</div>
            </div>
            <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">确认密码</label>
              <div class="layui-input-inline">
                <input type="password" id="L_repass" name="repass" required lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <button class="layui-btn" type="submit">确认修改</button>
            </div>
          </form>
        </div>
        {{-- 帐号绑定 --}}
        <div class="layui-form layui-form-pane layui-tab-item @if(strpos($_SERVER['REQUEST_URI'],'bind')!==false) layui-show @endif" style="margin: 10px 10px">
          <ul class="app-bind">
              <li class="fly-msg">
                  <img src="{{ asset('/assets/images/phone.png') }}" alt="" width="26px" height="26px">
                  <a href="">立即绑定</a>
                  <span>,即可使用手机帐号登录</span>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
  <script>
      //Demo
      layui.use('form', function(){
            var form = layui.form;
      });
      //根据ip获取城市
      if($('#L_city').val() === ''){
          $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function(){
              $('#L_city').val(remote_ip_info.city||'');
          });
      }
      //修改资料
      function changeInfo(){
          var fm = document.getElementById('infoForm');
          var fd = new FormData(fm);
          $.ajax({
              url:"/user/info",
              type:'post',
              data:fd,
              processData:false,
              contentType:false,
              success:function (res) {
                  if(res ==1 ){
                      layer.msg('修改成功', {
                          icon: 1
                          ,time: 1000
                          ,shade: 0.1
                      }, function(){
                          location.reload();
                      });
                  }else {
                      layer.msg('修改失败', {
                          icon: 2
                          ,time: 1000
                          ,shade: 0.1
                      });
                  }
              },
              error:function () {
                  
              }
              
          });
          event.preventDefault();

      }
      //上传图片
      if($('.upload-img')[0]){
          layui.use('upload', function(upload){
              var avatarAdd = $('.avatar-add');
              var tag_token = $('meta[name="csrf-token"]').attr('content');
              upload.render({
                  elem: '.upload-img'
                  ,type:'images'
                  ,exts: 'jpg|png|gif'
                  ,url: '/user/upload'
                  ,data:{'_token':tag_token}
                  ,before: function(obj){
                      //预读本地文件示例，不支持ie8
                      obj.preview(function(index, file, result){
                          $('.img-upload-view').attr('src', result); //图片链接（base64）
                      });
                  }
                  ,done: function(res){
                      //如果上传失败
                      alert(res);
                      if(res.status == 1){
                          return layer.msg('上传成功');
                      }else{//上传成功
                          layer.msg(res.message);
                      }
                  }
                  ,error: function(){
                      //演示失败状态，并实现重传
                      return layer.msg('上传失败,请重新上传');
                  }
              });
          });
      }
  </script>
@endsection