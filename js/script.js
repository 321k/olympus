display_file_content = function(){
  for(var i=0; i<data['data'].length;i++){
    console.log(data['data'][i]);
  };
};

generate_payments = function(){
  for(var i=0; data['data'].length;i++){
    form.append("amount", data['data'][i]['amount']);
    form.append("amountCurrency", data['data'][i]['amountCurrency']);
    form.append("exchangeId", "fa447bea-4016-4261-af94-f7bfd8c9810a");
    form.append("isFixedRate", data['data'][i]['isFixedRate']);
    form.append("profile", data['data'][i]['profile']);
    form.append("recipientId", data['data'][i]['recipientId']);
    form.append("refundRecipientId", "");
    form.append("sourceCurrency", data['data'][i]['sourceCurrency']);
    form.append("sourceOfFundsOptionId", "");
    form.append("sourceOfFundsText", "");
    form.append("targetCurrency", data['data'][i]['targetCurrency']);
    form.append("X_Authorization_key", data['data'][i]['X_Authorization_key']);
    form.append("X_Authorization_token ", data['data'][i]['X_Authorization_token']);

    $.ajax(settings).done(function (response) {
      console.log(response);
    });
  };
};


test_function = function(){

  for(var i = 0; i<data['data'].length;i++){

    var dataString = 'amount=' + data['data'][i]['amount'] + '&amountCurrency=' + data['data'][i]['amountCurrency'] + '&isFixedRate=' + data['data'][i]['isFixedRate'] + '&profile=' + data['data'][i]['profile'] + '&recipientId=' + data['data'][i]['recipientId'] + '&sourceCurrency=' + data['data'][i]['sourceCurrency'] + '&targetCurrency=' + data['data'][i]['targetCurrency'] + '&X_Authorization_key=' + data['data'][i]['X_Authorization_key'] + '&X_Authorization_token=' + data['data'][i]['X_Authorization_token'] + "&iter_no=" + i
    $.ajax({
      type: "POST",
      url: "submit_batch.php",
      data: dataString,
      cache: false,
      success: function(result){
      alert(result);
      }
    });
  }
}

create_gt_batch = function(){
  for(var i = 0; i<data['data'].length; i++){
    var dataString = 'keyword_1=' + data['data'][i]['keyword_1'] +
                      '&keyword_2=' + data['data'][i]['keyword_2'] +
                      '&keyword_3=' + data['data'][i]['keyword_3'] +
                      '&keyword_4=' + data['data'][i]['keyword_4'] +
                      '&keyword_5=' + data['data'][i]['keyword_5'] +
                      '&country='  + data['data'][i]['country'] +
                      '&region='  + data['data'][i]['region'] +
                      '&year='  + data['data'][i]['year'] +
                      '&month='  + data['data'][i]['month'] +
                      '&length='  + data['data'][i]['length']
                      $.ajax({
      type: "POST",
      url: "create_gt_batch.php",
      data: dataString,
      cache: false,
      success: function(result){
        alert(result);
      }
    });
  }
}