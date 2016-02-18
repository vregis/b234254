
$(function(){ alert('sadjg');
  $(document).on('click', '#send-btn', function(e){
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