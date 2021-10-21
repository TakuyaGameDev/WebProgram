 
$(function(){
 // データベースのデータの編集画面に移行処理-----------
 var rowIndex = 0;
 $('tr').on('click',function () 
 {
     rowIndex = this.rowIndex;
     alert(rowIndex);
 });
 $('#editBtn').on('click',function () 
 {
     var str = rowIndex;
     location.href = "dataEdit.php";
 });
 // --------------------------------------------------
  var url = window.location;
  var path = url.href.split('/');
  var file_name = path.pop();
  if(file_name != "home.php")
  {
    $('#head').addClass('fixed');
    $('#menuItem').addClass('fixed');
    $('#logo').addClass('fixed');
    $('#signin').addClass('fixed');
  }
  $(window).scroll(function(){

    if(file_name == "home.php")
    {
      var scrollAmount = $(this).scrollTop();
      if(scrollAmount <= 0)
      {
        $('#jumpTopBtn').fadeOut();
        
        $('#blackBoard').removeClass('active');
        $('#blackBoard').addClass('nonActive');
        $('#menuItem').removeClass('active');
        $('#menuItem').addClass('nonActive');
        $('#logo').removeClass('active');
        $('#logo').addClass('nonActive');
      }
      else
      {
        $('#jumpTopBtn').fadeIn();
        $('#blackBoard').removeClass('nonActive');
        $('#blackBoard').addClass('active');
        $('#menuItem').removeClass('nonActive');
        $('#menuItem').addClass('active');
        $('#logo').removeClass('nonActive');
        $('#logo').addClass('active');
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
      $('#modal').animate(
          {opacity:1},300
        );
      $('#modal').removeClass('slideDown');
      $('#modal').addClass('slideUp');
      $('#overlay').fadeIn();
        return false;
      });
      $('#overlay').on('click', function () {
        $("#modal").animate(
          {opacity:0},300
        );
        $('#modal').removeClass('slideUp');
        $('#modal').addClass('slideDown');
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
