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
    var dataString = 'amount=' + data['data'][i]['amount'] + '&amountCurrency=' + data['data'][i]['amountCurrency'] + '&isFixedRate=' + data['data'][i]['isFixedRate'] + '&profile=' + data['data'][i]['profile'] + '&recipientId=' + data['data'][i]['recipientId'] + '&sourceCurrency=' + data['data'][i]['sourceCurrency'] + '&targetCurrency=' + data['data'][i]['targetCurrency'] + '&X_Authorization_key=' + data['data'][i]['X_Authorization_key'] + '&X_Authorization_token=' + data['data'][i]['X_Authorization_token']
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