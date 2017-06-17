@extends('layouts.home')

@section('title','register')

@section('content')
    <div class="weui_cells_title">Register Method</div>
    <div class="weui_cells weui_cells_radio">
        <label class="weui_cell weui_check_label" for="x11">
            <div class="weui_cell_bd weui_cell_primary">
                <p>Phone</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x11" checked="checked">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
        <label class="weui_cell weui_check_label" for="x12">
            <div class="weui_cell_bd weui_cell_primary">
                <p>Email</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x12">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Number</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name="phone"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Password</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="no less than 6 digits" name='passwd_phone'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Confirm</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="no less than 6 digits" name='passwd_phone_cfm'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Code</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name='phone_code'/>
            </div>
            <p class="bk_important bk_phone_code_send">send code</p>
            <div class="weui_cell_ft">
            </div>
        </div>
    </div>
    <div class="weui_cells weui_cells_form" style="display: none;">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Email</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="" name='email'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Password</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="no less than 6 digits" name='passwd_email'>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Confirm</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="no less than 6 digits" name='passwd_email_cfm'/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">Code</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="please input the code" name='validate_code'/>
            </div>
            <div class="weui_cell_ft">
                <img src="{{url("service/validateCode/code")}}" class="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onRegisterClick();">Register</a>
    </div>
    <a href="{{url('/login')}}" class="bk_bottom_tips bk_important">with an acount? Sign in</a>
@endsection


