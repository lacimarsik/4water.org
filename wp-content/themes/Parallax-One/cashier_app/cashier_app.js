// =============================
// CASHIER APP - V1.0 Javascript part

// Form part: cashier_app_process.php (in the theme folder)
// Process part: cashier_app_process.php (in the root folder)
// Summary part: cashier_app_summary.php (in the theme folder)

// OUTLINE
// 1. FUNCTIONS
// =============================

if (typeof jQuery === 'undefined') {
  throw new Error('Cashier app requires jQuery')
}

// =============================
// 1. FUNCTIONS
// =============================

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
      url: './cashier_app_process.php',
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
    url: './cashier_app_process.php',
    type: 'POST',
    data: get_data,
    success: function (data) {
      if (data != "") {
        data = JSON.parse(data);
        var volunteer_name = data['volunteer_name'];
        if (volunteer_name != $('#name').val()) {
          if (volunteer_name == 'Please Select ...') {
            alert("The counts will be saved under " + $('#name').val());
          } else {
            alert("This class was already counted by: " + volunteer_name + ". Making changes will overwrite the previous count. Note that even hitting '+' or '-' saves the counts.")
          }
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

  $('form#cashier').on('submit', function (e) {
    e.preventDefault();
    var name = $("select[name='name']").val();
    if (name == 'Please Select ...') {
      alert('You did not select your name. Please select your name and submit agian.');
      return
    }

    var class_type = $("select[name='class_type']").val();
    var level = $("select[name='level']").val();
    var date = $("select[name='date']").val();
    var time = $("select[name='time']").val();
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var dateParsed = new Date(date);
    var dateHumanized = dateParsed.toLocaleDateString("en-US", options);
    if (confirm("(Final check) You are submitting counts for:\n\n" + class_type + " " + level + "\n" + dateHumanized + "\n" + time + "\n\nIs that correct?")) {
      this.submit();
    }
  });
});