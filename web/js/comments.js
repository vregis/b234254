
$(function(){
  $(document).on('click', '#send-btn', function(e){ alert('asjkdj');
      e.preventDefault();
      var text = $('#comment_area').val();
      if(text == ''){
          alert('Cannot be empty');
          return false;
      }else{
          alert(text)
      }
  })
})