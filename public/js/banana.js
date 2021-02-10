


$(window).on('load', function () {
  // 〜処理〜
  $('#talk-inner-scroll').animate({ scrollTop: $('#talk-inner-scroll')[0].scrollHeight }, 'fast');
});

// $('#talk-inner-scroll').on('load', function() {
//   // 〜処理〜
// });

$("#inputImage").on("input", function () {

  var input = $(this).val(); //input に入力された文字を取得

  if (input) { //もし文字が入っていれば
    $("#btnImage").prop('disabled', false); //disabled を無効にする＝ボタンが押せる
  } else {
    $("#btnImage").prop('disabled', true); //disabled を有効にする＝ボタンが押せない
  }

});




$('.drawer-burger').on('click', function () {
  $('.drawer-burger, .drawer-burger-line, .header-nav, .header-nav-item, .header-overlay, body').toggleClass('is-active');
});





$('.toggle-button').on('click', function () {
  $('.toggle-show').toggleClass('is-active');
});