@section('my-js')
  <script>
      $('#x12').next().hide();// hide the email method
      // deal with the register method: only one method can be selected
      $('input:radio[name=register_type]').click(function (event) {
          $('input:radio[name=register_type]').attr('checked',false);
          $(this).attr('checked',true);
          if ($(this).attr('id') == 'x11'){
              $('#x11').next().show();// show 'click'
              $('#x12').next().hide();// hide 'click'
              $('.weui_cells_form').eq(0).show();// show form1
              $('.weui_cells_form').eq(1).hide();// hide form2
          }else {
              $('#x11').next().hide();// hide 'click'
              $('#x12').next().show();// show 'click'
              $('.weui_cells_form').eq(0).hide();// hide form1
              $('.weui_cells_form').eq(1).show();// show form2
          }
      });

      // after count seconds, can send again
      var sendFlag = true; // flag to determine send or not
      var phone = $('input[name=phone]').val();// get the phone number
      $('.bk_phone_code_send').click(function (event) {
          // phone number should not be empty
          if(phone == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('input phone number');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return;
          }
          // judge phone number format
          if (phone.length != 10 || !phone.match(/[0-9]*/) ){
              $('.bk_toptips').show();
              $('.bk_toptips span').html('phone number is wrong!');
              setTimeout(function () {
                  $('.bk_toptips').hide();
              },2000);
              return;
          }
          if (sendFlag == false){
              return;
          }
          sendFlag = false;
          var count = 5;
          var interval = window.setInterval(function () {
              $('.bk_phone_code_send').html(--count + 's send again');
              if (count == 0){
                  // set the font color
                  $('.bk_phone_code_send').removeClass('bk_summary');
                  $('.bk_phone_code_send').addClass('bk_important');

                  sendFlag = true;
                  window.clearInterval(interval);
                  $('.bk_phone_code_send').html('send again');
              }
          }, 1000);

          // ajax to submit register info


          // judge phone number format
          if (phone.length != 10 || !phone.match(/[0-9]*/) ){
              $('.bk_toptips').show();
              $('.bk_toptips span').html('phone number is wrong!');
              setTimeout(function () {
                  $('.m3_toptips').hide();
              },2000);
              return;
          }

          $.post("{{url('service/validateCode/send')}}",
              {'_token':'{{csrf_token()}}','phone':phone},
              function (aData) {
                  if (aData == null){
                      $('.bk_toptips').show();
                      $('.bk_toptips span').html('server error!');
                      setTimeout(function () {
                          $('.m3_toptips').hide();
                      },2000);
                      return;
                  }
                  if (aData.status == 1){
                      $('.bk_toptips').show();
                      $('.bk_toptips span').html(aData.message);
                      setTimeout(function () {
                          $('.bk_toptips').hide();
                      },2000);
                  }else{
                      $('.bk_toptips').show();
                      $('.bk_toptips span').html('send successfully');
                      setTimeout(function () {
                          $('.bk_toptips').hide();
                      },2000);
                  }
              },
          'json'
          )
      });
  </script>
  <script type="text/javascript">

      function onRegisterClick() {

          $('input:radio[name=register_type]').each(function(index, el) {
              if($(this).attr('checked') == 'checked') {
                  var email = '';
                  var phone = '';
                  var password = '';
                  var confirm = '';
                  var phone_code = '';
                  var validate_code = '';

                  var id = $(this).attr('id');
                  if(id == 'x11') {
                      phone = ($('input[name=phone]').val()).trim();
                      password = ($('input[name=passwd_phone]').val()).trim();
                      confirm = ($('input[name=passwd_phone_cfm]').val()).trim();
                      phone_code = ($('input[name=phone_code]').val()).trim();
                      if(verifyPhone(phone, password, confirm, phone_code) == false) {
                          return;
                      }
                  } else if(id == 'x12') {
                      email = ($('input[name=email]').val()).trim();
                      password = ($('input[name=passwd_email]').val()).trim();
                      confirm = ($('input[name=passwd_email_cfm]').val()).trim();
                      validate_code = ($('input[name=validate_code]').val()).trim();
                      if(verifyEmail(email, password, confirm, validate_code) == false) {
                          return;
                      }
                  }

                  $.ajax({
                      type: "POST",
                      url: '{{url('/service/register')}}',
                      dataType: 'json',
                      cache: false,
                      data: {phone: phone, email: email, password: password, confirm: confirm,
                          phone_code: phone_code, validate_code: validate_code, _token: "{{csrf_token()}}"},
                      success: function(data) {
                          if(data == null) {
                              $('.bk_toptips').show();
                              $('.bk_toptips span').html('server error');
                              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                              return;
                          }
                          if(data.status != 0) {
                              $('.bk_toptips').show();
                              $('.bk_toptips span').html(data.message);
                              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                              return;
                          }

                          $('.bk_toptips').show();
                          $('.bk_toptips span').html('register successfully');
                          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                          // jump to login web
                          location.href = "{{url('login')}}";
                      },
                      error: function(xhr, status, error) {
                          console.log(xhr);
                          console.log(status);
                          console.log(error);
                      }
                  });
              }
          });
      }

      function verifyPhone(phone, password, confirm, phone_code) {
          // phone number should not be empty
          if(phone == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('input phone number');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          // judge phone number format
          if (phone.length != 10 || !phone.match(/[0-9]*/) ){
              $('.bk_toptips').show();
              $('.bk_toptips span').html('phone number is wrong!');
              setTimeout(function () {
                  $('.bk_toptips').hide();
              },2000);
              return false;
          }

          if(password == '' || confirm == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('password should not be empty');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(password.length < 6 || confirm.length < 6) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('password should not be less than 6 digits');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(password != confirm) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('twice passwords are not same!');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(phone_code == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('validate code should not be empty !');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(phone_code.length != 6) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('validate code is 6 digits!');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          return true;
      }

      function verifyEmail(email, password, confirm, validate_code) {
          // email should not be empty
          if(email == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('input email address');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          // email format
          if(email.indexOf('@') == -1 || email.indexOf('.') == -1) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('email format is wrong');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(password == '' || confirm == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('password should not be empty');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(password.length < 6 || confirm.length < 6) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('password should not be less than 6 digits');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(password != confirm) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('twice passwords are not same!');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(validate_code == '') {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('validate code should not be empty!');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          if(validate_code.length != 4) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('validate code is 4 digits!');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return false;
          }
          return true;
      }


  </script>
  <script>
      // validate code
      $('.bk_validate_code').click(function () {
          $(this).attr('src', '/service/validateCode/code?random=' + Math.random());
      });
  </script>
@endsection
