display_file_content = function(){
  $("#file-content").html('asdf');
};

document.getElementById('#file-content').onchange = function() {
    display_file_content();
};
