<?php require( 'header.php'); ?>

  <header>
    <nav>
      <div class="header-title">
        <div class="header-back">
          <span class="glyphicon glyphicon-menu-left">
          </span>
        </div>
        <div class="header-main-title">
          食谱
        </div>
      </div>
    </nav>
  </header>

<section>
<div class="introduction-page">
    <div class="vip-enjoy vip-enjoy-padding">
      <div class="vip-video">
        <video src="movie.ogg" controls="controls">
          您的浏览器不支持 video 标签。
        </video>
        <!--<img src="">-->
      </div>
      <div class="vip-content">
        <div class="vip-title">
          标题标题标题
        </div>
        <div class="vip-post">
          内容标题内容标题内容标题内容标题内容标题内容标题内容标题内容标题
        </div>
        <div class="vip-content-time">
          <ul id="introduction-time-list1" class="introduction-time">
            <li>备料和预处理</li>
            <li>料理时长</li>
            <li>享用份量</li>
          </ul>
          <ul id="introduction-time-list2" class="introduction-time">
            <li id="prepare-time">0分钟</li>
            <li id="cooking-time">0分钟</li>
            <li id="enjoy-num">0人份</li>
          </ul>
        </div>
        <div class="vip-menu">
          <ul>
            <li><span class="glyphicon glyphicon-eye-open"></span> <span id="browser-num">0</span></li>
            <li onclick="addToReadingList(this)">
              <span class="glyphicon glyphicon-heart-empty">
              </span>
            </li>
            <li>
              <span class="glyphicon glyphicon-link">
              </span>
            </li>
          </ul>
        </div>
        <div class="teacher-brand introduction-teacher-brand"><img src=""></div>
      </div>
    </div>
    
    <div class="introduction-comment">
      <ul>
        <li>
            <div class="profile-phtot-uploaded">
              <img width="50" id="user-comment-photo" height="50" src="images/default_photo.png" />   
            </div>
        </li>
        <li>
          <div class="introduction-comment-input-container">
            <span>在此输入留言或内容</span>
            <textarea style="display:none"></textarea>
          </div>
        </li>
      </ul>
      <ul>
        <li>
          <div class="profile-phtot-uploaded">
              <img width="50" id="user-comment-photo" height="50" src="images/default_photo.png" />   
          </div>
        </li>
        <li>
          <div class="introduction-comment-title">
            <ul>
              <li>雯雯 Carl</li>
              <li>2015-03-08</li>
            </ul>
          </div>
          <div class="introduction-comment-content">
            <span>文字内容文字kjkkl内容文字内容文字内容文字4558akaakll内容文字内容文字内容文字内容文字内容文字内容</span>
          </div>
          <div class="introduction-comment-reply">
            <div class="introduction-comment-title">
              <ul>
                <li>雯雯 Carl</li>
                <li>2015-03-08</li>
              </ul>
            </div>
            <div class="introduction-comment-content comment-reply-content">
              <span>文字内容文字内容文字内容文字内容文字4558akaakll内容文字内容文字内容文字内容文字内容文字内容</span>
            </div>
          </div>
        </li>
      </ul>
    </div>

    </div>
    </section>
    
    <footer>
      <div id="recipes-introduction-footer">
        <ul id="recipes-introduction-footer-ul">
          <li><span id="introduction" class="borderActive">介绍</span></li>
          <li><span id="formula">配方</span></li>
          <li><span id="step">步骤</span></li>
        </ul>
      </div>
    </footer>
  <script type="text/javascript">
    $(document).ready(function() {

      function displayCommentsList(){

      }

      displayALertForm('正在加载...',1000);
      var currentHref=document.location.href;
      if(currentHref.indexOf('#')!=-1){
        currentHref=currentHref.split('#')[1];
        getRecipeInfo(currentHref,0,1,10,function(data){
          if(data!=''){
            var jsonData=JSON.parse(data);
            if(jsonData['msg']!='成功'){
              displayALertForm(jsonData['msg']);
            }else{
              var introList=jsonData['data'];
              if(introList['info']!=''){
                var introInfo=introList['info'];
                $('.vip-title').html(introInfo['title']);
                $('.vip-post').html(introInfo['paper']);
                $('.introduction-time #prepare-time').html(introInfo['prepare_time']);
                $('.introduction-time #cooking-time').html(introInfo['cooking_time']);
                $('.introduction-time #enjoy-num').html(introInfo['enjoy_num']);
                $('.vip-menu ul li #browser-num').html(introInfo['browse_num']);
                $('.introduction-teacher-brand img').attr('src',introInfo['arrange_image_url']);
              }
              if(introList['comments']!=''){
                displayCommentsList();
              }else{
                $('#comment-show-area').hide();
              }
            }
          }else{
            displayALertForm('加载失败,请重试');
          }
        });
      }else{
        window.location.href="recipes.php";
      }

      var flag = false;
      function submitComments(articleid,comments){
        sendComments(1, localStorage.tokenID, articleid, comments,function(data) {
          var jsonData = JSON.parse(data);
          displayALertForm(jsonData);
          if (jsonData['msg'] == '留言成功') {
            displayALertForm(jsonData['msg']);
            flag = true;
          } else {
            displayALertForm(jsonData['msg']);
          }
        });
      }

      $('.introduction-comment-input-container textarea').keydown(function(event) {
        if (event.which == 13 && localStorage.isLogin == 'true') {
          displayALertForm('消息发送中，请稍候...');
          var scomments = $('.introduction-comment-ul .introduction-comment-input input').val();
          if (flag == false) {
            var overtime = new Date();
            localStorage.Time = overtime.getMinutes() + 0.50;
            submitComments(currentHref,scomments);
          } else if (flag == true) {
            var repeatTime = new Date();
            if (repeatTime.getMinutes() < localStorage.Time) {
              submitComments(currentHref,scomments);
              localStorage.Time = repeatTime.getMinutes() + 0.50;
            }
          }
        }
      });

      $('.vip-menu ul li:nth-child(2)').attr('type',1);
      $('.vip-menu ul li:nth-child(2)').attr('articleid',currentHref);

      $('#recipes-introduction-footer ul li').click(function(){
        var _this=$(this);
        var type=_this.find('span').attr('id');
        var elm;
        $('#recipes-introduction-footer ul li').each(function(e){
          var thisSpan=$(this).find('span');
          if(thisSpan.hasClass('borderActive')){thisSpan.removeClass('borderActive');}
        });
        _this.find('span').addClass('borderActive');
        if(type=='introduction'){loadPagesA('introduction.php','section');
        }else{loadPagesA('pages/introduction/'+type+'.php','.introduction-page');}
      });

      $('.introduction-comment-input-container').click(function(){
        var _this=$(this);
        var thisInput=_this.find('textarea');
        if(thisInput.css('display')=='none' || thisInput.val()==''){
          _this.find('span').toggle();
          thisInput.attr('width',_this.parent().width());
          thisInput.attr('height',_this.parent().height());
          thisInput.toggle();
          thisInput.focus();
        }
      });

    });

  </script>

<?php require('footer.php'); ?>

<script>
  $('.main-footer').html('');
  $('.introduction-page').css('marginTop','-7px');
</script>