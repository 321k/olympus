
'use strict';


function URL_GT(keyword, country, region, year, month, length){
  
  var start = "http://www.google.com/trends/trendsReport?hl=en-US&q=";
  var end = "&cmpt=q&content=1&export=1";
  var geo = "";
  var date = "";
  var URL = "";
  var month=1;
  var length=3;

  
  //Geographic restrictions
  if(typeof country!=="undefined" && country !== 'NA') {
    geo="&geo=";
    geo=geo + country;
    if(region !== undefined && region !=='NA') geo=geo + "-" + region;
  }
  
  if(typeof keyword==="string" && keyword !== 'NA'){
  	var queries=keyword;
  }
  
  if(typeof keyword==="object"){
  	var queries=keyword[0];
    for(var i=1; i < keyword.length; i++){
      queries=queries + "%2C" + keyword[i];
    }
  }
  
  //Dates
  if(typeof year==="string" && year !== 'NA'){
    date="&date=";
    date=date + month + "%2F" + year + "%20" + length + "m";
  }
  
  URL = start + queries + geo + date + end;
  URL = URL.replace(" ", "%20");
  return(URL);
}

function create_links(data){
  for(var i=0; i < data['data'].length; i++){
    var tmp_keyword = [data['data'][i]['keyword_1'], data['data'][i]['keyword_2'], data['data'][i]['keyword_3'], data['data'][i]['keyword_4'], data['data'][i]['keyword_5']];
    var country = data['data'][i]['country'];
    var region = data['data'][i]['region'];
    var year = data['data'][i]['year'];
    var month = data['data'][i]['month'];
    var length = data['data'][i]['length'];

    var keyword = [];
    for(var j = 0; j<5; j++){
      if(tmp_keyword !== 'NA' || tmp_keyword !== null){
        keyword.push(tmp_keyword[j]);
      }
    }
    
    var url = URL_GT(keyword, country, region, year, month, length);
    console.log(url);
    $.ajax ( {
        url: '../php/save_gt_url.php',
        type: 'POST',
        data: "url="+encodeURIComponent(url),
        success: function(data){
                $('#ajax-return').html(data);
             }
        } );
  }
}