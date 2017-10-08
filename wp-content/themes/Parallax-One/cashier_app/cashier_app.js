/**
 * Cashier app - prototype (JS part)
 */

if (typeof jQuery === 'undefined') {
  throw new Error('Cashier app requires jQuery')
}

function getCounterId(buttonId) {
  return buttonId.substr(0, buttonId.indexOf('-'));
}

function changeVal(val, change) {
  return (parseInt(val) + parseInt(change) > 0) ? (parseInt(val) + parseInt(change)) : 0;
}

function sendValuesToServer(buttonId, change) {
  var counterId = getCounterId(buttonId);
  $('#' + counterId).val(function (i, val) {
    form_data = {
      'cashier': true,
      'increment': true,
      'branch_id': $('#branch_id option:selected').val(),
      'date': $('#date').val(),
      'time': $('#time').val(),
      'class_type': $('#class_type option:selected').val(),
      'level': $('#level option:selected').val(),
      'name': $('#name option:selected').val(),
    };
    prices_data = {};
    $('.price').each(function() {
      var value = parseInt($( this ).val());
      if ($( this ).attr('id') == counterId) {
        value = changeVal(value, change);
      }
      $.extend(prices_data, $.parseJSON('{"' + $( this ).attr('id') + '": "' + value + '"}'));
    });
    $.ajax({
      url: './index.php',
      type: 'POST',
      data: $.extend(form_data, prices_data),
      success: function (data) {
      }
    });
    return changeVal(val, change);
  });
}

function enableForm() {
  $('.price-button').prop('disabled', false);
  $('.price').prop('disabled', false);
  $('.submit-button').prop('disabled', false);
  $('.price-button').prop('style', 'background-color: #00a5f9;');
  $('.submit-button').prop('style', 'background-color: #00a5f9;');
}

function getValuesFromServer() {
  get_data = {
    'cashier': true,
    'get_data': true,
    'branch_id': $('#branch_id option:selected').val(),
    'date': $('#date').val(),
    'time': $('#time').val(),
    'class_type': $('#class_type option:selected').val(),
    'level': $('#level option:selected').val(),
    'name': $('#name option:selected').val(),
  };
  $.ajax({
    url: './index.php',
    type: 'POST',
    data: get_data,
    success: function (data) {
      if (data != "") {
        data = JSON.parse(data);
        var volunteer_name = data['volunteer_name'];
        if (volunteer_name != $('#name').val()) {
          alert("This class was already counted by: " + volunteer_name + ". Submitting will overwrite the previous count.")
        } else {
          alert("Previous counts were found and were loaded.")
        }
        var prices_array = data['prices_array'];
        for (var key in prices_array) {
          $('#price' + key).val(prices_array[key]);
        }
      }
    }
  });
}

$(document).ready(function() {
  $('.js-plus').click(function () {
    var buttonId = $(this).attr('id');
    sendValuesToServer(buttonId, change = 1);
  });

  $('.js-minus').click(function () {
    var buttonId = $(this).attr('id');
    sendValuesToServer(buttonId, change = -1);
  });

  $('.js-start').change(function () {
    getValuesFromServer();
    enableForm();
  });
});