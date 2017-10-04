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
      'name': $('#name').val()
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

$(document).ready(function() {
  $('.js-plus').click(function () {
    var buttonId = $(this).attr('id');
    sendValuesToServer(buttonId, change = 1);
  })

  $('.js-minus').click(function () {
    var buttonId = $(this).attr('id');
    sendValuesToServer(buttonId, change = -1);
  })
})