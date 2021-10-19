
$(function(){
  var url = window.location;
  var path = url.href.split('/');
  var file_name = path.pop();
  if(file_name != "home.php")
  {
    $('#head').addClass('fixed');
  }
  $(window).scroll(function(){

    if(file_name == "home.php")
    {
      var scrollAmount = $(this).scrollTop();
      if(scrollAmount <= 0)
      {
        $('#jumpTopBtn').fadeOut();
        $('#head').removeClass('fixed');
      }
      else
      {
        $('#jumpTopBtn').fadeIn();
        
        $('#head').addClass('fixed');
      }
    }
  });

    $('a[href^="#"]').click(function(){
      var speed = 1000;
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $("html, body").animate({scrollTop:position}, speed, "swing");
      return false;
    });

    $('#signin').on('click',function(){
      $('#modal').fadeIn();
      $('#overlay').fadeIn();
        return false;
      });
      $('#overlay').on('click', function () {
        $('#modal').fadeOut();
        $('#overlay').fadeOut();
        return false;
      });
    $('#submitBtn').click(function(){
      inputInfo = new Array(5);
      errMsg = [];
      inputInfo[0]=($('input[name="name"]').val());
      inputInfo[1]=($('input[name="furigana"]').val());
      inputInfo[2]=($('input[name="telNum"]').val());
      inputInfo[3]=($('input[name="mailAddress"]').val());
      inputInfo[4]=($('#opinionBox').val());
      // 正規表現
      var regexNum = /^[0-9]+$/;
      var regexAddress = /.+@.+\..+/
      // バリデーション
      
      if((inputInfo[0].length <= 0) || (inputInfo[0].length >= 10))
      {
        errMsg.push("氏名は必須入力です。10文字以内でご入力ください。\r\n");
      }
      if((inputInfo[1].length <= 0) || (inputInfo[1].length >= 10))
      {
        errMsg.push("フリガナは必須入力です。10文字以内でご入力ください。\r\n");
      }
      if(inputInfo[2].length > 0)
      {
        if(!regexNum.test(inputInfo[2]))
        {
          errMsg.push("電話番号は0-9の数字のみでご入力ください。\r\n");
        }
      }
      if(!regexAddress.test(inputInfo[3]))
      {
        errMsg.push("メールアドレスは正しくご入力ください。\r\n");
      }
      if(inputInfo[4].length <= 0)
      {
        errMsg.push("お問い合わせ内容は必須入力です。\r\n");
      }
      let outputErrorMsg = "";
      errMsg.forEach(error=>{
        outputErrorMsg += error;
      });
      if(outputErrorMsg.length > 0)
      {
        alert(outputErrorMsg);
      }
    });


  });
